<?php
// One-time script to copy existing program page HTML into cms_pages
// Visit this file once in browser: /elevate1/one/admin/seed_program_pages.php

session_start();
include __DIR__ . '/../db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo "Forbidden. Please log in as admin.";
    exit;
}

require_once __DIR__ . '/admin_access.php';
require_admin_login();
require_super_admin();

$programs = [
    [
        'title' => 'Career Accelerator Program',
        'slug'  => 'career-accelerator-program',
    ],
    [
        'title' => 'Success Accelerator Program',
        'slug'  => 'success-accelerator-program',
    ],
    [
        'title' => 'Train The Trainer Program',
        'slug'  => 'train-the-trainer-program',
    ],
    [
        'title' => 'Work Integrated Learning Programmes',
        'slug'  => 'work-integrated-learning-programmes',
    ],
    [
        'title' => 'Corporate Success Program for Freshers & Early-Career Professionals',
        'slug'  => 'corporate-success-program-for-freshers-early-career-professionals',
    ],
    [
        'title' => 'Business Accelerator Program for Non-IT',
        'slug'  => 'business-accelerator-program-for-non-it',
    ],
    // Additional existing site pages to manage via CMS
    [
        'title' => 'About Us',
        'slug'  => 'about-us',
    ],
    [
        'title' => 'Business Ready Fresh Talent',
        'slug'  => 'business-ready-fresh-talent',
    ],
    [
        'title' => 'Dreamchazer – Build Your Dream Business',
        'slug'  => 'dreamchazer-build-your-dream-business',
    ],
    [
        'title' => 'Master Technology At Your Pace',
        'slug'  => 'master-technology-at-your-pace',
    ],
];

$results = [];

foreach ($programs as $p) {
    // Check if slug already exists
    $slug = $p['slug'];
    $title = $p['title'];
    $exists = false;

    if ($stmt = $GLOBALS['mysqli']->prepare("SELECT id FROM cms_pages WHERE slug = ? LIMIT 1")) {
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
    }

    if ($exists) {
        $results[] = "{$slug}: already present, skipped.";
        continue;
    }

    // Basic placeholder content; aap baad me CMS editor se change kar sakte hain.
    $html = '<div class="container" style="padding:40px 0;"><h1 style="margin-bottom:10px;">'
          . htmlspecialchars($title, ENT_QUOTES, 'UTF-8')
          . '</h1><p>Edit this content from Admin &gt; CMS Pages.</p></div>';

    if ($stmt = $GLOBALS['mysqli']->prepare("INSERT INTO cms_pages (title, slug, content, status) VALUES (?,?,?,'published')")) {
        $stmt->bind_param('sss', $title, $slug, $html);
        if ($stmt->execute()) {
            $results[] = "{$slug}: inserted successfully (page id {$stmt->insert_id}).";
        } else {
            $results[] = "{$slug}: DB insert failed - " . $stmt->error;
        }
        $stmt->close();
    } else {
        $results[] = "{$slug}: prepare failed - " . $GLOBALS['mysqli']->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seed Program Pages</title>
    <style>
        body { font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background:#0b0c10; color:#f0f0f5; padding:40px; }
        .box { max-width:800px; margin:0 auto; background:#111318; border-radius:12px; padding:24px 28px; border:1px solid rgba(255,255,255,0.08); }
        h1 { font-size:20px; margin-bottom:16px; }
        ul { margin:0; padding-left:20px; }
        li { margin-bottom:6px; font-size:14px; }
        a { color:#a89cf9; text-decoration:none; }
        a:hover { text-decoration:underline; }
    </style>
</head>
<body>
<div class="box">
    <h1>Program pages → CMS seeding</h1>
    <p>Result:</p>
    <ul>
        <?php foreach ($results as $line): ?>
            <li><?= htmlspecialchars($line) ?></li>
        <?php endforeach; ?>
    </ul>
    <p style="margin-top:16px;font-size:13px;color:#9898a8;">
        Ab aap <a href="pages.php">CMS Pages</a> me in slugs ko edit kar sakte hain.
    </p>
</div>
</body>
</html>

