<?php
$GLOBALS['elevate_json_api'] = true;
header('Content-Type: application/json');
header('Cache-Control: no-store');

include __DIR__ . '/db.php';
require_once __DIR__ . '/includes/quiz_functions.php';

quiz_ensure_schema($mysqli);

function quiz_json_response(bool $ok, array $data = [], string $message = '', int $code = 200): void
{
    http_response_code($code);
    echo json_encode(array_merge(['ok' => $ok, 'message' => $message], $data));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    quiz_json_response(false, [], 'Method not allowed', 405);
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = $_POST;
}

$action = trim((string)($input['action'] ?? ''));

if ($action === 'get_settings') {
    $settings = quiz_get_settings($mysqli);
    if (!(int)($settings['is_active'] ?? 0)) {
        quiz_json_response(false, [], 'Assessment is currently unavailable.');
    }
    $categories = quiz_get_categories($mysqli);
    quiz_json_response(true, [
        'settings' => [
            'title' => $settings['title'],
            'instructions' => $settings['instructions'],
            'duration_minutes' => (int)($settings['duration_minutes'] ?? 90),
            'total_questions' => quiz_get_questions_per_attempt($mysqli),
        ],
        'categories' => $categories,
    ]);
}

if ($action === 'start') {
    $settings = quiz_get_settings($mysqli);
    if (!(int)($settings['is_active'] ?? 0)) {
        quiz_json_response(false, [], 'Assessment is currently unavailable.');
    }

    $email = trim((string)($input['email'] ?? ''));
    $phone = trim((string)($input['phone'] ?? ''));
    $categoryId = (int)($input['category_id'] ?? 0);
    if ($categoryId <= 0) {
        $categoryId = (int)($settings['category_id'] ?? 0);
    }

    $category = $categoryId > 0 ? quiz_get_category_by_id($mysqli, $categoryId) : null;
    if (!$category) {
        quiz_json_response(false, [], 'Please select an assessment persona.');
    }

    $perAttempt = quiz_get_questions_per_attempt($mysqli);
    $totalNeeded = $perAttempt;
    $duration = max(1, (int)($settings['duration_minutes'] ?? 50));
    $categoryId = (int)$category['id'];

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        quiz_json_response(false, [], 'Please enter a valid email address.');
    }
    if ($phone === '' || !preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
        quiz_json_response(false, [], 'Please enter a valid phone number.');
    }

    $questions = quiz_pick_random_questions($mysqli, $totalNeeded, $categoryId);
    $bankCount = (int)($category['question_count'] ?? 0);
    if (count($questions) < $totalNeeded) {
        quiz_json_response(false, [
            'question_bank_count' => $bankCount,
            'required' => $totalNeeded,
        ], "Not enough questions for {$category['name']} ({$bankCount}/{$totalNeeded}). Please contact admin.");
    }

    $questionIds = array_map(static fn($q) => (int)$q['id'], $questions);
    $categoryMeta = [
        'pillars' => $category['pillars'] ?? [],
        'pillar_weights' => $category['pillar_weights'] ?? [],
        'item_types' => $category['item_types'] ?? [],
        'proficiency_bands' => $category['proficiency_bands'] ?? [],
    ];
    $clientQuestions = array_map(static fn($q) => quiz_format_question_for_client($q, $categoryMeta), $questions);
    $token = quiz_generate_token();
    $now = date('Y-m-d H:i:s');
    $expires = date('Y-m-d H:i:s', strtotime("+{$duration} minutes"));
    $idsJson = json_encode($questionIds);

    $stmt = $mysqli->prepare("
        INSERT INTO quiz_attempts (attempt_token, email, phone, question_ids, started_at, expires_at, total_questions, category_id, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'in_progress')
    ");
    $stmt->bind_param('ssssssii', $token, $email, $phone, $idsJson, $now, $expires, $totalNeeded, $categoryId);
    if (!$stmt->execute()) {
        quiz_json_response(false, [], 'Could not start assessment. Please try again.');
    }
    $stmt->close();

    quiz_json_response(true, [
        'attempt_token' => $token,
        'started_at' => $now,
        'expires_at' => $expires,
        'duration_seconds' => $duration * 60,
        'questions' => $clientQuestions,
        'settings' => [
            'title' => $category['name'],
            'duration_minutes' => $duration,
            'total_questions' => $totalNeeded,
            'category_id' => $categoryId,
            'category_name' => $category['name'],
        ],
    ]);
}

