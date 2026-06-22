<?php
include 'header.php';
include __DIR__ . '/db.php';

function getProgramContent($mysqli, $slug) {
    $stmt = $mysqli->prepare("SELECT content FROM cms_pages WHERE slug = ? AND status = 'published' LIMIT 1");
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $res['content'] ?? '';
}

$cap_content = getProgramContent($mysqli, 'career-accelerator-program');
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Hero uses shared .page-hero from style.css (same as About Us) */

/* ===== PROGRAM OVERVIEW SECTION ===== */
.program-overview {
    background: #ffffff;
    padding: 120px 0;
}

.program-overview .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.overview-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.overview-image {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
    position: relative;
}

.overview-image::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, #99138a 0%, #99138a 100%);
    opacity: 0.05;
    border-radius: 50%;
}

.overview-image img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.3s ease;
}

.overview-image:hover img {
    transform: scale(1.03);
}

.overview-text h2 {
    color: #99138a;
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 25px;
    line-height: 1.3;
}

.overview-text p {
    color: #4a5568;
    font-size: 1.1rem;
    line-height: 2;
    margin-bottom: 20px;
}

/* ===== WHO SHOULD JOIN SECTION ===== */
.who-should-join {
    background: linear-gradient(180deg, #f8fbff 0%, #e8f4ff 100%);
    padding: 120px 0;
    position: relative;
}

.who-should-join::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 400px;
    height: 400px;
    background: rgba(153, 19, 138, 0.06);
    border-radius: 50%;
}

.who-should-join .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
    position: relative;
    z-index: 1;
}

.section-title {
    font-size: 2.8rem;
    font-weight: 800;
    color: #99138a;
    text-align: center;
    margin-bottom: 80px;
    position: relative;
    padding-bottom: 25px;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 5px;
    background: linear-gradient(90deg, #99138a 0%, #99138a 100%);
    border-radius: 3px;
}

.who-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
}

.who-image {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
}

.who-image img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.3s ease;
}

.who-image:hover img {
    transform: scale(1.03);
}

