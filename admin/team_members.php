<?php
session_start();
include __DIR__ . '/../db.php';
require_once __DIR__ . '/admin_access.php';

require_admin_login();
require_super_admin();

// Create admin_users table for team members with granular access controls.
$mysqli->query("
    CREATE TABLE IF NOT EXISTS admin_users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        email VARCHAR(255) NULL,
        password VARCHAR(255) NOT NULL,
        can_manage_blogs TINYINT(1) NOT NULL DEFAULT 1,
        can_view_enquiries TINYINT(1) NOT NULL DEFAULT 0,
        can_view_ai_assessment TINYINT(1) NOT NULL DEFAULT 0,
        can_view_job_placement TINYINT(1) NOT NULL DEFAULT 0,
        can_view_hiring_assistance TINYINT(1) NOT NULL DEFAULT 0,
        can_manage_pages TINYINT(1) NOT NULL DEFAULT 0,
        can_manage_testimonials TINYINT(1) NOT NULL DEFAULT 0,
        can_manage_settings TINYINT(1) NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

// Backward compatible: if table existed without `email`, add it.
$hasEmailCol = false;
$colRes = $mysqli->query("SHOW COLUMNS FROM admin_users LIKE 'email'");
if ($colRes && $colRes->num_rows > 0) {
    $hasEmailCol = true;
}
if (!$hasEmailCol) {
    $mysqli->query("ALTER TABLE admin_users ADD COLUMN email VARCHAR(255) NULL");
}

$permissionCols = [
    "can_view_enquiries TINYINT(1) NOT NULL DEFAULT 0",
    "can_view_ai_assessment TINYINT(1) NOT NULL DEFAULT 0",
    "can_view_job_placement TINYINT(1) NOT NULL DEFAULT 0",
    "can_view_hiring_assistance TINYINT(1) NOT NULL DEFAULT 0",
    "can_manage_pages TINYINT(1) NOT NULL DEFAULT 0",
    "can_manage_testimonials TINYINT(1) NOT NULL DEFAULT 0",
    "can_manage_settings TINYINT(1) NOT NULL DEFAULT 0"
];
foreach ($permissionCols as $colDef) {
    $col = strtok($colDef, ' ');
    $colRes = $mysqli->query("SHOW COLUMNS FROM admin_users LIKE '{$col}'");
    if ($colRes && $colRes->num_rows === 0) {
        $mysqli->query("ALTER TABLE admin_users ADD COLUMN {$colDef}");
    }
}

$flash = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $permInput = $_POST['permissions'] ?? [];
    if (!is_array($permInput)) {
        $permInput = [];
    }
    $hasPerm = static function (string $key) use ($permInput): int {
        return in_array($key, $permInput, true) ? 1 : 0;
    };

    // Default for new users: only blog access unless explicitly checked.
    $canManageBlogs = $hasPerm('can_manage_blogs');
    $canViewEnquiries = $hasPerm('can_view_enquiries');
    $canViewAiAssessment = $hasPerm('can_view_ai_assessment');
    $canViewJobPlacement = $hasPerm('can_view_job_placement');
    $canViewHiringAssistance = $hasPerm('can_view_hiring_assistance');
    $canManagePages = $hasPerm('can_manage_pages');
    $canManageTestimonials = $hasPerm('can_manage_testimonials');
    $canManageSettings = $hasPerm('can_manage_settings');

    if ($username === '' || $password === '' || $email === '') {
        $flash = 'Username, email and password are required.';
    } else {
        $exists = false;
        $stmt = $mysqli->prepare("SELECT id FROM admin_users WHERE username = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $res = $stmt->get_result();
            $exists = $res && $res->num_rows > 0;
            $stmt->close();
        }

        if ($exists) {
            $flash = 'This username already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("INSERT INTO admin_users (username, email, password, can_manage_blogs, can_view_enquiries, can_view_ai_assessment, can_view_job_placement, can_view_hiring_assistance, can_manage_pages, can_manage_testimonials, can_manage_settings) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            if ($stmt) {
                $stmt->bind_param(
                    'sssiiiiiiii',
                    $username,
                    $email,
                    $hash,
                    $canManageBlogs,
                    $canViewEnquiries,
                    $canViewAiAssessment,
                    $canViewJobPlacement,
                    $canViewHiringAssistance,
                    $canManagePages,
                    $canManageTestimonials,
                    $canManageSettings
                );
                $ok = $stmt->execute();
                $stmt->close();
                $flash = $ok ? 'Team member added successfully.' : 'Failed to add team member.';
            } else {
                $flash = 'Prepare failed: ' . htmlspecialchars($mysqli->error ?? '');
            }
        }
    }
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM admin_users WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        header('Location: team_members.php?deleted=1');
        exit;
    }
}

