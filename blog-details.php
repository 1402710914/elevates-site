<?php
include 'header.php';
include 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $mysqli->prepare("SELECT * FROM blogs WHERE id = ? AND status='published'");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
$stmt->close();

if (!$post) {
    echo "<div class='container py-5'><h2>Post not found</h2><p>The requested article does not exist.</p><a href='blog.php'>Back to Blog</a></div>";
    include 'footer.php';
    exit;
}
?>

    <!-- Page Hero (consistent with other pages) -->
    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="page-title"><?= htmlspecialchars($post['title']) ?></h1>
                    <p class="page-subtitle"><?= htmlspecialchars($post['excerpt']) ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Detail Header -->
    <!-- <section class="blog-detail-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="blog.php">Blog</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($post['category']) ?></li>
                        </ol>
                    </nav> -->
                    <!-- <span class="article-category"><?= htmlspecialchars(ucfirst($post['category'])) ?></span>
                    <h1 class="article-title"><?= htmlspecialchars($post['title']) ?></h1>-->
                    <!-- <div class="article-meta"> 
                        <div class="author-info">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="Author" class="author-img">
                            <div>
                                <span class="author-name"><?= htmlspecialchars($post['author']) ?></span>
                                <span class="author-title"><?= htmlspecialchars($post['author_title']) ?></span>
                            </div>
                        </div>
                        <div class="article-stats">
                            <span><i class="far fa-calendar"></i> <?= htmlspecialchars($post['date']) ?></span>
                            <span><i class="far fa-clock"></i> <?= htmlspecialchars($post['minutes']) ?></span>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </section> -->

    <!-- Featured Image -->
    <section class="article-featured-image">
        <div class="container">
            <div class="row justify-content-center">
                 <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <img src="<?= htmlspecialchars($post['image_path']) ?>" alt="Featured Image" class="img-fluid rounded">
                </div>
                 <div class="col-lg-2"></div>
            </div>
        </div>
    </section>

    <!-- Article Content -->
    <section class="article-content py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <!-- Share Buttons Sidebar -->
                    <div class="share-sidebar">
                        <span class="share-label">Share</span>
                        <a href="#" class="share-btn facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="share-btn twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="share-btn linkedin"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="share-btn email"><i class="far fa-envelope"></i></a>
                    </div>

                    <div class="article-body">
                        <?= $post['content'] ?>

                        <!-- Tags removed per request -->

                        <!-- Author Bio -->
                        <!-- <div class="author-bio mt-5">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150" alt="Author" class="author-bio-img">
                            <div class="author-bio-content">
                                <h4><?= htmlspecialchars($post['author']) ?></h4>
                                <p class="author-bio-title"><?= htmlspecialchars($post['author_title']) ?></p>
                                <p>Author bio and credentials are available upon request.</p>
                                <div class="author-social">
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Posts -->
    <section class="related-posts py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title text-center mb-5">Related Articles</h2>
                </div>
            </div>
            <div class="row g-4">
                <?php foreach ($posts as $p): if ($p['id'] === $post['id']) continue; ?>
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['title']) ?>">
                            <span class="blog-category-tag <?= htmlspecialchars($p['category']) ?>"><?= htmlspecialchars(ucfirst($p['category'])) ?></span>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta mb-3">
                                <span><i class="far fa-calendar"></i> <?= htmlspecialchars($p['date']) ?></span>
                                <span><i class="far fa-clock"></i> <?= htmlspecialchars($p['minutes']) ?></span>
                            </div>
                            <h3 class="blog-title"><?= htmlspecialchars($p['title']) ?></h3>
                            <a href="blog-details.php?id=<?= $p['id'] ?>" class="blog-link">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mb-3">Stay Updated</h2>
                    <p class="text-white mb-4">Subscribe to our newsletter and get the latest insights delivered to your inbox.</p>
                    <form class="newsletter-form">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your email address" required>
                            <button class="btn btn-light" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="script.js"></script>

    <!-- Article Scripts -->
    <script>
        // Newsletter form
        document.querySelectorAll('.newsletter-form').forEach(function(form){
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Thank you for subscribing to our newsletter!');
                this.reset();
            });
        });

        // Share buttons
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const platform = this.classList[1];
                alert(`Sharing on ${platform}...`);
            });
        });
    </script>

<?php include 'footer.php'; ?>