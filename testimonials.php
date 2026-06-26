<?php
include 'header.php';
include 'db.php';
require_once __DIR__ . '/includes/testimonial_helpers.php';

// Helper: fetch testimonials by category
function get_testimonials_by_category(mysqli $mysqli, string $category): array {
    return get_published_testimonials($mysqli, $category);
}

$professionals = get_testimonials_by_category($mysqli, 'b2c');
$businesses    = get_testimonials_by_category($mysqli, 'b2b');
?>

<style>
/* ==================== TESTIMONIALS SECTION ==================== */
.testimonials-section {
    background: #ffffff;
    padding: 80px 20px;
    color: #000000;
}

.testimonials-section .testimonials-title,
.testimonials-section .testimonials-subtitle {
    color: #000000;
}

.testimonials-title {
    font-family: 'Playfair Display', serif;
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 20px;
    text-align: center;
    color: var(--text-light);
}

.testimonials-subtitle {
    text-align: center;
    color: var(--text-muted);
    font-size: 18px;
}

/* Tab bar: outside hero, fixes below header on scroll */
.testimonial-tabs-bar {
    background: #f8f9fa;
    padding: 16px 0;
    transition: box-shadow 0.2s ease;
}
.testimonial-tabs-inner {
    display: flex;
    flex-wrap: nowrap;
    gap: 16px;
    justify-content: center;
    align-items: center;
}
.testimonial-tab-btn {
    display: inline-block;
    padding: 12px 24px;
    background: linear-gradient(135deg, #6a0dad 0%, #a9167e 100%);
    color: #fff !important;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 50px;
    text-decoration: none !important;
    transition: transform 0.2s, box-shadow 0.2s;
    border: none;
    white-space: nowrap;
}
.testimonial-tab-btn:hover {
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(106, 13, 173, 0.4);
}
.testimonial-tabs-bar.is-fixed {
    position: fixed;
    left: 0;
    right: 0;
    z-index: 1015;
    background: #fff;
    padding: 12px 0;
    margin: 0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.testimonial-tabs-bar.is-fixed .testimonial-tabs-inner {
    max-width: 1200px;
    margin: 0 auto;
}
@media (max-width: 767px) {
    .testimonial-tabs-inner {
        flex-wrap: nowrap;
        gap: 10px;
    }
    .testimonial-tab-btn {
        padding: 10px 14px;
        font-size: 0.9rem;
    }
}
.testimonial-tabs-spacer {
    display: none;
    height: 0;
}
.testimonial-tabs-spacer.visible {
    display: block;
}
.testimonials-block-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    color: #251a37;
    margin-bottom: 24px;
    text-align: center;
}
#professionals-testimonials,
#business-testimonials {
    scroll-margin-top: 140px;
}

.testimonials-wrapper {
    position: relative;
    padding: 0 60px;
}

/* Testimonials: Nav (arrows + dots) center m */
.testimonials-swiper {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.testimonials-swiper .swiper-wrapper {
    width: 100%;
}

.testimonials-nav-wrapper {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    margin-top: 40px;
}

.testimonials-nav-wrapper .testimonials-swiper-prev {
    margin-right: -8px !important;
}

.testimonials-nav-wrapper .testimonials-swiper-next {
    margin-left: -8px !important;
}

.testimonials-swiper .testimonials-swiper-prev,
.testimonials-swiper .testimonials-swiper-next {
    position: relative !important;
    left: auto !important;
    right: auto !important;
    top: auto !important;
    margin: 0 !important;
    width: 45px;
    height: 45px;
    background: #251a37 !important;
    border: none;
    border-radius: 50%;
    color: #99138a;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
    transition: all 0.3s ease;
}

.testimonials-swiper .testimonials-swiper-prev:hover,
.testimonials-swiper .testimonials-swiper-next:hover {
    background: #f5f5f5;
    color: #99138a;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15);
}

.testimonials-nav-wrapper .testimonials-pagination,
.testimonials-swiper .testimonials-pagination {
    position: relative !important;
    margin: 0 !important;
    padding: 0 !important;
    display: flex;
    align-items: center;
    gap: 6px;
    width: auto !important;
}

.testimonials-pagination .swiper-pagination-bullet {
    width: 8px;
    height: 8px;
    background: #d1d1d1;
    border: none;
    border-radius: 50%;
    opacity: 1;
    transition: all 0.3s ease;
}

.testimonials-pagination .swiper-pagination-bullet-active {
    width: 24px;
    height: 8px;
    border-radius: 4px;
    background: #99138a;
    transform: none;
}

.testimonials-swiper-prev::after,
.testimonials-swiper-next::after {
    color: #99138a !important;
}

.swiper {
    padding: 20px 0;
}

.testimonial-card {
    position: relative;
    height: 500px;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid rgba(153, 19, 138, 0.15);
    margin-bottom: 30px;
}

.testimonial-card:hover {
    border-color: var(--gold);
    transform: translateY(-8px);
}

.testimonial-image {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1;
}

.testimonial-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.15) 15%, rgba(0,0,0,0.35) 40%, rgba(10,10,10,0.75) 75%, rgba(10,10,10,0.98) 100%);
    z-index: 2;
    transition: all 0.3s ease;
    min-height: 240px;
    display: flex;
    align-items: flex-end;
}