.who-list {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.who-item {
    background: white;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    display: flex;
    gap: 20px;
    align-items: flex-start;
    border-left: 6px solid #99138a;
}

.who-item:hover {
    transform: translateX(15px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.who-icon {
    width: 55px;
    height: 55px;
    background: linear-gradient(135deg, #99138a 0%, #2d3748 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.6rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(26, 54, 93, 0.2);
}

.who-item:hover .who-icon {
    transform: scale(1.2) rotate(12deg);
    box-shadow: 0 15px 35px rgba(26, 54, 93, 0.3);
}

.who-text p {
    color: #4a5568;
    font-size: 1.05rem;
    line-height: 1.7;
    margin: 0;
    font-weight: 500;
}

/* ===== HOW IT WORKS SECTION ===== */
.how-it-works {
    background: #ffffff;
    padding: 120px 0;
}

.how-it-works .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.how-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.how-steps {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.how-step {
    background: linear-gradient(135deg, #f8fbff 0%, #f0f7ff 100%);
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border-left: 6px solid #99138a;
    display: flex;
    gap: 25px;
    align-items: flex-start;
}

.how-step:hover {
    transform: translateX(10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
}

.how-number {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #99138a 0%, #2d3748 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    font-weight: 800;
    flex-shrink: 0;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(26, 54, 93, 0.2);
}

.how-step:hover .how-number {
    transform: scale(1.15);
    box-shadow: 0 15px 40px rgba(26, 54, 93, 0.3);
}

.how-content h4 {
    color: #99138a;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.how-content p {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.7;
    margin: 0;
}

.how-image {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
    position: relative;
}

.how-image img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.3s ease;
}

.how-image:hover img {
    transform: scale(1.03);
}

/* ===== BENEFITS SECTION ===== */
.benefits-section {
    background: linear-gradient(180deg, #f8fbff 0%, #e8f4ff 100%);
    padding: 120px 0;
    position: relative;
}

.benefits-section::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    width: 400px;
    height: 400px;
    background: rgba(153, 19, 138, 0.06);
    border-radius: 50%;
    transform: translateY(-50%);
}

.benefits-section .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
    position: relative;
    z-index: 1;
}

.benefits-intro {
    text-align: center;
    margin-bottom: 70px;
}

.benefits-intro p {
    color: #4a5568;
    font-size: 1.15rem;
    line-height: 1.9;
    max-width: 750px;
    margin: 0 auto;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 35px;
}

.benefit-card {
    background: white;
    padding: 45px 35px;
    border-radius: 16px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    text-align: center;
    border-top: 5px solid #99138a;
}

.benefit-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.benefit-icon {
    width: 75px;
    height: 75px;
    background: linear-gradient(135deg, #99138a 0%, #2d3748 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    margin: 0 auto 25px;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(26, 54, 93, 0.2);
}

.benefit-card:hover .benefit-icon {
    transform: scale(1.25) rotate(15deg);
    box-shadow: 0 15px 40px rgba(26, 54, 93, 0.3);
}

.benefit-text h4 {
    color: #99138a;
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.benefit-text p {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.7;
    margin: 0;
}

/* CTA uses shared .cta-section from style.css (same as About Us) */

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1024px) {
    .overview-wrapper {
        grid-template-columns: 1fr;
        gap: 50px;
    }

    .who-wrapper {
        grid-template-columns: 1fr;
        gap: 50px;
    }

    .how-wrapper {
        grid-template-columns: 1fr;
        gap: 50px;
    }

    .benefits-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }
}

@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }

    .overview-text h2 {
        font-size: 2rem;
    }

    .program-overview,
    .who-should-join,
    .how-it-works,
    .benefits-section,
    .cta-section {
        padding: 80px 0;
    }

    .who-item,
    .how-step {
        padding: 25px;
    }

    .who-icon {
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
    }

    .how-number {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .benefit-card {
        padding: 30px 20px;
    }

    .benefit-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }

    .benefits-grid {
        grid-template-columns: 1fr;
    }
}

</style>

    <!-- Page Hero (same as About Us) -->
    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="page-title page-title-with-tm">Career Accelerator Program<span class="page-title-tm-circle">TM</span></h1>
                    <p class="page-subtitle">Master interview confidence and land your dream job with expert coaching and proven strategies</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview">
        <div class="container">
            <div class="overview-wrapper">
                <div class="overview-image">
                    <img src="img/career-page.png" alt="Professional interview discussion">
                </div>
                <div class="overview-text">
                    <h2>What's This Program All About?</h2>
                    <p>Career Accelerator Program is designed to help you overcome interview anxiety and perform with confidence, clarity, and impact.</p>
                    <p>Through practical coaching, mock interviews, and structured feedback, you learn how to answer questions effectively, communicate your strengths, and present your story authentically — so you walk into every interview fully prepared and in control.</p>
                    <p><strong>This program focuses on real interview performance, not just theory.</strong></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Who Should Join -->
    <section class="who-should-join">
        <div class="container">
            <h2 class="section-title">Who Should Join This Program?</h2>
            <div class="who-wrapper">
                <div class="who-image">
                    <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600" alt="Career Development">
                </div>
                <div class="who-list">
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="who-text">
                            <p>Recent graduates preparing for their first professional interviews</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-briefcase"></i></div>
                        <div class="who-text">
                            <p>Professionals planning a job change or career upgrade</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-chart-line"></i></div>
                        <div class="who-text">
                            <p>Individuals aiming for promotions or higher-responsibility roles</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="who-text">
                            <p>Anyone who feels nervous, underprepared, or unsure during interviews</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How This Program Works -->
    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title">How Does This Program Work?</h2>
            <div class="how-wrapper">
                <div class="how-steps">
                    <div class="how-step">
                        <div class="how-number">1</div>
                        <div class="how-content">
                            <h4>Live Mock Interviews with Experts</h4>
                            <p>Practice real interview scenarios in a supportive, no-judgment environment with experienced professionals.</p>
                        </div>
                    </div>

                    <div class="how-step">
                        <div class="how-number">2</div>
                        <div class="how-content">
                            <h4>Personalized Performance Feedback</h4>
                            <p>Receive clear insights on strengths, improvement areas, and action steps tailored to your needs.</p>
                        </div>
                    </div>

                    <div class="how-step">
                        <div class="how-number">3</div>
                        <div class="how-content">
                            <h4>Proven Interview Frameworks</h4>
                            <p>Learn structured approaches to handle tough questions and tell your story confidently.</p>
                        </div>
                    </div>

                    <div class="how-step">
                        <div class="how-number">4</div>
                        <div class="how-content">
                            <h4>Resume & LinkedIn Optimization</h4>
                            <p>Build a strong personal brand that attracts recruiters and hiring managers.</p>
                        </div>
                    </div>

                    <div class="how-step">
                        <div class="how-number">5</div>
                        <div class="how-content">
                            <h4>Weekly Accountability Coaching</h4>
                            <p>Ongoing support to ensure consistent improvement and confidence building throughout the program.</p>
                        </div>
                    </div>
                </div>

                <div class="how-image">
                    <img src="programs-img/ace2.png" alt="Interview Preparation">
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join This Program -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="section-title">Why Join the Program?</h2>
            <div class="benefits-intro">
                <p>Transform your interview performance with our comprehensive, proven methodology designed for real, measurable results.</p>
            </div>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-lightbulb"></i></div>
                    <div class="benefit-text">
                        <h4>Replace Interview Fear</h4>
                        <p>Transform anxiety into confidence and clarity in every interview</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-microphone-alt"></i></div>
                    <div class="benefit-text">
                        <h4>Communicate Impact</h4>
                        <p>Articulate your skills and experience with powerful language</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-bolt"></i></div>
                    <div class="benefit-text">
                        <h4>Excel Under Pressure</h4>
                        <p>Master high-pressure interview situations with proven techniques</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-trophy"></i></div>
                    <div class="benefit-text">
                        <h4>Land More Offers</h4>
                        <p>Increase job offers and unlock faster career opportunities</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-star"></i></div>
                    <div class="benefit-text">
                        <h4>Build Strong Brand</h4>
                        <p>Create a professional presence that extends beyond interviews</p>
                    </div>
                </div>
            </div>

            <!-- CMS driven extra content (optional) -->
            <div class="benefits-intro" style="margin-top:40px;">
                <?= $cap_content ?>
            </div>
        </div>
    </section>

    <!-- CTA Section (same as About Us) -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4">Ready to Master Your Next Interview?</h2>
                    <p class="text-white mb-4">Join professionals who are transforming their interview performance and landing their dream jobs. Start your interview mastery journey today with expert guidance and proven strategies.</p>
                    <a href="contact-us.php" class="btn btn-light btn-lg px-5">Get Started Today</a>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>