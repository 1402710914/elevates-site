<?php
session_start();
include __DIR__ . '/../db.php';
require_once __DIR__ . '/admin_access.php';
require_once __DIR__ . '/../includes/quiz_functions.php';

require_admin_login();
require_super_admin();
quiz_ensure_schema($mysqli);

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM quiz_result_bands WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: quiz_result_bands.php?deleted=1');
    exit;
}

$editingId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editing = null;
if ($editingId > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM quiz_result_bands WHERE id = ?");
    $stmt->bind_param('i', $editingId);
    $stmt->execute();
    $editing = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $minPercent = (float)($_POST['min_percent'] ?? 0);
    $maxPercent = (float)($_POST['max_percent'] ?? 100);
    $title = trim($_POST['title'] ?? '');
    $resultText = trim($_POST['result_text'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);

    if ($editingId > 0) {
        $stmt = $mysqli->prepare("UPDATE quiz_result_bands SET min_percent=?, max_percent=?, title=?, result_text=?, sort_order=? WHERE id=?");
        $stmt->bind_param('ddssii', $minPercent, $maxPercent, $title, $resultText, $sortOrder, $editingId);
        $stmt->execute();
        $stmt->close();
        header('Location: quiz_result_bands.php?updated=1');
    } else {
        $stmt = $mysqli->prepare("INSERT INTO quiz_result_bands (min_percent, max_percent, title, result_text, sort_order) VALUES (?,?,?,?,?)");
        $stmt->bind_param('ddssi', $minPercent, $maxPercent, $title, $resultText, $sortOrder);
        $stmt->execute();
        $stmt->close();
        header('Location: quiz_result_bands.php?created=1');
    }
    exit;
}

$bands = $mysqli->query("SELECT * FROM quiz_result_bands ORDER BY sort_order ASC, min_percent ASC");

$quizPageTitle = 'Result Messages';
$quizActiveNav = 'results';
include __DIR__ . '/quiz_layout_start.php';
?>
<?php if (isset($_GET['created'])): ?><div class="toast">Result band added.</div><?php endif; ?>
<?php if (isset($_GET['updated'])): ?><div class="toast">Result band updated.</div><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><div class="toast">Result band deleted.</div><?php endif; ?>

<div class="grid2">
    <div class="card">
        <h3 style="font-family:'Syne',sans-serif;margin-bottom:14px"><?php echo $editing ? 'Edit Result Band' : 'Add Result Band'; ?></h3>
        <form method="post">
            <div class="grid2">
                <div>
                    <label>Min Score %</label>
                    <input type="number" name="min_percent" step="0.01" min="0" max="100" value="<?php echo htmlspecialchars($editing['min_percent'] ?? '0'); ?>" required>
                </div>
                <div>
                    <label>Max Score %</label>
                    <input type="number" name="max_percent" step="0.01" min="0" max="100" value="<?php echo htmlspecialchars($editing['max_percent'] ?? '100'); ?>" required>
                </div>
            </div>

            <label>Result Title</label>
            <input type="text" name="title" required value="<?php echo htmlspecialchars($editing['title'] ?? ''); ?>" placeholder="e.g. Strong Performer">

            <label>Result Message (shown to user)</label>
            <textarea name="result_text" required rows="6"><?php echo htmlspecialchars($editing['result_text'] ?? ''); ?></textarea>

            <label>Sort Order</label>
            <input type="number" name="sort_order" value="<?php echo (int)($editing['sort_order'] ?? 0); ?>">

            <button type="submit" class="btn"><?php echo $editing ? 'Update' : 'Add'; ?> Result Band</button>
            <?php if ($editing): ?><a href="quiz_result_bands.php" class="btn btn-ghost" style="margin-left:8px">Cancel</a><?php endif; ?>
        </form>
    </div>
    <div class="card">
        <p style="color:var(--ink2);font-size:13px;line-height:1.7">
            Define score ranges and the message users see after submitting the quiz.
            Example: 0–40% = "Needs Improvement", 41–70% = "Good", 71–100% = "Excellent".
        </p>
    </div>
</div>

<div class="tableWrap">
    <table>
        <thead>
            <tr><th>Score Range</th><th>Title</th><th>Message Preview</th><th>Order</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php if ($bands && $bands->num_rows > 0): while ($b = $bands->fetch_assoc()): ?>
            <tr>
                <td><?php echo $b['min_percent']; ?>% – <?php echo $b['max_percent']; ?>%</td>
                <td><strong><?php echo htmlspecialchars($b['title']); ?></strong></td>
                <td style="max-width:320px"><?php echo htmlspecialchars(mb_strimwidth($b['result_text'], 0, 100, '…')); ?></td>
                <td><?php echo (int)$b['sort_order']; ?></td>
                <td class="actions">
                    <a href="quiz_result_bands.php?edit=<?php echo (int)$b['id']; ?>">Edit</a>
                    <a class="del" href="quiz_result_bands.php?delete=<?php echo (int)$b['id']; ?>" onclick="return confirm('Delete this result band?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="5" style="color:var(--ink3)">No result bands yet. Add score-based messages above.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/quiz_layout_end.php'; ?>
