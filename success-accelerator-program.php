<?php include 'header.php'; ?>

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
    padding: 100px 0;
}

.program-overview .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.overview-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.overview-text h2 {
    color: #99138a;
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 25px;
    line-height: 1.3;
}

.overview-text p {
    color: #4a5568;
    font-size: 1.05rem;
    line-height: 1.9;
    margin-bottom: 20px;
}

.overview-image {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.overview-image img {
    width: 100%;
    height: auto;
    display: block;
}

/* ===== WHO SHOULD JOIN SECTION ===== */
.who-should-join {
    background: linear-gradient(180deg, #f8fbff 0%, #f0f7ff 100%);
    padding: 100px 0;
}

.who-should-join .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #99138a;
    text-align: center;
    margin-bottom: 70px;
    position: relative;
    padding-bottom: 20px;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #99138a 0%, #99138a 100%);
    border-radius: 2px;
}

.criteria-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

.criteria-card {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border-top: 5px solid #99138a;
}

.criteria-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.criteria-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #99138a 0%, #7a0d6e 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.criteria-card:hover .criteria-icon {
    transform: scale(1.15) rotate(10deg);
}

.criteria-card h4 {
    color: #99138a;
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 12px;
}

.criteria-card p {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.7;
}

/* ===== HOW IT WORKS SECTION ===== */
.how-it-works {
    background: #ffffff;
    padding: 100px 0;
}

