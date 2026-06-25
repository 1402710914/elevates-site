<?php
/**
 * Shared admin sidebar navigation.
 * Set $adminNavActive before including (e.g. 'dashboard', 'quiz_settings', 'blogs').
 */
if (!isset($adminNavActive)) {
    $adminNavActive = '';
}

$adminSidebarName = htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');
$adminIsSuper = function_exists('is_super_admin') ? is_super_admin() : true;
$canViewQuizAttempts = $adminIsSuper || (function_exists('can_access_permission') && can_access_permission('can_view_ai_assessment'));
$showQuizDropdown = $adminIsSuper || $canViewQuizAttempts;
$quizNavOpen = ($adminNavActive !== '' && strncmp($adminNavActive, 'quiz_', 5) === 0);

$quizSubItems = [];
if ($adminIsSuper) {
    $quizSubItems = [
        ['key' => 'quiz_settings', 'href' => 'quiz_settings.php', 'label' => 'Settings & Instructions'],
        ['key' => 'quiz_categories', 'href' => 'quiz_categories.php', 'label' => 'Categories'],
        ['key' => 'quiz_questions', 'href' => 'quiz_questions.php', 'label' => 'Questions'],
        ['key' => 'quiz_results', 'href' => 'quiz_result_bands.php', 'label' => 'Result Messages'],
        ['key' => 'quiz_attempts', 'href' => 'quiz_attempts.php', 'label' => 'User Attempts'],
    ];
} elseif ($canViewQuizAttempts) {
    $quizSubItems = [
        ['key' => 'quiz_attempts', 'href' => 'quiz_attempts.php', 'label' => 'User Attempts'],
    ];
}

$navActive = static function (string $key) use ($adminNavActive): string {
    return $adminNavActive === $key ? ' active' : '';
};

if (!defined('ELEVATE_ADMIN_NAV_CSS')) {
    define('ELEVATE_ADMIN_NAV_CSS', true);
    echo '<style>
    .nav-dropdown{margin:2px 0}
    .nav-dropdown-toggle{width:100%;border:none;background:none;cursor:pointer;font:inherit;text-align:left}
    .nav-dropdown-toggle .nav-chevron{margin-left:auto;width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;transition:transform .22s;flex-shrink:0}
    .nav-dropdown.open .nav-chevron{transform:rotate(180deg)}
    .nav-dropdown.open>.nav-dropdown-toggle,.nav-dropdown-toggle:hover{background:var(--bg-hover, #1e2028);color:var(--ink, #f0f0f5)}
    .nav-dropdown.open>.nav-dropdown-toggle{color:var(--accent-2, #a89cf9)}
    .nav-sub{list-style:none;padding:0;margin:0;max-height:0;overflow:hidden;transition:max-height .28s ease}
    .nav-dropdown.open .nav-sub{max-height:320px;padding:2px 0 6px}
    .nav-sublink{display:block;padding:8px 12px 8px 42px;border-radius:8px;color:var(--ink-2, #9898a8);text-decoration:none;font-size:13px;line-height:1.35;transition:background .18s,color .18s}
    .nav-sublink:hover{background:rgba(124,111,247,.08);color:var(--ink, #f0f0f5)}
    .nav-sublink.active{background:rgba(124,111,247,.12);color:var(--accent-2, #a89cf9);font-weight:500}
    </style>';
}
?>
<ul class="nav">
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('dashboard'); ?>" href="admin_dashboard.php">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('blog_categories'); ?>" href="blog_categories.php">
            <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L3 13.99V4a1 1 0 0 1 1-1h9.99l7.6 7.6a2 2 0 0 1 0 2.81z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            Blog Categories
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('blogs'); ?>" href="blogs.php">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Manage Blogs
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('all_posts'); ?>" href="all-posts.php">
            <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            All Blogs
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('pages'); ?>" href="pages.php">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="14" y2="12"/><line x1="7" y1="16" x2="12" y2="16"/></svg>
            CMS Pages
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('testimonials'); ?>" href="testimonials.php">
            <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7H11l-4 3v-3H7.5A8.5 8.5 0 1 1 21 11.5z"/></svg>
            Testimonials
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('all_testimonials'); ?>" href="all-testimonials.php">
            <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7H11l-4 3v-3H7.5A8.5 8.5 0 1 1 21 11.5z"/></svg>
            All Testimonials
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('enquiries'); ?>" href="enquiries.php">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            Enquiries
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('ai_assessment'); ?>" href="ai_assessment_enquiries.php">
            <svg viewBox="0 0 24 24"><path d="M12 3a9 9 0 0 0-9 9c0 3.31 1.79 6.2 4.46 7.75L7 22l2.68-1.34A9 9 0 1 0 12 3z"/></svg>
            AI Assessment Enquiries
        </a>
    </li>
    <?php if ($showQuizDropdown && !empty($quizSubItems)): ?>
    <li class="nav-item nav-dropdown<?php echo $quizNavOpen ? ' open' : ''; ?>" id="quizNavDropdown">
        <button type="button" class="nav-link nav-dropdown-toggle<?php echo $quizNavOpen ? ' active' : ''; ?>" aria-expanded="<?php echo $quizNavOpen ? 'true' : 'false'; ?>">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            AI Assessment Quiz
            <svg class="nav-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <ul class="nav-sub">
            <?php foreach ($quizSubItems as $item): ?>
            <li>
                <a class="nav-sublink<?php echo $navActive($item['key']); ?>" href="<?php echo htmlspecialchars($item['href']); ?>">
                    <?php echo htmlspecialchars($item['label']); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </li>
    <?php endif; ?>
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('job_placement'); ?>" href="job_placement_enquiries.php">
            <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Job &amp; Placement Enquiries
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link long-label<?php echo $navActive('hiring_assistance'); ?>" href="hiring_assistance_enquiries.php">
            <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            Hiring Assistance Enquiries
        </a>
    </li>
    <?php if ($adminIsSuper): ?>
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('team_members'); ?>" href="team_members.php">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Users
        </a>
    </li>
    <?php endif; ?>
    <li class="nav-item">
        <a class="nav-link<?php echo $navActive('settings'); ?>" href="settings.php">
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
<script>
(function () {
    var dd = document.getElementById('quizNavDropdown');
    if (!dd) return;
    var btn = dd.querySelector('.nav-dropdown-toggle');
    if (!btn) return;
    btn.addEventListener('click', function () {
        dd.classList.toggle('open');
        btn.setAttribute('aria-expanded', dd.classList.contains('open') ? 'true' : 'false');
    });
})();
</script>
