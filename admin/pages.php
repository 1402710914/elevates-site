<?php
session_start();
include __DIR__ . '/../db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once __DIR__ . '/admin_access.php';
require_admin_login();
require_permission('can_manage_pages');

$editingId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editingPage = null;
if ($editingId > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM cms_pages WHERE id = ?");
    $stmt->bind_param('i', $editingId);
    $stmt->execute();
    $editingPage = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM cms_pages WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: pages.php?deleted=1');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Only allow updating existing pages; no new page creation from this screen.
    if ($editingId > 0) {
        $title   = trim($_POST['title'] ?? '');
        $slug    = trim($_POST['slug'] ?? '');
        $content = $_POST['content'] ?? '';
        $status  = $_POST['status'] ?? 'published';

        if ($slug === '' && $title !== '') {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
            $slug = trim($slug, '-');
        }

        $stmt = $mysqli->prepare("UPDATE cms_pages SET title=?, slug=?, content=?, status=? WHERE id=?");
        $stmt->bind_param('ssssi', $title, $slug, $content, $status, $editingId);
        $stmt->execute();
        $stmt->close();
        header('Location: pages.php?updated=1');
        exit;
    } else {
        // No insert; just show a message.
        header('Location: pages.php?select=1');
        exit;
    }
}

// All pages list
$pages = $mysqli->query("SELECT * FROM cms_pages ORDER BY created_at DESC");
$admin_name = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pages — Elevate Pro</title>
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
        /* Edit panel wider, list panel narrower */
        .panels {
            display: grid;
            grid-template-columns: minmax(480px, 1.3fr) minmax(260px, 0.7fr);
            gap: 20px;
            align-items: flex-start;
        }
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
        th, td { padding: 8px 8px; border-bottom: 1px solid var(--border); text-align: left; }
        th { font-size: 11px; text-transform: uppercase; color: var(--ink-3); letter-spacing: 0.6px; }
        td.slug { color: var(--ink-3); }
        td.status { font-size: 12px; color: var(--ink-2); }
        td.actions a { font-size: 12px; margin-right: 10px; text-decoration: none; }
        td.actions a.edit { color: var(--accent-2); }
        td.actions a.del { color: var(--red); }

        .flash { margin-bottom: 14px; font-size: 13px; }
        .flash.ok { color: var(--green); }
        .flash.err { color: var(--red); }

        /* Simple modal popup for success */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 500;
        }
        .modal-backdrop.show { display: flex; }
        .modal-box {
            background: var(--bg-2);
            border-radius: var(--r-lg);
            border: 1px solid var(--border-md);
            padding: 22px 24px 18px;
            max-width: 360px;
            width: 100%;
            box-shadow: 0 18px 45px rgba(0,0,0,0.55);
            text-align: center;
        }
        .modal-box h3 {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            margin-bottom: 6px;
        }
        .modal-box p {
            font-size: 13px;
            color: var(--ink-3);
            margin-bottom: 14px;
        }
        .modal-btn {
            margin-top: 4px;
            padding: 7px 18px;
            border-radius: 999px;
            border: 1px solid var(--accent);
            background: rgba(124,111,247,0.12);
            color: var(--accent-2);
            font-size: 12.5px;
            cursor: pointer;
        }

        /* Doc-style editor (same pattern as Blogs content editor) */
        .editor-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 8px;
        }
        .editor-btn {
            background: var(--bg-3);
            border: 1px solid var(--border);
            color: var(--ink-2);
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 11.5px;
            cursor: pointer;
        }
        .editor-btn.active {
            border-color: var(--accent);
            color: var(--accent-2);
        }
        .rich-editor {
            min-height: 260px;
            background: var(--bg-3);
            border-radius: var(--r);
            border: 1px solid var(--border);
            padding: 10px 12px;
            font-size: 13.5px;
            line-height: 1.7;
            outline: none;
            overflow-y: auto;
        }
        .rich-editor:focus-visible {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124,111,247,0.15);
        }

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

    <div class="main">
        <div class="topbar">
            <div class="topbar-left">
                <div>
                    <div class="page-title">CMS Pages</div>
                    <div class="breadcrumb">Elevate Pro <span>›</span> CMS Pages</div>
                </div>
            </div>
        </div>

        <div class="content">
            <?php if (isset($_GET['updated'])): ?>
                <div class="flash ok">Page updated successfully.</div>
            <?php elseif (isset($_GET['deleted'])): ?>
                <div class="flash err">Page deleted.</div>
            <?php elseif (isset($_GET['select'])): ?>
                <div class="flash err">Please select a page from the list to edit. New pages cannot be created here.</div>
            <?php endif; ?>

            <div class="panels">
                <div class="panel">
                    <h2><?= $editingId ? 'Edit Page' : 'Select a Page to Edit' ?></h2>
                    <?php if ($editingId && $editingPage): ?>
                        <?php if ($editingPage['slug'] === 'about-us-intro'): ?>
                            <!-- Special multi-section editor for About Us -->
                            <form action="pages.php?edit=<?= $editingId ?>" method="post">
                                <div class="field">
                                    <label>About Us – Intro</label>
                                    <div class="editor-toolbar">
                                        <button type="button" class="editor-btn" data-target="intro" data-cmd="bold"><b>B</b></button>
                                        <button type="button" class="editor-btn" data-target="intro" data-cmd="italic"><i>I</i></button>
                                        <button type="button" class="editor-btn" data-target="intro" data-cmd="underline"><u>U</u></button>
                                        <button type="button" class="editor-btn" data-target="intro" data-cmd="insertUnorderedList">• List</button>
                                        <button type="button" class="editor-btn" data-target="intro" data-cmd="insertOrderedList">1. List</button>
                                        <button type="button" class="editor-btn" data-target="intro" data-cmd="formatBlock" data-value="h2">H2</button>
                                        <button type="button" class="editor-btn" data-target="intro" data-cmd="formatBlock" data-value="h3">H3</button>
                                        <button type="button" class="editor-btn" id="about-intro-toggle">HTML</button>
                                    </div>
                                    <div id="about-intro-editor" class="rich-editor" contenteditable="true"></div>
                                    <textarea id="about-intro-content" name="about_intro" rows="10" style="display:none;"><?= htmlspecialchars($aboutIntroContent) ?></textarea>
                                </div>

                                <?php
                                // Fetch mission & vision rows if present
                                $aboutMissionRow = null;
                                $aboutVisionRow  = null;
                                if ($stmt = $mysqli->prepare("SELECT * FROM cms_pages WHERE slug = 'about-us-mission' LIMIT 1")) {
                                    $stmt->execute();
                                    $aboutMissionRow = $stmt->get_result()->fetch_assoc();
                                    $stmt->close();
                                }
                                if ($stmt = $mysqli->prepare("SELECT * FROM cms_pages WHERE slug = 'about-us-vision' LIMIT 1")) {
                                    $stmt->execute();
                                    $aboutVisionRow = $stmt->get_result()->fetch_assoc();
                                    $stmt->close();
                                }

                                // Default contents if empty (so editor not blank)
                                $aboutIntroContent = $editingPage['content'] ?? '';
                                // Agar empty ho YA purana placeholder ho to About Elevates ka real text daal do
                                if ($aboutIntroContent === '' || strpos($aboutIntroContent, 'Edit this content from Admin') !== false) {
                                    $aboutIntroContent = "<p>At Elevates, our commitment is to support early and mid-career professionals, as well as Small and Medium businesses, on their transformational journey.</p>"
                                        . "<p>Our tailored, all-encompassing, and results-driven approach boosts value selling, client management, personality growth, communication, leadership abilities, mental well-being, and technical skills. This comprehensive focus on professional development ensures that you are fully prepared to excel in today's competitive environment.</p>"
                                        . "<p>We understand the unique challenges faced by emerging professionals and growing businesses. That's why we've designed our programs to address not just the technical aspects of professional growth, but also the personal development, mental wellness, and work-life balance that are essential for long-term success and fulfillment.</p>";
                                }

                                $aboutMissionContent = $aboutMissionRow['content'] ?? '';
                                if ($aboutMissionContent === '') {
                                    $aboutMissionContent = "<p><strong>Elevates is on a mission</strong> to create &amp; transform a global community of high-achieving early &amp; mid-career professionals and small-medium businesses.</p>"
                                        . "<p>We are dedicated to empowering professionals and business owners to reach their full potential through personalized coaching, comprehensive development programs, and innovative solutions tailored to meet the unique challenges of today's dynamic business environment.</p>";
                                }

                                $aboutVisionContent = $aboutVisionRow['content'] ?? '';
                                if ($aboutVisionContent === '') {
                                    $aboutVisionContent = "<p><strong>Our Vision</strong> is to foster sustainable growth, success, work-life balance, health, happiness and time freedom for professionals &amp; business owners.</p>"
                                        . "<p>We envision a world where every professional and business owner has the tools, support, and guidance needed to achieve not just career success, but holistic well-being and fulfillment in all aspects of life.</p>";
                                }
                                ?>

                                <div class="field">
                                    <label>Our Mission</label>
                                    <div class="editor-toolbar">
                                        <button type="button" class="editor-btn" data-target="mission" data-cmd="bold"><b>B</b></button>
                                        <button type="button" class="editor-btn" data-target="mission" data-cmd="italic"><i>I</i></button>
                                        <button type="button" class="editor-btn" data-target="mission" data-cmd="underline"><u>U</u></button>
                                        <button type="button" class="editor-btn" data-target="mission" data-cmd="insertUnorderedList">• List</button>
                                        <button type="button" class="editor-btn" data-target="mission" data-cmd="insertOrderedList">1. List</button>
                                        <button type="button" class="editor-btn" data-target="mission" data-cmd="formatBlock" data-value="h2">H2</button>
                                        <button type="button" class="editor-btn" data-target="mission" data-cmd="formatBlock" data-value="h3">H3</button>
                                        <button type="button" class="editor-btn" id="about-mission-toggle">HTML</button>
                                    </div>
                                    <div id="about-mission-editor" class="rich-editor" contenteditable="true"></div>
                                    <textarea id="about-mission-content" name="about_mission" rows="10" style="display:none;"><?= htmlspecialchars($aboutMissionContent) ?></textarea>
                                </div>

                                <div class="field">
                                    <label>Our Vision</label>
                                    <div class="editor-toolbar">
                                        <button type="button" class="editor-btn" data-target="vision" data-cmd="bold"><b>B</b></button>
                                        <button type="button" class="editor-btn" data-target="vision" data-cmd="italic"><i>I</i></button>
                                        <button type="button" class="editor-btn" data-target="vision" data-cmd="underline"><u>U</u></button>
                                        <button type="button" class="editor-btn" data-target="vision" data-cmd="insertUnorderedList">• List</button>
                                        <button type="button" class="editor-btn" data-target="vision" data-cmd="insertOrderedList">1. List</button>
                                        <button type="button" class="editor-btn" data-target="vision" data-cmd="formatBlock" data-value="h2">H2</button>
                                        <button type="button" class="editor-btn" data-target="vision" data-cmd="formatBlock" data-value="h3">H3</button>
                                        <button type="button" class="editor-btn" id="about-vision-toggle">HTML</button>
                                    </div>
                                    <div id="about-vision-editor" class="rich-editor" contenteditable="true"></div>
                                    <textarea id="about-vision-content" name="about_vision" rows="10" style="display:none;"><?= htmlspecialchars($aboutVisionContent) ?></textarea>
                                </div>

                                <button type="submit" class="btn-primary">
                                    Update About Us Sections
                                </button>
                                <button type="button" class="btn-secondary" onclick="window.location='pages.php'">Cancel edit</button>
                            </form>
                        <?php else: ?>
                            <!-- Default single-page editor -->
                            <?php
                            // Prefill About Us intro default text if empty so editor is not blank
                            if ($editingPage['slug'] === 'about-us-intro' && trim((string)($editingPage['content'] ?? '')) === '') {
                                $editingPage['content'] = '<p class="lead">At Elevates, our commitment is to support early and mid-career professionals, as well as Small and Medium businesses, on their transformational journey.</p>'
                                    . '<p>Our tailored, all-encompassing, and results-driven approach boosts value selling, client management, personality growth, communication, leadership abilities, mental well-being, and technical skills. This comprehensive focus on professional development ensures that you are fully prepared to excel in today\'s competitive environment.</p>'
                                    . '<p>We understand the unique challenges faced by emerging professionals and growing businesses. That\'s why we\'ve designed our programs to address not just the technical aspects of professional growth, but also the personal development, mental wellness, and work-life balance that are essential for long-term success and fulfillment.</p>';
                            }
                            ?>
                            <form action="pages.php?edit=<?= $editingId ?>" method="post">
                                <div class="field">
                                    <label>Title</label>
                                    <input type="text" name="title" required
                                           value="<?= htmlspecialchars($editingPage['title'] ?? '') ?>"
                                           oninput="autoSlug(this.value)">
                                </div>
                                <div class="field">
                                    <label>Slug</label>
                                    <input type="text" name="slug" id="slug-field"
                                           placeholder="about-us, career-accelerator-program..."
                                           value="<?= htmlspecialchars($editingPage['slug'] ?? '') ?>">
                                    <small>Slug ko front pages me use karoge. Program pages ke liye file name se match rakhna best hai.</small>
                                </div>
                                <div class="field">
                                    <label>Status</label>
                                    <?php $st = $editingPage['status'] ?? 'published'; ?>
                                    <select name="status">
                                        <option value="published" <?= $st === 'published' ? 'selected' : '' ?>>Published</option>
                                        <option value="draft" <?= $st === 'draft' ? 'selected' : '' ?>>Draft</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label>Content <span style="color:var(--ink-3);font-size:10px;text-transform:none;letter-spacing:0;">(Doc style + HTML source toggle)</span></label>
                                    <div class="editor-toolbar">
                                        <button type="button" class="editor-btn" data-target="cms" data-cmd="bold"><b>B</b></button>
                                        <button type="button" class="editor-btn" data-target="cms" data-cmd="italic"><i>I</i></button>
                                        <button type="button" class="editor-btn" data-target="cms" data-cmd="underline"><u>U</u></button>
                                        <button type="button" class="editor-btn" data-target="cms" data-cmd="insertUnorderedList">• List</button>
                                        <button type="button" class="editor-btn" data-target="cms" data-cmd="insertOrderedList">1. List</button>
                                        <button type="button" class="editor-btn" data-target="cms" data-cmd="formatBlock" data-value="h2">H2</button>
                                        <button type="button" class="editor-btn" data-target="cms" data-cmd="formatBlock" data-value="h3">H3</button>
                                        <button type="button" class="editor-btn" id="cms-toggle-html">HTML</button>
                                    </div>
                                    <div id="cms-editor" class="rich-editor" contenteditable="true"></div>
                                    <textarea id="cms-content" name="content" rows="12" style="display:none;"><?= htmlspecialchars($editingPage['content'] ?? '') ?></textarea>
                                </div>
                                <button type="submit" class="btn-primary">
                                    Update Page
                                </button>
                                <button type="button" class="btn-secondary" onclick="window.location='pages.php'">Cancel edit</button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <p style="font-size:13px;color:var(--ink-3);">
                            Right side se koi page select karke <strong>Edit</strong> pe click kijiye. 
                            Yaha se sirf existing pages update ho sakte hain, naye pages create nahi honge.
                        </p>
                    <?php endif; ?>
                </div>

                <div class="panel">
                    <h2>All Pages</h2>
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($pages && $pages->num_rows > 0): ?>
                            <?php while ($row = $pages->fetch_assoc()): ?>
                                <tr>
                                    <td><?= (int)$row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                    <td class="slug"><?= htmlspecialchars($row['slug']) ?></td>
                                    <td class="status"><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                                    <td class="actions">
                                        <a href="pages.php?edit=<?= (int)$row['id'] ?>" class="edit">Edit</a>
                                        <a href="pages.php?delete=<?= (int)$row['id'] ?>" class="del"
                                           onclick="return confirm('Delete this page?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5">No pages yet.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success modal -->
