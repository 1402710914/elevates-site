<?php
/**
 * One-time Quiz setup for live server.
 *
 * Usage (SSH on live server, from project root):
 *   php scripts/quiz_install_live.php
 *
 * What it does:
 *   1. Creates/updates all quiz_* tables
 *   2. Imports P1–P5 categories, 1000 questions, result bands, settings
 *
 * Requires: data/persona_p*.json files uploaded with the project.
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    die("Run from command line only: php scripts/quiz_install_live.php\n");
}

$root = dirname(__DIR__);
require_once $root . '/db.php';
require_once $root . '/includes/quiz_functions.php';
require_once $root . '/includes/quiz_import_personas.php';

echo "=== ELEVATES Quiz Live Install ===\n\n";

echo "[1/2] Creating/updating quiz tables...\n";
quiz_ensure_schema($mysqli);
echo "      Done.\n\n";

echo "[2/2] Importing P1–P5 personas (categories + questions + bands)...\n";
$result = quiz_import_all_personas($mysqli, true);

if (!empty($result['purge'])) {
    $p = $result['purge'];
    echo "      Purge: {$p['removed_categories']} categories, {$p['removed_questions']} questions removed.\n";
}

foreach ($result['results'] ?? [] as $r) {
    $status = !empty($r['ok']) ? 'OK' : 'FAIL';
    echo "      [{$status}] " . ($r['message'] ?? $r['name'] ?? 'unknown') . "\n";
}

echo "\n--- Summary ---\n";
$rows = [
    'quiz_categories' => 'SELECT COUNT(*) c FROM quiz_categories',
    'quiz_questions' => 'SELECT COUNT(*) c FROM quiz_questions WHERE status=\'active\'',
    'quiz_result_bands' => 'SELECT COUNT(*) c FROM quiz_result_bands',
    'quiz_settings' => 'SELECT COUNT(*) c FROM quiz_settings',
];
foreach ($rows as $table => $sql) {
    $c = (int)$mysqli->query($sql)->fetch_assoc()['c'];
    echo sprintf("  %-22s %d\n", $table . ':', $c);
}

$settings = quiz_get_settings($mysqli);
echo "\n  Questions per attempt: " . (int)($settings['total_questions'] ?? 40) . "\n";
echo "  Duration (minutes):    " . (int)($settings['duration_minutes'] ?? 50) . "\n";

if (empty($result['ok'])) {
    echo "\nInstall completed with errors. Check messages above.\n";
    exit(1);
}

echo "\nInstall completed successfully.\n";
exit(0);
