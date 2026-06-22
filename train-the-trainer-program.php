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
    left: 0;
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
    right: 0;
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
                    <h1 class="page-title ">Train The Trainer Program</h1>
                    <p class="page-subtitle">Become a Confident, Impactful Facilitator and Mentor</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview">
        <div class="container">
            <div class="overview-wrapper">
                <div class="overview-image">
                    <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=600" alt="Training Facilitation">
                </div>
                <div class="overview-text">
                    <h2>What's This Program All About?</h2>
                    <p>The Train The Trainer Program is designed to help professionals become confident, impactful facilitators and mentors.</p>
                    <p>Through practical teaching techniques, live coaching, and hands-on practice, you'll learn how to deliver engaging sessions, communicate concepts clearly, and inspire meaningful learning experiences.</p>
                    <p><strong>This program focuses on real training performance — not just theory.</strong></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Who Should Join -->
    <section class="who-should-join">
        <div class="container">
            <h2 class="section-title">Who Should Join This Program?</h2>
            <div class="who-wrapper">
                <div class="who-list">
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-briefcase"></i></div>
                        <div class="who-text">
                            <p>Subject matter experts transitioning into training or mentoring roles</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-people-arrows"></i></div>
                        <div class="who-text">
                            <p>Managers and team leaders responsible for coaching teams</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-chalkboard-user"></i></div>
                        <div class="who-text">
                            <p>Corporate trainers, educators, and facilitators seeking to enhance skills</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-heart"></i></div>
                        <div class="who-text">
                            <p>Anyone passionate about teaching and knowledge sharing</p>
                        </div>
                    </div>
                </div>
                <div class="who-image">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600" alt="Training Professionals">
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
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600" alt="Training Methods">
                </div>
                <div class="how-steps">
                    <div class="how-step-item">
                        <div class="how-step-number">1</div>
                        <div class="how-step-content">
                            <h4>Core Training & Facilitation Techniques</h4>
                            <p>Learn proven methods to structure sessions, engage audiences, and deliver impactful learning experiences.</p>
                        </div>
                    </div>

                    <div class="how-step-item">
                        <div class="how-step-number">2</div>
                        <div class="how-step-content">
                            <h4>Hands-On Practice & Real-Time Feedback</h4>
                            <p>Practice live sessions and receive expert guidance to refine your training style and presentation skills.</p>
                        </div>
                    </div>

                    <div class="how-step-item">
                        <div class="how-step-number">3</div>
                        <div class="how-step-content">
                            <h4>Advanced Coaching from Experienced Facilitators</h4>
                            <p>Learn from professionals who have delivered successful training programs across multiple industries.</p>
                        </div>
                    </div>

                    <div class="how-step-item">
                        <div class="how-step-number">4</div>
                        <div class="how-step-content">
                            <h4>Weekly Accountability & Skill Development</h4>
                            <p>Consistent coaching to ensure continuous improvement and confidence building throughout your journey.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join This Program -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="section-title">Why Join the Train The Trainer Program?</h2>
            <div class="benefits-intro">
                <p>Transform into a highly effective trainer and mentor with proven strategies, expert guidance, and hands-on practice.</p>
            </div>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-star"></i></div>
                    <div class="benefit-text">
                        <h4>Deliver Engaging Sessions</h4>
                        <p>Create high-impact training sessions that captivate and inspire learners every time</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-heart"></i></div>
                    <div class="benefit-text">
                        <h4>Build Facilitator Confidence</h4>
                        <p>Develop unshakeable confidence in your ability to lead, mentor, and inspire others</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-brain"></i></div>
                    <div class="benefit-text">
                        <h4>Enhance Learning Retention</h4>
                        <p>Master techniques that improve learner engagement and knowledge retention significantly</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-chart-line"></i></div>
                    <div class="benefit-text">
                        <h4>Expand Career Opportunities</h4>
                        <p>Open doors to new roles, projects, and leadership positions through training expertise</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-award"></i></div>
                    <div class="benefit-text">
                        <h4>Build Professional Credibility</h4>
                        <p>Establish yourself as a recognized expert and trusted facilitator in your field</p>
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
                    <h2 class="text-white mb-4">Ready to Become a Master Trainer?</h2>
                    <p class="text-white mb-4">Join professionals who are transforming into impactful facilitators and mentors. Master the art of training, build lasting influence, and expand your career opportunities. Start your trainer journey today with expert guidance and proven methods.</p>
                    <a href="contact-us.php" class="btn btn-light btn-lg px-5">Get Started Today</a>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>