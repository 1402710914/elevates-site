<?php

function quiz_ensure_schema(mysqli $mysqli): void
{
    $mysqli->query("
        CREATE TABLE IF NOT EXISTS quiz_categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT NULL,
            sort_order INT NOT NULL DEFAULT 0,
            status ENUM('active','inactive') NOT NULL DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    $mysqli->query("
        CREATE TABLE IF NOT EXISTS quiz_questions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category_id INT NOT NULL,
            question_text TEXT NOT NULL,
            option_a VARCHAR(500) NOT NULL,
            option_b VARCHAR(500) NOT NULL,
            option_c VARCHAR(500) NULL,
            option_d VARCHAR(500) NULL,
            correct_option ENUM('a','b','c','d') NOT NULL,
            status ENUM('active','inactive') NOT NULL DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_category (category_id),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    $mysqli->query("
        CREATE TABLE IF NOT EXISTS quiz_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL DEFAULT 'AI Based Assessment',
            instructions TEXT NULL,
            duration_minutes INT NOT NULL DEFAULT 50,
            total_questions INT NOT NULL DEFAULT 40,
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    $mysqli->query("
        CREATE TABLE IF NOT EXISTS quiz_result_bands (
            id INT AUTO_INCREMENT PRIMARY KEY,
            min_percent DECIMAL(5,2) NOT NULL DEFAULT 0,
            max_percent DECIMAL(5,2) NOT NULL DEFAULT 100,
            title VARCHAR(255) NOT NULL,
            result_text TEXT NOT NULL,
            sort_order INT NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    $mysqli->query("
        CREATE TABLE IF NOT EXISTS quiz_attempts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            attempt_token VARCHAR(64) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            question_ids JSON NOT NULL,
            answers JSON NULL,
            started_at DATETIME NOT NULL,
            submitted_at DATETIME NULL,
            expires_at DATETIME NOT NULL,
            time_taken_seconds INT NULL,
            total_questions INT NOT NULL,
            correct_count INT NULL,
            score_percent DECIMAL(5,2) NULL,
            result_band_id INT NULL,
            result_title VARCHAR(255) NULL,
            result_text TEXT NULL,
            status ENUM('in_progress','submitted','expired') NOT NULL DEFAULT 'in_progress',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY uq_attempt_token (attempt_token),
            INDEX idx_email (email),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    $count = $mysqli->query("SELECT COUNT(*) AS c FROM quiz_settings")->fetch_assoc();
    if ((int)($count['c'] ?? 0) === 0) {
        $defaultInstructions = "Welcome to the AI Based Assessment.\n\n"
            . "• Total questions: 40\n"
            . "• Time limit: 50 minutes\n"
            . "• Each question has one correct answer — select the best option\n"
            . "• You cannot pause once the quiz starts\n"
            . "• Submit before time runs out\n"
            . "• Results will be shown immediately after submission";
        $stmt = $mysqli->prepare("INSERT INTO quiz_settings (title, instructions, duration_minutes, total_questions) VALUES (?,?,?,?)");
        $title = 'AI Based Assessment';
        $dur = 50;
        $total = 40;
        $stmt->bind_param('ssii', $title, $defaultInstructions, $dur, $total);
        $stmt->execute();
        $stmt->close();
    }

    $questionCols = [
        "item_code VARCHAR(10) NULL",
        "question_type VARCHAR(10) NOT NULL DEFAULT 'K'",
        "option_e VARCHAR(500) NULL",
        "pillar VARCHAR(20) NULL",
        "topic VARCHAR(255) NULL",
        "scoring_meta JSON NULL",
    ];
    foreach ($questionCols as $colDef) {
        $col = strtok($colDef, ' ');
        $res = $mysqli->query("SHOW COLUMNS FROM quiz_questions LIKE '{$col}'");
        if ($res && $res->num_rows === 0) {
            $mysqli->query("ALTER TABLE quiz_questions ADD COLUMN {$colDef}");
        }
    }
    $settingsCol = $mysqli->query("SHOW COLUMNS FROM quiz_settings LIKE 'category_id'");
    if ($settingsCol && $settingsCol->num_rows === 0) {
        $mysqli->query("ALTER TABLE quiz_settings ADD COLUMN category_id INT NULL DEFAULT NULL");
    }

    $categoryCols = [
        "instructions TEXT NULL",
        "duration_minutes INT NOT NULL DEFAULT 90",
        "total_questions INT NOT NULL DEFAULT 200",
        "persona_code VARCHAR(10) NULL",
        "meta_json LONGTEXT NULL",
    ];
    foreach ($categoryCols as $colDef) {
        $col = strtok($colDef, ' ');
        $res = $mysqli->query("SHOW COLUMNS FROM quiz_categories LIKE '{$col}'");
        if ($res && $res->num_rows === 0) {
            $mysqli->query("ALTER TABLE quiz_categories ADD COLUMN {$colDef}");
        }
    }

    $attemptCol = $mysqli->query("SHOW COLUMNS FROM quiz_attempts LIKE 'category_id'");
    if ($attemptCol && $attemptCol->num_rows === 0) {
        $mysqli->query("ALTER TABLE quiz_attempts ADD COLUMN category_id INT NULL DEFAULT NULL");
    }

    $mysqli->query("ALTER TABLE quiz_questions MODIFY COLUMN correct_option ENUM('a','b','c','d','e') NOT NULL DEFAULT 'a'");
}

function quiz_decode_category_meta(?string $json): array
{
    if ($json === null || $json === '') {
        return [];
    }
    $meta = json_decode($json, true);
    return is_array($meta) ? $meta : [];
}

function quiz_item_type_hint(array $meta, string $type): string
{
    $type = strtoupper(trim($type));
    foreach ($meta['item_types'] ?? [] as $item) {
        if (strtoupper($item['code'] ?? '') === $type) {
            return (string)($item['hint'] ?? '');
        }
    }
    $defaults = [
        'K' => 'One correct answer. Choose the best response based on your knowledge.',
        'SJT' => 'All options are plausible. Choose what you would most likely do in real life.',
        'SCI' => 'No right or wrong answer — answer honestly about yourself.',
        'SCI-R' => 'No right or wrong answer — answer honestly.',
        'BEH' => 'Rate how often this applies to you (Never → Always).',
    ];
    return $defaults[$type] ?? '';
}

function quiz_get_questions_per_attempt(mysqli $mysqli): int
{
    $settings = quiz_get_settings($mysqli);
    $count = (int)($settings['total_questions'] ?? 40);
    return max(1, min(200, $count));
}

function quiz_format_category_for_api(array $row, int $perAttempt = 40): array
{
    $bankSize = (int)($row['total_questions'] ?? 200);
    $qCount = (int)($row['question_count'] ?? 0);
    $meta = quiz_decode_category_meta($row['meta_json'] ?? null);

    return [
        'id' => (int)$row['id'],
        'name' => $row['name'],
        'persona_code' => $row['persona_code'] ?? '',
        'description' => $row['description'] ?? '',
        'instructions' => $row['instructions'] ?? '',
        'duration_minutes' => (int)($row['duration_minutes'] ?? 90),
        'total_questions' => $perAttempt,
        'question_bank_size' => $bankSize,
        'question_count' => $qCount,
        'bank_ready' => $qCount >= $perAttempt,
        'context_line' => $meta['context_line'] ?? (explode("\n", $row['description'] ?? '')[1] ?? ''),
        'tagline' => $meta['tagline'] ?? '',
        'persona_label' => $meta['persona'] ?? '',
        'about' => $meta['about'] ?? '',
        'how_to' => $meta['how_to'] ?? '',
        'time_required' => $meta['time_required'] ?? '',
        'pillars' => $meta['pillars'] ?? [],
        'pillar_weights' => $meta['pillar_weights'] ?? [],
        'item_types' => $meta['item_types'] ?? [],
        'proficiency_bands' => $meta['proficiency_bands'] ?? [],
    ];
}

function quiz_get_settings(mysqli $mysqli): array
{
    quiz_ensure_schema($mysqli);
    $row = $mysqli->query("SELECT * FROM quiz_settings ORDER BY id ASC LIMIT 1")->fetch_assoc();
    return $row ?: [
        'title' => 'AI Based Assessment',
        'instructions' => '',
        'duration_minutes' => 50,
        'total_questions' => 40,
        'is_active' => 1,
    ];
}

function quiz_get_categories(mysqli $mysqli): array
{
    quiz_ensure_schema($mysqli);
    $perAttempt = quiz_get_questions_per_attempt($mysqli);
    $res = $mysqli->query("
        SELECT c.*,
               (SELECT COUNT(*) FROM quiz_questions q WHERE q.category_id = c.id AND q.status = 'active') AS question_count
        FROM quiz_categories c
        WHERE c.status = 'active'
          AND c.persona_code IS NOT NULL AND c.persona_code != ''
        ORDER BY c.sort_order ASC, c.name ASC
    ");
    $rows = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $rows[] = quiz_format_category_for_api($row, $perAttempt);
        }
    }
    return $rows;
}

function quiz_get_category_by_id(mysqli $mysqli, int $categoryId): ?array
{
    quiz_ensure_schema($mysqli);
    $perAttempt = quiz_get_questions_per_attempt($mysqli);
    $stmt = $mysqli->prepare("
        SELECT c.*,
               (SELECT COUNT(*) FROM quiz_questions q WHERE q.category_id = c.id AND q.status = 'active') AS question_count
        FROM quiz_categories c
        WHERE c.id = ? AND c.status = 'active'
          AND c.persona_code IS NOT NULL AND c.persona_code != ''
        LIMIT 1
    ");
    $stmt->bind_param('i', $categoryId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$row) {
        return null;
    }
    return quiz_format_category_for_api($row, $perAttempt);
}

function quiz_purge_non_doc_content(mysqli $mysqli): array
{
    quiz_ensure_schema($mysqli);

    $removedQuestions = 0;
    $removedCategories = 0;

    // Remove questions in non-persona categories or without doc item codes
    $mysqli->query("
        DELETE q FROM quiz_questions q
        LEFT JOIN quiz_categories c ON c.id = q.category_id
        WHERE c.persona_code IS NULL OR c.persona_code = '' OR q.item_code IS NULL OR q.item_code = ''
    ");
    $removedQuestions += (int)$mysqli->affected_rows;

    // Remove orphan questions (category deleted)
    $mysqli->query("
        DELETE q FROM quiz_questions q
        LEFT JOIN quiz_categories c ON c.id = q.category_id
        WHERE c.id IS NULL
    ");
    $removedQuestions += (int)$mysqli->affected_rows;

    // Remove non-doc categories (demo / manual without persona)
    $res = $mysqli->query("SELECT id FROM quiz_categories WHERE persona_code IS NULL OR persona_code = ''");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $cid = (int)$row['id'];
            $mysqli->query("DELETE FROM quiz_questions WHERE category_id = {$cid}");
            $removedQuestions += (int)$mysqli->affected_rows;
            $mysqli->query("DELETE FROM quiz_categories WHERE id = {$cid}");
            $removedCategories += (int)$mysqli->affected_rows;
        }
    }

    $mysqli->query("UPDATE quiz_settings SET category_id = 0 WHERE category_id NOT IN (
        SELECT id FROM (SELECT id FROM quiz_categories WHERE persona_code IS NOT NULL AND persona_code != '') t
    ) OR category_id IS NULL");

    return [
        'removed_questions' => $removedQuestions,
        'removed_categories' => $removedCategories,
    ];
}

function quiz_generate_token(): string
{
    return bin2hex(random_bytes(32));
}

function quiz_pick_random_questions(mysqli $mysqli, int $count, ?int $categoryId = null): array
{
    if ($categoryId === null || $categoryId <= 0) {
        return [];
    }

    $stmt = $mysqli->prepare("
        SELECT q.id, q.category_id, q.question_text, q.option_a, q.option_b, q.option_c, q.option_d, q.option_e,
               q.question_type, q.item_code, q.pillar, q.topic, q.scoring_meta, c.name AS category_name
        FROM quiz_questions q
        INNER JOIN quiz_categories c ON c.id = q.category_id
        WHERE q.status = 'active' AND c.status = 'active'
          AND c.persona_code IS NOT NULL AND c.persona_code != ''
          AND q.category_id = ? AND q.item_code IS NOT NULL AND q.item_code != ''
        ORDER BY RAND()
        LIMIT ?
    ");
    $stmt->bind_param('ii', $categoryId, $count);
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $rows;
}

function quiz_format_question_for_client(array $row, array $categoryMeta = []): array
{
    $options = [
        ['key' => 'a', 'text' => $row['option_a']],
        ['key' => 'b', 'text' => $row['option_b']],
    ];
    if (!empty($row['option_c'])) {
        $options[] = ['key' => 'c', 'text' => $row['option_c']];
    }
    if (!empty($row['option_d'])) {
        $options[] = ['key' => 'd', 'text' => $row['option_d']];
    }
    if (!empty($row['option_e'])) {
        $options[] = ['key' => 'e', 'text' => $row['option_e']];
    }

    $qType = strtoupper($row['question_type'] ?? 'K');
    $label = '';
    if (!empty($row['item_code'])) {
        $label = $row['item_code'];
        if (!empty($row['question_type'])) {
            $label .= ' · ' . $row['question_type'];
        }
    }

    $pillarNames = [];
    foreach ($categoryMeta['pillar_weights'] ?? $categoryMeta['pillars'] ?? [] as $pw) {
        $pillarNames[$pw['num'] ?? ''] = $pw['name'] ?? '';
    }
    $pillarNum = str_pad((string)($row['pillar'] ?? ''), 2, '0', STR_PAD_LEFT);
    $pillarLabel = $pillarNames[$pillarNum] ?? '';

    return [
        'id' => (int)$row['id'],
        'category' => $row['category_name'] ?? '',
        'item_code' => $row['item_code'] ?? '',
        'question_type' => $qType,
        'question_label' => $label,
        'pillar' => $row['pillar'] ?? '',
        'pillar_name' => $pillarLabel,
        'topic' => $row['topic'] ?? '',
        'type_hint' => quiz_item_type_hint($categoryMeta, $qType),
        'question' => $row['question_text'],
        'options' => $options,
    ];
}

function quiz_likert_position(string $option): int
{
    $map = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
    return $map[strtolower($option)] ?? 0;
}

function quiz_max_raw_item_score(string $type): float
{
    $type = strtoupper($type);
    if ($type === 'SJT') {
        return 3.0;
    }
    if (in_array($type, ['SCI', 'SCI-R', 'BEH'], true)) {
        return 5.0;
    }
    return 1.0;
}

function quiz_raw_item_score(array $row, string $userAns): float
{
    $userAns = strtolower(trim($userAns));
    if ($userAns === '') {
        return 0.0;
    }

    $type = strtoupper($row['question_type'] ?? 'K');
    $meta = [];
    if (!empty($row['scoring_meta'])) {
        $meta = is_array($row['scoring_meta']) ? $row['scoring_meta'] : json_decode($row['scoring_meta'], true);
        if (!is_array($meta)) {
            $meta = [];
        }
    }

    if ($type === 'SJT' && !empty($meta['weights'][$userAns])) {
        return (float)$meta['weights'][$userAns];
    }

    if (in_array($type, ['SCI', 'BEH', 'SCI-R'], true)) {
        $pos = quiz_likert_position($userAns);
        if ($pos === 0) {
            return 0.0;
        }
        if ($type === 'SCI-R' || !empty($meta['reverse'])) {
            return (float)(6 - $pos);
        }
        return (float)$pos;
    }

    $correct = strtolower($row['correct_option'] ?? '');
    return ($correct !== '' && $userAns === $correct) ? 1.0 : 0.0;
}

function quiz_score_single_question(array $row, string $userAns): float
{
    $type = strtoupper($row['question_type'] ?? 'K');
    $max = quiz_max_raw_item_score($type);
    if ($max <= 0) {
        return 0.0;
    }
    return quiz_raw_item_score($row, $userAns) / $max;
}

function quiz_get_result_band(mysqli $mysqli, float $percent, ?int $categoryId = null): ?array
{
    if ($categoryId !== null && $categoryId > 0) {
        $cat = quiz_get_category_by_id($mysqli, $categoryId);
        $bands = $cat['proficiency_bands'] ?? [];
        foreach ($bands as $band) {
            $min = (float)($band['min'] ?? 0);
            $max = (float)($band['max'] ?? 100);
            if ($percent >= $min && $percent <= $max) {
                return [
                    'id' => 0,
                    'title' => $band['title'] ?? 'Your Result',
                    'result_text' => $band['descriptor'] ?? '',
                    'min_percent' => $min,
                    'max_percent' => $max,
                ];
            }
        }
    }

    $stmt = $mysqli->prepare("
        SELECT * FROM quiz_result_bands
        WHERE ? >= min_percent AND ? <= max_percent
        ORDER BY sort_order ASC, id ASC
        LIMIT 1
    ");
    $stmt->bind_param('dd', $percent, $percent);
    $stmt->execute();
    $band = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $band ?: null;
}

function quiz_score_attempt(mysqli $mysqli, array $questionIds, array $answers, ?int $categoryId = null): array
{
    if (empty($questionIds)) {
        return ['correct' => 0, 'total' => 0, 'percent' => 0.0, 'points' => 0.0, 'max_points' => 0.0, 'pillar_scores' => []];
    }

    $placeholders = implode(',', array_fill(0, count($questionIds), '?'));
    $types = str_repeat('i', count($questionIds));
    $stmt = $mysqli->prepare("
        SELECT id, correct_option, question_type, scoring_meta, pillar
        FROM quiz_questions WHERE id IN ($placeholders)
    ");
    $stmt->bind_param($types, ...$questionIds);
    $stmt->execute();
    $result = $stmt->get_result();
    $questionMap = [];
    while ($row = $result->fetch_assoc()) {
        $questionMap[(int)$row['id']] = $row;
    }
    $stmt->close();

    $pillarRaw = [];
    $pillarMax = [];
    $points = 0.0;
    $fullCorrect = 0;
    $total = count($questionIds);

    foreach ($questionIds as $qid) {
        $qid = (int)$qid;
        $userAns = isset($answers[$qid]) ? strtolower(trim((string)$answers[$qid])) : '';
        if (!isset($questionMap[$qid])) {
            continue;
        }
        $row = $questionMap[$qid];
        $type = strtoupper($row['question_type'] ?? 'K');
        $raw = quiz_raw_item_score($row, $userAns);
        $maxRaw = quiz_max_raw_item_score($type);
        $qScore = $maxRaw > 0 ? ($raw / $maxRaw) : 0.0;
        $points += $qScore;
        if ($qScore >= 0.99) {
            $fullCorrect++;
        }

        $pillarKey = str_pad((string)($row['pillar'] ?? '0'), 2, '0', STR_PAD_LEFT);
        if (!isset($pillarRaw[$pillarKey])) {
            $pillarRaw[$pillarKey] = 0.0;
            $pillarMax[$pillarKey] = 0.0;
        }
        $pillarRaw[$pillarKey] += $raw;
        $pillarMax[$pillarKey] += $maxRaw;
    }

    $category = ($categoryId !== null && $categoryId > 0) ? quiz_get_category_by_id($mysqli, $categoryId) : null;
    $pillarWeights = $category['pillar_weights'] ?? [];
    $weightMap = [];
    foreach ($pillarWeights as $pw) {
        $weightMap[$pw['num'] ?? ''] = (float)($pw['weight_pct'] ?? 0);
    }

    $pillarScores = [];
    $composite = 0.0;
    $weightSum = 0.0;
    foreach ($pillarRaw as $pillarKey => $rawSum) {
        $maxSum = $pillarMax[$pillarKey] ?? 0.0;
        $pct = $maxSum > 0 ? round(($rawSum / $maxSum) * 100, 2) : 0.0;
        $weight = $weightMap[$pillarKey] ?? 0.0;
        $pillarScores[$pillarKey] = [
            'percent' => $pct,
            'weight' => $weight,
        ];
        if ($weight > 0) {
            $composite += $pct * $weight;
            $weightSum += $weight;
        }
    }

    if ($weightSum > 0 && !empty($pillarWeights)) {
        $percent = round($composite / $weightSum, 2);
    } else {
        $percent = $total > 0 ? round(($points / $total) * 100, 2) : 0.0;
    }

    return [
        'correct' => $fullCorrect,
        'total' => $total,
        'percent' => $percent,
        'points' => round($points, 2),
        'max_points' => (float)$total,
        'pillar_scores' => $pillarScores,
    ];
}
