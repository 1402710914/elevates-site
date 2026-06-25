<?php
session_start();
include __DIR__ . '/../db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once __DIR__ . '/admin_access.php';
require_admin_login();
require_permission('can_manage_testimonials');

$uploadError = '';

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM testimonials WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: testimonials.php?deleted=1');
    exit;
}

// Fetch for edit
$editingId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editingTestimonial = null;
if ($editingId > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM testimonials WHERE id = ?");
    $stmt->bind_param('i', $editingId);
    $stmt->execute();
    $editingTestimonial = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Handle create / update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $role        = trim($_POST['role'] ?? '');
    $company     = trim($_POST['company'] ?? '');
    $photo_url   = trim($_POST['photo_url'] ?? '');
    $rating      = (int)($_POST['rating'] ?? 5);
    $text        = trim($_POST['text'] ?? '');
    $status      = $_POST['status'] ?? 'published';
    $category    = $_POST['category'] ?? 'b2c';

    // In edit mode, avoid overwriting existing photo_url with empty value.
    if ($editingId > 0 && $photo_url === '') {
        $photo_url = trim($editingTestimonial['photo_url'] ?? '');
    }

    // Normalize category
    if (!in_array($category, ['b2c', 'b2b'], true)) {
        $category = 'b2c';
    }

    // Optional image upload – store under ../review-img and save relative path in photo_url
    $file = $_FILES['photo_file'] ?? null;
    if (is_array($file)) {
        $uploadDirPath = __DIR__ . '/../review-img';
        $uploadDir = realpath($uploadDirPath);
        $errCode = (int)($file['error'] ?? 0);
        $errMap = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds PHP post_max_size / upload_max_filesize.',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds form max file size.',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder on server.',
            UPLOAD_ERR_CANT_WRITE => 'Server failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'Upload stopped by a PHP extension.',
        ];

        // If user didn't choose a file, do nothing.
        if ($errCode === UPLOAD_ERR_NO_FILE) {
            // keep $photo_url from input (or empty if user intentionally left it blank)
        } elseif ($uploadDir === false) {
            $uploadError = 'Upload folder not found: review-img (expected at: ' . $uploadDirPath . ')';
            error_log('[testimonials] ' . $uploadError);
        } elseif (!is_writable($uploadDir)) {
            $uploadError = 'Upload folder is not writable: ' . $uploadDir;
            error_log('[testimonials] ' . $uploadError);
        } elseif ($errCode !== UPLOAD_ERR_OK) {
            $uploadError = 'Upload failed (code ' . $errCode . ').' . (!empty($errMap[$errCode]) ? ' ' . $errMap[$errCode] : '');
            error_log('[testimonials] upload error code: ' . $errCode);
        } elseif (!is_uploaded_file($file['tmp_name'] ?? '')) {
            $uploadError = 'Upload failed: tmp file not received by PHP.';
            error_log('[testimonials] upload tmp not uploaded: ' . ($file['tmp_name'] ?? ''));
        } else {
            $ext = pathinfo($file['name'] ?? '', PATHINFO_EXTENSION);
            $ext = strtolower(preg_replace('/[^a-z0-9]/i', '', $ext));
            if ($ext === '') {
                $ext = 'jpg';
            }
            $basename = 'testimonial_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
            $targetFsPath = $uploadDir . DIRECTORY_SEPARATOR . $basename;

            if (move_uploaded_file($file['tmp_name'], $targetFsPath)) {
                // Path used on site (relative to web root of /one)
                $photo_url = 'review-img/' . $basename;
            } else {
                $uploadError = 'Upload failed while moving the file to server folder.';
                error_log('[testimonials] move_uploaded_file failed to: ' . $targetFsPath);
            }
        }
    }

    if ($name !== '' && $text !== '') {
        if ($editingId > 0) {
            $stmt = $mysqli->prepare("UPDATE testimonials SET name=?, role=?, company=?, photo_url=?, rating=?, text=?, status=?, category=? WHERE id=?");
            $stmt->bind_param('ssssisssi', $name, $role, $company, $photo_url, $rating, $text, $status, $category, $editingId);
            $stmt->execute();
            $stmt->close();
            if ($uploadError !== '') {
                $_SESSION['flash_upload_error'] = $uploadError;
            } else {
                unset($_SESSION['flash_upload_error']);
            }
            header('Location: testimonials.php?updated=1');
            exit;
        } else {
            $stmt = $mysqli->prepare("INSERT INTO testimonials (name, role, company, photo_url, rating, text, status, category) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bind_param('ssssisss', $name, $role, $company, $photo_url, $rating, $text, $status, $category);
            $stmt->execute();
            $stmt->close();
            if ($uploadError !== '') {
                $_SESSION['flash_upload_error'] = $uploadError;
            } else {
                unset($_SESSION['flash_upload_error']);
            }
            header('Location: testimonials.php?created=1');
            exit;
        }
    }
}

