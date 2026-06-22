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
    gap: 60px;
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
    position: relative;
}

.how-it-works::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 400px;
    height: 400px;
    background: rgba(153, 19, 138, 0.06);
    border-radius: 50%;
}

.how-it-works .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
    position: relative;
    z-index: 1;
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

.how-step-item {
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

.how-step-item:hover {
    transform: translateX(10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
}

.how-step-number {
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

.how-step-item:hover .how-step-number {
    transform: scale(1.15);
    box-shadow: 0 15px 40px rgba(26, 54, 93, 0.3);
}

.how-step-content h4 {
    color: #99138a;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.how-step-content p {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.7;
    margin: 0;
}

.how-image {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
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
    right: 0;
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
    grid-template-columns: repeat(2, 1fr);
    gap: 35px;
}

.benefit-card {
    background: white;
    padding: 45px;
    border-radius: 16px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border-top: 6px solid #99138a;
    display: flex;
    gap: 25px;
}

.benefit-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.benefit-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #99138a 0%, #2d3748 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(26, 54, 93, 0.2);
}

.benefit-card:hover .benefit-icon {
    transform: scale(1.25) rotate(15deg);
    box-shadow: 0 15px 40px rgba(26, 54, 93, 0.3);
}

.benefit-text h4 {
    color: #99138a;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 10px;
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
        grid-template-columns: 1fr;
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

    .who-item {
        padding: 25px;
    }

    .who-icon {
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
    }

    .how-step-item {
        padding: 25px;
    }

    .how-step-number {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .benefit-card {
        padding: 30px;
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
                    <h1 class="page-title page-title-with-tm">Corporate Success Program<span class="page-title-tm-circle">TM</span></h1>
                    <p class="page-subtitle">Master Workplace Skills and Launch Your Career with Confidence</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview">
        <div class="container">
            <div class="overview-wrapper">
                <div class="overview-image">
                    <img src="programs-img/corporate.png" alt="Corporate Success">
                </div>
                <div class="overview-text">
                    <h2>What's This Program All About?</h2>
                    <p>The Corporate Success Program is designed to help fresh graduates and early-career professionals transition smoothly into the corporate world with confidence and workplace-ready skills.</p>
                    <p>Through practical training, real-world scenarios, and structured guidance, you'll develop the communication, professionalism, and problem-solving abilities needed to perform effectively from your very first role.</p>
                    <p><strong>This program prepares you for real work — not just classroom learning.</strong></p>
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
                    <img src="programs-img/corporate3.png" alt="Fresh Professionals">
                </div>
                <div class="who-list">
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="who-text">
                            <p>Fresh graduates entering the professional workforce for the first time</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-chart-line"></i></div>
                        <div class="who-text">
                            <p>Early-career professionals seeking stronger workplace performance</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-lightbulb"></i></div>
                        <div class="who-text">
                            <p>Individuals struggling to adapt to corporate expectations and culture</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-handshake"></i></div>
                        <div class="who-text">
                            <p>Anyone wanting a confident and successful career start</p>
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
                    <div class="how-step-item">
                        <div class="how-step-number">1</div>
                        <div class="how-step-content">
                            <h4>Skill & Readiness Assessment</h4>
                            <p>Understand your current strengths and identify specific development areas for growth.</p>
                        </div>
                    </div>

                    <div class="how-step-item">
                        <div class="how-step-number">2</div>
                        <div class="how-step-content">
                            <h4>Core Workplace Skill Training</h4>
                            <p>Develop communication, teamwork, professionalism, problem-solving, and time management skills.</p>
                        </div>
                    </div>

                    <div class="how-step-item">
                        <div class="how-step-number">3</div>
                        <div class="how-step-content">
                            <h4>Practical Application & Feedback</h4>
                            <p>Apply learning through real-life workplace scenarios and receive continuous improvement feedback.</p>
                        </div>
                    </div>

                    <div class="how-step-item">
                        <div class="how-step-number">4</div>
                        <div class="how-step-content">
                            <h4>Weekly Accountability Coaching</h4>
                            <p>Ongoing support to maintain progress, build confidence, and achieve consistent success.</p>
                        </div>
                    </div>
                </div>

                <div class="how-image">
                    <img src="programs-img/corporate2.png" alt="Workplace Training">
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join This Program -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="section-title">Why Join the Corporate Success Program?</h2>
            <div class="benefits-intro">
                <p>Get the competitive edge you need to thrive in your corporate career with proven workplace skills and professional development.</p>
            </div>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="benefit-text">
                        <h4>Start with Confidence</h4>
                        <p>Begin your career with clarity, confidence, and the skills employers truly value</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-brain"></i></div>
                    <div class="benefit-text">
                        <h4>Learn Essential Skills</h4>
                        <p>Master workplace communication, professionalism, and problem-solving abilities</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                    <div class="benefit-text">
                        <h4>Avoid Costly Mistakes</h4>
                        <p>Learn from expert guidance and avoid common early-career pitfalls and missteps</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-handshake"></i></div>
                    <div class="benefit-text">
                        <h4>Build Strong Relationships</h4>
                        <p>Develop professional relationships and network effectively within your organization</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-star"></i></div>
                    <div class="benefit-text">
                        <h4>Stand Out Immediately</h4>
                        <p>Emerge as a high-performing team member from day one of your role</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section (same as About Us) -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4">Ready to Launch Your Corporate Career?</h2>
                    <p class="text-white mb-4">Start your professional journey with confidence, skills, and expert guidance. Join freshers and early-career professionals who are building successful, fulfilling corporate careers. Get the foundation you need to excel.</p>
                    <a href="contact-us.php" class="btn btn-light btn-lg px-5">Get Started Today</a>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>