<?php
session_start();
include __DIR__ . '/../db.php';

require_once __DIR__ . '/admin_access.php';
require_admin_login();
require_permission('can_view_job_placement');

$mysqli->query("
    CREATE TABLE IF NOT EXISTS job_placement_assistance_submissions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(150) NOT NULL,
        phone VARCHAR(30) NOT NULL,
        email VARCHAR(190) NOT NULL,
        total_experience_years DECIMAL(4,1) NOT NULL,
        qualification VARCHAR(190) NOT NULL,
        current_organization VARCHAR(190) NOT NULL,
        designation_expertise TEXT NOT NULL,
        current_ctc VARCHAR(80) NOT NULL,
        expected_ctc VARCHAR(80) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $del = $mysqli->prepare('DELETE FROM job_placement_assistance_submissions WHERE id = ?');
    $del->bind_param('i', $id);
    $del->execute();
    $del->close();
    header('Location: job_placement_enquiries.php?deleted=1');
    exit;
}

$countRow = $mysqli->query('SELECT COUNT(*) AS c FROM job_placement_assistance_submissions')->fetch_assoc();
$todayRow = $mysqli->query('SELECT COUNT(*) AS c FROM job_placement_assistance_submissions WHERE DATE(created_at)=CURDATE()')->fetch_assoc();
$total = (int)($countRow['c'] ?? 0);
$today = (int)($todayRow['c'] ?? 0);

$result = $mysqli->query('
    SELECT id, name, phone, email, total_experience_years, qualification, current_organization,
           designation_expertise, current_ctc, expected_ctc, created_at
    FROM job_placement_assistance_submissions
    ORDER BY created_at DESC
');

$admin_name = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job &amp; Placement Enquiries — Elevate Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        :root{--bg:#0b0c10;--bg2:#111318;--bg3:#17191f;--line:rgba(255,255,255,.08);--ink:#f0f0f5;--ink2:#9898a8;--ink3:#5c5c70;--acc:#7c6ff7;--acc2:#a89cf9;--danger:#f06060}
        body{background:var(--bg);color:var(--ink);font-family:'DM Sans',sans-serif;overflow-x:hidden}
        .shell{display:flex;min-height:100vh}
        .sidebar{width:240px;flex-shrink:0;background:var(--bg2);border-right:1px solid var(--line);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:200;transition:transform .28s cubic-bezier(.22,1,.36,1)}
        .sidebar-brand{padding:22px 20px 20px;border-bottom:1px solid var(--line);display:flex;align-items:center;gap:11px}
        .brand-mark{width:34px;height:34px;background:var(--acc);border-radius:9px;display:grid;place-items:center;flex-shrink:0}
        .brand-mark svg{width:17px;height:17px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .brand-label{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--ink);letter-spacing:-.2px}
        .brand-sublabel{font-size:11px;color:var(--ink3);letter-spacing:.3px}
        .nav{list-style:none;padding:14px 10px;flex:1;overflow:auto}
        .nav-item{margin:2px 0}
        .nav-link{display:flex;align-items:center;gap:10px;color:var(--ink2);text-decoration:none;padding:9px 12px;border-radius:10px;font-size:13.5px;line-height:1.25;transition:background .18s,color .18s}
        .nav-link svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
        .nav-link:hover{background:var(--bg3);color:var(--ink)}
        .nav-link.active{background:rgba(124,111,247,.12);color:var(--acc2)}
        .nav-link.active svg{stroke:var(--acc2)}
        .nav-link.long-label{font-size:12.7px}
        .nav-sep{height:1px;background:var(--line);margin:10px 2px}
        .nav-link.danger{color:var(--danger)}
        .nav-link.danger:hover{background:rgba(240,96,96,.10);color:var(--danger)}
        .sidebar-footer{padding:14px 10px;border-top:1px solid var(--line)}
        .user-pill{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:10px}
        .avatar{width:30px;height:30px;background:rgba(124,111,247,.18);border-radius:50%;display:grid;place-items:center;font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:var(--acc2);text-transform:uppercase;flex-shrink:0}
        .user-name{font-size:13px;color:var(--ink);font-weight:500}
        .user-role{font-size:11px;color:var(--ink3)}
        .main{margin-left:240px;flex:1;display:flex;flex-direction:column;min-height:100vh}
        .top{height:58px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 28px;background:var(--bg2);position:sticky;top:0;z-index:100}
        .title{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;letter-spacing:-.2px}
        .sub{font-size:12px;color:var(--ink3)}
        .content{padding:22px}
        .stats{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-bottom:16px}
        .card{background:var(--bg2);border:1px solid var(--line);border-radius:12px;padding:14px}
        .label{font-size:12px;color:var(--ink2);margin-bottom:8px}
        .value{font-family:'Syne',sans-serif;font-size:26px}
        .toast{background:rgba(232,165,75,.14);border:1px solid rgba(232,165,75,.35);color:#f4d08d;padding:10px 12px;border-radius:10px;margin-bottom:14px}
        .tableWrap{background:var(--bg2);border:1px solid var(--line);border-radius:12px;overflow:auto}
        table{width:100%;border-collapse:collapse;min-width:1200px}
        th,td{padding:12px;border-bottom:1px solid var(--line);text-align:left;vertical-align:top;font-size:13px}
        th{font-size:11px;text-transform:uppercase;letter-spacing:.4px;color:var(--ink2);background:#0f1116}
        td small{display:block;color:var(--ink3);margin-top:4px}
        .expert{white-space:pre-wrap;max-width:320px;color:#d7d7e2;line-height:1.45}
        .del{color:var(--danger);text-decoration:none}
        .del:hover{text-decoration:underline}
        @media (max-width:900px){.sidebar{transform:translateX(-100%)}.main{margin-left:0}.stats{grid-template-columns:1fr}}
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

    <main class="main">
        <div class="top">
            <div>
                <div class="title">Job &amp; Placement Enquiries</div>
                <div class="sub">Submissions from the Job &amp; Placement Assistance form</div>
            </div>
            <div class="sub"><?= $admin_name ?></div>
        </div>

        <div class="content">
            <?php if (isset($_GET['deleted'])): ?>
                <div class="toast">Record deleted successfully.</div>
            <?php endif; ?>

            <div class="stats">
                <div class="card">
                    <div class="label">Total Job &amp; Placement requests</div>
                    <div class="value"><?= $total ?></div>
                </div>
                <div class="card">
                    <div class="label">Today</div>
                    <div class="value"><?= $today ?></div>
                </div>
            </div>

            <div class="tableWrap">
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact / Email</th>
                        <th>Exp (yrs)</th>
                        <th>Qualification</th>
                        <th>Organization</th>
                        <th>Designation &amp; expertise</th>
                        <th>Current CTC</th>
                        <th>Expected CTC</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
                                <td>
                                    <?= htmlspecialchars($row['phone'] ?? '') ?>
                                    <small><?= htmlspecialchars($row['email'] ?? '') ?></small>
                                </td>
                                <td><?= htmlspecialchars((string)$row['total_experience_years']) ?></td>
                                <td><?= htmlspecialchars($row['qualification'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['current_organization'] ?? '') ?></td>
                                <td class="expert"><?= htmlspecialchars($row['designation_expertise'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['current_ctc'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['expected_ctc'] ?? '') ?></td>
                                <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
                                <td>
                                    <a class="del" href="?delete=<?= (int)$row['id'] ?>" onclick="return confirm('Delete this record?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="10">No job &amp; placement enquiries yet.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>
<?php
if ($result) {
    $result->free();
}
$mysqli->close();
?>
