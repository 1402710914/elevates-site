<?php
session_start();
include __DIR__ . '/../db.php';
require_once __DIR__ . '/admin_access.php';
require_once __DIR__ . '/../includes/quiz_functions.php';

require_admin_login();
require_permission('can_view_ai_assessment');
quiz_ensure_schema($mysqli);

if (isset($_GET['delete']) && is_numeric($_GET['delete']) && is_super_admin()) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM quiz_attempts WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: quiz_attempts.php?deleted=1');
    exit;
}

$totalRow = $mysqli->query("SELECT COUNT(*) AS c FROM quiz_attempts WHERE status='submitted'")->fetch_assoc();
$todayRow = $mysqli->query("SELECT COUNT(*) AS c FROM quiz_attempts WHERE status='submitted' AND DATE(submitted_at)=CURDATE()")->fetch_assoc();

$attempts = $mysqli->query("
    SELECT * FROM quiz_attempts
    ORDER BY COALESCE(submitted_at, started_at) DESC
    LIMIT 200
");

$quizPageTitle = 'Quiz Attempts';
$quizActiveNav = 'attempts';
include __DIR__ . '/quiz_layout_start.php';
?>
<?php if (isset($_GET['deleted'])): ?><div class="toast">Attempt deleted.</div><?php endif; ?>

<div class="stats">
    <div class="stat"><div class="val"><?php echo (int)($totalRow['c'] ?? 0); ?></div><div class="lab">Total Submitted</div></div>
    <div class="stat"><div class="val"><?php echo (int)($todayRow['c'] ?? 0); ?></div><div class="lab">Submitted Today</div></div>
</div>

<div class="tableWrap">
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Score</th>
                <th>Result</th>
                <th>Time</th>
                <th>Status</th>
                <th>Date</th>
                <?php if (is_super_admin()): ?><th>Actions</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php if ($attempts && $attempts->num_rows > 0): while ($a = $attempts->fetch_assoc()): ?>
            <tr>
                <td>
                    <strong><?php echo htmlspecialchars($a['email']); ?></strong><br>
                    <small style="color:var(--ink3)"><?php echo htmlspecialchars($a['phone']); ?></small>
                </td>
                <td>
                    <?php if ($a['status'] === 'submitted'): ?>
                        <?php echo (int)$a['correct_count']; ?>/<?php echo (int)$a['total_questions']; ?><br>
                        <strong><?php echo $a['score_percent']; ?>%</strong>
                    <?php else: ?>—<?php endif; ?>
                </td>
                <td style="max-width:280px">
                    <?php if ($a['result_title']): ?>
                        <strong><?php echo htmlspecialchars($a['result_title']); ?></strong><br>
                        <small><?php echo htmlspecialchars(mb_strimwidth($a['result_text'] ?? '', 0, 80, '…')); ?></small>
                    <?php else: ?>—<?php endif; ?>
                </td>
                <td>
                    <?php if ($a['time_taken_seconds']): ?>
                        <?php echo floor($a['time_taken_seconds'] / 60); ?>m <?php echo $a['time_taken_seconds'] % 60; ?>s
                    <?php else: ?>—<?php endif; ?>
                </td>
                <td><span class="badge <?php echo $a['status'] === 'submitted' ? 'badge-ok' : ($a['status'] === 'expired' ? 'badge-off' : ''); ?>"><?php echo $a['status']; ?></span></td>
                <td><small><?php echo htmlspecialchars($a['submitted_at'] ?: $a['started_at']); ?></small></td>
                <?php if (is_super_admin()): ?>
                <td class="actions">
                    <a class="del" href="quiz_attempts.php?delete=<?php echo (int)$a['id']; ?>" onclick="return confirm('Delete this attempt?')">Delete</a>
                </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="7" style="color:var(--ink3)">No quiz attempts yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/quiz_layout_end.php'; ?>
