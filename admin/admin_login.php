<?php
session_start();

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin_dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../db.php';

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($username) && !empty($password)) {
        // Table for team members (limited access).
        $mysqli->query("
            CREATE TABLE IF NOT EXISTS admin_users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL UNIQUE,
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
            $check = $mysqli->query("SHOW COLUMNS FROM admin_users LIKE '{$col}'");
            if ($check && $check->num_rows === 0) {
                $mysqli->query("ALTER TABLE admin_users ADD COLUMN {$colDef}");
            }
        }

        $verified = false;
        $isSuperAdmin = false;
        $permissions = [
            'can_manage_blogs' => false,
            'can_view_enquiries' => false,
            'can_view_ai_assessment' => false,
            'can_view_job_placement' => false,
            'can_view_hiring_assistance' => false,
            'can_manage_pages' => false,
            'can_manage_testimonials' => false,
            'can_manage_settings' => false,
        ];

        // 1) Super admin login from `admins` table
        $stmt = $mysqli->prepare("SELECT id, password FROM admins WHERE username = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && $res->num_rows === 1) {
                $row = $res->fetch_assoc();
                $stored = $row['password'];
                $adminId = $row['id'];

                $verified = false;
                if (strlen($stored) === 32 && md5($password) === $stored) {
                    $verified = true;
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $up = $mysqli->prepare("UPDATE admins SET password = ? WHERE id = ?");
                    if ($up) {
                        $up->bind_param('si', $newHash, $adminId);
                        $up->execute();
                        $up->close();
                    }
                } else {
                    if (password_verify($password, $stored)) {
                        $verified = true;
                        if (password_needs_rehash($stored, PASSWORD_DEFAULT)) {
                            $rehash = password_hash($password, PASSWORD_DEFAULT);
                            $up = $mysqli->prepare("UPDATE admins SET password = ? WHERE id = ?");
                            if ($up) {
                                $up->bind_param('si', $rehash, $adminId);
                                $up->execute();
                                $up->close();
                            }
                        }
                    }
                }

                if ($verified) {
                    $isSuperAdmin = true;
                    foreach ($permissions as $k => $v) {
                        $permissions[$k] = true;
                    }
                }
            }
            $stmt->close();
        } else {
            error_log('Admin login prepare failed: ' . ($mysqli->error ?? 'unknown') . "\n", 3, __DIR__ . '/../enquiry_errors.log');
            $error = 'Database error';
        }

        // 2) Team member login from `admin_users`
        if (!$verified && empty($error)) {
            $stmt2 = $mysqli->prepare("SELECT id, password, can_manage_blogs, can_view_enquiries, can_view_ai_assessment, can_view_job_placement, can_view_hiring_assistance, can_manage_pages, can_manage_testimonials, can_manage_settings FROM admin_users WHERE username = ? LIMIT 1");
            if ($stmt2) {
                $stmt2->bind_param('s', $username);
                $stmt2->execute();
                $res2 = $stmt2->get_result();
                if ($res2 && $res2->num_rows === 1) {
                    $row2 = $res2->fetch_assoc();
                    $stored2 = $row2['password'];
                    $verified = password_verify($password, $stored2);
                    if ($verified) {
                        $isSuperAdmin = false;
                        foreach (array_keys($permissions) as $permKey) {
                            $permissions[$permKey] = ((int)($row2[$permKey] ?? 0) === 1);
                        }
                    }
                }
                $stmt2->close();
            } else {
                error_log('Team login prepare failed: ' . ($mysqli->error ?? 'unknown') . "\n", 3, __DIR__ . '/../enquiry_errors.log');
            }
        }

        if ($verified) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_is_super_admin'] = $isSuperAdmin;
            foreach ($permissions as $permKey => $permVal) {
                $_SESSION[$permKey] = $permVal ? 1 : 0;
            }

            if (isset($mysqli) && $mysqli) $mysqli->close();
            header('Location: admin_dashboard.php');
            exit;
        }

        if (isset($mysqli) && $mysqli) $mysqli->close();
        if (empty($error)) $error = 'Invalid username or password';
    } else {
        $error = 'Please enter username and password';
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Elevate Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink: #0d0d0f;
            --ink-muted: #6b6b78;
            --ink-hint: #a8a8b3;
            --surface: #ffffff;
            --surface-raised: #f7f7f9;
            --border: rgba(0,0,0,0.08);
            --border-strong: rgba(0,0,0,0.14);
            --accent: #1a1a2e;
            --accent-glow: #4f46e5;
            --danger: #c0392b;
            --danger-bg: #fdf2f2;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f0eff4;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Subtle background geometry */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 800px 600px at 15% 10%, rgba(79,70,229,0.06) 0%, transparent 70%),
                radial-gradient(ellipse 600px 800px at 90% 90%, rgba(16,185,129,0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .grid-lines {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(0,0,0,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,0,0,0.025) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        /* Card */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            width: 100%;
            max-width: 420px;
            padding: 48px 44px 44px;
            position: relative;
            animation: rise 0.45s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(24px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Brand mark */
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: var(--ink);
            border-radius: 10px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .brand-icon svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: white;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .brand-name {
            font-family: 'Syne', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.3px;
        }

        .brand-sub {
            font-size: 12px;
            color: var(--ink-hint);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-weight: 400;
            margin-top: 1px;
        }

        /* Heading */
        .heading {
            font-family: 'Syne', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.6px;
            line-height: 1.2;
            margin-bottom: 6px;
        }

        .subheading {
            font-size: 14px;
            color: var(--ink-muted);
            margin-bottom: 32px;
            font-weight: 300;
        }

        /* Alert */
        .alert {
            background: var(--danger-bg);
            border: 1px solid rgba(192,57,43,0.2);
            border-radius: 10px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
            font-size: 13.5px;
            color: var(--danger);
            animation: shake 0.35s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translateX(-2px); }
            20%, 80% { transform: translateX(3px); }
            30%, 50%, 70% { transform: translateX(-3px); }
            40%, 60% { transform: translateX(3px); }
        }

        .alert svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            stroke: var(--danger);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
        }

        /* Form */
        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--ink-muted);
            letter-spacing: 0.4px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            stroke: var(--ink-hint);
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            pointer-events: none;
            transition: stroke 0.2s;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            height: 46px;
            border: 1.5px solid var(--border-strong);
            border-radius: 10px;
            background: var(--surface-raised);
            font-family: 'DM Sans', sans-serif;
            font-size: 14.5px;
            color: var(--ink);
            padding: 0 14px 0 42px;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: var(--accent-glow);
            background: var(--surface);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }

        input[type="text"]:focus ~ svg,
        input[type="password"]:focus ~ svg {
            stroke: var(--accent-glow);
        }

        /* Weird z-index trick — icon is after input in DOM but we use sibling selector */
        /* So let's put icon BEFORE input and use different approach */

        /* Toggle password */
        .toggle-pw {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--ink-hint);
            display: grid;
            place-items: center;
            transition: color 0.2s;
        }

        .toggle-pw:hover { color: var(--ink-muted); }
        .toggle-pw svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            height: 48px;
            background: var(--ink);
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            letter-spacing: 0.1px;
            transition: background 0.2s, transform 0.15s;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.07);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .btn-submit:hover {
            background: #1e1e35;
            transform: translateY(-1px);
        }

        .btn-submit:hover::after { opacity: 1; }
        .btn-submit:active { transform: translateY(0) scale(0.99); }

        .btn-submit svg {
            width: 16px;
            height: 16px;
            stroke: white;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Footer hint */
        .hint {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .hint-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            flex-shrink: 0;
            box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
        }

        .hint-text {
            font-size: 12.5px;
            color: var(--ink-hint);
        }

        .hint-cred {
            font-family: 'DM Sans', monospace;
            font-size: 12px;
            background: var(--surface-raised);
            border: 1px solid var(--border);
            border-radius: 5px;
            padding: 2px 7px;
            color: var(--ink-muted);
        }
    </style>
</head>
<body>
    <div class="grid-lines"></div>

    <div class="card">
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
            </div>
            <div>
                <div class="brand-name">Elevate Pro</div>
                <div class="brand-sub">Admin Panel</div>
            </div>
        </div>

        <h1 class="heading">Welcome back</h1>
        <p class="subheading">Sign in to your admin account</p>

        <?php if ($error): ?>
        <div class="alert">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <div class="field">
                <label for="username">Username</label>
                <div class="input-wrap">
                    <input type="text" id="username" name="username" placeholder="Enter your username" required autofocus>
                    <svg viewBox="0 0 24 24" style="left:14px;top:50%;position:absolute;transform:translateY(-50%);pointer-events:none;">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <svg viewBox="0 0 24 24" style="left:14px;top:50%;position:absolute;transform:translateY(-50%);pointer-events:none;">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <button type="button" class="toggle-pw" onclick="togglePassword()" title="Show/hide password">
                        <svg id="eye-icon" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Sign in
            </button>
        </form>

        <div class="hint">
            <div class="hint-dot"></div>
            <span class="hint-text">Default credentials &nbsp;<span class="hint-cred">admin</span>&nbsp;/&nbsp;<span class="hint-cred">admin123</span></span>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }

        // Focus ring icon color sync
        document.querySelectorAll('input').forEach(input => {
            const wrap = input.closest('.input-wrap');
            const icon = wrap ? wrap.querySelector('svg') : null;
            if (!icon) return;
            input.addEventListener('focus', () => icon.style.stroke = '#4f46e5');
            input.addEventListener('blur', () => icon.style.stroke = '');
        });
    </script>
</body>
</html>