if ($action === 'submit') {
    $token = trim((string)($input['attempt_token'] ?? ''));
    $answersRaw = $input['answers'] ?? [];

    if ($token === '') {
        quiz_json_response(false, [], 'Invalid attempt.');
    }
    if (!is_array($answersRaw)) {
        quiz_json_response(false, [], 'Invalid answers format.');
    }

    $stmt = $mysqli->prepare("SELECT * FROM quiz_attempts WHERE attempt_token = ? LIMIT 1");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $attempt = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$attempt) {
        quiz_json_response(false, [], 'Attempt not found.');
    }
    if ($attempt['status'] === 'submitted') {
        quiz_json_response(true, [
            'already_submitted' => true,
            'result' => [
                'correct_count' => (int)$attempt['correct_count'],
                'total_questions' => (int)$attempt['total_questions'],
                'score_percent' => (float)$attempt['score_percent'],
                'result_title' => $attempt['result_title'],
                'result_text' => $attempt['result_text'],
            ],
        ]);
    }

    $nowTs = time();
    $expiresTs = strtotime($attempt['expires_at']);
    if ($nowTs > $expiresTs) {
        $upd = $mysqli->prepare("UPDATE quiz_attempts SET status = 'expired' WHERE id = ?");
        $aid = (int)$attempt['id'];
        $upd->bind_param('i', $aid);
        $upd->execute();
        $upd->close();
        quiz_json_response(false, [], 'Time is up. Your attempt has expired.');
    }

    $questionIds = json_decode($attempt['question_ids'], true);
    if (!is_array($questionIds)) {
        $questionIds = [];
    }

    $answers = [];
    foreach ($answersRaw as $qid => $ans) {
        $answers[(int)$qid] = strtolower(trim((string)$ans));
    }

    $categoryId = (int)($attempt['category_id'] ?? 0);
    $score = quiz_score_attempt($mysqli, $questionIds, $answers, $categoryId > 0 ? $categoryId : null);
    $band = quiz_get_result_band($mysqli, $score['percent'], $categoryId > 0 ? $categoryId : null);

    $resultTitle = $band['title'] ?? 'Your Result';
    $resultText = $band['result_text'] ?? 'Thank you for completing the assessment.';
    $bandId = isset($band['id']) ? (int)$band['id'] : 0;

    $startedTs = strtotime($attempt['started_at']);
    $timeTaken = max(0, $nowTs - $startedTs);
    $submittedAt = date('Y-m-d H:i:s');
    $answersJson = json_encode($answers);

    $upd = $mysqli->prepare("
        UPDATE quiz_attempts
        SET answers = ?, submitted_at = ?, time_taken_seconds = ?,
            correct_count = ?, score_percent = ?, result_band_id = ?,
            result_title = ?, result_text = ?, status = 'submitted'
        WHERE id = ?
    ");
    $aid = (int)$attempt['id'];
    $upd->bind_param(
        'ssiidissi',
        $answersJson,
        $submittedAt,
        $timeTaken,
        $score['correct'],
        $score['percent'],
        $bandId,
        $resultTitle,
        $resultText,
        $aid
    );
    if (!$upd->execute()) {
        quiz_json_response(false, [], 'Could not save your result. Please try again.');
    }
    $upd->close();

    // Also log in enquiries for admin visibility
    $subject = 'AI Assessment Quiz — ' . $score['percent'] . '%';
    $message = "Score: {$score['correct']}/{$score['total']} ({$score['percent']}%)\n"
        . "Result: {$resultTitle}\n\n{$resultText}";
    $firstName = 'Quiz';
    $lastName = 'User';
    $company = '';
    $enq = $mysqli->prepare("
        INSERT INTO enquiries (first_name, last_name, email, phone, company, subject, message, source, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'ai_assessment_quiz', NOW())
    ");
    if ($enq) {
        $enq->bind_param('sssssss', $firstName, $lastName, $attempt['email'], $attempt['phone'], $company, $subject, $message);
        $enq->execute();
        $enq->close();
    }

    quiz_json_response(true, [
        'result' => [
            'correct_count' => $score['correct'],
            'total_questions' => $score['total'],
            'score_percent' => $score['percent'],
            'result_title' => $resultTitle,
            'result_text' => $resultText,
            'time_taken_seconds' => $timeTaken,
            'pillar_scores' => $score['pillar_scores'] ?? [],
        ],
    ]);
}

quiz_json_response(false, [], 'Unknown action.', 400);
