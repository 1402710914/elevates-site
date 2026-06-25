<?php
require_once __DIR__ . '/quiz_functions.php';

function quiz_build_persona_instructions(array $meta): string
{
    $parts = [
        trim($meta['header'] ?? 'ELEVATES | PROFESSIONAL GROWTH ASSESSMENT'),
        trim(($meta['persona'] ?? '') . ' — ' . ($meta['title'] ?? $meta['name'] ?? '')),
        trim($meta['context_line'] ?? ''),
        '',
    ];
    if (!empty($meta['tagline'])) {
        $parts[] = trim($meta['tagline']);
        $parts[] = '';
    }
    if (!empty($meta['pillars'])) {
        $parts[] = 'FIVE PILLARS ASSESSED';
        foreach ($meta['pillars'] as $p) {
            $parts[] = ($p['num'] ?? '') . '  ' . ($p['name'] ?? '');
        }
        $parts[] = '';
    }
    if (!empty($meta['about'])) {
        $parts[] = "ABOUT THIS ASSESSMENT\n" . trim($meta['about']);
        $parts[] = '';
    }
    if (!empty($meta['how_to'])) {
        $parts[] = "HOW TO TAKE THIS ASSESSMENT\n" . trim($meta['how_to']);
        $parts[] = '';
    }
    if (!empty($meta['time_required'])) {
        $parts[] = 'TIME REQUIRED: ' . trim($meta['time_required']);
        $parts[] = '';
    }
    if (!empty($meta['item_types'])) {
        $parts[] = 'ITEM TYPES IN THIS ASSESSMENT';
        foreach ($meta['item_types'] as $it) {
            $parts[] = '• ' . ($it['code'] ?? '') . ' — ' . ($it['name'] ?? '') . ': ' . ($it['hint'] ?? '');
        }
        $parts[] = '';
    }
    if (!empty($meta['pillar_weights'])) {
        $parts[] = 'PILLAR WEIGHTS (for composite score)';
        foreach ($meta['pillar_weights'] as $pw) {
            $parts[] = sprintf('• %s — %s items (%s)', $pw['name'] ?? '', $pw['items'] ?? '', $pw['weight'] ?? '');
        }
        $parts[] = '';
    }
    if (!empty($meta['proficiency_bands'])) {
        $parts[] = 'PROFICIENCY BANDS';
        foreach ($meta['proficiency_bands'] as $b) {
            $parts[] = sprintf('• %s (%s–%s): %s', $b['title'] ?? '', $b['min'] ?? '', $b['max'] ?? '', $b['descriptor'] ?? '');
        }
    }
    return implode("\n", $parts);
}

function quiz_build_persona_description(array $meta): string
{
    return trim(($meta['persona'] ?? '') . "\n"
        . ($meta['context_line'] ?? '') . "\n\n"
        . mb_strimwidth(trim($meta['about'] ?? ''), 0, 500, '…'));
}

