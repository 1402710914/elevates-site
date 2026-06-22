<?php include 'header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Hero uses shared .page-hero from style.css (same as About Us); badge kept for coming-soon */
.coming-soon-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 700;
    margin-bottom: 20px;
    font-size: 1rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

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
    background: linear-gradient(135deg, #99138a 0%, #7a0d6e 100%);
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

.how-it-works::after {
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
    background: linear-gradient(135deg, #99138a 0%, #7a0d6e 100%);
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

/* ===== BENEFITS SECTION ===== */
.benefits-section {
    background: linear-gradient(180deg, #f8fbff 0%, #e8f4ff 100%);
    padding: 120px 0;
    position: relative;
}

.benefits-section::before {
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
    border-top: 6px solid #99138a;
}

.benefit-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.benefit-icon {
    width: 75px;
    height: 75px;
    background: linear-gradient(135deg, #99138a 0%, #7a0d6e 100%);
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

/* ===== TECH TRACKS PREVIEW ===== */
.tech-tracks {
    background: #ffffff;
    padding: 120px 0;
    position: relative;
}

.tech-tracks::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 400px;
    height: 400px;
    background: rgba(153, 19, 138, 0.06);
    border-radius: 50%;
}

.tech-tracks .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
    position: relative;
    z-index: 1;
}

.tracks-intro {
    text-align: center;
    margin-bottom: 70px;
}

.tracks-intro h3 {
    color: #99138a;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 20px;
}

.tracks-intro p {
    color: #4a5568;
    font-size: 1.1rem;
    max-width: 700px;
    margin: 0 auto;
}

.tracks-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.track-card {
    background: linear-gradient(135deg, #f8fbff 0%, #f0f7ff 100%);
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    text-align: center;
    border-top: 6px solid #99138a;
}

.track-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.track-icon {
    width: 65px;
    height: 65px;
    background: linear-gradient(135deg, #99138a 0%, #7a0d6e 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    margin: 0 auto 20px;
    transition: all 0.3s ease;
}

.track-card:hover .track-icon {
    transform: scale(1.2) rotate(15deg);
}

.track-card h4 {
    color: #99138a;
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.track-card p {
    color: #4a5568;
    font-size: 0.95rem;
    line-height: 1.7;
    margin: 0;
}

/* ===== RECORDED COURSES SECTION ===== */
.recorded-courses {
    background: linear-gradient(180deg, #f8fbff 0%, #e8f4ff 100%);
    padding: 120px 0;
    position: relative;
}

.recorded-courses::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: 0;
    width: 350px;
    height: 350px;
    background: rgba(153, 19, 138, 0.05);
    border-radius: 50%;
    pointer-events: none;
}

.recorded-courses .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
    position: relative;
    z-index: 1;
}

.recorded-courses .section-subtitle {
    text-align: center;
    color: #4a5568;
    font-size: 1.1rem;
    max-width: 700px;
    margin: -50px auto 70px;
    line-height: 1.8;
}

.courses-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 35px;
}

.course-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    transition: all 0.35s ease;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(153, 19, 138, 0.08);
}

.course-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 28px 65px rgba(153, 19, 138, 0.18);
}

/* Thumbnail */
.course-thumb {
    position: relative;
    overflow: hidden;
    height: 275px;
}

.course-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.course-card:hover .course-thumb img {
    transform: scale(1.07);
}

.course-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    padding: 5px 14px;
    border-radius: 30px;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.course-badge.free {
    background: #22c55e;
    color: #fff;
}

.course-badge.paid {
    background: #99138a;
    color: #fff;
}

.course-play-btn {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(153, 19, 138, 0.55);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.course-card:hover .course-play-btn {
    opacity: 1;
}

.course-play-btn i {
    color: #fff;
    font-size: 3rem;
    filter: drop-shadow(0 2px 6px rgba(0,0,0,0.4));
}

/* Body */
.course-body {
    padding: 28px 28px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.course-category {
    font-size: 0.78rem;
    font-weight: 700;
    color: #99138a;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 10px;
}

.course-title {
    color: #1a202c;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 12px;
    line-height: 1.45;
}

.course-desc {
    color: #718096;
    font-size: 0.92rem;
    line-height: 1.65;
    margin-bottom: 18px;
    flex: 1;
}

/* Meta row */
.course-meta {
    display: flex;
    align-items: center;
    gap: 18px;
    font-size: 0.85rem;
    color: #718096;
    padding-bottom: 18px;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom: 18px;
    flex-wrap: wrap;
}

.course-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
}

.course-meta i {
    color: #99138a;
    font-size: 0.9rem;
}

/* Footer */
.course-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 28px 24px;
}

.course-price {
    font-size: 1.3rem;
    font-weight: 800;
    color: #99138a;
}

.course-price.free-label {
    color: #22c55e;
}

.btn-enroll {
    background: linear-gradient(135deg, #99138a 0%, #7a0d6e 100%);
    color: #fff;
    border: none;
    padding: 10px 22px;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(153, 19, 138, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 7px;
}

.btn-enroll:hover {
    background: linear-gradient(135deg, #7a0d6e 0%, #5c0a54 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(153, 19, 138, 0.4);
    text-decoration: none;
}

/* View All button */
.courses-view-all {
    text-align: center;
    margin-top: 60px;
}

.btn-view-all {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: transparent;
    border: 2px solid #99138a;
    color: #99138a;
    padding: 14px 40px;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-view-all:hover {
    background: #99138a;
    color: #fff;
    text-decoration: none;
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(153, 19, 138, 0.3);
}

/* CTA uses shared .cta-section from style.css (same as About Us) */

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1024px) {
    .overview-wrapper,
    .who-wrapper,
    .how-wrapper {
        grid-template-columns: 1fr;
        gap: 50px;
    }

    .benefits-grid,
    .tracks-grid,
    .courses-grid {
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
    .tech-tracks,
    .recorded-courses,
    .cta-section {
        padding: 80px 0;
    }

    .who-item { padding: 25px; }
    .who-icon { width: 45px; height: 45px; font-size: 1.3rem; }
    .how-step-item { padding: 25px; }
    .how-step-number { width: 50px; height: 50px; font-size: 1.5rem; }
    .benefit-card { padding: 30px 20px; }
    .benefit-icon { width: 60px; height: 60px; font-size: 1.5rem; }

    .benefits-grid,
    .tracks-grid,
    .courses-grid {
        grid-template-columns: 1fr;
    }

    .btn-notify {
        display: block;
        margin: 15px auto 0;
    }

    .course-footer {
        flex-direction: column;
        gap: 14px;
        align-items: flex-start;
    }

    .btn-enroll {
        width: 100%;
        justify-content: center;
    }
}
</style>

    <!-- Page Hero (same as About Us) -->
    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    
                    <h1 class="page-title ">Master Technology at Your Pace</h1>
                    <p class="page-subtitle">Build In-Demand Technical Skills Through Flexible, Hands-On Learning</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview">
        <div class="container">
            <div class="overview-wrapper">
                <div class="overview-image">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600" alt="Technology Learning">
                </div>
                <div class="overview-text">
                    <h2>What's This Program All About?</h2>
                    <p>The Master Technology at Your Pace Program is designed to help students and professionals build in-demand technical skills through flexible, hands-on learning.</p>
                    <p>From cloud computing and cybersecurity to artificial intelligence and emerging technologies, you can choose your learning path and progress at a speed that fits your schedule — without compromising on practical experience or expert support.</p>
                    <p><strong>This program makes advanced technology learning accessible, structured, and career-focused.</strong></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Who Should Join -->
    <section class="who-should-join">
        <div class="container">
            <h2 class="section-title">Who Is This Program For?</h2>
            <div class="who-wrapper">
                <div class="who-image">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600" alt="Tech Learners">
                </div>
                <div class="who-list">
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="who-text">
                            <p>Students preparing for future technology careers in a digital world</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-code"></i></div>
                        <div class="who-text">
                            <p>Professionals looking to upskill or transition into tech roles</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-hourglass-half"></i></div>
                        <div class="who-text">
                            <p>Individuals wanting flexible, self-paced learning options that fit their lifestyle</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-rocket"></i></div>
                        <div class="who-text">
                            <p>Anyone aiming to stay competitive in a rapidly changing job market</p>
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
                <div class="how-image">
                    <img src="https://images.unsplash.com/photo-1501504905252-473c47e087f8?w=600" alt="Learning Path">
                </div>
                <div class="how-steps">
                    <div class="how-step-item">
                        <div class="how-step-number">1</div>
                        <div class="how-step-content">
                            <h4>Choose Your Learning Track</h4>
                            <p>Select from curated technology courses based on your career goals and interests.</p>
                        </div>
                    </div>

                    <div class="how-step-item">
                        <div class="how-step-number">2</div>
                        <div class="how-step-content">
                            <h4>Flexible, Self-Paced Learning</h4>
                            <p>Access bite-sized lessons that fit easily into your schedule without restrictions.</p>
                        </div>
                    </div>

                    <div class="how-step-item">
                        <div class="how-step-number">3</div>
                        <div class="how-step-content">
                            <h4>Hands-On Projects & Real-World Practice</h4>
                            <p>Build practical skills through guided projects and challenges with real applications.</p>
                        </div>
                    </div>

                    <div class="how-step-item">
                        <div class="how-step-number">4</div>
                        <div class="how-step-content">
                            <h4>Expert Coaching & Progress Tracking</h4>
                            <p>Learn from industry professionals with automated progress monitoring and feedback.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join This Program -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="section-title">Why Join the Program?</h2>
            <div class="benefits-intro">
                <p>Unlock your potential with flexible technology learning that adapts to your pace and empowers your career.</p>
            </div>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-star"></i></div>
                    <div class="benefit-text">
                        <h4>In-Demand Skills</h4>
                        <p>Gain technology skills that employers actively value and seek</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-clock"></i></div>
                    <div class="benefit-text">
                        <h4>Learn Flexibly</h4>
                        <p>Progress at your own pace without disrupting work or studies</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-project-diagram"></i></div>
                    <div class="benefit-text">
                        <h4>Real-World Experience</h4>
                        <p>Build practical skills through guided projects and real challenges</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-chart-line"></i></div>
                    <div class="benefit-text">
                        <h4>Career Growth</h4>
                        <p>Increase career opportunities and earning potential significantly</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-certificate"></i></div>
                    <div class="benefit-text">
                        <h4>Industry Certifications</h4>
                        <p>Earn globally recognized industry certifications that boost credibility</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Tracks Preview -->
    <section class="tech-tracks">
        <div class="container">
            <div class="tracks-intro">
                <h3>Explore Our Learning Tracks</h3>
                <p>Choose from diverse technology domains tailored to your career aspirations and skill level</p>
            </div>
            <div class="tracks-grid">
                <div class="track-card">
                    <div class="track-icon"><i class="fas fa-cloud"></i></div>
                    <h4>Cloud Computing</h4>
                    <p>Master AWS, Azure, and modern cloud infrastructure</p>
                </div>
                <div class="track-card">
                    <div class="track-icon"><i class="fas fa-shield-alt"></i></div>
                    <h4>Cybersecurity</h4>
                    <p>Protect systems and networks against evolving threats</p>
                </div>
                <div class="track-card">
                    <div class="track-icon"><i class="fas fa-brain"></i></div>
                    <h4>AI & Machine Learning</h4>
                    <p>Build intelligent systems and leverage data science</p>
                </div>
                <div class="track-card">
                    <div class="track-icon"><i class="fas fa-code"></i></div>
                    <h4>Full Stack Development</h4>
                    <p>Build complete web and mobile applications</p>
                </div>
                <div class="track-card">
                    <div class="track-icon"><i class="fas fa-database"></i></div>
                    <h4>Data Engineering</h4>
                    <p>Design and manage scalable data systems</p>
                </div>
                <div class="track-card">
                    <div class="track-icon"><i class="fas fa-cubes"></i></div>
                    <h4>Emerging Tech</h4>
                    <p>Explore blockchain, IoT, and cutting-edge technologies</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== RECORDED COURSES SECTION ===== -->
    <section class="recorded-courses">
        <div class="container">
            <h2 class="section-title">Recorded Courses</h2>
            <p class="section-subtitle">Anytime, anywhere — watch expert-led video courses at your own pace and start building skills from day one.</p>

            <div class="courses-grid">

                <!-- Course 1 -->
                <div class="course-card">
                    <div class="course-thumb">
                        <img src="img/3.jpeg" alt="AWS Cloud Fundamentals">
                       
                    </div>
                    <div class="course-body">
                       
                        <h3 class="course-title">Interview Success Masterclass</h3>
                        <p class="course-desc">Have you ever felt that you were qualified… but still didn’t get selected?</p>
                       
                    </div>
                    <div class="course-footer">
                        
                        <a href="https://exlycrm.elevates.pro/checkout/65a1e579-8aa1-4651-b263-e0cc498f7e92" class="btn-enroll"><i class="fas fa-play"></i> Enroll Now</a>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="course-card">
                    <div class="course-thumb">
                        <img src="img/1.jpeg" alt="Cybersecurity Essentials">
                     
                    </div>
                    <div class="course-body">
                        
                        <h3 class="course-title">Masterclass:Communicate with Confidence</h3>
                        <p class="course-desc">Have you ever had the right ideas… but couldn’t express them properly?</p>
                       
                    </div>
                    <div class="course-footer">
                      
                        <a href="https://exlycrm.elevates.pro/checkout/65a1e579-8aa1-4651-b263-e0cc498f7e92" class="btn-enroll"><i class="fas fa-play"></i> Enroll Now</a>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="course-card">
                    <div class="course-thumb">
                        <img src="img/2.jpeg" alt="AI & Machine Learning">
                      
                        
                    </div>
                    <div class="course-body">
                       
                        <h3 class="course-title">Microsoft Cloud Azure Administrator Masterclass</h3>
                        <p class="course-desc">“Do you want to build a high-paying IT career… even if you’re not from a hardcore coding background?</p>
                       
                    </div>
                    <div class="course-footer">
                      
                        <a href="https://exlycrm.elevates.pro/checkout/f7050a4f-03e1-4e2a-8d26-a65c579b3a18" class="btn-enroll"><i class="fas fa-play"></i> Enroll Now</a>
                    </div>
                </div>

               

            </div><!-- /.courses-grid -->

            <!-- <div class="courses-view-all">
                <a href="contact-us.php" class="btn-view-all">
                    View All Courses <i class="fas fa-arrow-right"></i>
                </a>
            </div> -->

        </div>
    </section>
    <!-- ===== END RECORDED COURSES SECTION ===== -->

    <!-- CTA Section (same as About Us) -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4">Get Ready to Master Technology!</h2>
                    <p class="text-white mb-4">Be among the first to experience flexible, hands-on technology learning designed for your pace. Build in-demand skills, gain real-world experience, and accelerate your tech career. Join the future of learning.</p>
                    <a href="contact-us.php" class="btn btn-light btn-lg px-5 me-3">Express Interest</a>
                    <a href="#" class="btn btn-outline-light btn-lg px-4"><i class="fas fa-bell me-2"></i>Notify Me When Live</a>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>