$teamRes = $mysqli->query("SELECT id, username, email, can_manage_blogs, can_view_enquiries, can_view_ai_assessment, can_view_job_placement, can_view_hiring_assistance, can_manage_pages, can_manage_testimonials, can_manage_settings, created_at FROM admin_users ORDER BY created_at DESC");
$team = [];
if ($teamRes) {
    while ($row = $teamRes->fetch_assoc()) {
        $team[] = $row;
    }
}

$admin_name = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');
$adminNavActive = 'team_members';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Members — Elevate Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0b0c10;
            --bg-2: #111318;
            --bg-3: #17191f;
            --bg-hover: #1e2028;
            --border: rgba(255,255,255,0.07);
            --border-md: rgba(255,255,255,0.12);
            --ink: #f0f0f5;
            --ink-2: #9898a8;
            --ink-3: #5c5c70;
            --accent: #7c6ff7;
            --accent-2: #a89cf9;
            --red: #f06060;
            --red-bg: rgba(240,96,96,0.08);
            --green: #3ecf8e;
            --green-bg: rgba(62,207,142,0.08);
            --r: 10px;
            --r-lg: 14px;
            --transition: 0.18s;
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

        .noise {
            position: fixed;
            inset: 0;
            z-index: -1;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        .shell {
            display: flex;
            min-height: 100vh;
        }

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
            padding-top: 0;
        }

        .sidebar-brand {
            padding: 22px 20px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .brand-mark {
            width: 34px;
            height: 34px;
            background: var(--accent);
            border-radius: 9px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .brand-mark svg {
            width: 17px;
            height: 17px;
            stroke: white;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
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
            transition: background var(--transition), color var(--transition);
        }

        /* Match sidebar icon styling with other admin pages */
        .nav-link svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        .nav-link svg * {
            fill: none;
        }

        .nav-link:hover {
            background: var(--bg-hover);
            color: var(--ink);
        }

        .nav-link.active {
            background: rgba(124,111,247,0.12);
            color: var(--accent-2);
        }

        .nav-link.active svg {
            stroke: var(--accent-2);
        }

        .nav-sep {
            height: 1px;
            background: var(--border);
            margin: 10px 2px;
        }

        .nav-link.danger {
            color: var(--red);
        }
        .nav-link.danger:hover {
            background: var(--red-bg);
        }

        .sidebar-footer {
            padding: 14px 10px;
            border-top: 1px solid var(--border);
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 30px;
            height: 30px;
            background: rgba(124,111,247,0.18);
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: var(--accent-2);
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .user-name { font-size: 13px; color: var(--ink); font-weight: 500; }
        .user-role { font-size: 11px; color: var(--ink-3); }

        .main {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            background: var(--bg-2);
            border-bottom: 1px solid var(--border);
            padding: 0 22px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .page-title { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; }
        .breadcrumb { font-size: 12px; color: var(--ink-3); display:flex; align-items:center; gap:6px; }
        .breadcrumb span { color: var(--ink-2); }

        .menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            color: var(--ink-2);
        }
        .menu-btn svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        .content { padding: 28px; flex: 1; }
        .wrap {  margin: 0 auto; }

        .card {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            padding: 18px 20px;
            margin-bottom: 18px;
        }

        h1 { font-family: 'Syne', sans-serif; margin: 0 0 18px; font-size: 22px; }
        label { display:block; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.6px; color: var(--ink-3); margin-bottom: 8px; }
        input[type=text],input[type=password],input[type=email] { width:100%; padding: 10px 12px; border-radius: var(--r); border: 1px solid var(--border-md); background: var(--bg-3); color: var(--ink); font-family:'DM Sans',sans-serif; }
        .password-wrap { position: relative; }
        .password-wrap input { padding-right: 42px; }
        .pw-toggle {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            border: 1px solid var(--border);
            background: var(--bg-2);
            color: var(--ink-2);
            border-radius: 8px;
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
        }
        .pw-toggle:hover { color: var(--ink); border-color: var(--border-md); }
        .pw-toggle svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .perm-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px 14px;
            margin-top: 12px;
        }
        .perm-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--ink-2);
        }
        .perm-item input { accent-color: var(--accent); }
        .row { display:flex; gap:12px; }
        .col { flex: 1; }
        button { cursor: pointer; border: none; border-radius: 12px; padding: 12px 16px; background: linear-gradient(135deg, var(--accent) 0%, #a9167e 100%); color: #fff; font-weight: 700; }
        .flash { padding: 10px 12px; border-radius: 12px; margin-bottom: 14px; background: rgba(240,96,96,.12); border: 1px solid rgba(240,96,96,.25); }
        table { width:100%; border-collapse:collapse; }
        th, td { padding: 10px 8px; border-bottom: 1px solid rgba(255,255,255,.07); text-align: left; font-size: 13px; }
        th { color: var(--ink-2); text-transform: uppercase; letter-spacing: .6px; font-size: 11px; }
        .muted { color: var(--ink-2); }
        .actions a { color: var(--accent-2); text-decoration:none; font-size: 13px; margin-right: 10px; }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .menu-btn { display: flex; }
            .sidebar.open ~ .main .topbar { z-index: 210; }
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
                    <button class="menu-btn" type="button" onclick="toggleSidebar()">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <div>
                        <div class="page-title">Team Members</div>
                        <div class="breadcrumb">Elevate Pro <span>›</span> Team Members</div>
                    </div>
                </div>
            </div>

            <div class="content">
            <div class="wrap">
                
                <?php if (!empty($_GET['deleted'])): ?>
                    <div class="flash" style="background:rgba(62,207,142,.12);border-color:rgba(62,207,142,.25);">
                        Team member deleted.
                    </div>
                <?php endif; ?>

<?php if ($flash !== ''): ?>
        <div class="flash"><?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>

                <div class="card">
                    <h2 style="margin:0 0 14px;font-size:16px;">Add Team Member</h2>
                    <form method="post" action="team_members.php">
                        <div class="row">
                            <div class="col">
                                <label>Username</label>
                                <input type="text" name="username" required placeholder="e.g. team1">
                            </div>
                            <div class="col">
                                <label>Email</label>
                                <input type="email" name="email" required placeholder="team1@example.com">
                            </div>
                        </div>
                        <div class="row" style="margin-top:12px;">
                            <div class="col">
                                <label>Password</label>
                                <div class="password-wrap">
                                    <input type="password" id="new-member-password" name="password" required placeholder="Enter password">
                                    <button type="button" class="pw-toggle" id="pw-toggle-btn" aria-label="Show password">
                                        <svg id="eye-open" viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                        <svg id="eye-closed" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.95 10.95 0 0 1 12 19C5 19 1 12 1 12a21.77 21.77 0 0 1 5.06-5.94"/><path d="M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 8 11 8a21.9 21.9 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:12px;">
                            <label>Access Permissions</label>
                            <div class="perm-grid">
                                <label class="perm-item"><input type="checkbox" name="permissions[]" value="can_manage_blogs" checked> Manage Blogs</label>
                                <label class="perm-item"><input type="checkbox" name="permissions[]" value="can_view_enquiries"> All Enquiries</label>
                                <label class="perm-item"><input type="checkbox" name="permissions[]" value="can_view_ai_assessment"> AI Assessment Enquiries</label>
                                <label class="perm-item"><input type="checkbox" name="permissions[]" value="can_view_job_placement"> Job Placement Enquiries</label>
                                <label class="perm-item"><input type="checkbox" name="permissions[]" value="can_view_hiring_assistance"> Hiring Assistance Enquiries</label>
                                <label class="perm-item"><input type="checkbox" name="permissions[]" value="can_manage_pages"> CMS Pages</label>
                                <label class="perm-item"><input type="checkbox" name="permissions[]" value="can_manage_testimonials"> Testimonials</label>
                                <label class="perm-item"><input type="checkbox" name="permissions[]" value="can_manage_settings"> Settings</label>
                            </div>
                        </div>
                        <div style="margin-top:14px;">
                            <button type="submit">Add Team Member</button>
                        </div>
                        <div class="muted" style="margin-top:10px;font-size:12px;">
                            Default setup: only blog access enabled. You can enable more access using checkboxes.
                        </div>
                    </form>
                </div>

                <div class="card">
                    <h2 style="margin:0 0 14px;font-size:16px;">Existing Team Members</h2>
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Permissions</th>
                            <th>Created</th>
                            <th class="muted">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($team)): ?>
                            <?php foreach ($team as $t): ?>
                                <tr>
                                    <td><?= (int)$t['id'] ?></td>
                                    <td><?= htmlspecialchars($t['username']) ?></td>
                                    <td class="muted"><?= htmlspecialchars($t['email'] ?? '') ?></td>
                                    <td class="muted">
                                        <?php
                                            $permLabels = [];
                                            if ((int)($t['can_manage_blogs'] ?? 0) === 1) $permLabels[] = 'Blogs';
                                            if ((int)($t['can_view_enquiries'] ?? 0) === 1) $permLabels[] = 'Enquiries';
                                            if ((int)($t['can_view_ai_assessment'] ?? 0) === 1) $permLabels[] = 'AI Assessments';
                                            if ((int)($t['can_view_job_placement'] ?? 0) === 1) $permLabels[] = 'Job Placement';
                                            if ((int)($t['can_view_hiring_assistance'] ?? 0) === 1) $permLabels[] = 'Hiring Assistance';
                                            if ((int)($t['can_manage_pages'] ?? 0) === 1) $permLabels[] = 'Pages';
                                            if ((int)($t['can_manage_testimonials'] ?? 0) === 1) $permLabels[] = 'Testimonials';
                                            if ((int)($t['can_manage_settings'] ?? 0) === 1) $permLabels[] = 'Settings';
                                            echo !empty($permLabels) ? htmlspecialchars(implode(', ', $permLabels)) : 'No access';
                                        ?>
                                    </td>
                                    <td class="muted"><?= htmlspecialchars($t['created_at'] ?? '') ?></td>
                                    <td class="actions">
                                        <a href="team_members.php?delete=<?= (int)$t['id'] ?>" onclick="return confirm('Delete this team member?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="muted">No team members yet.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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

    (function () {
        var btn = document.getElementById('pw-toggle-btn');
        var input = document.getElementById('new-member-password');
        var eyeOpen = document.getElementById('eye-open');
        var eyeClosed = document.getElementById('eye-closed');
        if (!btn || !input) return;
        btn.addEventListener('click', function () {
            var showing = input.type === 'text';
            input.type = showing ? 'password' : 'text';
            if (eyeOpen && eyeClosed) {
                eyeOpen.style.display = showing ? 'inline' : 'none';
                eyeClosed.style.display = showing ? 'none' : 'inline';
            }
            btn.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
        });
    })();
</script>
</body>
</html>

