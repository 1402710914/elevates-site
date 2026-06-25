<?php
session_start();
include __DIR__ . '/../db.php';
require_once __DIR__ . '/admin_access.php';
require_once __DIR__ . '/../includes/quiz_functions.php';

require_admin_login();
require_super_admin();
quiz_ensure_schema($mysqli);

$filterCat = isset($_GET['category']) ? (int)$_GET['category'] : 0;

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM quiz_questions WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $redir = 'quiz_questions.php?deleted=1' . ($filterCat ? '&category=' . $filterCat : '');
    header('Location: ' . $redir);
    exit;
}

$editingId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editing = null;
if ($editingId > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM quiz_questions WHERE id = ?");
    $stmt->bind_param('i', $editingId);
    $stmt->execute();
    $editing = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($editing) {
        $filterCat = (int)$editing['category_id'];
    }
}

$categories = $mysqli->query("SELECT id, name FROM quiz_categories WHERE persona_code IS NOT NULL AND persona_code != '' ORDER BY sort_order ASC, name ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = (int)($_POST['category_id'] ?? 0);
    $questionText = trim($_POST['question_text'] ?? '');
    $optionA = trim($_POST['option_a'] ?? '');
    $optionB = trim($_POST['option_b'] ?? '');
    $optionC = trim($_POST['option_c'] ?? '');
    $optionD = trim($_POST['option_d'] ?? '');
    $correct = strtolower(trim($_POST['correct_option'] ?? 'a'));
    $status = ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';

    if (!in_array($correct, ['a', 'b', 'c', 'd'], true)) {
        $correct = 'a';
    }
    if ($optionC === '') { $optionC = null; }
    if ($optionD === '') { $optionD = null; }

    if ($editingId > 0) {
        $stmt = $mysqli->prepare("
            UPDATE quiz_questions SET category_id=?, question_text=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=?, status=?
            WHERE id=?
        ");
        $stmt->bind_param('isssssssi', $categoryId, $questionText, $optionA, $optionB, $optionC, $optionD, $correct, $status, $editingId);
        $stmt->execute();
        $stmt->close();
        header('Location: quiz_questions.php?updated=1&category=' . $categoryId);
    } else {
        $stmt = $mysqli->prepare("
            INSERT INTO quiz_questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_option, status)
            VALUES (?,?,?,?,?,?,?,?)
        ");
        $stmt->bind_param('isssssss', $categoryId, $questionText, $optionA, $optionB, $optionC, $optionD, $correct, $status);
        $stmt->execute();
        $stmt->close();
        header('Location: quiz_questions.php?created=1&category=' . $categoryId);
    }
    exit;
}

$sql = "
    SELECT q.*, c.name AS category_name
    FROM quiz_questions q
    INNER JOIN quiz_categories c ON c.id = q.category_id
";
if ($filterCat > 0) {
    $sql .= " WHERE q.category_id = " . $filterCat;
}
$sql .= " ORDER BY q.id DESC";
$questions = $mysqli->query($sql);

$totalActive = $mysqli->query("SELECT COUNT(*) AS c FROM quiz_questions WHERE status='active'")->fetch_assoc();

$quizPageTitle = 'Quiz Questions';
$quizActiveNav = 'questions';
include __DIR__ . '/quiz_layout_start.php';
?>
<?php if (isset($_GET['created'])): ?><div class="toast">Question added.</div><?php endif; ?>
<?php if (isset($_GET['updated'])): ?><div class="toast">Question updated.</div><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><div class="toast">Question deleted.</div><?php endif; ?>

<div class="stats">
    <div class="stat"><div class="val"><?php echo (int)($totalActive['c'] ?? 0); ?></div><div class="lab">Active Questions</div></div>
    <div class="stat"><div class="val"><?php echo (int)quiz_get_settings($mysqli)['total_questions']; ?></div><div class="lab">Per Quiz Attempt</div></div>
</div>

<div class="card" style="margin-bottom:16px">
    <form method="get" style="display:flex;gap:12px;align-items:end;flex-wrap:wrap">
        <div style="flex:1;min-width:200px">
            <label>Filter by Category</label>
            <select name="category" onchange="this.form.submit()">
                <option value="0">All Categories</option>
                <?php if ($categories): $categories->data_seek(0); while ($c = $categories->fetch_assoc()): ?>
                    <option value="<?php echo (int)$c['id']; ?>" <?php echo $filterCat === (int)$c['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['name']); ?></option>
                <?php endwhile; endif; ?>
            </select>
        </div>
        <a href="quiz_questions.php" class="btn btn-ghost">Clear Filter</a>
    </form>
</div>

<div class="grid2">
    <div class="card">
        <h3 style="font-family:'Syne',sans-serif;margin-bottom:14px"><?php echo $editing ? 'Edit Question' : 'Add Question'; ?></h3>
        <form method="post">
            <label>Category *</label>
            <select name="category_id" required>
                <option value="">Select category</option>
                <?php if ($categories): $categories->data_seek(0); while ($c = $categories->fetch_assoc()): ?>
                    <option value="<?php echo (int)$c['id']; ?>" <?php echo ($filterCat === (int)$c['id'] || (int)($editing['category_id'] ?? 0) === (int)$c['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['name']); ?></option>
                <?php endwhile; endif; ?>
            </select>

            <label>Question *</label>
            <textarea name="question_text" required><?php echo htmlspecialchars($editing['question_text'] ?? ''); ?></textarea>

            <label>Option A *</label>
            <input type="text" name="option_a" required value="<?php echo htmlspecialchars($editing['option_a'] ?? ''); ?>">

            <label>Option B *</label>
            <input type="text" name="option_b" required value="<?php echo htmlspecialchars($editing['option_b'] ?? ''); ?>">

            <label>Option C</label>
            <input type="text" name="option_c" value="<?php echo htmlspecialchars($editing['option_c'] ?? ''); ?>">

            <label>Option D</label>
            <input type="text" name="option_d" value="<?php echo htmlspecialchars($editing['option_d'] ?? ''); ?>">

            <label>Correct Answer (tick mark) *</label>
            <select name="correct_option" required>
                <?php foreach (['a' => 'Option A', 'b' => 'Option B', 'c' => 'Option C', 'd' => 'Option D'] as $k => $lbl): ?>
                    <option value="<?php echo $k; ?>" <?php echo ($editing['correct_option'] ?? 'a') === $k ? 'selected' : ''; ?>><?php echo $lbl; ?></option>
                <?php endforeach; ?>
            </select>

            <label>Status</label>
            <select name="status">
                <option value="active" <?php echo ($editing['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo ($editing['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>

            <button type="submit" class="btn"><?php echo $editing ? 'Update' : 'Add'; ?> Question</button>
            <?php if ($editing): ?><a href="quiz_questions.php<?php echo $filterCat ? '?category='.$filterCat : ''; ?>" class="btn btn-ghost" style="margin-left:8px">Cancel</a><?php endif; ?>
        </form>
    </div>
    <div class="card">
        <p style="color:var(--ink2);font-size:13px;line-height:1.7">
            Each question has multiple choice options (A–D). Mark the correct answer using the dropdown.
            Questions are randomly selected from all categories for each quiz attempt.
        </p>
    </div>
</div>

<div class="tableWrap">
    <table>
        <thead>
            <tr><th>#</th><th>Code</th><th>Category</th><th>Type</th><th>Question</th><th>Correct</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php if ($questions && $questions->num_rows > 0): while ($q = $questions->fetch_assoc()): ?>
            <tr>
                <td><?php echo (int)$q['id']; ?></td>
                <td><?php echo htmlspecialchars($q['item_code'] ?? '—'); ?></td>
                <td><?php echo htmlspecialchars($q['category_name']); ?></td>
                <td><span class="badge badge-ok"><?php echo htmlspecialchars($q['question_type'] ?? 'K'); ?></span></td>
                <td style="max-width:360px"><?php echo htmlspecialchars(mb_strimwidth($q['question_text'], 0, 120, '…')); ?></td>
                <td><strong><?php echo strtoupper($q['correct_option']); ?></strong></td>
                <td><span class="badge <?php echo $q['status'] === 'active' ? 'badge-ok' : 'badge-off'; ?>"><?php echo $q['status']; ?></span></td>
                <td class="actions">
                    <a href="quiz_questions.php?edit=<?php echo (int)$q['id']; ?>">Edit</a>
                    <a class="del" href="quiz_questions.php?delete=<?php echo (int)$q['id']; ?><?php echo $filterCat ? '&category='.$filterCat : ''; ?>" onclick="return confirm('Delete this question?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="8" style="color:var(--ink3)">No questions found. Add questions above.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/quiz_layout_end.php'; ?>
