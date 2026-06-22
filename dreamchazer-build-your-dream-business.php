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
    left: -5%;
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

.how-steps-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 80px;
}

.how-step-card {
    background: linear-gradient(135deg, #f8fbff 0%, #f0f7ff 100%);
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border-top: 6px solid #99138a;
    text-align: center;
    position: relative;
}

.how-step-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.how-step-card::before {
    content: '';
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #99138a 0%, #2d3748 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    font-weight: 800;
    box-shadow: 0 10px 30px rgba(26, 54, 93, 0.2);
}

.how-step-card:nth-child(1)::before {
    content: '1';
}

.how-step-card:nth-child(2)::before {
    content: '2';
}

.how-step-card:nth-child(3)::before {
    content: '3';
}

.how-step-card:nth-child(4)::before {
    content: '4';
}

.how-step-card:nth-child(5)::before {
    content: '5';
}

.how-step-card h4 {
    color: #99138a;
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 15px;
    margin-top: 25px;
}

.how-step-card p {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.7;
    margin: 0;
}

.how-bottom {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
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

.how-info h3 {
    color: #99138a;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 20px;
}

.how-info p {
    color: #4a5568;
    font-size: 1.05rem;
    line-height: 1.9;
    margin-bottom: 15px;
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
    border-left: 6px solid #99138a;
    display: flex;
    gap: 25px;
}

.benefit-card:hover {
    transform: translateX(12px);
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

    .how-steps-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }

    .how-step-card:nth-child(5) {
        grid-column: 1 / -1;
        max-width: 50%;
        margin: 0 auto;
    }

    .how-bottom {
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

    .how-steps-grid {
        grid-template-columns: 1fr;
    }

    .how-step-card:nth-child(5) {
        grid-column: 1;
        max-width: 100%;
    }

    .how-step-card {
        padding: 30px 20px;
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
                    <h1 class="page-title page-title-with-tm">DreamChazer<span class="page-title-tm-circle">TM</span></h1>
                    <p class="page-subtitle">Build Your Dream Business with Expert Guidance and Proven Strategies</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview">
        <div class="container">
            <div class="overview-wrapper">
                <div class="overview-image">
                    <img src="programs-img/business.png" alt="Business Building">
                </div>
                <div class="overview-text">
                    <h2>What's This Program All About?</h2>
                    <p>The DreamChazer Program is designed to help aspiring entrepreneurs and business owners turn ideas into real, scalable businesses.</p>
                    <p>Through step-by-step guidance, expert mentorship, and practical execution strategies, you'll learn how to validate your idea, build a strong foundation, and grow a profitable business with confidence.</p>
                    <p><strong>This isn't just inspiration — it's real-world business building.</strong></p>
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
                        <div class="who-icon"><i class="fas fa-lightbulb"></i></div>
                        <div class="who-text">
                            <p>Individuals with a business idea they're passionate about and ready to bring to life</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-rocket"></i></div>
                        <div class="who-text">
                            <p>Entrepreneurs launching their first venture with vision and determination</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-chart-line"></i></div>
                        <div class="who-text">
                            <p>Small business owners looking to grow, pivot, or scale operations</p>
                        </div>
                    </div>
                    <div class="who-item">
                        <div class="who-icon"><i class="fas fa-handshake"></i></div>
                        <div class="who-text">
                            <p>Anyone who wants to build a sustainable and impactful business</p>
                        </div>
                    </div>
                </div>
                <div class="who-image">
                    <img src="programs-img/dream.png" alt="Entrepreneurship">
                </div>
            </div>
        </div>
    </section>

    <!-- How This Program Works -->
    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title">How Does This Program Work?</h2>
            <div class="how-steps-grid">
                <div class="how-step-card">
                    <h4>Business Clarity & Planning</h4>
                    <p>Define your vision, goals, and business model with a structured roadmap for success.</p>
                </div>

                <div class="how-step-card">
                    <h4>Core Business Skills & Strategy</h4>
                    <p>Learn practical approaches to sales, marketing, customer acquisition, and growth.</p>
                </div>

                <div class="how-step-card">
                    <h4>Personal Brand & Authority Building</h4>
                    <p>Build visibility and credibility through book publishing, social media, podcasts, and content.</p>
                </div>

                <div class="how-step-card">
                    <h4>Expert Mentorship & Real-World Feedback</h4>
                    <p>Get guidance from experienced entrepreneurs who've built successful businesses.</p>
                </div>

                <div class="how-step-card">
                    <h4>Weekly Accountability & Progress Support</h4>
                    <p>Ongoing coaching to ensure consistent action and momentum toward your goals.</p>
                </div>
            </div>

            <div class="how-bottom">
                <div class="how-image">
                    <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?w=600" alt="Business Strategy">
                </div>
                <div class="how-info">
                    <h3>Your Path to Business Success</h3>
                    <p>The DreamChazer program combines structured learning with real-world application. You don't just learn theory—you build your actual business while receiving expert feedback and accountability.</p>
                    <p>Each step is designed to move you closer to a profitable, sustainable business that aligns with your passion and purpose.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join This Program -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="section-title">Why Join the DreamChazer Program?</h2>
            <div class="benefits-intro">
                <p>Transform your entrepreneurial dreams into reality with a comprehensive program designed for real business builders.</p>
            </div>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="benefit-text">
                        <h4>Turn Ideas Into Reality</h4>
                        <p>Convert your business idea into a real, working venture with proven frameworks and guidance</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                    <div class="benefit-text">
                        <h4>Avoid Costly Mistakes</h4>
                        <p>Learn from experienced entrepreneurs and avoid the beginner mistakes that cost time and money</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-brain"></i></div>
                    <div class="benefit-text">
                        <h4>Build Entrepreneurial Skills</h4>
                        <p>Develop strong business skills and the confidence to lead and grow your venture</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-trophy"></i></div>
                    <div class="benefit-text">
                        <h4>Grow Income & Impact</h4>
                        <p>Create multiple revenue streams and build a business with lasting impact and long-term success</p>
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
                    <h2 class="text-white mb-4">Ready to Build Your Dream Business?</h2>
                    <p class="text-white mb-4">Join entrepreneurs who are turning their business ideas into profitable, scalable ventures. Get expert mentorship, proven strategies, and ongoing support to achieve your entrepreneurial goals. Start your journey today.</p>
                    <a href="contact-us.php" class="btn btn-light btn-lg px-5">Get Started Today</a>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>