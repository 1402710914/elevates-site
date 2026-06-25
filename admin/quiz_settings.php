<?php
session_start();
include __DIR__ . '/../db.php';
require_once __DIR__ . '/admin_access.php';
require_once __DIR__ . '/../includes/quiz_functions.php';
require_once __DIR__ . '/../includes/quiz_import_personas.php';

require_admin_login();
require_super_admin();
quiz_ensure_schema($mysqli);

if (isset($_GET['import_all_personas']) && $_GET['import_all_personas'] === '1') {
    $importResult = quiz_import_all_personas($mysqli, true);
    $_SESSION['quiz_import_msg'] = $importResult['message'] ?? 'Import done.';
    header('Location: quiz_settings.php');
    exit;
}

$settings = quiz_get_settings($mysqli);
$settingsId = (int)$settings['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $instructions = trim($_POST['instructions'] ?? '');
    $duration = max(1, (int)($_POST['duration_minutes'] ?? 50));
    $totalQuestions = max(1, (int)($_POST['total_questions'] ?? 40));
    $isActive = isset($_POST['is_active']) ? 1 : 0;
    $categoryId = (int)($_POST['category_id'] ?? 0);
    if ($categoryId <= 0) {
        $categoryId = null;
    }

    $stmt = $mysqli->prepare("
        UPDATE quiz_settings SET title=?, instructions=?, duration_minutes=?, total_questions=?, category_id=?, is_active=? WHERE id=?
    ");
    $stmt->bind_param('ssiiiii', $title, $instructions, $duration, $totalQuestions, $categoryId, $isActive, $settingsId);
    $stmt->execute();
    $stmt->close();
    header('Location: quiz_settings.php?saved=1');
    exit;
}

$settings = quiz_get_settings($mysqli);
$activeQ = $mysqli->query("SELECT COUNT(*) AS c FROM quiz_questions WHERE status='active'")->fetch_assoc();
$categories = $mysqli->query("SELECT id, name, (SELECT COUNT(*) FROM quiz_questions q WHERE q.category_id=c.id AND q.status='active') AS qc FROM quiz_categories c WHERE c.persona_code IS NOT NULL AND c.persona_code != '' ORDER BY sort_order, name");
$personaCount = (int)$mysqli->query("SELECT COUNT(*) c FROM quiz_categories WHERE persona_code IS NOT NULL AND persona_code != ''")->fetch_assoc()['c'];

$quizPageTitle = 'Quiz Settings';
$quizActiveNav = 'settings';
include __DIR__ . '/quiz_layout_start.php';
?>
<?php if (isset($_GET['saved'])): ?><div class="toast">Settings saved.</div><?php endif; ?>
<?php if (!empty($_SESSION['quiz_import_msg'])): ?><div class="toast"><?php echo htmlspecialchars($_SESSION['quiz_import_msg']); unset($_SESSION['quiz_import_msg']); ?></div><?php endif; ?>

<div class="stats">
    <div class="stat"><div class="val"><?php echo (int)($activeQ['c'] ?? 0); ?></div><div class="lab">Questions in Bank</div></div>
    <div class="stat"><div class="val"><?php echo (int)$settings['total_questions']; ?></div><div class="lab">Questions per Quiz</div></div>
    <div class="stat"><div class="val"><?php echo (int)$settings['duration_minutes']; ?>m</div><div class="lab">Time Limit</div></div>
</div>

<?php if ((int)($activeQ['c'] ?? 0) < (int)$settings['total_questions']): ?>
<div class="err">Warning: You have fewer active questions (<?php echo (int)$activeQ['c']; ?>) than required per quiz (<?php echo (int)$settings['total_questions']; ?>). Add more questions before users can take the assessment.</div>
<?php endif; ?>

<div class="card" style="max-width:720px">
    <form method="post">
        <label>Quiz Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($settings['title']); ?>" required>

        <label>Instructions (shown before quiz starts)</label>
        <textarea name="instructions" rows="10"><?php echo htmlspecialchars($settings['instructions']); ?></textarea>

        <div class="grid2">
            <div>
                <label>Duration (minutes)</label>
                <input type="number" name="duration_minutes" min="1" max="300" value="<?php echo (int)$settings['duration_minutes']; ?>" required>
            </div>
            <div>
                <label>Questions per Attempt</label>
                <input type="number" name="total_questions" min="1" max="200" value="<?php echo (int)$settings['total_questions']; ?>" required>
            </div>
        </div>

        <label>Quiz Category (optional — legacy; users pick persona on public page)</label>
        <select name="category_id">
            <option value="0">User selects persona on quiz page (recommended)</option>
            <?php if ($categories): while ($c = $categories->fetch_assoc()): ?>
            <option value="<?php echo (int)$c['id']; ?>" <?php echo (int)($settings['category_id'] ?? 0) === (int)$c['id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($c['name']); ?> (<?php echo (int)$c['qc']; ?> questions)
            </option>
            <?php endwhile; endif; ?>
        </select>

        <label style="display:flex;align-items:center;gap:8px;margin-top:8px">
            <input type="checkbox" name="is_active" value="1" <?php echo (int)$settings['is_active'] ? 'checked' : ''; ?> style="width:auto;margin:0">
            Quiz is active (users can take assessment)
        </label>

        <button type="submit" class="btn" style="margin-top:12px">Save Settings</button>
    </form>
</div>

<p style="color:var(--ink3);font-size:13px;margin-top:12px">
    Public quiz page: <a href="../ai-assessment-quiz.php" target="_blank" style="color:var(--acc2)">ai-assessment-quiz.php</a>
    &nbsp;|&nbsp;
    <a href="quiz_settings.php?import_all_personas=1" style="color:var(--acc2)" onclick="return confirm('Sync all 5 personas from doc files? This replaces questions with doc content only (1000 total) and removes any non-doc data.')">
        Sync from Doc Files (P1–P5)
    </a>
    <?php if ($personaCount >= 5): ?> — <span style="color:var(--green)"><?php echo $personaCount; ?> persona categories active</span><?php endif; ?>
</p>
<?php include __DIR__ . '/quiz_layout_end.php'; ?>