<div id="update-modal" class="modal-backdrop">
    <div class="modal-box">
        <h3>Changes saved</h3>
        <p>Your page content has been updated successfully.</p>
        <button type="button" class="modal-btn" onclick="closeUpdateModal()">OK</button>
    </div>
</div>

<script>
function autoSlug(val) {
    const sf = document.getElementById('slug-field');
    if (!sf || sf.dataset.manual === '1') return;
    sf.value = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
}
const sf = document.getElementById('slug-field');
if (sf) sf.addEventListener('input', () => sf.dataset.manual = '1');

// In-page doc-style editor + HTML toggle (same behaviour as Blogs "Content")
document.addEventListener('DOMContentLoaded', function () {
    function initDocEditor(prefix) {
        const hidden = document.getElementById(prefix + '-content');
        const editor = document.getElementById(prefix + '-editor');
        const toggleBtn = document.getElementById(prefix + '-toggle');
        if (!hidden || !editor || !toggleBtn) return;

        let htmlMode = false;
        editor.innerHTML = hidden.value || '';

        document.querySelectorAll('.editor-btn[data-target="'+prefix+'"][data-cmd]').forEach(btn => {
            btn.addEventListener('click', function () {
                const cmd = this.dataset.cmd;
                const value = this.dataset.value || null;
                if (htmlMode) return;
                editor.focus();
                if (cmd === 'formatBlock') {
                    document.execCommand(cmd, false, value);
                } else {
                    document.execCommand(cmd, false, value);
                }
            });
        });

        toggleBtn.addEventListener('click', function () {
            htmlMode = !htmlMode;
            this.classList.toggle('active', htmlMode);
            if (htmlMode) {
                hidden.style.display = 'block';
                hidden.value = editor.innerHTML;
                editor.style.display = 'none';
            } else {
                editor.innerHTML = hidden.value;
                editor.style.display = 'block';
                hidden.style.display = 'none';
            }
        });

        const form = hidden.form;
        if (form) {
            form.addEventListener('submit', function () {
                if (!htmlMode) {
                    hidden.value = editor.innerHTML;
                }
            });
        }
    }

    // Default single CMS editor
    initDocEditor('cms');
    // About Us multi-section editors (if present)
    initDocEditor('about-intro');
    initDocEditor('about-mission');
    initDocEditor('about-vision');

    // Show modal popup when ?updated=1 is in URL
    const params = new URLSearchParams(window.location.search);
    if (params.get('updated') === '1') {
        const m = document.getElementById('update-modal');
        if (m) m.classList.add('show');
    }
});

function closeUpdateModal() {
    const m = document.getElementById('update-modal');
    if (m) m.classList.remove('show');
}
</script>

<?php $mysqli->close(); ?>
</body>
</html>