function quiz_import_persona(mysqli $mysqli, string $personaCode, bool $replaceQuestions = false): array
{
    quiz_ensure_schema($mysqli);
    $code = strtoupper($personaCode);
    $dataDir = __DIR__ . '/../data';
    $metaPath = "{$dataDir}/persona_" . strtolower($code) . "_meta.json";
    $questionsPath = "{$dataDir}/persona_" . strtolower($code) . "_questions.json";

    if (!is_file($metaPath) || !is_file($questionsPath)) {
        return ['ok' => false, 'message' => "Data files missing for {$code}."];
    }

    $meta = json_decode(file_get_contents($metaPath), true);
    $questions = json_decode(file_get_contents($questionsPath), true);
    if (!is_array($meta) || !is_array($questions) || empty($questions)) {
        return ['ok' => false, 'message' => "Invalid data for {$code}."];
    }

    $catName = $meta['name'] ?? $code;
    $description = quiz_build_persona_description($meta);
    $instructions = quiz_build_persona_instructions($meta);
    $metaJson = json_encode($meta, JSON_UNESCAPED_UNICODE);
    $sortOrder = (int)($meta['sort_order'] ?? 0);
    $personaCodeDb = $code;
    $duration = 90;
    $totalQ = 200;

    $stmt = $mysqli->prepare("SELECT id FROM quiz_categories WHERE persona_code = ? OR name = ? LIMIT 1");
    $stmt->bind_param('ss', $personaCodeDb, $catName);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($row) {
        $categoryId = (int)$row['id'];
        $upd = $mysqli->prepare("
            UPDATE quiz_categories SET name=?, description=?, instructions=?, duration_minutes=?, total_questions=?, persona_code=?, sort_order=?, meta_json=?, status='active' WHERE id=?
        ");
        $upd->bind_param('sssissisi', $catName, $description, $instructions, $duration, $totalQ, $personaCodeDb, $sortOrder, $metaJson, $categoryId);
        $upd->execute();
        $upd->close();
    } else {
        $ins = $mysqli->prepare("
            INSERT INTO quiz_categories (name, description, instructions, duration_minutes, total_questions, persona_code, sort_order, meta_json, status)
            VALUES (?,?,?,?,?,?,?,?,'active')
        ");
        $ins->bind_param('sssissis', $catName, $description, $instructions, $duration, $totalQ, $personaCodeDb, $sortOrder, $metaJson);
        $ins->execute();
        $categoryId = (int)$ins->insert_id;
        $ins->close();
    }

    if ($replaceQuestions) {
        $del = $mysqli->prepare("DELETE FROM quiz_questions WHERE category_id = ?");
        $del->bind_param('i', $categoryId);
        $del->execute();
        $del->close();
    }

    $inserted = 0;
    $skipped = 0;
    $insQ = $mysqli->prepare("
        INSERT INTO quiz_questions (
            category_id, item_code, question_type, question_text,
            option_a, option_b, option_c, option_d, option_e,
            correct_option, pillar, topic, scoring_meta, status
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,'active')
    ");

    foreach ($questions as $q) {
        $itemCode = $q['item_code'] ?? '';
        if (!$replaceQuestions) {
            $check = $mysqli->prepare("SELECT id FROM quiz_questions WHERE category_id=? AND item_code=? LIMIT 1");
            $check->bind_param('is', $categoryId, $itemCode);
            $check->execute();
            if ($check->get_result()->fetch_assoc()) {
                $check->close();
                $skipped++;
                continue;
            }
            $check->close();
        }

        $opts = $q['options'] ?? [];
        $oa = $opts['a'] ?? '';
        $ob = $opts['b'] ?? '';
        $oc = $opts['c'] ?? null;
        $od = $opts['d'] ?? null;
        $oe = $opts['e'] ?? null;
        $correct = $q['correct'] ?? 'a';
        $qtype = $q['question_type'] ?? 'K';
        $qtext = $q['question_text'] ?? '';
        $pillar = $q['pillar'] ?? '';
        $topic = $q['topic'] ?? '';
        $metaJson = json_encode($q['scoring_meta'] ?? []);

        $insQ->bind_param(
            'issssssssssss',
            $categoryId,
            $itemCode,
            $qtype,
            $qtext,
            $oa,
            $ob,
            $oc,
            $od,
            $oe,
            $correct,
            $pillar,
            $topic,
            $metaJson
        );
        $insQ->execute();
        $inserted++;
    }
    $insQ->close();

    $totalInCat = (int)$mysqli->query("SELECT COUNT(*) c FROM quiz_questions WHERE category_id={$categoryId} AND status='active'")->fetch_assoc()['c'];

    return [
        'ok' => true,
        'code' => $code,
        'name' => $catName,
        'category_id' => $categoryId,
        'inserted' => $inserted,
        'skipped' => $skipped,
        'total' => $totalInCat,
        'message' => "{$catName}: {$inserted} imported, {$skipped} skipped. Total: {$totalInCat}.",
    ];
}

function quiz_import_all_personas(mysqli $mysqli, bool $replaceQuestions = true): array
{
    $purge = quiz_purge_non_doc_content($mysqli);
    $codes = ['P1', 'P2', 'P3', 'P4', 'P5'];
    $results = [];
    foreach ($codes as $code) {
        $results[] = quiz_import_persona($mysqli, $code, $replaceQuestions);
    }

    // Proficiency bands from doc (same descriptors across personas)
    $p1MetaPath = __DIR__ . '/../data/persona_p1_meta.json';
    $p1Meta = is_file($p1MetaPath) ? json_decode(file_get_contents($p1MetaPath), true) : [];
    $bands = is_array($p1Meta) ? ($p1Meta['proficiency_bands'] ?? []) : [];
    if (!empty($bands)) {
        $mysqli->query("DELETE FROM quiz_result_bands");
        $bandIns = $mysqli->prepare("INSERT INTO quiz_result_bands (min_percent, max_percent, title, result_text, sort_order) VALUES (?,?,?,?,?)");
        foreach ($bands as $i => $b) {
            $sort = $i + 1;
            $min = (float)($b['min'] ?? 0);
            $max = (float)($b['max'] ?? 100);
            $title = $b['title'] ?? 'RESULT';
            $text = $b['descriptor'] ?? '';
            $bandIns->bind_param('ddssi', $min, $max, $title, $text, $sort);
            $bandIns->execute();
        }
        $bandIns->close();
    } elseif ((int)$mysqli->query("SELECT COUNT(*) c FROM quiz_result_bands")->fetch_assoc()['c'] < 5) {
        $mysqli->query("DELETE FROM quiz_result_bands");
        $bands = [
            [85, 100, 'ADVANCED', 'Demonstrates sustained mastery. Ready for senior responsibility, mentoring others, and leading complex initiatives.'],
            [70, 84.99, 'PROFICIENT', 'Reliably effective in most situations. Benefits from stretch assignments and exposure to higher-complexity challenges.'],
            [50, 69.99, 'COMPETENT', 'Solid foundation with room to deepen. Coaching, applied practice, and structured feedback will accelerate development.'],
            [30, 49.99, 'EMERGING', 'Foundational understanding but inconsistent application. Needs targeted skill-building and supervised practice.'],
            [0, 29.99, 'DEVELOPING', 'Significant gap. Requires intensive learning, mentorship, and behavioral coaching before independent responsibility is appropriate.'],
        ];
        $bandIns = $mysqli->prepare("INSERT INTO quiz_result_bands (min_percent, max_percent, title, result_text, sort_order) VALUES (?,?,?,?,?)");
        foreach ($bands as $i => $b) {
            $sort = $i + 1;
            $bandIns->bind_param('ddssi', $b[0], $b[1], $b[2], $b[3], $sort);
            $bandIns->execute();
        }
        $bandIns->close();
    }

    // Global quiz settings — user picks category on site
    $settings = quiz_get_settings($mysqli);
    $settingsId = (int)$settings['id'];
    $title = 'ELEVATES Professional Growth Assessment';
    $instructions = 'Select your persona below to begin the professional growth assessment matched to your career stage. Each attempt includes 40 randomly selected questions from a 200-item bank.';
    $duration = 50;
    $totalQ = 40;
    $categoryId = 0;
    $isActive = 1;
    $upd = $mysqli->prepare("UPDATE quiz_settings SET title=?, instructions=?, duration_minutes=?, total_questions=?, category_id=?, is_active=? WHERE id=?");
    $upd->bind_param('ssiiiii', $title, $instructions, $duration, $totalQ, $categoryId, $isActive, $settingsId);
    $upd->execute();
    $upd->close();

    $ok = true;
    $summary = [];
    foreach ($results as $r) {
        if (empty($r['ok'])) {
            $ok = false;
        }
        $summary[] = $r['message'] ?? ($r['name'] ?? 'Error');
    }

    return [
        'ok' => $ok,
        'results' => $results,
        'purge' => $purge,
        'message' => 'Purge: ' . $purge['removed_categories'] . ' non-doc categories, ' . $purge['removed_questions'] . ' extra questions removed. | ' . implode(' | ', $summary),
    ];
}