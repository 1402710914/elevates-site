<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

include __DIR__ . '/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Invalid request method.']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$designation = trim($_POST['designation'] ?? '');
$current_company = trim($_POST['current_company'] ?? '');
$experience_years = trim($_POST['experience_years'] ?? '');
$interested_role = trim($_POST['interested_role'] ?? '');

if (
    $name === '' || $phone === '' || $email === '' || $designation === '' ||
    $current_company === '' || $experience_years === '' || $interested_role === ''
) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please fill all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

if (!preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please enter a valid phone number.']);
    exit;
}

$experience_value = is_numeric($experience_years) ? (float)$experience_years : null;
if ($experience_value === null || $experience_value < 0 || $experience_value > 50) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please enter valid years of experience.']);
    exit;
}

try {
    $createTableSql = "
        CREATE TABLE IF NOT EXISTS ai_assessment_submissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            email VARCHAR(190) NOT NULL,
            designation VARCHAR(150) NOT NULL,
            current_company VARCHAR(190) NOT NULL,
            experience_years DECIMAL(4,1) NOT NULL,
            interested_role VARCHAR(190) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $mysqli->query($createTableSql);

    $mysqli->begin_transaction();

    $stmtAi = $mysqli->prepare("
        INSERT INTO ai_assessment_submissions
        (name, phone, email, designation, current_company, experience_years, interested_role, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmtAi) {
        throw new Exception('Failed to prepare AI assessment insert.');
    }
    $stmtAi->bind_param(
        'sssssds',
        $name,
        $phone,
        $email,
        $designation,
        $current_company,
        $experience_value,
        $interested_role
    );
    $stmtAi->execute();
    $stmtAi->close();

    $message = "AI Assessment Submission\n"
        . "Designation: {$designation}\n"
        . "Current Company: {$current_company}\n"
        . "Experience (Years): {$experience_years}\n"
        . "Interested Role: {$interested_role}";

    $stmtEq = $mysqli->prepare("
        INSERT INTO enquiries
        (first_name, last_name, email, phone, company, subject, message, source, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmtEq) {
        throw new Exception('Failed to prepare enquiries insert.');
    }
    $lastName = '';
    $subject = 'AI Based Assessment (Skill Gap Analysis)';
    $source = 'ai_assessment';
    $stmtEq->bind_param(
        'ssssssss',
        $name,
        $lastName,
        $email,
        $phone,
        $current_company,
        $subject,
        $message,
        $source
    );
    $stmtEq->execute();
    $stmtEq->close();

    $mysqli->commit();

    echo json_encode(['ok' => true, 'message' => 'Assessment submitted successfully.']);
    require_once __DIR__ . '/google_sheet_append.php';
    elevate_after_form_response(function () use ($name, $phone, $email, $designation, $current_company, $experience_years, $interested_role) {
        elevate_google_sheet_append_row('AI_Assessment', [
            date('Y-m-d H:i:s'),
            $name,
            $phone,
            $email,
            $designation,
            $current_company,
            $experience_years,
            $interested_role,
        ]);
    });
} catch (Throwable $e) {
    if ($mysqli->errno) {
        $mysqli->rollback();
    }
    error_log('AI assessment save error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Unable to submit right now. Please try again.']);
}

$mysqli->close();