.testimonial-card:hover .testimonial-overlay {
    background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.1) 10%, rgba(0,0,0,0.25) 30%, rgba(10,10,10,0.85) 70%, rgba(10,10,10,0.99) 100%);
}

.testimonial-content {
    position: relative;
    z-index: 3;
    width: 100%;
    padding: 25px 20px 20px;
}

.testimonial-rating {
    color: #ffe234;
    font-size: 13px;
    margin-bottom: 8px;
    letter-spacing: 0.5px;
}

.testimonial-text {
    color: var(--text-light);
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 12px;
    font-style: italic;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: all 0.3s ease;
    max-height: 44px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.testimonial-card:hover .testimonial-text {
    -webkit-line-clamp: unset;
    line-clamp: unset;
    max-height: none;
    display: block;
    color: rgba(255, 255, 255, 0.98);
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
    line-height: 1.7;
}

.testimonial-author {
    border-top: 1px solid rgb(255 255 255 / 30%);
    padding-top: 10px;
}

.author-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.author-name {
    color: #fff;
    font-weight: 700;
    font-size: 14px;
    margin: 0;
    text-transform: uppercase;
    flex: 1;
    min-width: 0;
}

.author-title {
    color: rgba(255, 255, 255, 0.75);
    font-size: 11px;
    margin: 2px 0 0 0;
    text-align: right;
    flex-shrink: 0;
    max-width: 48%;
    line-height: 1.35;
}

/* Responsive Styles for Testimonials */
@media (max-width: 992px) {
    .testimonials-section {
        padding: 50px 20px;
    }
}

@media (min-width: 993px) and (max-width: 1199px) {
    .testimonials-section {
        padding: 80px 20px;
    }
}

@media (max-width: 768px) {
    .testimonials-section {
        padding: 50px 15px;
    }

    .testimonials-subtitle {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .testimonials-section {
        padding: 40px 12px;
    }

    .testimonial-card {
        height: 450px;
        margin-bottom: 20px;
    }

    .testimonial-content {
        padding: 20px 15px 15px;
    }

    .testimonial-text {
        font-size: 13px;
        line-height: 1.5;
    }

    .author-name {
        font-size: 13px;
    }
}
</style>

    <!-- Testimonials Hero -->
    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Client Testimonials</h1>
                    <p class="page-subtitle">Real stories from real professionals who've transformed their careers with Elevates</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tab bar: outside hero, fixes below header on scroll -->
    <div class="testimonial-tabs-bar" id="testimonialTabsBar">
        <div class="container">
            <div class="testimonial-tabs-inner">
                <a href="#professionals-testimonials" class="testimonial-tab-btn" data-section="professionals-testimonials">Professional </a>
                <a href="#business-testimonials" class="testimonial-tab-btn" data-section="business-testimonials">Businesses</a>
            </div>
        </div>
    </div>
    <div class="testimonial-tabs-spacer" id="testimonialTabsSpacer"></div>

    <!-- ==================== PROFESSIONALS TESTIMONIALS ==================== -->
    <section class="testimonials-section" id="professionals-testimonials">
        <div class="container">
            <h2 class="testimonials-block-title">Our Professional's Testimonials</h2>
            <div class="row g-4">
                <?php if (!empty($professionals)): ?>
                    <?php foreach ($professionals as $t): ?>
                        <?php
                        $img = testimonial_photo_src($t['name'] ?? '', $t['photo_url'] ?? '');
                        $rating = (int)($t['rating'] ?? 5);
                        if ($rating < 1) $rating = 1;
                        if ($rating > 5) $rating = 5;
                        ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="testimonial-card">
                                <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($t['name'] ?? 'Testimonial') ?>" class="testimonial-image" loading="lazy" onerror="this.src='review-img/placeholder.svg'">
                                <div class="testimonial-overlay">
                                    <div class="testimonial-content">
                                        <div class="testimonial-rating">
                                            <?php for ($i = 0; $i < $rating; $i++): ?>
                                                <i class="fas fa-star"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <p class="testimonial-text">"<?= htmlspecialchars($t['text'] ?? '') ?>"</p>
                                        <div class="testimonial-author">
                                            <div class="author-row">
                                                <p class="author-name"><?= strtoupper(htmlspecialchars($t['name'] ?? '')) ?></p>
                                                <?php $authorCompany = testimonial_author_company($t); ?>
                                                <?php if ($authorCompany !== ''): ?>
                                                    <p class="author-title"><?= htmlspecialchars($authorCompany) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No professional testimonials added yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ==================== BUSINESS TESTIMONIALS ==================== -->
    <section class="testimonials-section" id="business-testimonials">
        <div class="container">
            <h2 class="testimonials-block-title">Businesses Testimonials</h2>
            <div class="row g-4">
                <?php if (!empty($businesses)): ?>
                    <?php foreach ($businesses as $t): ?>
                        <?php
                        $img = testimonial_photo_src($t['name'] ?? '', $t['photo_url'] ?? '');
                        $rating = (int)($t['rating'] ?? 5);
                        if ($rating < 1) $rating = 1;
                        if ($rating > 5) $rating = 5;
                        ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="testimonial-card">
                                <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($t['name'] ?? 'Testimonial') ?>" class="testimonial-image" loading="lazy" onerror="this.src='review-img/placeholder.svg'">
                                <div class="testimonial-overlay">
                                    <div class="testimonial-content">
                                        <div class="testimonial-rating">
                                            <?php for ($i = 0; $i < $rating; $i++): ?>
                                                <i class="fas fa-star"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <p class="testimonial-text">"<?= htmlspecialchars($t['text'] ?? '') ?>"</p>
                                        <div class="testimonial-author">
                                            <div class="author-row">
                                                <p class="author-name"><?= strtoupper(htmlspecialchars($t['name'] ?? '')) ?></p>
                                                <?php $authorCompany = testimonial_author_company($t); ?>
                                                <?php if ($authorCompany !== ''): ?>
                                                    <p class="author-title"><?= htmlspecialchars($authorCompany) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No business testimonials added yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

<script>
(function() {
    var bar = document.getElementById('testimonialTabsBar');
    var spacer = document.getElementById('testimonialTabsSpacer');
    var header = document.querySelector('.main-header');
    if (!bar || !spacer) return;
    var barOffset = 0;
    function setFixed() {
        if (!barOffset) barOffset = bar.getBoundingClientRect().top + window.pageYOffset;
        if (window.pageYOffset > barOffset - 20) {
            bar.classList.add('is-fixed');
            spacer.classList.add('visible');
            spacer.style.height = bar.offsetHeight + 'px';
            if (header) bar.style.top = header.getBoundingClientRect().bottom + 'px';
        } else {
            bar.classList.remove('is-fixed');
            bar.style.top = '';
            spacer.classList.remove('visible');
            spacer.style.height = '0';
        }
    }
    window.addEventListener('scroll', setFixed, { passive: true });
    window.addEventListener('resize', setFixed);
    setFixed();
    document.querySelectorAll('.testimonial-tab-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var id = this.getAttribute('data-section') || (this.getAttribute('href') || '').slice(1);
            var el = document.getElementById(id);
            if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
})();
</script>

<?php
$mysqli->close();
include 'footer.php';
?>