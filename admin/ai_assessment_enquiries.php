<?php
session_start();
include __DIR__ . '/../db.php';

require_once __DIR__ . '/admin_access.php';
require_admin_login();
require_permission('can_view_ai_assessment');

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $del = $mysqli->prepare("DELETE FROM enquiries WHERE id = ? AND source = 'ai_assessment'");
    $del->bind_param('i', $id);
    $del->execute();
    $del->close();
    header('Location: ai_assessment_enquiries.php?deleted=1');
    exit;
}

$countRow = $mysqli->query("SELECT COUNT(*) AS c FROM enquiries WHERE source = 'ai_assessment'")->fetch_assoc();
$todayRow = $mysqli->query("SELECT COUNT(*) AS c FROM enquiries WHERE source = 'ai_assessment' AND DATE(created_at)=CURDATE()")->fetch_assoc();
$total = (int)($countRow['c'] ?? 0);
$today = (int)($todayRow['c'] ?? 0);

$stmt = $mysqli->prepare("
    SELECT id, first_name, last_name, email, phone, company, subject, message, created_at
    FROM enquiries
    WHERE source = 'ai_assessment'
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();

$admin_name = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');
$adminNavActive = 'ai_assessment';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Assessment Enquiries — Elevate Pro</title>
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
        .toast{background:rgba(62,207,142,.14);border:1px solid rgba(62,207,142,.35);color:#b8f2d4;padding:10px 12px;border-radius:10px;margin-bottom:14px}
        .tableWrap{background:var(--bg2);border:1px solid var(--line);border-radius:12px;overflow:auto}
        table{width:100%;border-collapse:collapse;min-width:980px}
        th,td{padding:12px;border-bottom:1px solid var(--line);text-align:left;vertical-align:top;font-size:13px}
        th{font-size:12px;text-transform:uppercase;letter-spacing:.4px;color:var(--ink2);background:#0f1116}
        td small{display:block;color:var(--ink3);margin-top:4px}
        .msg{white-space:pre-line;max-width:420px;color:#d7d7e2}
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

    <main class="main">
        <div class="top">
            <div>
                <div class="title">AI Assessment Enquiries</div>
                <div class="sub">Only submissions from AI Based Assessment form</div>
            </div>
            <div class="sub"><?= $admin_name ?></div>
        </div>

        <div class="content">
            <?php if (isset($_GET['deleted'])): ?>
                <div class="toast">AI assessment enquiry deleted successfully.</div>
            <?php endif; ?>

            <div class="stats">
                <div class="card">
                    <div class="label">Total AI Assessment Enquiries</div>
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
                        <th>Email / Phone</th>
                        <th>Company</th>
                        <th>Subject</th>
                        <th>Assessment Details</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars(trim(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''))) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($row['email'] ?? '') ?>
                                    <small><?= htmlspecialchars($row['phone'] ?? '-') ?></small>
                                </td>
                                <td><?= htmlspecialchars($row['company'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['subject'] ?? '-') ?></td>
                                <td class="msg"><?= htmlspecialchars($row['message'] ?? '-') ?></td>
                                <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
                                <td>
                                    <a class="del" href="?delete=<?= (int)$row['id'] ?>" onclick="return confirm('Delete this enquiry?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7">No AI assessment enquiries found yet.</td></tr>
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
$stmt->close();
$mysqli->close();
?>
