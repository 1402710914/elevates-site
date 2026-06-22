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

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM blog_categories WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: blog_categories.php?deleted=1');
    exit;
}

$editingId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editingCat = null;
if ($editingId > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM blog_categories WHERE id = ?");
    $stmt->bind_param('i', $editingId);
    $stmt->execute();
    $editingCat = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');

    if ($slug === '' && $name !== '') {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
        $slug = trim($slug, '-');
    }

    if ($editingId > 0) {
        $stmt = $mysqli->prepare("UPDATE blog_categories SET name=?, slug=? WHERE id=?");
        $stmt->bind_param('ssi', $name, $slug, $editingId);
        $stmt->execute();
        $stmt->close();
        header('Location: blog_categories.php?updated=1');
        exit;
    } else {
        $stmt = $mysqli->prepare("INSERT INTO blog_categories (name, slug) VALUES (?, ?)");
        $stmt->bind_param('ss', $name, $slug);
        $stmt->execute();
        $stmt->close();
        header('Location: blog_categories.php?created=1');
        exit;
    }
}

$cats = $mysqli->query("SELECT * FROM blog_categories ORDER BY name ASC");
if ($cats === false) { $catsError = $mysqli->error; }
$admin_name = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');
$isSuperAdmin = is_super_admin();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Categories — Elevate Pro</title>
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
            --green-bg:  rgba(62,207,142,0.08);
            --amber:     #f0a040;
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

        /* ── SIDEBAR ── */
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
        .user-pill { display: flex; align-items: center; gap: 10px; padding: 9px 12px; }

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

        /* ── MAIN ── */
        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        .topbar {
            background: var(--bg-2); border-bottom: 1px solid var(--border);
            padding: 0 28px; height: 58px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }

        .menu-btn { display: none; background: none; border: none; cursor: pointer; padding: 6px; color: var(--ink-2); }
        .menu-btn svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; }

        .page-title { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: var(--ink); letter-spacing: -0.2px; }
        .breadcrumb { font-size: 12px; color: var(--ink-3); display: flex; align-items: center; gap: 6px; }
        .breadcrumb span { color: var(--ink-2); }
        .time-badge { font-size: 12px; color: var(--ink-3); background: var(--bg-3); border: 1px solid var(--border); border-radius: 20px; padding: 4px 12px; }

        .content { padding: 28px; flex: 1; }

        /* Toast */
        .toast {
            display: flex; align-items: center; gap: 10px;
            border-radius: var(--r); padding: 12px 16px; margin-bottom: 24px;
            font-size: 13.5px; animation: slide-in 0.35s cubic-bezier(0.22,1,0.36,1);
        }

        .toast.success { background: var(--green-bg); border: 1px solid rgba(62,207,142,0.25); color: var(--green); }
        .toast.warning { background: rgba(240,160,64,0.08); border: 1px solid rgba(240,160,64,0.25); color: var(--amber); }

        .toast svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
        .toast-close { margin-left: auto; background: none; border: none; cursor: pointer; color: inherit; opacity: 0.6; font-size: 16px; line-height: 1; padding: 0 2px; }

        @keyframes slide-in { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }

        /* Layout */
        .panels { display: grid; grid-template-columns: 320px 1fr; gap: 20px; align-items: start; }

        /* Panel */
        .panel { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; }

        .panel-header {
            padding: 16px 20px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }

        .panel-title {
            font-family: 'Syne', sans-serif; font-size: 13.5px; font-weight: 700;
            color: var(--ink);
            display: flex; align-items: center; gap: 8px;
        }

        .panel-title svg { width: 15px; height: 15px; stroke: var(--accent-2); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        .edit-badge { font-size: 11px; font-weight: 500; background: rgba(124,111,247,0.12); color: var(--accent-2); border-radius: 20px; padding: 2px 9px; }

        .panel-body { padding: 20px; }

        /* Form */
        .field { margin-bottom: 16px; }

        .field label {
            display: block; font-size: 11px; font-weight: 500;
            text-transform: uppercase; letter-spacing: 0.6px;
            color: var(--ink-3); margin-bottom: 7px;
        }

        .field input[type="text"] {
            width: 100%;
            background: var(--bg-3); border: 1px solid var(--border);
            border-radius: var(--r); color: var(--ink);
            font-family: 'DM Sans', sans-serif; font-size: 13.5px;
            padding: 9px 12px; outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        .field input[type="text"]:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124,111,247,0.1);
        }

        .field-hint { font-size: 11.5px; color: var(--ink-3); margin-top: 5px; }

        /* Preview pill */
        .slug-preview {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 12px; color: var(--ink-3);
            background: var(--bg-3); border: 1px solid var(--border);
            border-radius: 20px; padding: 3px 10px; margin-top: 6px;
        }

        .slug-preview svg { width: 12px; height: 12px; stroke: var(--ink-3); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }

        .slug-preview span { font-family: monospace; font-size: 11.5px; color: var(--accent-2); }

        /* Buttons */
        .btn-submit {
            width: 100%; height: 42px;
            background: var(--accent); color: white; border: none;
            border-radius: var(--r); font-family: 'DM Sans', sans-serif;
            font-size: 14px; font-weight: 500; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background 0.18s, transform 0.15s; margin-top: 4px;
        }

        .btn-submit:hover { background: #9080f9; transform: translateY(-1px); }
        .btn-submit:active { transform: scale(0.99); }
        .btn-submit svg { width: 15px; height: 15px; stroke: white; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        .btn-cancel {
            width: 100%; height: 40px; margin-top: 8px;
            background: none; color: var(--ink-3); border: 1px solid var(--border);
            border-radius: var(--r); font-family: 'DM Sans', sans-serif;
            font-size: 13px; cursor: pointer;
            transition: border-color 0.15s, color 0.15s;
        }

        .btn-cancel:hover { border-color: var(--border-md); color: var(--ink-2); }

        /* Table */
        .tbl-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            font-size: 11px; font-weight: 500; text-transform: uppercase;
            letter-spacing: 0.6px; color: var(--ink-3);
            padding: 12px 16px; text-align: left;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--bg-hover); }

        td { padding: 13px 16px; font-size: 13.5px; color: var(--ink); vertical-align: middle; }

        .td-id { color: var(--ink-3); font-size: 12px; }

        .cat-name-cell { display: flex; align-items: center; gap: 9px; }

        .cat-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--accent); flex-shrink: 0;
            box-shadow: 0 0 0 3px rgba(124,111,247,0.15);
        }

        .cat-name { font-size: 13.5px; font-weight: 500; color: var(--ink); }

        .slug-pill {
            display: inline-flex; align-items: center;
            font-family: monospace; font-size: 12px;
            background: var(--bg-3); border: 1px solid var(--border);
            color: var(--ink-2); border-radius: 6px; padding: 3px 8px;
        }

        .actions { display: flex; gap: 6px; }

        .btn-icon {
            width: 30px; height: 30px;
            background: var(--bg-hover); border: 1px solid var(--border);
            border-radius: 8px; display: grid; place-items: center;
            text-decoration: none; transition: border-color 0.15s, background 0.15s;
        }

        .btn-icon svg { width: 13px; height: 13px; stroke: var(--ink-2); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        .btn-icon.edit:hover { border-color: var(--accent); background: rgba(124,111,247,0.1); }
        .btn-icon.edit:hover svg { stroke: var(--accent-2); }

        .btn-icon.del:hover { border-color: var(--red); background: var(--red-bg); }
        .btn-icon.del:hover svg { stroke: var(--red); }

        /* Count pill */
        .count-pill { font-size: 11.5px; color: var(--ink-3); }

        /* Empty */
        .tbl-empty { text-align: center; padding: 48px 20px; }
        .empty-icon-sm { width: 40px; height: 40px; background: var(--bg-3); border-radius: 10px; display: grid; place-items: center; margin: 0 auto 12px; }
        .empty-icon-sm svg { width: 18px; height: 18px; stroke: var(--ink-3); fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
        .tbl-empty h4 { font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
        .tbl-empty p { font-size: 12.5px; color: var(--ink-3); }

        /* DB error */
        .db-error { padding: 16px; background: var(--red-bg); border-left: 3px solid var(--red); border-radius: 6px; font-size: 13px; color: var(--red); }
        .db-error code { font-family: monospace; font-size: 12px; background: rgba(240,96,96,0.1); padding: 1px 5px; border-radius: 4px; }

        /* Noise */
        .noise { position: fixed; inset: 0; z-index: -1; background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E"); pointer-events: none; }

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
        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .menu-btn { display: flex; }
            .sidebar.open ~ .main .topbar { z-index: 210; }
            .panels { grid-template-columns: 1fr; }
        }

        @media (max-width: 540px) { .content { padding: 16px; } }
    </style>
</head>
<body>
<div class="noise"></div>

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
                <button class="menu-btn" onclick="toggleSidebar()">
                    <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div>
                    <div class="page-title">Blog Categories</div>
                    <div class="breadcrumb">Elevate Pro <span>›</span> Blog Categories</div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="time-badge" id="clock">--:-- --</div>
            </div>
        </div>

        <div class="content">

            <?php if (isset($_GET['created'])): ?>
            <div class="toast success" id="toast">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Category created successfully.
                <button class="toast-close" onclick="this.closest('.toast').remove()">×</button>
            </div>
            <?php elseif (isset($_GET['updated'])): ?>
            <div class="toast success" id="toast">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Category updated successfully.
                <button class="toast-close" onclick="this.closest('.toast').remove()">×</button>
            </div>
            <?php elseif (isset($_GET['deleted'])): ?>
            <div class="toast warning" id="toast">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                Category deleted.
                <button class="toast-close" onclick="this.closest('.toast').remove()">×</button>
            </div>
            <?php endif; ?>

            <div class="panels">

                <!-- FORM PANEL -->
                <div class="panel">
                    <div class="panel-header">
                        <div class="panel-title">
                            <?php if ($editingId): ?>
                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit Category
                            <?php else: ?>
                            <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L3 13.99V4a1 1 0 0 1 1-1h9.99l7.6 7.6a2 2 0 0 1 0 2.81z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                            Add Category
                            <?php endif; ?>
                        </div>
                        <?php if ($editingId): ?>
                        <span class="edit-badge">ID #<?= $editingId ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="panel-body">
                        <form action="blog_categories.php<?= $editingId ? '?edit=' . $editingId : '' ?>" method="post">

                            <div class="field">
                                <label>Category Name</label>
                                <input type="text" name="name" id="cat-name" required
                                    placeholder="e.g. Leadership"
                                    value="<?= htmlspecialchars($editingCat['name'] ?? '') ?>"
                                    oninput="autoSlug(this.value)">
                            </div>

                            <div class="field">
                                <label>Slug</label>
                                <input type="text" name="slug" id="slug-field"
                                    placeholder="auto-generated"
                                    value="<?= htmlspecialchars($editingCat['slug'] ?? '') ?>">
                                <div class="field-hint">Leave blank to auto-generate</div>
                                <div class="slug-preview" id="slug-preview" style="<?= empty($editingCat['slug']) && !$editingId ? 'display:none' : '' ?>">
                                    <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                    /blog/<span id="slug-display"><?= htmlspecialchars($editingCat['slug'] ?? '') ?></span>
                                </div>
                            </div>

                            <button type="submit" class="btn-submit">
                                <?php if ($editingId): ?>
                                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                Update Category
                                <?php else: ?>
                                <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L3 13.99V4a1 1 0 0 1 1-1h9.99l7.6 7.6a2 2 0 0 1 0 2.81z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                                Create Category
                                <?php endif; ?>
                            </button>

                            <?php if ($editingId): ?>
                            <button type="button" class="btn-cancel" onclick="window.location='blog_categories.php'">Cancel editing</button>
                            <?php endif; ?>

                        </form>
                    </div>
                </div>

                <!-- TABLE PANEL -->
                <div class="panel">
                    <div class="panel-header">
                        <div class="panel-title">
                            <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            All Categories
                        </div>
                        <?php if (!isset($catsError) && $cats): ?>
                        <span class="count-pill"><?= $cats->num_rows ?> total</span>
                        <?php endif; ?>
                    </div>

                    <div class="tbl-wrap">
                        <?php if (isset($catsError)): ?>
                        <div style="padding: 20px;">
                            <div class="db-error">
                                <strong>Database error:</strong> blog_categories table not found.<br>
                                <code><?= htmlspecialchars($catsError) ?></code>
                            </div>
                        </div>

                        <?php elseif ($cats && $cats->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $cats->fetch_assoc()): ?>
                                <tr>
                                    <td class="td-id"><?= (int)$row['id'] ?></td>
                                    <td>
                                        <div class="cat-name-cell">
                                            <div class="cat-dot"></div>
                                            <div class="cat-name"><?= htmlspecialchars($row['name']) ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="slug-pill"><?= htmlspecialchars($row['slug']) ?></span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="blog_categories.php?edit=<?= (int)$row['id'] ?>" class="btn-icon edit" title="Edit">
                                                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                            </a>
                                            <a href="blog_categories.php?delete=<?= (int)$row['id'] ?>" class="btn-icon del" title="Delete"
                                               onclick="return confirm('Delete this category?')">
                                                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>

                        <?php else: ?>
                        <div class="tbl-empty">
                            <div class="empty-icon-sm">
                                <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L3 13.99V4a1 1 0 0 1 1-1h9.99l7.6 7.6a2 2 0 0 1 0 2.81z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                            </div>
                            <h4>No categories yet</h4>
                            <p>Add your first category using the form.</p>
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
        const open = sb.classList.toggle('open');
        ov.style.display = open ? 'block' : 'none';
    }

    const slugField   = document.getElementById('slug-field');
    const slugPreview = document.getElementById('slug-preview');
    const slugDisplay = document.getElementById('slug-display');

    function autoSlug(val) {
        if (slugField && slugField.dataset.manual !== '1') {
            const s = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            slugField.value = s;
            updatePreview(s);
        }
    }

    function updatePreview(val) {
        if (!slugPreview || !slugDisplay) return;
        if (val) {
            slugDisplay.textContent = val;
            slugPreview.style.display = 'inline-flex';
        } else {
            slugPreview.style.display = 'none';
        }
    }

    if (slugField) {
        slugField.addEventListener('input', function() {
            this.dataset.manual = '1';
            updatePreview(this.value);
        });
        updatePreview(slugField.value);
    }

    function tick() {
        const el = document.getElementById('clock');
        if (!el) return;
        el.textContent = new Date().toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit', hour12: true });
    }
    tick(); setInterval(tick, 15000);

    const toast = document.getElementById('toast');
    if (toast) setTimeout(() => toast.remove(), 5000);
</script>

<?php $mysqli->close(); ?>
</body>
</html>