$testimonials = $mysqli->query("SELECT * FROM testimonials ORDER BY created_at DESC");
$admin_name = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');
$adminNavActive = 'testimonials';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Testimonials — Elevate Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0b0c10;
            --bg-2:      #111318;
            --bg-3:      #17191f;
            --bg-hover:  #1e2028;
            --border:    rgba(255,255,255,0.07);
            --border-md: rgba(255,255,255,0.12);
            --ink:       #f0f0f5;
            --ink-2:     #9898a8;
            --ink-3:     #5c5c70;
            --accent:    #7c6ff7;
            --accent-2:  #a89cf9;
            --red:       #f06060;
            --red-bg:    rgba(240,96,96,0.08);
            --green:     #3ecf8e;
            --r:         10px;
            --r-lg:      14px;
        }

        html, body {
            height: 100%;
            background: var(--bg);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .shell { display: flex; min-height: 100vh; }

        .sidebar {
            width: 240px; flex-shrink: 0;
            background: var(--bg-2);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 200;
            transition: transform 0.28s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .sidebar-brand {
            padding: 22px 20px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 11px;
        }
        .brand-mark {
            width: 34px; height: 34px;
            background: var(--accent);
            border-radius: 9px;
            display: grid; place-items: center; flex-shrink: 0;
        }
        .brand-mark svg {
            width: 17px; height: 17px;
            stroke: white; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }
        .brand-label { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: var(--ink); letter-spacing: -0.2px; }
        .brand-sublabel { font-size: 11px; color: var(--ink-3); letter-spacing: 0.3px; }

        .nav { list-style: none; padding: 14px 10px; flex: 1; }
        .nav-item { margin: 2px 0; }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: var(--r);
            color: var(--ink-2); text-decoration: none;
            font-size: 13.5px; font-weight: 400;
            transition: background 0.18s, color 0.18s;
        }
        .nav-link svg {
            width: 16px; height: 16px;
            stroke: currentColor; fill: none;
            stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;
            flex-shrink: 0;
        }
        .nav-link:hover { background: var(--bg-hover); color: var(--ink); }
        .nav-link.active { background: rgba(124,111,247,0.12); color: var(--accent-2); }
        .nav-link.active svg { stroke: var(--accent-2); }
        .nav-sep { height: 1px; background: var(--border); margin: 10px 2px; }
        .nav-link.danger { color: var(--red); }
        .nav-link.danger:hover { background: var(--red-bg); }
        .nav-link.danger svg { stroke: var(--red); }

        .sidebar-footer { padding: 14px 10px; border-top: 1px solid var(--border); }
        .user-pill { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: var(--r); }
        .avatar {
            width: 30px; height: 30px;
            background: rgba(124,111,247,0.18);
            border-radius: 50%;
            display: grid; place-items: center;
            font-family: 'Syne', sans-serif; font-size: 12px; font-weight: 700;
            color: var(--accent-2); flex-shrink: 0; text-transform: uppercase;
        }
        .user-name { font-size: 13px; color: var(--ink); font-weight: 500; }
        .user-role { font-size: 11px; color: var(--ink-3); }

        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar {
            background: var(--bg-2); border-bottom: 1px solid var(--border);
            padding: 0 28px; height: 58px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .page-title { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: var(--ink); letter-spacing: -0.2px; }
        .breadcrumb { font-size: 12px; color: var(--ink-3); display: flex; align-items: center; gap: 6px; }
        .breadcrumb span { color: var(--ink-2); }

        .content { padding: 28px; flex: 1; }
        .panels { display: grid; grid-template-columns: 380px 1fr; gap: 20px; align-items: flex-start; }
        .panel {
            background: var(--bg-2); border: 1px solid var(--border);
            border-radius: var(--r-lg); padding: 18px 20px;
        }
        .panel h2 {
            font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700;
            margin-bottom: 14px; color: var(--ink);
        }

        .field { margin-bottom: 14px; }
        .field label {
            display: block; font-size: 11px; font-weight: 500;
            text-transform: uppercase; letter-spacing: 0.6px;
            color: var(--ink-3); margin-bottom: 6px;
        }
        .field input[type="text"],
        .field input[type="number"],
        .field select,
        .field textarea {
            width: 100%;
            background: var(--bg-3); border: 1px solid var(--border);
            border-radius: var(--r); color: var(--ink);
            font-family: 'DM Sans', sans-serif; font-size: 13.5px;
            padding: 8px 11px; outline: none;
        }
        .field small { font-size: 11px; color: var(--ink-3); }

        .btn-primary {
            width: 100%; height: 40px;
            background: var(--accent); color: #fff;
            border-radius: var(--r); border: none;
            font-size: 13.5px; font-weight: 500;
            cursor: pointer;
        }
        .btn-secondary {
            width: 100%; height: 38px; margin-top: 6px;
            background: none; border-radius: var(--r);
            border: 1px solid var(--border);
            color: var(--ink-3); font-size: 13px;
            cursor: pointer;
        }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { padding: 8px 8px; border-bottom: 1px solid var(--border); text-align: left; vertical-align: top; }
        th { font-size: 11px; text-transform: uppercase; color: var(--ink-3); letter-spacing: 0.6px; }
        td.status { font-size: 12px; color: var(--ink-2); }
        td.actions a { font-size: 12px; margin-right: 10px; text-decoration: none; }
        td.actions a.edit { color: var(--accent-2); }
        td.actions a.del { color: var(--red); }

        .flash { margin-bottom: 14px; font-size: 13px; }
        .flash.ok { color: var(--green); }
        .flash.err { color: var(--red); }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .panels { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="shell">
<aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-mark">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
            </div>
            <div>
                <div class="brand-label">Elevate Pro</div>
                <div class="brand-sublabel">Admin Panel</div>
            </div>
        </div>
        <?php include __DIR__ . '/includes/sidebar_nav.php'; ?>

<div class="sidebar-footer">
            <div class="user-pill">
                <div class="avatar"><?= strtoupper(substr($admin_name, 0, 2)) ?></div>
                <div>
                    <div class="user-name"><?= $admin_name ?></div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <div class="topbar-left">
                <div>
                    <div class="page-title">Testimonials</div>
                    <div class="breadcrumb">Elevate Pro <span>›</span> Testimonials</div>
                </div>
            </div>
        </div>

        <div class="content">
            <?php if (isset($_GET['created'])): ?>
                <div class="flash ok">Testimonial created successfully.</div>
            <?php elseif (isset($_GET['updated'])): ?>
                <div class="flash ok">Testimonial updated successfully.</div>
            <?php elseif (isset($_GET['deleted'])): ?>
                <div class="flash err">Testimonial deleted.</div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['flash_upload_error'])): ?>
                <div class="flash err"><?= htmlspecialchars($_SESSION['flash_upload_error']) ?></div>
                <?php unset($_SESSION['flash_upload_error']); ?>
            <?php endif; ?>
            <?php if (!empty($uploadError)): ?>
                <div class="flash err"><?= htmlspecialchars($uploadError) ?></div>
            <?php endif; ?>

            <div class="panels">
                <div class="panel">
                    <h2><?= $editingId ? 'Edit Testimonial' : 'New Testimonial' ?></h2>
                    <form action="testimonials.php<?= $editingId ? '?edit='.$editingId : '' ?>" method="post" enctype="multipart/form-data">
                        <div class="field">
                            <label>Name</label>
                            <input type="text" name="name" required
                                   value="<?= htmlspecialchars($editingTestimonial['name'] ?? '') ?>">
                        </div>
                        <div class="field">
                            <label>Role / Title</label>
                            <input type="text" name="role"
                                   placeholder="Director, VP, Student..."
                                   value="<?= htmlspecialchars($editingTestimonial['role'] ?? '') ?>">
                        </div>
                        <div class="field">
                            <label>Company</label>
                            <input type="text" name="company"
                                   value="<?= htmlspecialchars($editingTestimonial['company'] ?? '') ?>">
                        </div>
                        <div class="field">
                            <label>Photo URL (optional)</label>
                            <input type="text" name="photo_url"
                                   placeholder="img/rahul.png or full URL"
                                   value="<?= htmlspecialchars($editingTestimonial['photo_url'] ?? '') ?>">
                            <small>Agar blank hoga to auto avatar use hoga. Neeche se image upload bhi kar sakte ho.</small>
                        </div>
                        <div class="field">
                            <label>Upload Photo (optional)</label>
                            <input type="file" name="photo_file" accept="image/*">
                            <small>JPEG/PNG image. Upload karoge to ye hi image use hogi.</small>
                        </div>
                        <div class="field">
                            <label>Rating (1–5)</label>
                            <?php $rt = (int)($editingTestimonial['rating'] ?? 5); ?>
                            <input type="number" name="rating" min="1" max="5" value="<?= $rt ?: 5 ?>">
                        </div>
                        <div class="field">
                            <label>Category</label>
                            <?php $cat = $editingTestimonial['category'] ?? 'b2c'; ?>
                            <select name="category">
                                <option value="b2c" <?= $cat === 'b2c' ? 'selected' : '' ?>>B2C / Professionals</option>
                                <option value="b2b" <?= $cat === 'b2b' ? 'selected' : '' ?>>B2B / Businesses</option>
                            </select>
                        </div>
                        <div class="field">
                            <label>Testimonial Text</label>
                            <textarea name="text" rows="6" required><?= htmlspecialchars($editingTestimonial['text'] ?? '') ?></textarea>
                        </div>
                        <div class="field">
                            <label>Status</label>
                            <?php $st = $editingTestimonial['status'] ?? 'published'; ?>
                            <select name="status">
                                <option value="published" <?= $st === 'published' ? 'selected' : '' ?>>Published</option>
                                <option value="draft" <?= $st === 'draft' ? 'selected' : '' ?>>Draft</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary">
                            <?= $editingId ? 'Update Testimonial' : 'Save Testimonial' ?>
                        </button>
                        <?php if ($editingId): ?>
                            <button type="button" class="btn-secondary" onclick="window.location='testimonials.php'">Cancel edit</button>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="panel">
                    <h2>All Testimonials</h2>
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Role & Company</th>
                            <th>Rating</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($testimonials && $testimonials->num_rows > 0): ?>
                            <?php while ($row = $testimonials->fetch_assoc()): ?>
                                <tr>
                                    <td><?= (int)$row['id'] ?></td>
                                    <td>
                                        <?php
                                        $thumb = trim($row['photo_url'] ?? '');
                                        if ($thumb === '') {
                                            // Fallback thumbnails for cases where upload/photo_url is empty
                                            $cat = strtolower(trim($row['category'] ?? 'b2c'));
                                            $thumb = $cat === 'b2b' ? 'review-img/8.jpg' : 'review-img/1.jpg';
                                        }
                                        // Admin page is inside /one/admin, so fix relative image path.
                                        $thumbSrc = $thumb;
                                        if ($thumbSrc !== '' && strpos($thumbSrc, 'review-img/') === 0) {
                                            $thumbSrc = '../' . $thumbSrc;
                                        }
                                        if ($thumbSrc !== ''):
                                        ?>
                                            <img src="<?= htmlspecialchars($thumbSrc) ?>" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td>
                                        <?= htmlspecialchars($row['role']) ?><br>
                                        <small><?= htmlspecialchars($row['company']) ?></small>
                                    </td>
                                    <td><?= (int)$row['rating'] ?>/5</td>
                                    <td><?= htmlspecialchars(strtoupper($row['category'] ?? 'b2c')) ?></td>
                                    <td class="status"><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                                    <td class="actions">
                                        <a href="testimonials.php?edit=<?= (int)$row['id'] ?>" class="edit">Edit</a>
                                        <a href="testimonials.php?delete=<?= (int)$row['id'] ?>" class="del"
                                           onclick="return confirm('Delete this testimonial?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6">No testimonials yet.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $mysqli->close(); ?>
</body>
</html>