.how-it-works .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.how-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.steps-container {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.step-item {
    display: flex;
    gap: 30px;
    align-items: flex-start;
}

.step-circle {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #99138a 0%, #7a0d6e 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: 700;
    flex-shrink: 0;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(26, 54, 93, 0.2);
}

.step-item:hover .step-circle {
    transform: scale(1.15);
    background: linear-gradient(135deg, #7a0d6e 0%, #99138a 100%);
    box-shadow: 0 15px 40px rgba(26, 54, 93, 0.3);
}

.step-content {
    flex: 1;
}

.step-content h4 {
    color: #99138a;
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 12px;
}

.step-content p {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.7;
    margin: 0;
}

.how-image {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.how-image img {
    width: 100%;
    height: auto;
    display: block;
    transition: all 0.3s ease;
}

.how-image:hover img {
    transform: scale(1.05);
}

/* ===== BENEFITS SECTION ===== */
.benefits-section {
    background: linear-gradient(180deg, #f8fbff 0%, #f0f7ff 100%);
    padding: 100px 0;
}

.benefits-section .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.benefits-intro {
    text-align: center;
    margin-bottom: 60px;
}

.benefits-intro p {
    color: #4a5568;
    font-size: 1.1rem;
    line-height: 1.8;
    max-width: 700px;
    margin: 0 auto;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

.benefit-card {
    background: white;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    display: flex;
    gap: 20px;
}

.benefit-card:hover {
    transform: translateX(10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
}

.benefit-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #99138a 0%, #7a0d6e 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.6rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.benefit-card:hover .benefit-icon {
    transform: scale(1.2) rotate(10deg);
}

.benefit-text h4 {
    color: #99138a;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.benefit-text p {
    color: #4a5568;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0;
}

/* ===== CTA SECTION ===== */
.cta-section {
    background: linear-gradient(135deg, #1a1a2e 0%, #99138a 100%);
    padding: 100px 0;
    color: white;
    text-align: center;
}

.cta-section .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.cta-content h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 20px;
}

.cta-content p {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.8;
}

.btn-cta {
    background-color: white;
    color: #99138a;
    border: none;
    font-weight: 700;
    padding: 18px 50px;
    font-size: 1.05rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    display: inline-block;
}

.btn-cta:hover {
    background-color: #f0f7ff;
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1024px) {
    .overview-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .criteria-grid {
        grid-template-columns: 1fr;
    }

    .how-content {
        grid-template-columns: 1fr;
        gap: 50px;
    }

    .benefits-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }

    .cta-content h2 {
        font-size: 1.8rem;
    }

    .program-overview,
    .who-should-join,
    .how-it-works,
    .benefits-section,
    .cta-section {
        padding: 60px 0;
    }

    .criteria-card {
        padding: 25px;
    }

    .step-item {
        gap: 20px;
    }

    .step-circle {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }

    .benefit-card {
        padding: 20px;
        flex-direction: column;
        text-align: center;
    }

    .benefit-icon {
        margin: 0 auto;
    }
}

</style>

    <!-- Page Hero (same as About Us) -->
    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="page-title page-title-with-tm">Success Accelerator Program<span class="page-title-tm-circle">TM</span></h1>
                    <p class="page-subtitle">Fast-track your career with practical, job-ready skills that deliver real results</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview">
        <div class="container">
            <div class="overview-content">
                <div class="overview-text">
                    <h2>What's This Program All About?</h2>
                    <p>The Success Accelerator Program equips you with practical, job-ready skills to secure better opportunities, grow faster, and confidently achieve your professional goals.</p>
                    <p>Whether you're seeking a promotion, planning a career transition, or looking to enhance your professional presence, this program delivers actionable strategies and expert guidance to accelerate your success.</p>
                </div>
                <div class="overview-image">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600" alt="Career Acceleration">
                </div>
            </div>
        </div>
    </section>

    <!-- Who Should Join -->
    <section class="who-should-join">
        <div class="container">
            <h2 class="section-title">Who Should Join?</h2>
            <div class="criteria-grid">
                <div class="criteria-card">
                    <div class="criteria-icon"><i class="fas fa-user-tie"></i></div>
                    <div>
                        <h4>Ambitious Professionals</h4>
                        <p>Seeking faster growth and better career opportunities</p>
                    </div>
                </div>
                <div class="criteria-card">
                    <div class="criteria-icon"><i class="fas fa-arrow-right-arrow-left"></i></div>
                    <div>
                        <h4>Career Changers</h4>
                        <p>Planning transitions or role upgrades</p>
                    </div>
                </div>
                <div class="criteria-card">
                    <div class="criteria-icon"><i class="fas fa-handshake"></i></div>
                    <div>
                        <h4>Client-Facing Professionals</h4>
                        <p>Aiming to improve performance and impact</p>
                    </div>
                </div>
                <div class="criteria-card">
                    <div class="criteria-icon"><i class="fas fa-comments"></i></div>
                    <div>
                        <h4>Communication Builders</h4>
                        <p>Boosting skills and personal branding</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How This Program Works -->
    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title">How Does This Program Work?</h2>
            <div class="how-content">
                <div class="steps-container">
                    <div class="step-item">
                        <div class="step-circle">1</div>
                        <div class="step-content">
                            <h4>Career Assessment & Goal Clarity</h4>
                            <p>Understand your current strengths, gaps, and career direction to create a personalized roadmap for success.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-circle">2</div>
                        <div class="step-content">
                            <h4>Skill Development Plan</h4>
                            <p>Learn the exact skills needed to bridge the gap between where you are and where you want to be.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-circle">3</div>
                        <div class="step-content">
                            <h4>Interactive Learning & Practical Application</h4>
                            <p>Engage in hands-on sessions focused on real workplace scenarios and challenges you'll face.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-circle">4</div>
                        <div class="step-content">
                            <h4>Expert Coaching & Feedback</h4>
                            <p>Receive continuous guidance to improve performance, build confidence, and master new capabilities.</p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-circle">5</div>
                        <div class="step-content">
                            <h4>Weekly Accountability Support</h4>
                            <p>Stay on track with regular check-ins that ensure progress remains consistent and measurable.</p>
                        </div>
                    </div>
                </div>

                <div class="how-image">
                    <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=500" alt="Program Process">
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join This Program -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="section-title">Why Join This Program?</h2>
            <div class="benefits-intro">
                <p>Achieve tangible career results with our proven methodology designed to transform your professional trajectory and deliver lasting impact.</p>
            </div>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-rocket"></i></div>
                    <div class="benefit-text">
                        <h4>Accelerate Growth</h4>
                        <p>Break through career plateaus and grow faster than ever before</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-microphone-alt"></i></div>
                    <div class="benefit-text">
                        <h4>Build Confidence</h4>
                        <p>Improve communication, confidence, and leadership presence</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-crown"></i></div>
                    <div class="benefit-text">
                        <h4>Achieve Success</h4>
                        <p>Secure promotions, role upgrades, or successful transitions</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-star"></i></div>
                    <div class="benefit-text">
                        <h4>Excel in Interviews</h4>
                        <p>Perform better in interviews and workplace situations</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-compass"></i></div>
                    <div class="benefit-text">
                        <h4>Find Clarity</h4>
                        <p>Build long-term career clarity and sustainable momentum</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-trophy"></i></div>
                    <div class="benefit-text">
                        <h4>Proven Results</h4>
                        <p>Leverage our proven methodology with measurable outcomes</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Transform Your Career?</h2>
                <p>Join professionals who are accelerating their growth and achieving their career goals. Start your success journey today.</p>
                <a href="contact-us.php" class="btn-cta">Get Started Today</a>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>