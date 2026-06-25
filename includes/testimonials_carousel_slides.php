<?php
/** @var array<int, array<string, mixed>> $testimonials */
foreach ($testimonials as $t):
    $name = htmlspecialchars((string)($t['name'] ?? ''), ENT_QUOTES, 'UTF-8');
    $text = htmlspecialchars((string)($t['text'] ?? ''), ENT_QUOTES, 'UTF-8');
    $img = htmlspecialchars(testimonial_photo_src((string)($t['name'] ?? ''), $t['photo_url'] ?? ''), ENT_QUOTES, 'UTF-8');
    $rating = max(1, min(5, (int)($t['rating'] ?? 5)));
    $company = trim((string)($t['company'] ?? ''));
    $role = trim((string)($t['role'] ?? ''));
    $authorTitle = $role;
    if ($company !== '') {
        $authorTitle = $authorTitle !== '' ? $authorTitle . ' · ' . $company : $company;
    }
?>
                     <div class="swiper-slide">
                        <div class="testimonial-card">
                           <img src="<?= $img ?>" alt="<?= $name ?>" class="testimonial-image" loading="lazy" onerror="this.src='review-img/placeholder.svg'">
                           <div class="testimonial-overlay">
                              <div class="testimonial-content">
                                 <div class="testimonial-rating">
                                    <?php for ($i = 0; $i < $rating; $i++): ?>
                                    <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                 </div>
                                 <p class="testimonial-text">"<?= $text ?>"</p>
                                 <div class="testimonial-author">
                                    <p class="author-name"><?= strtoupper($name) ?></p>
                                    <?php if ($authorTitle !== ''): ?>
                                    <p class="author-title"><?= htmlspecialchars($authorTitle, ENT_QUOTES, 'UTF-8') ?></p>
                                    <?php endif; ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
<?php endforeach; ?>
