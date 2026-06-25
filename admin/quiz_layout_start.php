<?php
/** Shared admin layout for Quiz management pages */
require_once __DIR__ . '/includes/quiz_nav_bootstrap.php';
if (!isset($quizPageTitle)) {
    $quizPageTitle = 'Quiz';
}
if (!isset($quizActiveNav)) {
    $quizActiveNav = '';
}
$admin_name = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');
$isSuperAdmin = function_exists('is_super_admin') ? is_super_admin() : true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($quizPageTitle); ?> — Elevate Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        :root{--bg:#0b0c10;--bg2:#111318;--bg3:#17191f;--line:rgba(255,255,255,.08);--ink:#f0f0f5;--ink2:#9898a8;--ink3:#5c5c70;--acc:#7c6ff7;--acc2:#a89cf9;--danger:#f06060;--green:#3ecf8e;--r:10px}
        body{background:var(--bg);color:var(--ink);font-family:'DM Sans',sans-serif;font-size:14px;line-height:1.6}
        .shell{display:flex;min-height:100vh}
        .sidebar{width:240px;flex-shrink:0;background:var(--bg2);border-right:1px solid var(--line);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:200}
        .sidebar-brand{padding:22px 20px 20px;border-bottom:1px solid var(--line);display:flex;align-items:center;gap:11px}
        .brand-mark{width:34px;height:34px;background:var(--acc);border-radius:9px;display:grid;place-items:center}
        .brand-mark svg{width:17px;height:17px;stroke:#fff;fill:none;stroke-width:2}
        .brand-label{font-family:'Syne',sans-serif;font-size:15px;font-weight:700}
        .brand-sublabel{font-size:11px;color:var(--ink3)}
        .nav{list-style:none;padding:14px 10px;flex:1;overflow:auto}
        .nav-link{display:flex;align-items:center;gap:10px;color:var(--ink2);text-decoration:none;padding:9px 12px;border-radius:10px;font-size:13.5px}
        .nav-link svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:1.8;flex-shrink:0}
        .nav-link:hover{background:var(--bg3);color:var(--ink)}
        .nav-link.active{background:rgba(124,111,247,.12);color:var(--acc2)}
        .nav-link.long-label{font-size:12.7px}
        .nav-sep{height:1px;background:var(--line);margin:10px 2px}
        .nav-link.danger{color:var(--danger)}
        .sidebar-footer{padding:14px 10px;border-top:1px solid var(--line)}
        .avatar{width:30px;height:30px;background:rgba(124,111,247,.18);border-radius:50%;display:grid;place-items:center;font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:var(--acc2)}
        .user-pill{display:flex;align-items:center;gap:10px;padding:9px 12px}
        .user-name{font-size:13px;font-weight:500}
        .user-role{font-size:11px;color:var(--ink3)}
        .main{margin-left:240px;flex:1;display:flex;flex-direction:column;min-height:100vh}
        .top{height:58px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 28px;background:var(--bg2);position:sticky;top:0;z-index:100}
        .title{font-family:'Syne',sans-serif;font-size:15px;font-weight:700}
        .content{padding:22px 28px 40px}
        .card{background:var(--bg2);border:1px solid var(--line);border-radius:12px;padding:18px;margin-bottom:16px}
        .toast{background:rgba(62,207,142,.14);border:1px solid rgba(62,207,142,.35);color:#b8f2d4;padding:10px 12px;border-radius:10px;margin-bottom:14px}
        .err{background:rgba(240,96,96,.12);border:1px solid rgba(240,96,96,.35);color:#ffc9c9;padding:10px 12px;border-radius:10px;margin-bottom:14px}
        label{display:block;font-size:12px;color:var(--ink2);margin-bottom:6px}
        input[type=text],input[type=email],input[type=number],input[type=url],select,textarea{
            width:100%;background:var(--bg3);border:1px solid var(--line);border-radius:8px;padding:10px 12px;color:var(--ink);font:inherit;margin-bottom:12px
        }
        textarea{min-height:100px;resize:vertical}
        .btn{display:inline-flex;align-items:center;gap:6px;background:var(--acc);color:#fff;border:none;border-radius:8px;padding:10px 16px;font:inherit;font-weight:600;cursor:pointer;text-decoration:none}
        .btn:hover{opacity:.92}
        .btn-ghost{background:transparent;border:1px solid var(--line);color:var(--ink2)}
        .btn-danger{background:var(--danger)}
        .grid2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .tableWrap{background:var(--bg2);border:1px solid var(--line);border-radius:12px;overflow:auto}
        table{width:100%;border-collapse:collapse;min-width:700px}
        th,td{padding:12px;border-bottom:1px solid var(--line);text-align:left;vertical-align:top;font-size:13px}
        th{font-size:11px;text-transform:uppercase;letter-spacing:.4px;color:var(--ink2);background:#0f1116}
        .badge{display:inline-block;padding:3px 8px;border-radius:999px;font-size:11px;font-weight:600}
        .badge-ok{background:rgba(62,207,142,.15);color:var(--green)}
        .badge-off{background:rgba(240,96,96,.12);color:var(--danger)}
        .actions a,.actions button{margin-right:8px;color:var(--acc2);background:none;border:none;cursor:pointer;font:inherit;text-decoration:none}
        .actions .del{color:var(--danger)}
        .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px;margin-bottom:16px}
        .stat{background:var(--bg2);border:1px solid var(--line);border-radius:12px;padding:14px}
        .stat .val{font-family:'Syne',sans-serif;font-size:24px;font-weight:700}
        .stat .lab{font-size:12px;color:var(--ink3)}
        @media(max-width:900px){.sidebar{transform:translateX(-100%)}.main{margin-left:0}.grid2{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="shell">
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-mark"><svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></div>
        <div><div class="brand-label">Elevate Pro</div><div class="brand-sublabel">Admin Panel</div></div>
    </div>
    <?php include __DIR__ . '/includes/sidebar_nav.php'; ?>
    <div class="sidebar-footer">
        <div class="user-pill">
            <div class="avatar"><?php echo strtoupper(substr($admin_name, 0, 1)); ?></div>
            <div><div class="user-name"><?php echo $admin_name; ?></div><div class="user-role"><?php echo $isSuperAdmin ? 'Super Admin' : 'Team Member'; ?></div></div>
        </div>
    </div>
</aside>
<main class="main">
    <div class="top"><div class="title"><?php echo htmlspecialchars($quizPageTitle); ?></div></div>
    <div class="content">
