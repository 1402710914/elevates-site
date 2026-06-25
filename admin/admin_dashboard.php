<?php
session_start();
include __DIR__ . '/../db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once __DIR__ . '/admin_access.php';
require_admin_login();

if (is_super_admin() && isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM enquiries WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    header('Location: admin_dashboard.php?deleted=1');
    exit;
}

$total_enquiries = $mysqli->query("SELECT COUNT(*) as count FROM enquiries")->fetch_assoc()['count'];
$today_enquiries = $mysqli->query("SELECT COUNT(*) as count FROM enquiries WHERE DATE(created_at) = CURDATE()")->fetch_assoc()['count'];
$ai_assessments = $mysqli->query("SELECT COUNT(*) as count FROM enquiries WHERE source = 'ai_assessment'")->fetch_assoc()['count'];
$job_placement_count = $mysqli->query("SELECT COUNT(*) as count FROM enquiries WHERE source = 'job_placement_assistance'")->fetch_assoc()['count'];
$hiring_assistance_count = $mysqli->query("SELECT COUNT(*) as count FROM enquiries WHERE source = 'hiring_assistance'")->fetch_assoc()['count'];
$admin_name = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');
$isSuperAdmin = is_super_admin();
$adminNavActive = 'dashboard';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Elevate Pro</title>
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

        /* Layout shell */
        .shell {
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 240px;
            flex-shrink: 0;
            background: var(--bg-2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 200;
            transition: transform 0.28s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .sidebar-brand {
            padding: 22px 20px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .brand-mark {
            width: 34px; height: 34px;
            background: var(--accent);
            border-radius: 9px;
            display: grid; place-items: center;
            flex-shrink: 0;
        }

        .brand-mark svg {
            width: 17px; height: 17px;
            stroke: white; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        .brand-label {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.2px;
        }

        .brand-sublabel {
            font-size: 11px;
            color: var(--ink-3);
            letter-spacing: 0.3px;
        }

        /* Nav */
        .nav {
            list-style: none;
            padding: 14px 10px;
            flex: 1;
        }

        .nav-item { margin: 2px 0; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--r);
            color: var(--ink-2);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 400;
            transition: background 0.18s, color 0.18s;
            position: relative;
        }

        .nav-link svg {
            width: 16px; height: 16px;
            stroke: currentColor; fill: none;
            stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;
            flex-shrink: 0;
        }

        .nav-link:hover {
            background: var(--bg-hover);
            color: var(--ink);
        }

        .nav-link.active {
            background: rgba(124,111,247,0.12);
            color: var(--accent-2);
        }

        .nav-link.active svg { stroke: var(--accent-2); }

        .nav-sep {
            height: 1px;
            background: var(--border);
            margin: 10px 2px;
        }

        .nav-link.danger { color: var(--red); }
        .nav-link.danger:hover { background: var(--red-bg); color: var(--red); }
        .nav-link.danger svg { stroke: var(--red); }

        /* Sidebar user footer */
        .sidebar-footer {
            padding: 14px 10px;
            border-top: 1px solid var(--border);
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--r);
        }

        .avatar {
            width: 30px; height: 30px;
            background: rgba(124,111,247,0.18);
            border-radius: 50%;
            display: grid; place-items: center;
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: var(--accent-2);
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .user-name {
            font-size: 13px;
            color: var(--ink);
            font-weight: 500;
        }

        .user-role {
            font-size: 11px;
            color: var(--ink-3);
        }

        /* ── MAIN ── */
        .main {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            background: var(--bg-2);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-btn {
            display: none;
            background: none; border: none; cursor: pointer;
            padding: 6px;
            color: var(--ink-2);
        }

        .menu-btn svg {
            width: 20px; height: 20px;
            stroke: currentColor; fill: none;
            stroke-width: 2; stroke-linecap: round;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.2px;
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--ink-3);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .breadcrumb span { color: var(--ink-2); }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .time-badge {
            font-size: 12px;
            color: var(--ink-3);
            background: var(--bg-3);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 4px 12px;
        }

        /* Content */
        .content {
            padding: 28px;
            flex: 1;
        }

        /* Toast */
        .toast {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(62,207,142,0.1);
            border: 1px solid rgba(62,207,142,0.25);
            border-radius: var(--r);
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 13.5px;
            color: var(--green);
            animation: slide-in 0.35s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .toast svg {
            width: 16px; height: 16px;
            stroke: var(--green); fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
            flex-shrink: 0;
        }

        .toast-close {
            margin-left: auto;
            background: none; border: none; cursor: pointer;
            color: var(--green); opacity: 0.6;
            font-size: 16px; line-height: 1;
            padding: 0 2px;
        }

        @keyframes slide-in {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Stat grid */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 28px;
        }

        .stat {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            padding: 20px 22px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.2s, transform 0.2s;
            cursor: default;
        }

        .stat:hover {
            border-color: var(--border-md);
            transform: translateY(-2px);
        }

        .stat-label {
            font-size: 11.5px;
            font-weight: 500;
            color: var(--ink-3);
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .stat-label svg {
            width: 13px; height: 13px;
            stroke: currentColor; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 34px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -1px;
            line-height: 1;
        }

        .stat-sub {
            font-size: 12px;
            color: var(--ink-3);
            margin-top: 6px;
        }

        .stat-pip {
            position: absolute;
            top: 20px; right: 20px;
            width: 8px; height: 8px;
            border-radius: 50%;
        }

        .pip-blue  { background: var(--accent);  box-shadow: 0 0 0 3px rgba(124,111,247,0.15); }
        .pip-green { background: var(--green);   box-shadow: 0 0 0 3px rgba(62,207,142,0.15); }
        .pip-amber { background: var(--amber);   box-shadow: 0 0 0 3px rgba(240,160,64,0.15); }

        /* Section header */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.2px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .section-title svg {
            width: 15px; height: 15px;
            stroke: var(--accent-2); fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        .count-pill {
            background: rgba(124,111,247,0.12);
            color: var(--accent-2);
            font-size: 11.5px;
            font-weight: 600;
            border-radius: 20px;
            padding: 2px 9px;
        }

        /* Enquiry rows */
        .eq-list { display: flex; flex-direction: column; gap: 10px; }

        .eq-card {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            overflow: hidden;
            transition: border-color 0.2s;
            animation: rise-up 0.4s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes rise-up {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .eq-card:hover { border-color: var(--border-md); }

        /* Row layout */
        .eq-row {
            display: grid;
            grid-template-columns: 2fr 1.5fr 1.5fr 1fr auto;
            align-items: center;
            gap: 0;
            padding: 16px 20px;
            cursor: pointer;
        }

        .eq-row:hover .eq-toggle svg { stroke: var(--accent-2); }

        .eq-name {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
        }

        .eq-email {
            font-size: 13px;
            color: var(--accent-2);
            text-decoration: none;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .eq-email:hover { text-decoration: underline; }

        .eq-time {
            font-size: 12px;
            color: var(--ink-3);
        }

        .eq-source {
            display: inline-flex;
            align-items: center;
            font-size: 11.5px;
            font-weight: 500;
            background: var(--bg-3);
            border: 1px solid var(--border);
            color: var(--ink-2);
            border-radius: 20px;
            padding: 3px 10px;
            white-space: nowrap;
        }

        .eq-toggle {
            background: none; border: none; cursor: pointer;
            padding: 6px; border-radius: 6px;
            transition: background 0.15s;
            display: flex; align-items: center;
        }

        .eq-toggle:hover { background: var(--bg-hover); }

        .eq-toggle svg {
            width: 15px; height: 15px;
            stroke: var(--ink-3); fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
            transition: stroke 0.15s, transform 0.25s;
        }

        .eq-toggle.open svg { transform: rotate(180deg); stroke: var(--accent-2); }

        /* Expanded body */
        .eq-body {
            display: none;
            border-top: 1px solid var(--border);
            padding: 18px 20px 20px;
            background: var(--bg-3);
        }

        .eq-body.show { display: block; animation: fade-in 0.2s ease; }

        @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }

        .eq-meta {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }

        .meta-item {}

        .meta-label {
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--ink-3);
            margin-bottom: 4px;
        }

        .meta-value {
            font-size: 13.5px;
            color: var(--ink);
        }

        .eq-message-label {
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--ink-3);
            margin-bottom: 8px;
        }

        .eq-message {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 13.5px;
            line-height: 1.7;
            color: var(--ink);
            word-break: break-word;
        }

        .eq-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 14px;
        }

        .btn-del {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--red-bg);
            border: 1px solid rgba(240,96,96,0.2);
            color: var(--red);
            border-radius: 8px;
            padding: 7px 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.18s, border-color 0.18s;
        }

        .btn-del:hover {
            background: rgba(240,96,96,0.14);
            border-color: rgba(240,96,96,0.35);
            color: var(--red);
        }

        .btn-del svg {
            width: 14px; height: 14px;
            stroke: currentColor; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        /* Empty state */
        .empty {
            background: var(--bg-2);
            border: 1px dashed var(--border-md);
            border-radius: var(--r-lg);
            padding: 60px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 48px; height: 48px;
            background: var(--bg-3);
            border-radius: 12px;
            display: grid; place-items: center;
            margin: 0 auto 16px;
        }

        .empty-icon svg {
            width: 22px; height: 22px;
            stroke: var(--ink-3); fill: none;
            stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round;
        }

        .empty h3 {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .empty p { font-size: 13px; color: var(--ink-3); }

        /* Subtle BG noise texture */
        .noise {
            position: fixed; inset: 0; z-index: -1;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .menu-btn { display: flex; }
            .sidebar.open ~ .main .topbar { z-index: 210; }
            .stats { grid-template-columns: 1fr 1fr; }
            .eq-row { grid-template-columns: 1fr auto; gap: 4px; }
            .eq-email, .eq-time, .eq-source { display: none; }
        }

        @media (max-width: 540px) {
            .stats { grid-template-columns: 1fr; }
            .content { padding: 18px; }
        }
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

    <!-- Main -->
    <div class="main">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="menu-btn" id="menuBtn" onclick="toggleSidebar()">
                    <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div>
                    <div class="page-title">Dashboard Overview</div>
                    <div class="breadcrumb">Elevate Pro <span>›</span> Dashboard</div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="time-badge" id="clock">--:-- --</div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">

            <!-- Stats -->
            <div class="stats">
                <div class="stat">
                    <div class="stat-pip pip-blue"></div>
                    <div class="stat-label">
                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Total Enquiries
                    </div>
                    <div class="stat-value"><?= $total_enquiries ?></div>
                    <div class="stat-sub">All time</div>
                </div>
                <div class="stat">
                    <div class="stat-pip pip-green"></div>
                    <div class="stat-label">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Today
                    </div>
                    <div class="stat-value"><?= $today_enquiries ?></div>
                    <div class="stat-sub"><?= date('d M Y') ?></div>
                </div>
                <a href="ai_assessment_enquiries.php" class="stat" style="text-decoration:none;">
                    <div class="stat-pip pip-amber"></div>
                    <div class="stat-label">
                        <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        AI Assessments
                    </div>
                    <div class="stat-value"><?= $ai_assessments ?></div>
                    <div class="stat-sub">Skill gap form submissions</div>
                </a>
                <a href="job_placement_enquiries.php" class="stat" style="text-decoration:none;">
                    <div class="stat-pip pip-green"></div>
                    <div class="stat-label">
                        <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Job &amp; Placement
                    </div>
                    <div class="stat-value"><?= (int)$job_placement_count ?></div>
                    <div class="stat-sub">Placement assistance requests</div>
                </a>
                <a href="hiring_assistance_enquiries.php" class="stat" style="text-decoration:none;">
                    <div class="stat-pip pip-blue"></div>
                    <div class="stat-label">
                        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        Hiring Assistance
                    </div>
                    <div class="stat-value"><?= (int)$hiring_assistance_count ?></div>
                    <div class="stat-sub">Business hiring form</div>
                </a>
            </div>

            <!-- Quick links to all blogs / testimonials -->
            <div class="stats" style="margin-top:0; margin-bottom:24px; grid-template-columns: repeat(2, minmax(0,1fr));">
                <a href="all-posts.php" class="stat" style="text-decoration:none;">
                    <div class="stat-pip pip-blue"></div>
                    <div class="stat-label">
                        <svg viewBox="0 0 24 24"><path d="M4 4h16v16H4z"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="13" y2="12"/><line x1="8" y1="16" x2="12" y2="16"/></svg>
                        All Blogs
                    </div>
                    <div class="stat-sub">View &amp; manage all blog posts</div>
                </a>
                <a href="all-testimonials.php" class="stat" style="text-decoration:none;">
                    <div class="stat-pip pip-green"></div>
                    <div class="stat-label">
                        <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7H11l-4 3v-3H7.5A8.5 8.5 0 1 1 21 11.5z"/></svg>
                        All Testimonials
                    </div>
                    <div class="stat-sub">View &amp; manage all reviews</div>
                </a>
            </div>

            <!-- Enquiries moved to dedicated page -->
            <div class="section-header">
                <div class="section-title">
                    <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Recent Enquiries
                </div>
                <a href="enquiries.php" class="count-pill" style="text-decoration:none;">View all</a>
            </div>

        </div>
    </div>
</div>

<!-- Overlay for mobile sidebar -->
<div id="overlay" onclick="toggleSidebar()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:199;"></div>

<script>
    function toggleCard(id) {
        const body = document.getElementById(id);
        const btn  = document.getElementById('btn-' + id);
        const open = body.classList.toggle('show');
        btn.classList.toggle('open', open);
    }

    function toggleSidebar() {
        const sb = document.getElementById('sidebar');
        const ov = document.getElementById('overlay');
        const open = sb.classList.toggle('open');
        ov.style.display = open ? 'block' : 'none';
    }

    // Live clock
    function tick() {
        const el = document.getElementById('clock');
        if (!el) return;
        const now = new Date();
        el.textContent = now.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit', hour12: true });
    }
    tick();
    setInterval(tick, 15000);

    // Auto-dismiss toast
    const toast = document.getElementById('toast');
    if (toast) setTimeout(() => toast.remove(), 5000);
</script>

<?php $mysqli->close(); ?>
</body>
</html>