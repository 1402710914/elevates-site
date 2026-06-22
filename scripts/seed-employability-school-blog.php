<?php
/**
 * One-time: insert "Employability begins in school" blog post.
 * Run from project root: php one/scripts/seed-employability-school-blog.php
 * Safe to re-run: skips if slug already exists.
 *
 * Uses 127.0.0.1 if localhost socket fails (common on macOS + XAMPP).
 */
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'elevate';

$mysqli = null;
foreach (['127.0.0.1', 'localhost'] as $hostTry) {
    try {
        $t = new mysqli($hostTry, $username, $password, $database);
        if (!$t->connect_error) {
            $mysqli = $t;
            break;
        }
        $t->close();
    } catch (mysqli_sql_exception $e) {
        continue;
    }
}
if (!$mysqli) {
    fwrite(STDERR, "DB connection failed (tried 127.0.0.1 and localhost).\n");
    exit(1);
}
$mysqli->set_charset('utf8mb4');

$slug = 'employability-journey-begins-in-school-not-college';
$chk = $mysqli->prepare('SELECT id FROM blogs WHERE slug = ?');
$chk->bind_param('s', $slug);
$chk->execute();
if ($chk->get_result()->fetch_assoc()) {
    echo "Already present (slug: {$slug}).\n";
    exit(0);
}
$chk->close();

$title = 'The New Employability Journey May Now Begin in School, Not College.';
$excerpt = 'For a long time, we have treated employability as a college-level conversation.';
$category = 'news';
$image_path = 'img/blog-img.png';
$status = 'published';

$paragraphs = [
    'The New Employability Journey May Now Begin in School, Not College.  For a long time, we have treated employability as a college-level conversation.',
    'We wait until students are close to graduation, then begin talking about interviews, resumes, communication skills, internships, confidence, and workplace readiness. By then, we are often trying to solve in a few months what should have been built over many years.',
    'I believe that is where we need to pause and rethink.',
    'What if employability does not begin in college at all?',
    'What if it begins much earlier, in school?',
    'That question feels more relevant than ever today.',
    'As education starts moving toward AI awareness, skill-based learning, practical exposure, and more application-oriented models, we may be witnessing a much bigger shift than a curriculum update. We may be seeing the early foundation of a different kind of learner.',
    'A learner who is not only preparing for exams, but also preparing for life, work, decision-making, and change.',
    'And that is important.',
    'Because the world students will enter is not the same world many of us prepared for. It is faster, more digital, more uncertain, and more demanding. It rewards not just knowledge, but adaptability. Not just marks, but mindset. Not just degrees, but the ability to learn, communicate, collaborate, and respond to real situations.',
    'If that is the world ahead, then surely preparation for it cannot begin only after school is over.',
    'This is why I find the current shift in education deeply encouraging.',
    'When schools begin introducing children to areas like AI, computational thinking, skills, application-based learning, and broader exposure beyond memorisation, they are doing something powerful. They are telling students that learning is not only about remembering answers. It is about understanding the world, solving problems, asking better questions, and becoming capable human beings.',
    'That, to me, is where employability truly begins.',
    'Not in a placement cell.',
    'Not in the final year of college.',
    'But in the habits, confidence, curiosity, and thinking patterns that start forming much earlier.',
    'Employability is often misunderstood as job preparation alone. But in reality, it is much deeper than that.',
    'It is about how a young person sees themselves.',
    'How they express ideas.',
    'How they respond when things are unclear.',
    'How comfortable they are with learning something new.',
    'How they work with others.',
    'How they build confidence through doing, not just knowing.',
    'These things do not appear suddenly at age 21.',
    'They are shaped over time.',
    'This is why schools now have an even bigger role than before. Not just as places of academic instruction, but as early spaces where confidence, communication, problem-solving, digital comfort, ethics, and self-belief can begin to grow.',
    'Of course, school students do not need career pressure too early. That is not the point.',
    'The point is not to turn childhood into corporate training.',
    'The point is to build stronger foundations.',
    'A child who learns how to think clearly, speak with confidence, explore technology responsibly, work on practical projects, and stay curious is not just becoming a better student. That child is slowly becoming better prepared for the future of work and life.',
    'And that distinction matters.',
    'Because the future will not only test what students know. It will test how they adapt. How they learn. How they handle ambiguity. How they work with people and with technology at the same time.',
    'In that sense, employability is no longer a late-stage outcome. It is an early-stage development journey.',
    'I believe this is the mindset shift we need.',
    'Colleges will continue to play a major role. Industry will continue to shape expectations. Skilling organizations will continue to bridge important gaps. But if schools begin planting the seeds of practical learning, confidence, and future-readiness earlier, the entire journey becomes stronger.',
    'Instead of repairing gaps later, we start building readiness sooner.',
    'That is a far more powerful model.',
    'It also gives us a more hopeful view of education.',
    'We stop seeing school as a place only for marks and subjects. We begin seeing it as the place where the first layers of confidence, capability, and direction are formed. We begin recognizing that future-readiness is not built in one course, one workshop, or one semester. It is built gradually, through repeated exposure to the right kind of learning.',
    'This is where I believe educators, institutions, parents, and skilling ecosystems must come together more intentionally.',
    'Because if the world has changed, our learning journey must change too.',
    'And perhaps that journey no longer starts at the gates of college.',
    'Perhaps it starts much earlier, in the classroom, in the questions students are encouraged to ask, in the skills they are allowed to practice, and in the confidence they build while discovering what they are capable of becoming.',
    'If that happens, employability will stop being a last-minute concern.',
    'It will become a natural outcome of education done right.',
    'Written by Abhinav Johari, Founder & Chief Growth Officer at ELEVATES.',
];

$content = '<p>' . implode('</p><p>', $paragraphs) . '</p>';

$stmt = $mysqli->prepare(
    'INSERT INTO blogs (title, slug, excerpt, content, category, image_path, status, created_at, updated_at) VALUES (?,?,?,?,?,?,?,NOW(),NOW())'
);
$stmt->bind_param('sssssss', $title, $slug, $excerpt, $content, $category, $image_path, $status);
$stmt->execute();
if ($stmt->error) {
    fwrite(STDERR, 'Insert failed: ' . $stmt->error . PHP_EOL);
    exit(1);
}
$id = $mysqli->insert_id;
$stmt->close();
$mysqli->close();

echo "Inserted blog id={$id} slug={$slug}\n";
