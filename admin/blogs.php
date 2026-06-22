<?php
session_start();
include __DIR__ . '/../db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once __DIR__ . '/admin_access.php';
require_admin_login();
require_can_manage_blogs();
$isSuperAdmin = is_super_admin();

if (!function_exists('ensure_unique_blog_slug')) {
    function ensure_unique_blog_slug(mysqli $mysqli, string $baseSlug, int $excludeId = 0): string
    {
        $slug = trim($baseSlug);
        if ($slug === '') {
            $slug = 'post';
        }
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $slug));
        $slug = trim($slug, '-');
        if ($slug === '') {
            $slug = 'post';
        }

        $candidate = $slug;
        $suffix = 2;
        while (true) {
            if ($excludeId > 0) {
                $stmt = $mysqli->prepare("SELECT id FROM blogs WHERE slug = ? AND id != ? LIMIT 1");
                $stmt->bind_param('si', $candidate, $excludeId);
            } else {
                $stmt = $mysqli->prepare("SELECT id FROM blogs WHERE slug = ? LIMIT 1");
                $stmt->bind_param('s', $candidate);
            }
            $stmt->execute();
            $exists = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (!$exists) {
                return $candidate;
            }
            $candidate = $slug . '-' . $suffix;
            $suffix++;
        }
    }
}

$uploadDir = __DIR__ . '/../uploads/blogs';
$uploadError = '';
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0775, true)) {
        $uploadError = 'Upload folder create nahi ho pa rahi: ' . htmlspecialchars($uploadDir);
    }
}

