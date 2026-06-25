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
    $stmt = $mysqli->prepare("DELETE FROM quiz_categories WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: quiz_categories.php?deleted=1');
    exit;
}

$editingId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editing = null;
if ($editingId > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM quiz_categories WHERE id = ?");
    $stmt->bind_param('i', $editingId);
    $stmt->execute();
    $editing = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $status = ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';

    if ($editingId > 0) {
        $stmt = $mysqli->prepare("UPDATE quiz_categories SET name=?, description=?, sort_order=?, status=? WHERE id=?");
        $stmt->bind_param('ssisi', $name, $description, $sortOrder, $status, $editingId);
        $stmt->execute();
        $stmt->close();
        header('Location: quiz_categories.php?updated=1');
    } else {
        $stmt = $mysqli->prepare("INSERT INTO quiz_categories (name, description, sort_order, status) VALUES (?,?,?,?)");
        $stmt->bind_param('ssis', $name, $description, $sortOrder, $status);
        $stmt->execute();
        $stmt->close();
        header('Location: quiz_categories.php?created=1');
    }
    exit;
}

$cats = $mysqli->query("
    SELECT c.*, (SELECT COUNT(*) FROM quiz_questions q WHERE q.category_id = c.id) AS question_count
    FROM quiz_categories c
    WHERE c.persona_code IS NOT NULL AND c.persona_code != ''
    ORDER BY c.sort_order ASC, c.name ASC
");

$quizPageTitle = 'Quiz Categories';
$quizActiveNav = 'categories';
include __DIR__ . '/quiz_layout_start.php';
?>
<?php if (isset($_GET['created'])): ?><div class="toast">Category created.</div><?php endif; ?>
<?php if (isset($_GET['updated'])): ?><div class="toast">Category updated.</div><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><div class="toast">Category deleted.</div><?php endif; ?>

<div class="grid2">
    <div class="card">
        <h3 style="font-family:'Syne',sans-serif;margin-bottom:14px"><?php echo $editing ? 'Edit Category' : 'Add Category'; ?></h3>
        <form method="post">
            <label>Category Name *</label>
            <input type="text" name="name" required value="<?php echo htmlspecialchars($editing['name'] ?? ''); ?>">

            <label>Description</label>
            <textarea name="description"><?php echo htmlspecialchars($editing['description'] ?? ''); ?></textarea>

            <label>Sort Order</label>
            <input type="number" name="sort_order" value="<?php echo (int)($editing['sort_order'] ?? 0); ?>">

            <label>Status</label>
            <select name="status">
                <option value="active" <?php echo ($editing['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo ($editing['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>

            <button type="submit" class="btn"><?php echo $editing ? 'Update' : 'Create'; ?> Category</button>
            <?php if ($editing): ?><a href="quiz_categories.php" class="btn btn-ghost" style="margin-left:8px">Cancel</a><?php endif; ?>
        </form>
    </div>
    <div class="card">
        <p style="color:var(--ink2);font-size:13px;line-height:1.7">
            Create categories for your AI Assessment quiz. Questions are grouped by category.
            The quiz randomly picks <?php echo (int)quiz_get_settings($mysqli)['total_questions']; ?> questions from each category's question bank (e.g. 200 items) every time a user starts an attempt.
        </p>
    </div>
</div>

<div class="tableWrap">
    <table>
        <thead>
            <tr><th>#</th><th>Persona</th><th>Name</th><th>Bank</th><th>Per Attempt</th><th>Order</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php $perAttempt = (int)quiz_get_settings($mysqli)['total_questions']; ?>
        <?php if ($cats && $cats->num_rows > 0): while ($row = $cats->fetch_assoc()): ?>
            <tr>
                <td><?php echo (int)$row['id']; ?></td>
                <td><?php if (!empty($row['persona_code'])): ?><span class="badge badge-ok"><?php echo htmlspecialchars($row['persona_code']); ?></span><?php else: ?>—<?php endif; ?></td>
                <td>
                    <strong><?php echo htmlspecialchars($row['name']); ?></strong>
                    <?php if ($row['description']): ?><br><small style="color:var(--ink3)"><?php echo htmlspecialchars(mb_substr($row['description'], 0, 80)); ?>…</small><?php endif; ?>
                </td>
                <td><?php echo (int)$row['question_count']; ?> <small style="color:var(--ink3)">/ <?php echo (int)$row['total_questions']; ?></small></td>
                <td><?php echo $perAttempt; ?> random</td>
                <td><?php echo (int)$row['sort_order']; ?></td>
                <td><span class="badge <?php echo $row['status'] === 'active' ? 'badge-ok' : 'badge-off'; ?>"><?php echo $row['status']; ?></span></td>
                <td class="actions">
                    <a href="quiz_categories.php?edit=<?php echo (int)$row['id']; ?>">Edit</a>
                    <a href="quiz_questions.php?category=<?php echo (int)$row['id']; ?>">Questions</a>
                    <a class="del" href="quiz_categories.php?delete=<?php echo (int)$row['id']; ?>" onclick="return confirm('Delete this category and all its questions?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="8" style="color:var(--ink3)">No categories yet. Add your first category above.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/quiz_layout_end.php'; ?>
