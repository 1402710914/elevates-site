<?php

function testimonial_photo_src(string $name, ?string $photoUrl = null): string
{
    $photo = trim($photoUrl ?? '');
    if ($photo !== '') {
        return $photo;
    }

    return 'review-img/placeholder.svg';
}

function testimonial_avatar_fallback(string $name): string
{
    $nameForAvatar = urlencode($name ?: 'Client');

    return "https://ui-avatars.com/api/?name={$nameForAvatar}&size=800&background=251a37&color=ffffff&bold=true";
}

function get_published_testimonials(mysqli $mysqli, ?string $category = null): array
{
    $items = [];

    if ($category !== null) {
        $stmt = $mysqli->prepare("SELECT * FROM testimonials WHERE status = 'published' AND category = ? ORDER BY created_at DESC");
        if ($stmt) {
            $stmt->bind_param('s', $category);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $items[] = $row;
            }
            $stmt->close();
        }
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM testimonials WHERE status = 'published' ORDER BY created_at DESC");
        if ($stmt) {
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $items[] = $row;
            }
            $stmt->close();
        }
    }

    return $items;
}

function testimonial_to_api_row(array $row): array
{
    $name = (string)($row['name'] ?? '');

    return [
        'id' => (int)($row['id'] ?? 0),
        'name' => $name,
        'role' => (string)($row['role'] ?? ''),
        'company' => (string)($row['company'] ?? ''),
        'text' => (string)($row['text'] ?? ''),
        'rating' => max(1, min(5, (int)($row['rating'] ?? 5))),
        'photo_url' => testimonial_photo_src($name, $row['photo_url'] ?? ''),
        'category' => (string)($row['category'] ?? 'b2c'),
    ];
}
