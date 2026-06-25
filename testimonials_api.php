<?php
$GLOBALS['elevate_json_api'] = true;

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/testimonial_helpers.php';

header('Content-Type: application/json; charset=utf-8');

$category = isset($_GET['category']) ? trim((string)$_GET['category']) : null;
if ($category !== null && !in_array($category, ['b2c', 'b2b'], true)) {
    $category = null;
}

$rows = get_published_testimonials($mysqli, $category);
$testimonials = array_map('testimonial_to_api_row', $rows);

echo json_encode([
    'ok' => true,
    'testimonials' => $testimonials,
]);
