<?php include 'header.php'; ?>
<?php include 'db.php'; ?>

    <!-- Blog Hero -->
    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Our Blog</h1>
                    <p class="page-subtitle">Insights, tips, and stories to help you unlock your potential and thrive in work and life.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Categories Filter -->
    <section class="blog-filter py-4 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <button class="btn btn-filter active" data-category="all">All Posts</button>
                        <?php
                        $catRes = $mysqli->query("SELECT * FROM blog_categories ORDER BY name ASC");
                        if ($catRes):
                            while ($cat = $catRes->fetch_assoc()):
                        ?>
                            <button class="btn btn-filter" data-category="<?= htmlspecialchars($cat['slug']) ?>">
                                <?= htmlspecialchars($cat['name']) ?>
                            </button>
                        <?php
                            endwhile;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Blog Grid -->
    <section class="blog-grid py-5">
        <div class="container">
            <div class="row g-4">
                <?php
                $result = $mysqli->query("SELECT * FROM blogs WHERE status='published' ORDER BY created_at DESC");
                while ($post = $result->fetch_assoc()):
                    $catAttr = trim((string)$post['category']);
                ?>
                    <div class="col-lg-4 col-md-6" data-category="<?= htmlspecialchars($catAttr) ?>">
                        <div class="blog-card">
                            <div class="blog-image">
                                <img src="<?= htmlspecialchars($post['image_path']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" style="width: 100%; height: auto;">
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta mb-3">
                                    <span><i class="far fa-calendar"></i> <?= htmlspecialchars(date('d M Y', strtotime($post['created_at']))) ?></span>
                                </div>
                                <h3 class="blog-title"><?= htmlspecialchars($post['title']) ?></h3>
                                <p class="blog-excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
                                <a href="blog-details.php?id=<?= (int)$post['id'] ?>" class="blog-link">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <!-- <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Blog pagination">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div> -->
        </div>
    </section>


      <!-- CTA Section -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4">Ready to Transform Your Career or Business?</h2>
                    <p class="text-white mb-4">Join thousands of professionals and businesses that have elevated their success with our comprehensive coaching and development programs.</p>
                    <a href="contact.php" class="btn btn-light btn-lg px-5">Get Started Today</a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="script.js"></script>

    <!-- Blog Filter Script -->
    <script>
        // Blog category filter (supports multiple categories per post)
        const filterButtons = document.querySelectorAll('.btn-filter');
        const blogCards = document.querySelectorAll('.blog-grid .col-lg-4');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const category = this.getAttribute('data-category');

                blogCards.forEach(card => {
                    const cardCatsRaw = card.getAttribute('data-category') || '';
                    const cardCats = cardCatsRaw.split(',').map(c => c.trim()).filter(Boolean);

                    const show = category === 'all' || cardCats.includes(category);

                    if (show) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 10);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });

        // Newsletter form
        document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for subscribing to our newsletter!');
            this.reset();
        });
    </script>
