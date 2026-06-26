<?php
require_once __DIR__ . '/../db.php';

$newTestimonials = [
    [
        'name' => 'Mani Sinha',
        'role' => '',
        'company' => '',
        'category' => 'b2c',
        'photo_url' => 'review-img/mani-sinha.png',
        'text' => 'From confidence building to interview preparation, ELEVATES provided the guidance and support I needed to navigate my layoff and move forward with confidence.',
    ],
    [
        'name' => 'Prashant Kumar',
        'role' => '',
        'company' => '',
        'category' => 'b2c',
        'photo_url' => 'review-img/prashant-kumar.png',
        'text' => 'Through ELEVATES, I developed stronger communication, public speaking, and leadership skills that transformed the way I interact with customers and teams.',
    ],
    [
        'name' => 'Debashish Maji',
        'role' => '',
        'company' => '',
        'category' => 'b2b',
        'photo_url' => 'review-img/debashish-maji.png',
        'text' => 'ELEVATES has helped our team strengthen communication, enhance client interactions, and approach every opportunity with greater confidence and professionalism.',
    ],
    [
        'name' => 'Rakesh Pandey',
        'role' => '',
        'company' => '',
        'category' => 'b2b',
        'photo_url' => 'review-img/rakesh-pandey.png',
        'text' => 'ELEVATES mentorship has played a valuable role in developing professionals who think with clarity, communicate effectively, and deliver greater value to customers.',
    ],
    [
        'name' => 'Shikhar Shukla',
        'role' => '',
        'company' => '',
        'category' => 'b2b',
        'photo_url' => 'review-img/shikhar.png',
        'text' => 'What stands out about ELEVATES is its practical approach to professional development. The impact is reflected in the confidence, mindset, and execution of our team.',
    ],
    [
        'name' => 'Tarika Nigam',
        'role' => '',
        'company' => '',
        'category' => 'b2c',
        'photo_url' => 'review-img/tarika.png',
        'text' => 'ELEVATES helped me strengthen my communication, build confidence, and approach my professional journey with greater clarity and purpose.',
    ],
    [
        'name' => 'Shubham Mer',
        'role' => '',
        'company' => 'NetApp',
        'category' => 'b2c',
        'photo_url' => 'review-img/shubham-mer.png',
        'text' => 'ELEVATES helped me sharpen my professional communication and approach every business conversation with greater clarity and purpose.',
    ],
    [
        'name' => 'Priyanka Tisoria',
        'role' => '',
        'company' => '',
        'category' => 'b2c',
        'photo_url' => 'review-img/priyanka-tisoria.png',
        'text' => 'The mentorship at ELEVATES enhanced my confidence, communication, and ability to build lasting relationships with customers.',
    ],
    [
        'name' => 'Mayank Bhatia',
        'role' => '',
        'company' => '',
        'category' => 'b2c',
        'photo_url' => 'review-img/mayank-bhatia.png',
        'text' => 'ELEVATES helped me look beyond products and focus on delivering meaningful business value through every customer interaction.',
    ],
    [
        'name' => 'Ravi Singh',
        'role' => '',
        'company' => '',
        'category' => 'b2c',
        'photo_url' => 'review-img/ravi-singh.png',
        'text' => 'The practical insights from ELEVATES helped me build confidence, improve client conversations, and strengthen my professional approach.',
    ],
    [
        'name' => 'Subhadip',
        'role' => '',
        'company' => '',
        'category' => 'b2c',
        'photo_url' => 'review-img/subhadip.png',
        'text' => 'ELEVATES gave me a broader business perspective, enabling me to approach customer conversations with greater confidence and strategic thinking.',
    ],
    [
        'name' => 'Shubham Pandey',
        'role' => '',
        'company' => '',
        'category' => 'b2c',
        'photo_url' => 'review-img/shubham-pandey.png',
        'text' => 'The mentorship at ELEVATES strengthened my consultative approach, helping me build stronger customer relationships and communicate value more effectively.',
    ],
    [
        'name' => 'Prikshit Awasthi',
        'role' => '',
        'company' => '',
        'category' => 'b2c',
        'photo_url' => 'review-img/prikshit.png',
        'text' => 'ELEVATES helped me communicate technical solutions with greater clarity and confidence, making every customer interaction more impactful.',
    ],
];

$inserted = 0;
$skipped = 0;

foreach ($newTestimonials as $item) {
    $check = $mysqli->prepare('SELECT id FROM testimonials WHERE name = ? AND text = ? LIMIT 1');
    $check->bind_param('ss', $item['name'], $item['text']);
    $check->execute();
    $exists = $check->get_result()->fetch_assoc();
    $check->close();

    if ($exists) {
        $skipped++;
        continue;
    }

    $photoUrl = '';
    $rating = 5;
    $status = 'published';

    $stmt = $mysqli->prepare('INSERT INTO testimonials (name, role, company, photo_url, rating, text, status, category) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->bind_param(
        'ssssisss',
        $item['name'],
        $item['role'],
        $item['company'],
        $photoUrl,
        $rating,
        $item['text'],
        $status,
        $item['category']
    );
    $stmt->execute();
    $stmt->close();
    $inserted++;
}

echo "Inserted: {$inserted}, skipped: {$skipped}\n";
