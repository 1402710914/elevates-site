
<?php
include 'header.php';
include __DIR__ . '/db.php';

function getPageContent($mysqli, $slug) {
    $stmt = $mysqli->prepare("SELECT content FROM cms_pages WHERE slug = ? AND status = 'published' LIMIT 1");
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $res['content'] ?? '';
}

$about_intro = getPageContent($mysqli, 'about-us');
?>

    <!-- About Page Hero -->
    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="page-title">About Elevates</h1>
                    <p class="page-subtitle">Creating and transforming a global community of high-achieving early & mid-career professionals and small-medium businesses.</p>
                </div>
            </div>
        </div>
    </section>

     <!-- About Elevates Content Section -->
    <section class="about-content-section py-5 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- <h2 class="section-title text-center mb-5">About Elevates</h2> -->
                    <div class="about-description">
                        <?= $about_intro ?>
                    </div>
                   
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="mission-section py-5 bg-light">
        <div class="container">
            <div class="row align-items-center g-5 mb-5">
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800" alt="Team collaboration" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title mb-4">Our Mission</h2>
                    <p class="lead">Elevates is on a mission to create & transform a global community of high-achieving early & mid-career professionals and small-medium businesses.</p>
                    <p>We are dedicated to empowering professionals and business owners to reach their full potential through personalized coaching, comprehensive development programs, and innovative solutions tailored to meet the unique challenges of today's dynamic business environment.</p>
                </div>
            </div>
            
            <div class="row align-items-center g-5">
                <div class="col-lg-6 order-lg-2">
                    <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=800" alt="Our Vision" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6 order-lg-1">
                    <h2 class="section-title mb-4">Our Vision</h2>
                    <p class="lead">Our Vision is to foster sustainable growth, success, work-life balance, health, happiness and time freedom for professionals & business owners.</p>
                    <p>We envision a world where every professional and business owner has the tools, support, and guidance needed to achieve not just career success, but holistic well-being and fulfillment in all aspects of life.</p>
                </div>
            </div>
        </div>
    </section>

   

    <!-- What We Offer Section -->
    <section class="services-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="section-title">What We Offer</h2>
                    <p class="lead">Comprehensive solutions for your professional growth</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Value Selling & Client Management</h4>
                        <p>Master the art of selling value and building lasting client relationships that drive business growth.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h4>Personality Growth</h4>
                        <p>Develop your unique personality traits and strengths to stand out in your professional journey.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h4>Communication Skills</h4>
                        <p>Enhance your ability to communicate effectively across all professional contexts and audiences.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h4>Leadership Abilities</h4>
                        <p>Build strong leadership skills to inspire teams and drive organizational success.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4>Mental Well-being</h4>
                        <p>Prioritize your mental health with strategies for stress management, resilience, and balance.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h4>Technical Skills</h4>
                        <p>Stay ahead with cutting-edge technical training and skill development programs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="values-section py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="section-title">Our Core Values</h2>
                    <p class="lead">The principles that guide our work</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h4>Results-Driven</h4>
                        <p>We focus on delivering measurable outcomes that transform careers and businesses.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <h4>Personalized Approach</h4>
                        <p>Every professional and business is unique. Our solutions are tailored to your specific needs.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h4>Holistic Development</h4>
                        <p>We believe in nurturing both professional excellence and personal well-being.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Commitment to Success</h4>
                        <p>Your success is our success. We're with you every step of your transformational journey.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Leadership Team Section -->
    <!-- <section class="team-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="section-title">Leadership Team</h2>
                    <p class="lead">Meet the visionaries driving our mission forward</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400" alt="CEO" class="team-img">
                        <h4>Alexi Robichaux</h4>
                        <p class="team-role">Co-Founder & CEO</p>
                        <div class="team-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=400" alt="CTO" class="team-img">
                        <h4>Eduardo Medina</h4>
                        <p class="team-role">Co-Founder & CTO</p>
                        <div class="team-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400" alt="COO" class="team-img">
                        <h4>Sarah Johnson</h4>
                        <p class="team-role">Chief Operating Officer</p>
                        <div class="team-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Stats Section -->
    <section class="stats-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center mb-4">
                <div class="col-lg-8">
                    <h2 class="section-title text-light">Our Impact</h2>
                </div>
            </div>
            <div class="row text-center g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="stat-card">
                        <h3 class="stat-number js-stat-counter" data-target="1500" data-suffix="+">0+</h3>
                        <p class="stat-label">Professionals Coached</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="stat-card">
                        <h3 class="stat-number js-stat-counter" data-target="50" data-suffix="+">0+</h3>
                        <p class="stat-label">Businesses Transformed</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="stat-card">
                        <h3 class="stat-number js-stat-counter" data-target="99" data-suffix="%">0%</h3>
                        <p class="stat-label">Client Satisfaction Rate</p>
                    </div>
                </div>
                <!-- <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <h3 class="stat-number">25+</h3>
                        <p class="stat-label">Countries Reached</p>
                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-section py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="section-title">Why Choose Elevates?</h2>
                    <p class="lead">We're different because we care about your complete success</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="feature-box">
                        <i class="fas fa-check-circle text-primary fa-2x mb-3"></i>
                        <h4>Comprehensive Development</h4>
                        <p>From technical skills to mental well-being, we cover all aspects of professional growth to ensure you're prepared for any challenge.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-box">
                        <i class="fas fa-check-circle text-primary fa-2x mb-3"></i>
                        <h4>Work-Life Balance Focus</h4>
                        <p>We don't just focus on career success. We help you achieve happiness, health, and time freedom alongside your professional goals.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-box">
                        <i class="fas fa-check-circle text-primary fa-2x mb-3"></i>
                        <h4>Proven Results</h4>
                        <p>Our results-driven approach has helped thousands of professionals and businesses achieve sustainable growth and success.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-box">
                        <i class="fas fa-check-circle text-primary fa-2x mb-3"></i>
                        <h4>Expert Guidance</h4>
                        <p>Learn from experienced coaches and industry experts who understand the challenges you face and know how to overcome them.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4">Ready to Transform Your Career or Business?</h2>
                    <p class="text-white mb-4">Join thousands of professionals and businesses that have elevated their success with our comprehensive coaching and development programs.</p>
                    <a href="contact-us.php" class="btn btn-light btn-lg px-5">Get Started Today</a>
                </div>
            </div>
        </div>
    </section>

<script>
(function () {
    var counters = document.querySelectorAll('.js-stat-counter');
    if (!counters.length) return;

    function animateCounter(el) {
        var target = parseInt(el.getAttribute('data-target') || '0', 10);
        var suffix = el.getAttribute('data-suffix') || '';
        var duration = 1400;
        var start = 0;
        var startTime = null;

        function update(ts) {
            if (!startTime) startTime = ts;
            var progress = Math.min((ts - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var value = Math.floor(start + (target - start) * eased);
            el.textContent = value + suffix;
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                el.textContent = target + suffix;
            }
        }

        requestAnimationFrame(update);
    }

    var observer = new IntersectionObserver(function (entries, obs) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.35 });

    counters.forEach(function (counter) {
        observer.observe(counter);
    });
})();
</script>

<?php include 'footer.php'; ?>