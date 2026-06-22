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

$admin_name = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');

$result = $mysqli->query("SELECT * FROM testimonials ORDER BY created_at DESC");
$testimonialsError = $result === false ? $mysqli->error : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Testimonials — Elevate Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        :root{
            --bg:#0b0c10;--bg-2:#111318;--bg-3:#17191f;--bg-hover:#1e2028;
            --border:rgba(255,255,255,0.07);--border-md:rgba(255,255,255,0.12);
            --ink:#f0f0f5;--ink-2:#9898a8;--ink-3:#5c5c70;
            --accent:#7c6ff7;--accent-2:#a89cf9;
            --red:#f06060;--red-bg:rgba(240,96,96,0.08);
            --green:#3ecf8e;--green-bg:rgba(62,207,142,0.08);
            --r:10px;--r-lg:14px;
        }
        html,body{height:100%;background:var(--bg);color:var(--ink);font-family:'DM Sans',sans-serif;font-size:14px;line-height:1.6;overflow-x:hidden;}
        .shell{display:flex;min-height:100vh;}
        .sidebar{width:240px;flex-shrink:0;background:var(--bg-2);border-right:1px solid var(--border);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:200;transition:transform .28s cubic-bezier(.22,1,.36,1);}
        .sidebar-brand{padding:22px 20px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:11px;}
        .brand-mark{width:34px;height:34px;background:var(--accent);border-radius:9px;display:grid;place-items:center;flex-shrink:0;}
        .brand-mark svg{width:17px;height:17px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;}
        .brand-label{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--ink);letter-spacing:-.2px;}
        .brand-sublabel{font-size:11px;color:var(--ink-3);letter-spacing:.3px;}
        .nav{list-style:none;padding:14px 10px;flex:1;}
        .nav-item{margin:2px 0;}
        .nav-link{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:var(--r);color:var(--ink-2);text-decoration:none;font-size:13.5px;transition:background .18s,color .18s;}
        .nav-link svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;}
        .nav-link:hover{background:var(--bg-hover);color:var(--ink);}
        .nav-link.active{background:rgba(124,111,247,.12);color:var(--accent-2);}
        .nav-link.active svg{stroke:var(--accent-2);}
        .nav-sep{height:1px;background:var(--border);margin:10px 2px;}
        .nav-link.danger{color:var(--red);}
        .nav-link.danger:hover{background:var(--red-bg);}
        .nav-link.danger svg{stroke:var(--red);}
        .sidebar-footer{padding:14px 10px;border-top:1px solid var(--border);}
        .user-pill{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:var(--r);}
        .avatar{width:30px;height:30px;background:rgba(124,111,247,.18);border-radius:50%;display:grid;place-items:center;font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:var(--accent-2);flex-shrink:0;text-transform:uppercase;}
        .user-name{font-size:13px;color:var(--ink);font-weight:500;}
        .user-role{font-size:11px;color:var(--ink-3);}
        .main{margin-left:240px;flex:1;display:flex;flex-direction:column;min-height:100vh;}
        .topbar{background:var(--bg-2);border-bottom:1px solid var(--border);padding:0 28px;height:58px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;}
        .topbar-left{display:flex;align-items:center;gap:12px;}
        .menu-btn{display:none;background:none;border:none;cursor:pointer;padding:6px;color:var(--ink-2);}
        .menu-btn svg{width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;}
        .page-title{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--ink);letter-spacing:-.2px;}
        .breadcrumb{font-size:12px;color:var(--ink-3);display:flex;align-items:center;gap:6px;}
        .breadcrumb span{color:var(--ink-2);}
        .time-badge{font-size:12px;color:var(--ink-3);background:var(--bg-3);border:1px solid var(--border);border-radius:20px;padding:4px 12px;}
        .content{padding:28px;flex:1;}
        .tbl-wrap{background:var(--bg-2);border-radius:var(--r-lg);border:1px solid var(--border);overflow-x:auto;}
        table{width:100%;border-collapse:collapse;}
        thead th{font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.6px;color:var(--ink-3);padding:12px 16px;text-align:left;border-bottom:1px solid var(--border);white-space:nowrap;}
        tbody tr{border-bottom:1px solid var(--border);}
        tbody tr:last-child{border-bottom:none;}
        tbody tr:hover{background:var(--bg-hover);}
        td{padding:12px 16px;font-size:13.5px;color:var(--ink);vertical-align:middle;}
        .td-title{max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:500;}
        .td-muted{font-size:12px;color:var(--ink-3);}
        .status-pill{display:inline-flex;align-items:center;gap:5px;font-size:11.5px;border-radius:20px;padding:3px 9px;}
        .status-pill.published{background:var(--green-bg);color:var(--green);}
        .status-pill.draft{background:rgba(255,255,255,.05);color:var(--ink-3);}
        .status-dot{width:5px;height:5px;border-radius:50%;background:currentColor;}
        .actions a{font-size:12px;color:var(--accent-2);text-decoration:none;margin-right:8px;}
        .thumb{width:40px;height:40px;border-radius:8px;object-fit:cover;background:#222;}
        .empty{padding:32px 20px;text-align:center;font-size:13px;color:var(--ink-3);}
        .noise{position:fixed;inset:0;z-index:-1;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");pointer-events:none;}
        /* Ensure sidebar icons render same as other admin pages */
        .nav-link svg, .nav-link svg *{
            stroke: currentColor !important;
            fill: none !important;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        .nav-link.active svg, .nav-link.active svg *{
            stroke: var(--accent-2) !important;
        }
        @media(max-width:900px){.sidebar{transform:translateX(-100%);}.sidebar.open{transform:translateX(0);}.main{margin-left:0;}.menu-btn{display:flex;}.sidebar.open~.main .topbar{z-index:210;}}
        @media(max-width:540px){.content{padding:16px;}}
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
                <button type="button" class="menu-btn" onclick="toggleSidebar()">
                    <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div>
                    <div class="page-title">All Testimonials</div>
                    <div class="breadcrumb">Elevate Pro <span>›</span> All Testimonials</div>
                </div>
            </div>
            <div class="topbar-right">
                <div class="time-badge" id="clock">--:-- --</div>
            </div>
        </div>
        <div class="content">
            <div class="tbl-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Role &amp; Company</th>
                        <th>Rating</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($testimonialsError): ?>
                        <tr><td colspan="9" class="td-muted">Database error: <?= htmlspecialchars($testimonialsError) ?></td></tr>
                    <?php elseif (!$result || $result->num_rows === 0): ?>
                        <tr><td colspan="9" class="empty">No testimonials found. Add some from the Testimonials page.</td></tr>
                    <?php else: ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= (int)$row['id'] ?></td>
                                <td>
                                    <?php $thumb = trim($row['photo_url'] ?? ''); ?>
                                    <?php
                                    $thumbSrc = $thumb;
                                    // Admin page is inside /one/admin, so fix relative image path.
                                    if ($thumbSrc !== '' && strpos($thumbSrc, 'review-img/') === 0) {
                                        $thumbSrc = '../' . $thumbSrc;
                                    }
                                    ?>
                                    <?php if ($thumbSrc !== ''): ?>
                                        <img src="<?= htmlspecialchars($thumbSrc) ?>" alt="" class="thumb">
                                    <?php else: ?>
                                        <span class="td-muted">No image</span>
                                    <?php endif; ?>
                                </td>
                                <td class="td-title" title="<?= htmlspecialchars($row['name']) ?>"><?= htmlspecialchars($row['name']) ?></td>
                                <td class="td-muted">
                                    <?= htmlspecialchars($row['role']) ?><br>
                                    <span class="td-muted"><?= htmlspecialchars($row['company']) ?></span>
                                </td>
                                <td><?= (int)$row['rating'] ?>/5</td>
                                <td class="td-muted"><?= htmlspecialchars(strtoupper($row['category'] ?? 'b2C')) ?></td>
                                <td>
                                    <span class="status-pill <?= $row['status'] === 'published' ? 'published' : 'draft' ?>">
                                        <span class="status-dot"></span><?= htmlspecialchars(ucfirst($row['status'])) ?>
                                    </span>
                                </td>
                                <td class="td-muted"><?= htmlspecialchars($row['created_at'] ?? '') ?></td>
                                <td class="actions">
                                    <a href="testimonials.php?edit=<?= (int)$row['id'] ?>">Edit</a>
                                    <a href="testimonials.php?delete=<?= (int)$row['id'] ?>" onclick="return confirm('Delete this testimonial?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="overlay" onclick="toggleSidebar()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:199;"></div>
<script>
function toggleSidebar() {
    var sb = document.getElementById('sidebar');
    var ov = document.getElementById('overlay');
    if (!sb) return;
    var open = sb.classList.toggle('open');
    if (ov) ov.style.display = open ? 'block' : 'none';
}
function updateClock(){
    var el=document.getElementById('clock');
    if(!el)return;
    var d=new Date();
    el.textContent=d.toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});
}
updateClock();setInterval(updateClock,60000);
</script>
</body>
</html>