if (isset($_GET['autosave']) && $_GET['autosave'] === '1' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    try {
        $autoId = (int)($_POST['autosave_id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $excerpt = trim($_POST['excerpt'] ?? '');
        $content = (string)($_POST['content'] ?? '');
        $selectedCategories = $_POST['categories'] ?? [];
        if (!is_array($selectedCategories)) {
            $selectedCategories = [];
        }
        $category = implode(',', array_filter(array_map('trim', $selectedCategories)));

        // If nothing meaningful is typed yet, skip autosave.
        if ($title === '' && $excerpt === '' && trim(strip_tags($content)) === '') {
            echo json_encode(['ok' => true, 'skipped' => true]);
            exit;
        }

        if ($slug === '' && $title !== '') {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
            $slug = trim($slug, '-');
        }
        $slug = ensure_unique_blog_slug($mysqli, $slug !== '' ? $slug : ($title !== '' ? $title : 'draft'), $autoId);

        $status = 'draft'; // autosave always stores draft

        if ($autoId > 0) {
            $stmt = $mysqli->prepare("UPDATE blogs SET title=?, slug=?, excerpt=?, content=?, category=?, status=?, updated_at=NOW() WHERE id=?");
            $stmt->bind_param('ssssssi', $title, $slug, $excerpt, $content, $category, $status, $autoId);
            $stmt->execute();
            $stmt->close();
            echo json_encode(['ok' => true, 'id' => $autoId, 'status' => 'draft']);
            exit;
        }

        $imagePath = '';
        $stmt = $mysqli->prepare("INSERT INTO blogs (title, slug, excerpt, content, category, image_path, status, created_at, updated_at) VALUES (?,?,?,?,?,?,?,NOW(),NOW())");
        $stmt->bind_param('sssssss', $title, $slug, $excerpt, $content, $category, $imagePath, $status);
        $stmt->execute();
        $newId = (int)$mysqli->insert_id;
        $stmt->close();
        echo json_encode(['ok' => true, 'id' => $newId, 'status' => 'draft']);
        exit;
    } catch (Throwable $e) {
        error_log('blogs autosave error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['ok' => false, 'message' => 'autosave_failed']);
        exit;
    }
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: blogs.php?deleted=1');
    exit;
}

if (isset($_GET['publish']) && is_numeric($_GET['publish'])) {
    try {
        $id = (int)$_GET['publish'];
        $stmt = $mysqli->prepare("UPDATE blogs SET status='published', updated_at=NOW() WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        header('Location: blogs.php?published=1');
        exit;
    } catch (Throwable $e) {
        error_log('blogs publish error: ' . $e->getMessage());
        header('Location: blogs.php?dberror=1');
        exit;
    }
}

$editingId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editingBlog = null;
if ($editingId > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->bind_param('i', $editingId);
    $stmt->execute();
    $editingBlog = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$allCategories = [];
$catRes = $mysqli->query("SELECT * FROM blog_categories ORDER BY name ASC");
if ($catRes) {
    while ($row = $catRes->fetch_assoc()) {
        $allCategories[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title'] ?? '');
    $slug     = trim($_POST['slug'] ?? '');
    $excerpt  = trim($_POST['excerpt'] ?? '');
    $content  = $_POST['content'] ?? '';
    $selectedCategories = $_POST['categories'] ?? [];
    if (!is_array($selectedCategories)) $selectedCategories = [];
    $category = implode(',', array_filter(array_map('trim', $selectedCategories)));
    $status   = $_POST['status'] ?? 'published';
    if (isset($_POST['force_publish']) && $_POST['force_publish'] === '1') {
        $status = 'published';
    }
    if (!$isSuperAdmin) {
        // Team members can submit only for review; admin publishes later.
        $status = 'draft';
    }

    if ($slug === '' && $title !== '') {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
        $slug = trim($slug, '-');
    }
    $slug = ensure_unique_blog_slug($mysqli, $slug !== '' ? $slug : $title, $editingId);

    $imagePath = $editingBlog['image_path'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $safeName = uniqid('blog_', true) . '.' . strtolower($ext);
        $targetPath = $uploadDir . '/' . $safeName;
        if (is_uploaded_file($_FILES['image']['tmp_name']) && move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = 'uploads/blogs/' . $safeName;
        } else {
            $uploadError = 'Image upload failed. Folder permission ya PHP config check karein.';
        }
    }

    try {
        if ($editingId > 0) {
            $stmt = $mysqli->prepare("UPDATE blogs SET title=?, slug=?, excerpt=?, content=?, category=?, image_path=?, status=? WHERE id=?");
            $stmt->bind_param('sssssssi', $title, $slug, $excerpt, $content, $category, $imagePath, $status, $editingId);
            $stmt->execute();
            $stmt->close();
            if ($isSuperAdmin) {
                header('Location: blogs.php?updated=1');
            } else {
                header('Location: blogs.php?submitted=1');
            }
            exit;
        } else {
            $stmt = $mysqli->prepare("INSERT INTO blogs (title, slug, excerpt, content, category, image_path, status, created_at, updated_at) VALUES (?,?,?,?,?,?,?,NOW(),NOW())");
            $stmt->bind_param('sssssss', $title, $slug, $excerpt, $content, $category, $imagePath, $status);
            $stmt->execute();
            $stmt->close();
            if ($isSuperAdmin) {
                header('Location: blogs.php?created=1');
            } else {
                header('Location: blogs.php?submitted=1');
            }
            exit;
        }
    } catch (Throwable $e) {
        error_log('blogs save error: ' . $e->getMessage());
        $uploadError = 'Unable to save blog right now. Please check title/slug uniqueness and try again.';
    }
}

$blogs = $mysqli->query("SELECT * FROM blogs ORDER BY created_at DESC");
if ($blogs === false) { $blogsError = $mysqli->error; }
$admin_name = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs — Elevate Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <!-- CKEditor for WYSIWYG + HTML source editing -->
    <script src="https://cdn.ckeditor.com/4.25.1/full/ckeditor.js"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #0b0c10; --bg-2: #111318; --bg-3: #17191f; --bg-hover: #1e2028;
            --border: rgba(255,255,255,0.07); --border-md: rgba(255,255,255,0.12);
            --ink: #f0f0f5; --ink-2: #9898a8; --ink-3: #5c5c70;
            --accent: #7c6ff7; --accent-2: #a89cf9;
            --red: #f06060; --red-bg: rgba(240,96,96,0.08);
            --green: #3ecf8e; --green-bg: rgba(62,207,142,0.08);
            --amber: #f0a040; --r: 10px; --r-lg: 14px;
        }
        html, body { height: 100%; background: var(--bg); color: var(--ink); font-family: 'DM Sans', sans-serif; font-size: 14px; line-height: 1.6; overflow-x: hidden; }
        .shell { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar { width: 240px; flex-shrink: 0; background: var(--bg-2); border-right: 1px solid var(--border); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 200; transition: transform 0.28s cubic-bezier(0.22,1,0.36,1); }
        .sidebar-brand { padding: 22px 20px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 11px; }
        .brand-mark { width: 34px; height: 34px; background: var(--accent); border-radius: 9px; display: grid; place-items: center; flex-shrink: 0; }
        .brand-mark svg { width: 17px; height: 17px; stroke: white; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .brand-label { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: var(--ink); letter-spacing: -0.2px; }
        .brand-sublabel { font-size: 11px; color: var(--ink-3); letter-spacing: 0.3px; }
        .nav { list-style: none; padding: 14px 10px; flex: 1; }
        .nav-item { margin: 2px 0; }
        .nav-link { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: var(--r); color: var(--ink-2); text-decoration: none; font-size: 13.5px; transition: background 0.18s, color 0.18s; }
        .nav-link svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
        .nav-link:hover { background: var(--bg-hover); color: var(--ink); }
        .nav-link.active { background: rgba(124,111,247,0.12); color: var(--accent-2); }
        .nav-link.active svg { stroke: var(--accent-2); }
        .nav-sep { height: 1px; background: var(--border); margin: 10px 2px; }
        .nav-link.danger { color: var(--red); }
        .nav-link.danger:hover { background: var(--red-bg); }
        .nav-link.danger svg { stroke: var(--red); }
        .sidebar-footer { padding: 14px 10px; border-top: 1px solid var(--border); }
        .user-pill { display: flex; align-items: center; gap: 10px; padding: 9px 12px; }
        .avatar { width: 30px; height: 30px; background: rgba(124,111,247,0.18); border-radius: 50%; display: grid; place-items: center; font-family: 'Syne', sans-serif; font-size: 12px; font-weight: 700; color: var(--accent-2); flex-shrink: 0; text-transform: uppercase; }
        .user-name { font-size: 13px; color: var(--ink); font-weight: 500; }
        .user-role { font-size: 11px; color: var(--ink-3); }

        /* MAIN */
        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: var(--bg-2); border-bottom: 1px solid var(--border); padding: 0 28px; height: 58px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .menu-btn { display: none; background: none; border: none; cursor: pointer; padding: 6px; color: var(--ink-2); }
        .menu-btn svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; }
        .page-title { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: var(--ink); letter-spacing: -0.2px; }
        .breadcrumb { font-size: 12px; color: var(--ink-3); display: flex; align-items: center; gap: 6px; }
        .breadcrumb span { color: var(--ink-2); }
        .time-badge { font-size: 12px; color: var(--ink-3); background: var(--bg-3); border: 1px solid var(--border); border-radius: 20px; padding: 4px 12px; }
        .content { padding: 28px; flex: 1; }

        /* Toast */
        .toast { display: flex; align-items: center; gap: 10px; border-radius: var(--r); padding: 12px 16px; margin-bottom: 24px; font-size: 13.5px; animation: slide-in 0.35s cubic-bezier(0.22,1,0.36,1); }
        .toast.success { background: var(--green-bg); border: 1px solid rgba(62,207,142,0.25); color: var(--green); }
        .toast.warning { background: rgba(240,160,64,0.08); border: 1px solid rgba(240,160,64,0.25); color: var(--amber); }
        .toast svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
        .toast-close { margin-left: auto; background: none; border: none; cursor: pointer; color: inherit; opacity: 0.6; font-size: 16px; line-height: 1; padding: 0 2px; }
        @keyframes slide-in { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }

        /* Stacked panels */
        .stack { display: flex; flex-direction: column; gap: 20px; }
        .panel { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; }
        .panel-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .panel-title { font-family: 'Syne', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: 8px; }
        .panel-title svg { width: 15px; height: 15px; stroke: var(--accent-2); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .edit-badge { font-size: 11px; font-weight: 500; background: rgba(124,111,247,0.12); color: var(--accent-2); border-radius: 20px; padding: 2px 9px; }
        .panel-body { padding: 24px; }

        /* Form grid: 3-col */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0 20px; }
        .form-grid .field { margin-bottom: 18px; }
        .span-2 { grid-column: span 2; }
        .span-3 { grid-column: span 3; }

        .field label { display: flex; font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.6px; color: var(--ink-3); margin-bottom: 7px; }
        .field input[type="text"], .field textarea, .field select {
            width: 100%; background: var(--bg-3); border: 1px solid var(--border);
            border-radius: var(--r); color: var(--ink); font-family: 'DM Sans', sans-serif;
            font-size: 13.5px; padding: 9px 12px; outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
        }
        .field input[type="text"]:focus, .field textarea:focus, .field select:focus {
            border-color: var(--accent); box-shadow: 0 0 0 3px rgba(124,111,247,0.1);
        }
        .field textarea { resize: vertical; min-height: 90px; line-height: 1.6; }
        .field select option { background: var(--bg-3); }
        .field-hint { font-size: 11.5px; color: var(--ink-3); margin-top: 5px; }

        /* Custom multiselect */
        .ms-wrap { position: relative; }

        .ms-trigger {
            width: 100%; min-height: 40px;
            background: var(--bg-3); border: 1px solid var(--border);
            border-radius: var(--r); color: var(--ink);
            font-family: 'DM Sans', sans-serif; font-size: 13.5px;
            padding: 7px 36px 7px 12px;
            cursor: pointer; text-align: left;
            display: flex; align-items: flex-start;
            transition: border-color 0.18s, box-shadow 0.18s;
            position: relative;
        }

        .ms-trigger:focus, .ms-trigger.open {
            border-color: var(--accent); box-shadow: 0 0 0 3px rgba(124,111,247,0.1);
        }

        .ms-chevron {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            width: 14px; height: 14px;
            stroke: var(--ink-3); fill: none; stroke-width: 2;
            stroke-linecap: round; stroke-linejoin: round;
            transition: transform 0.2s;
            pointer-events: none;
        }

        .ms-trigger.open .ms-chevron { transform: translateY(-50%) rotate(180deg); }

        .ms-placeholder { color: var(--ink-3); line-height: 1.6; }

        .ms-tags { display: flex; flex-wrap: wrap; gap: 4px; }
        .ms-tag { background: rgba(124,111,247,0.15); color: var(--accent-2); border: 1px solid rgba(124,111,247,0.25); border-radius: 20px; font-size: 11.5px; padding: 1px 9px; white-space: nowrap; }

        .ms-dropdown {
            display: none; position: absolute;
            top: calc(100% + 4px); left: 0; right: 0;
            background: var(--bg-3); border: 1px solid var(--border-md);
            border-radius: var(--r); z-index: 50;
            max-height: 220px; overflow-y: auto;
            box-shadow: 0 8px 28px rgba(0,0,0,0.4);
        }

        .ms-dropdown.open { display: block; animation: dd-in 0.15s ease; }
        @keyframes dd-in { from { opacity:0; transform:translateY(-4px); } to { opacity:1; transform:translateY(0); } }

        .ms-item { display: flex; align-items: center; gap: 10px; padding: 9px 14px; cursor: pointer; transition: background 0.12s; user-select: none; }
        .ms-item:hover { background: var(--bg-hover); }
        .ms-item input[type="checkbox"] { display: none; }

        .ms-box { width: 15px; height: 15px; border-radius: 4px; flex-shrink: 0; border: 1.5px solid var(--border-md); display: grid; place-items: center; transition: background 0.15s, border-color 0.15s; }
        .ms-box svg { width: 9px; height: 9px; stroke: white; fill: none; stroke-width: 3; stroke-linecap: round; stroke-linejoin: round; opacity: 0; }
        .ms-item.checked .ms-box { background: var(--accent); border-color: var(--accent); }
        .ms-item.checked .ms-box svg { opacity: 1; }
        .ms-item.checked .ms-name { color: var(--ink); }

        .ms-name { font-size: 13.5px; color: var(--ink-2); }
        .ms-empty { padding: 14px 16px; font-size: 12.5px; color: var(--ink-3); text-align: center; }

        /* File picker */
        .file-area { background: var(--bg-3); border: 1px dashed var(--border-md); border-radius: var(--r); padding: 10px 14px; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: border-color 0.18s; min-height: 40px; }
        .file-area:hover { border-color: var(--accent); }
        .file-area svg { width: 15px; height: 15px; stroke: var(--ink-3); fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
        .file-area input[type="file"] { display: none; }
        .file-lbl { font-size: 13px; color: var(--ink-2); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        /* Actions row */
        .form-actions { display: flex; gap: 10px; align-items: center; padding-top: 4px; }
        .btn-submit { height: 42px; padding: 0 24px; background: var(--accent); color: white; border: none; border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.18s, transform 0.15s; }
        .btn-submit:hover { background: #9080f9; transform: translateY(-1px); }
        .btn-submit:active { transform: scale(0.99); }
        .btn-submit svg { width: 15px; height: 15px; stroke: white; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .btn-cancel { height: 42px; padding: 0 20px; background: none; color: var(--ink-3); border: 1px solid var(--border); border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 13px; cursor: pointer; transition: border-color 0.15s, color 0.15s; }
        .btn-cancel:hover { border-color: var(--border-md); color: var(--ink-2); }

        /* Simple in-panel rich text editor */
        .editor-toolbar {
            display: inline-flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 8px;
        }
        .editor-btn {
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--bg-3);
            color: var(--ink-2);
            font-size: 12px;
            padding: 4px 8px;
            cursor: pointer;
        }
        .editor-btn.active {
            border-color: var(--accent);
            color: var(--accent-2);
            background: rgba(124,111,247,0.12);
        }
        .rich-editor {
            width: 100%;
            min-height: 220px;
            padding: 10px 12px;
            border-radius: var(--r);
            border: 1px solid var(--border);
            background: var(--bg-3);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            line-height: 1.6;
            outline: none;
            overflow-y: auto;
        }
        .rich-editor:focus-visible {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124,111,247,0.1);
        }

        /* Table */
        .tbl-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th { font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.6px; color: var(--ink-3); padding: 12px 16px; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap; }
        tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--bg-hover); }
        td { padding: 13px 16px; font-size: 13.5px; color: var(--ink); vertical-align: middle; }
        .td-title { font-weight: 500; max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .td-muted { color: var(--ink-2); font-size: 12.5px; }
        .td-date { color: var(--ink-3); font-size: 12px; white-space: nowrap; }

        .cat-tags { display: flex; flex-wrap: wrap; gap: 4px; max-width: 200px; }
        .cat-tag { background: rgba(124,111,247,0.1); color: var(--accent-2); border: 1px solid rgba(124,111,247,0.18); border-radius: 20px; font-size: 11px; padding: 1px 8px; white-space: nowrap; }

        .status-pill { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 500; border-radius: 20px; padding: 3px 9px; }
        .status-pill.published { background: var(--green-bg); color: var(--green); }
        .status-pill.draft { background: rgba(255,255,255,0.05); color: var(--ink-3); }
        .status-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

        .actions { display: flex; gap: 6px; }
        .btn-icon { width: 30px; height: 30px; background: var(--bg-hover); border: 1px solid var(--border); border-radius: 8px; display: grid; place-items: center; text-decoration: none; transition: border-color 0.15s, background 0.15s; }
        .btn-icon svg { width: 13px; height: 13px; stroke: var(--ink-2); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .btn-icon.edit:hover { border-color: var(--accent); background: rgba(124,111,247,0.1); }
        .btn-icon.edit:hover svg { stroke: var(--accent-2); }
        .btn-icon.del:hover { border-color: var(--red); background: var(--red-bg); }
        .btn-icon.del:hover svg { stroke: var(--red); }

        .tbl-empty { text-align: center; padding: 48px 20px; }
        .empty-icon-sm { width: 40px; height: 40px; background: var(--bg-3); border-radius: 10px; display: grid; place-items: center; margin: 0 auto 12px; }
        .empty-icon-sm svg { width: 18px; height: 18px; stroke: var(--ink-3); fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
        .tbl-empty h4 { font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
        .tbl-empty p { font-size: 12.5px; color: var(--ink-3); }
        .db-error { padding: 16px; background: var(--red-bg); border-left: 3px solid var(--red); border-radius: 6px; font-size: 13px; color: var(--red); }
        .db-error code { font-family: monospace; font-size: 12px; background: rgba(240,96,96,0.1); padding: 1px 5px; border-radius: 4px; }

        .noise { position: fixed; inset: 0; z-index: -1; background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E"); pointer-events: none; }

        <?php if (!$isSuperAdmin): ?>
        .quick-access-universal { display: none !important; }
        .nav .nav-link { display: none !important; }
        .nav .nav-link[href="admin_dashboard.php"],
        .nav .nav-link[href="blog_categories.php"],
        .nav .nav-link[href="blogs.php"],
        .nav .nav-link[href="all-posts.php"],
        .nav .nav-link[href="logout.php"] { display: flex !important; }
        .nav .nav-sep { display: none !important; }
        <?php endif; ?>
        @media (max-width: 1200px) { .form-grid { grid-template-columns: 1fr 1fr; } .span-3 { grid-column: span 2; } }
        @media (max-width: 900px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: translateX(0); } .main { margin-left: 0; } .menu-btn { display: flex; } .sidebar.open ~ .main .topbar { z-index: 210; } .form-grid { grid-template-columns: 1fr; } .span-2, .span-3 { grid-column: span 1; } }
        @media (max-width: 540px) { .content { padding: 16px; } }
    </style>
</head>
<body>
<div class="noise"></div>
<div class="shell">

    <!-- Sidebar -->
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

        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="admin_dashboard.php">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="blog_categories.php">
                    <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L3 13.99V4a1 1 0 0 1 1-1h9.99l7.6 7.6a2 2 0 0 1 0 2.81z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    Blog Categories
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="blogs.php">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Manage Blogs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="all-posts.php">
                    <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    All Blogs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pages.php">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="14" y2="12"/><line x1="7" y1="16" x2="12" y2="16"/></svg>
                    CMS Pages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="testimonials.php">
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7H11l-4 3v-3H7.5A8.5 8.5 0 1 1 21 11.5z"/></svg>
                    Testimonials
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="all-testimonials.php">
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7H11l-4 3v-3H7.5A8.5 8.5 0 1 1 21 11.5z"/></svg>
                    All Testimonials
                </a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" href="enquiries.php">
                    <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Enquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ai_assessment_enquiries.php">
                    <svg viewBox="0 0 24 24"><path d="M12 3a9 9 0 0 0-9 9c0 3.31 1.79 6.2 4.46 7.75L7 22l2.68-1.34A9 9 0 1 0 12 3z"/><path d="M9.5 12a2.5 2.5 0 1 1 5 0c0 .93-.5 1.73-1.25 2.16-.51.29-.75.6-.75 1.09"/><circle cx="12" cy="17.25" r=".75"/></svg>
                    AI Assessment Enquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="job_placement_enquiries.php">
                    <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Job &amp; Placement Enquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link long-label" href="hiring_assistance_enquiries.php">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    Hiring Assistance Enquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="team_members.php">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Users
                </a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" href="settings.php">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Settings
                </a>
            </li>

           
            <li class="nav-item">
                <a class="nav-link danger" href="logout.php">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </a>
            </li>
        </ul>

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

    <!-- Main -->
    <div class="main">
        <div class="topbar">
            <div class="topbar-left">
                <button class="menu-btn" onclick="toggleSidebar()"><svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
                <div>
                    <div class="page-title">Manage Blogs</div>
                    <div class="breadcrumb">Elevate Pro <span>›</span> Blogs</div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="time-badge" id="clock">--:-- --</div>
            </div>
        </div>

        <div class="content">

            <?php if (!empty($uploadError)): ?>
            <div class="toast warning" id="toast"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg><?= $uploadError ?><button class="toast-close" onclick="this.closest('.toast').remove()">×</button></div>
            <?php elseif (isset($_GET['created'])): ?>
            <div class="toast success" id="toast"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Blog post created successfully.<button class="toast-close" onclick="this.closest('.toast').remove()">×</button></div>
            <?php elseif (isset($_GET['updated'])): ?>
            <div class="toast success" id="toast"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Blog post updated successfully.<button class="toast-close" onclick="this.closest('.toast').remove()">×</button></div>
            <?php elseif (isset($_GET['submitted'])): ?>
            <div class="toast success" id="toast"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Blog submitted for admin verification.<button class="toast-close" onclick="this.closest('.toast').remove()">×</button></div>
            <?php elseif (isset($_GET['published'])): ?>
            <div class="toast success" id="toast"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Blog post published successfully.<button class="toast-close" onclick="this.closest('.toast').remove()">×</button></div>
            <?php elseif (isset($_GET['dberror'])): ?>
            <div class="toast warning" id="toast"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>Unable to update blog status right now.<button class="toast-close" onclick="this.closest('.toast').remove()">×</button></div>
            <?php elseif (isset($_GET['deleted'])): ?>
            <div class="toast warning" id="toast"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>Blog post deleted.<button class="toast-close" onclick="this.closest('.toast').remove()">×</button></div>
            <?php endif; ?>

            <div class="stack" style="margin-bottom:16px; display:flex; justify-content:flex-end;">
                <a href="all-posts.php" style="font-size:13px; padding:7px 14px; border-radius:999px; border:1px solid var(--border); background:var(--bg-3); color:var(--ink-2); text-decoration:none;">
                    View All Posts
                </a>
            </div>

            <div class="stack">

                <!-- FORM PANEL — full width -->
                <div class="panel">
                    <div class="panel-header">
                        <div class="panel-title">
                            <?php if ($editingId): ?>
                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit Blog Post
                            <?php else: ?>
                            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            New Blog Post
                            <?php endif; ?>
                        </div>
                        <?php if ($editingId): ?><span class="edit-badge">ID #<?= $editingId ?></span><?php endif; ?>
                    </div>

                    <div class="panel-body">
                        <form action="blogs.php<?= $editingId ? '?edit='.$editingId : '' ?>" method="post" enctype="multipart/form-data">
                            <div class="form-grid">

                                <!-- Title (2 col) + Slug (1 col) -->
                                <div class="field span-2">
                                    <label>Title</label>
                                    <input type="text" name="title" required placeholder="Your blog post title"
                                        value="<?= htmlspecialchars($editingBlog['title'] ?? '') ?>"
                                        oninput="autoSlug(this.value)">
                                </div>
                                <div class="field">
                                    <label>Slug</label>
                                    <input type="text" name="slug" id="slug-field" placeholder="auto-generated-from-title"
                                        value="<?= htmlspecialchars($editingBlog['slug'] ?? '') ?>">
                                    <div class="field-hint">Auto-generated if left blank</div>
                                </div>

                                <!-- Categories multiselect + Status + Image -->
                                <?php
                                $selectedSlugs = array_filter(array_map('trim', explode(',', $editingBlog['category'] ?? '')));
                                ?>
                                <div class="field">
                                    <label>Categories</label>
                                    <div class="ms-wrap" id="ms-wrap">
                                        <button type="button" class="ms-trigger" id="ms-trigger" onclick="msToggle()">
                                            <span id="ms-display">
                                                <?php
                                                $preSelected = [];
                                                foreach ($allCategories as $c) {
                                                    if (in_array($c['slug'], $selectedSlugs, true)) $preSelected[] = $c['name'];
                                                }
                                                if (empty($preSelected)): ?>
                                                <span class="ms-placeholder">Select categories…</span>
                                                <?php else: ?>
                                                <span class="ms-tags"><?php foreach ($preSelected as $n): ?><span class="ms-tag"><?= htmlspecialchars($n) ?></span><?php endforeach; ?></span>
                                                <?php endif; ?>
                                            </span>
                                            <svg class="ms-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                                        </button>
                                        <div class="ms-dropdown" id="ms-dropdown">
                                            <?php if (empty($allCategories)): ?>
                                            <div class="ms-empty">No categories yet — create them first.</div>
                                            <?php else: foreach ($allCategories as $cat):
                                                $chk = in_array($cat['slug'], $selectedSlugs, true); ?>
                                            <label class="ms-item <?= $chk ? 'checked' : '' ?>" data-name="<?= htmlspecialchars($cat['name']) ?>">
                                                <input type="checkbox" name="categories[]" value="<?= htmlspecialchars($cat['slug']) ?>" <?= $chk ? 'checked' : '' ?> onchange="msUpdate()">
                                                <div class="ms-box"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
                                                <span class="ms-name"><?= htmlspecialchars($cat['name']) ?></span>
                                            </label>
                                            <?php endforeach; endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <label>Status</label>
                                    <?php if ($isSuperAdmin): ?>
                                        <select name="status">
                                            <?php $st = $editingBlog['status'] ?? 'published'; ?>
                                            <option value="published" <?= $st === 'published' ? 'selected' : '' ?>>Published</option>
                                            <option value="draft"     <?= $st === 'draft'     ? 'selected' : '' ?>>Draft</option>
                                        </select>
                                    <?php else: ?>
                                        <input type="text" value="Draft (Admin verification required)" readonly>
                                        <input type="hidden" name="status" value="draft">
                                    <?php endif; ?>
                                </div>

                                <div class="field">
                                    <label>Cover Image</label>
                                    <div class="file-area" onclick="document.getElementById('img-input').click()">
                                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                        <span class="file-lbl" id="file-lbl"><?= !empty($editingBlog['image_path']) ? htmlspecialchars(basename($editingBlog['image_path'])) : 'Click to choose image' ?></span>
                                        <input type="file" id="img-input" name="image" accept="image/*" onchange="document.getElementById('file-lbl').textContent = this.files[0]?.name ?? 'Click to choose image'">
                                    </div>
                                    <?php if (!empty($editingBlog['image_path'])): ?>
                                    <div style="margin-top:8px;">
                                        <span class="field-hint">Current image preview:</span><br>
                                        <img src="../<?= htmlspecialchars($editingBlog['image_path']) ?>" alt="Cover image" style="margin-top:4px;max-width:160px;border-radius:8px;border:1px solid var(--border);">
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Excerpt full width -->
                                <div class="field span-3">
                                    <label>Short Excerpt</label>
                                    <textarea id="excerpt" name="excerpt" rows="3" required placeholder="A brief summary shown in listings..."><?= htmlspecialchars($editingBlog['excerpt'] ?? '') ?></textarea>
                                </div>

                                <!-- Content full width -->
                                <div class="field span-3">
                                    <label>Content <span style="color:var(--ink-3);font-size:10px;text-transform:none;letter-spacing:0;">(Doc style + HTML source toggle)</span></label>
                                    <div class="editor-toolbar">
                                        <button type="button" class="editor-btn" data-cmd="bold"><b>B</b></button>
                                        <button type="button" class="editor-btn" data-cmd="italic"><i>I</i></button>
                                        <button type="button" class="editor-btn" data-cmd="underline"><u>U</u></button>
                                        <button type="button" class="editor-btn" data-cmd="insertUnorderedList">• List</button>
                                        <button type="button" class="editor-btn" data-cmd="insertOrderedList">1. List</button>
                                        <button type="button" class="editor-btn" data-cmd="formatBlock" data-value="h2">H2</button>
                                        <button type="button" class="editor-btn" data-cmd="formatBlock" data-value="h3">H3</button>
                                        <button type="button" class="editor-btn" id="toggle-html">HTML</button>
                                    </div>
                                    <div id="content-editor" class="rich-editor" contenteditable="true"></div>
                                    <textarea id="content" name="content" rows="12" placeholder="Full blog content here..." style="display:none;"><?= htmlspecialchars($editingBlog['content'] ?? '') ?></textarea>
                                </div>

                            </div>

                            <div class="form-actions">
                                <input type="hidden" id="autosave-id" name="autosave_id" value="<?= (int)$editingId ?>">
                                <button type="submit" class="btn-submit" name="force_publish" value="<?= ($editingId && (($editingBlog['status'] ?? 'published') !== 'published')) ? '1' : '0' ?>">
                                    <?php if ($editingId): ?>
                                    <?php $isDraftEdit = (($editingBlog['status'] ?? 'published') !== 'published'); ?>
                                    <?php if ($isDraftEdit && $isSuperAdmin): ?>
                                    <svg viewBox="0 0 24 24"><path d="M22 2L11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>Publish Blog Post
                                    <?php else: ?>
                                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>Update Blog Post
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Publish Blog Post
                                    <?php endif; ?>
                                </button>
                                <span id="autosave-status" style="font-size:12px;color:var(--ink-3);"></span>
                                <?php if ($editingId): ?>
                                <button type="button" class="btn-cancel" onclick="window.location='blogs.php'">Cancel</button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- TABLE PANEL — full width -->
                <div class="panel">
                    <div class="panel-header">
                        <div class="panel-title">
                            <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            All Posts
                        </div>
                        <?php if (!isset($blogsError) && $blogs): ?>
                        <span style="font-size:11.5px;color:var(--ink-3);"><?= $blogs->num_rows ?> total</span>
                        <?php endif; ?>
                    </div>
                    <div class="tbl-wrap">
                        <?php if (isset($blogsError)): ?>
                        <div style="padding:20px;"><div class="db-error"><strong>Database error:</strong><br><code><?= htmlspecialchars($blogsError) ?></code></div></div>

                        <?php elseif ($blogs && $blogs->num_rows > 0): ?>
                        <table>
                            <thead><tr><th>#</th><th>Title</th><th>Categories</th><th>Status</th><th>Created</th><th></th></tr></thead>
                            <tbody>
                            <?php while ($row = $blogs->fetch_assoc()):
                                $catSlugs = array_filter(array_map('trim', explode(',', $row['category'] ?? ''))); ?>
                                <tr>
                                    <td class="td-muted"><?= (int)$row['id'] ?></td>
                                    <td class="td-title" title="<?= htmlspecialchars($row['title']) ?>"><?= htmlspecialchars($row['title']) ?></td>
                                    <td>
                                        <?php if (!empty($catSlugs)): ?>
                                        <div class="cat-tags">
                                            <?php foreach ($catSlugs as $sl):
                                                $f = array_filter($allCategories, fn($c) => $c['slug'] === $sl);
                                                $f = reset($f);
                                                if ($f): ?><span class="cat-tag"><?= htmlspecialchars($f['name']) ?></span><?php endif;
                                            endforeach; ?>
                                        </div>
                                        <?php else: ?><span class="td-muted">—</span><?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="status-pill <?= $row['status'] === 'published' ? 'published' : 'draft' ?>">
                                            <span class="status-dot"></span><?= ucfirst(htmlspecialchars($row['status'])) ?>
                                        </span>
                                    </td>
                                    <td class="td-date"><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                    <td>
                                        <div class="actions">
                                            <?php if (($row['status'] ?? '') !== 'published'): ?>
                                                <a href="blogs.php?publish=<?= (int)$row['id'] ?>" class="btn-icon edit" title="Publish now" onclick="return confirm('Publish this blog post now?')"><svg viewBox="0 0 24 24"><path d="M22 2L11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg></a>
                                            <?php endif; ?>
                                            <a href="blogs.php?edit=<?= (int)$row['id'] ?>" class="btn-icon edit" title="Edit"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                                            <a href="blogs.php?delete=<?= (int)$row['id'] ?>" class="btn-icon del" title="Delete" onclick="return confirm('Delete this blog post permanently?')"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>

                        <?php else: ?>
                        <div class="tbl-empty">
                            <div class="empty-icon-sm"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                            <h4>No posts yet</h4>
                            <p>Create your first blog post using the form above.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="overlay" onclick="toggleSidebar()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:199;"></div>

<script>
    function toggleSidebar() {
        const sb = document.getElementById('sidebar');
        const ov = document.getElementById('overlay');
        ov.style.display = sb.classList.toggle('open') ? 'block' : 'none';
    }

    /* Slug */
    function autoSlug(val) {
        const sf = document.getElementById('slug-field');
        if (sf && sf.dataset.manual !== '1')
            sf.value = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    }
    document.getElementById('slug-field')?.addEventListener('input', function() { this.dataset.manual = '1'; });

    /* Multiselect */
    function msToggle() {
        const dd = document.getElementById('ms-dropdown');
        const tr = document.getElementById('ms-trigger');
        const open = dd.classList.toggle('open');
        tr.classList.toggle('open', open);
    }

    function msUpdate() {
        const items = document.querySelectorAll('.ms-item');
        const disp  = document.getElementById('ms-display');
        const selected = [];

        items.forEach(item => {
            const cb = item.querySelector('input[type="checkbox"]');
            item.classList.toggle('checked', cb.checked);
            if (cb.checked) selected.push(item.dataset.name);
        });

        disp.innerHTML = selected.length
            ? '<span class="ms-tags">' + selected.map(n => `<span class="ms-tag">${n}</span>`).join('') + '</span>'
            : '<span class="ms-placeholder">Select categories…</span>';
    }

    document.addEventListener('click', function(e) {
        if (!document.getElementById('ms-wrap')?.contains(e.target)) {
            document.getElementById('ms-dropdown')?.classList.remove('open');
            document.getElementById('ms-trigger')?.classList.remove('open');
        }
    });

    /* Clock */
    function tick() {
        const el = document.getElementById('clock');
        if (el) el.textContent = new Date().toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit', hour12: true });
    }
    tick(); setInterval(tick, 15000);

    /* Toast */
    const t = document.getElementById('toast');
    if (t) setTimeout(() => t.remove(), 5000);

    /* In-page doc-style editor + HTML toggle (no CDN) */
    document.addEventListener('DOMContentLoaded', function () {
        const hidden = document.getElementById('content');
        const editor = document.getElementById('content-editor');
        const toggleBtn = document.getElementById('toggle-html');
        const autosaveIdEl = document.getElementById('autosave-id');
        const autosaveStatus = document.getElementById('autosave-status');
        if (!hidden || !editor || !toggleBtn) return;

        let htmlMode = false;

        // Load initial content as HTML into editor
        editor.innerHTML = hidden.value || '';

        // Toolbar buttons
        document.querySelectorAll('.editor-btn[data-cmd]').forEach(btn => {
            btn.addEventListener('click', function () {
                const cmd = this.dataset.cmd;
                const value = this.dataset.value || null;
                if (htmlMode) return; // only WYSIWYG mode
                editor.focus();
                if (cmd === 'formatBlock') {
                    document.execCommand(cmd, false, value);
                } else {
                    document.execCommand(cmd, false, value);
                }
            });
        });

        // HTML toggle
        toggleBtn.addEventListener('click', function () {
            htmlMode = !htmlMode;
            this.classList.toggle('active', htmlMode);
            if (htmlMode) {
                // Show raw HTML inside textarea, hide WYSIWYG
                hidden.style.display = 'block';
                hidden.value = editor.innerHTML;
                editor.style.display = 'none';
            } else {
                // Back to WYSIWYG
                editor.innerHTML = hidden.value;
                editor.style.display = 'block';
                hidden.style.display = 'none';
            }
        });

        // On submit, ensure textarea has latest HTML
        const form = hidden.form;
        if (form) {
            form.addEventListener('submit', function (e) {
                if (!htmlMode) {
                    hidden.value = editor.innerHTML;
                }
                const plain = (hidden.value || '').replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').trim();
                if (!plain) {
                    e.preventDefault();
                    alert('Please add blog content before publishing.');
                }
            });
        }

        // Auto-save draft every 20 seconds after changes.
        let dirty = false;
        let saving = false;
        let lastSnapshot = '';
        const snapshot = () => {
            const data = new FormData(form);
            data.set('content', htmlMode ? hidden.value : editor.innerHTML);
            return JSON.stringify({
                title: data.get('title') || '',
                slug: data.get('slug') || '',
                excerpt: data.get('excerpt') || '',
                content: data.get('content') || '',
                categories: data.getAll('categories[]') || []
            });
        };
        const markDirty = () => { dirty = true; };
        form.querySelectorAll('input[type="text"], textarea, select').forEach(el => {
            el.addEventListener('input', markDirty);
            el.addEventListener('change', markDirty);
        });
        editor.addEventListener('input', markDirty);

        const setStatus = (msg) => { if (autosaveStatus) autosaveStatus.textContent = msg; };
        setInterval(async () => {
            if (saving) return;
            const nowSnap = snapshot();
            if (!dirty && nowSnap === lastSnapshot) return;
            saving = true;
            setStatus('Auto-saving...');
            try {
                const data = new FormData(form);
                data.set('content', htmlMode ? hidden.value : editor.innerHTML);
                data.set('autosave_id', autosaveIdEl ? autosaveIdEl.value : '0');
                const res = await fetch('blogs.php?autosave=1', { method: 'POST', body: data });
                const out = await res.json();
                if (out && out.ok) {
                    dirty = false;
                    lastSnapshot = nowSnap;
                    if (autosaveIdEl && out.id && (!autosaveIdEl.value || autosaveIdEl.value === '0')) {
                        autosaveIdEl.value = String(out.id);
                        if (window.history && window.history.replaceState) {
                            window.history.replaceState({}, '', 'blogs.php?edit=' + out.id);
                        }
                    }
                    setStatus('Draft auto-saved');
                } else {
                    setStatus('Auto-save failed');
                }
            } catch (e) {
                setStatus('Auto-save failed');
            } finally {
                saving = false;
            }
        }, 20000);
    });
</script>

<?php $mysqli->close(); ?>
</body>
</html>