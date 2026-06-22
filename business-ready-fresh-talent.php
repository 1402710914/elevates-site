<?php include 'header.php'; ?>

<style>
/* Business-Ready Fresh Talent Program - Complete Styles */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Hero uses shared .page-hero from style.css (same as About Us) */

/* Program Overview Section */
.program-overview {
    background: #ffffff;
    padding: 80px 0;
}

.program-overview .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.program-overview .row {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    align-items: center;
}

.program-overview .col-lg-6 {
    flex: 0 0 calc(50% - 20px);
}

.program-overview img {
    width: 100%;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.program-overview h2 {
    color: #1a365d;
    font-weight: 600;
    font-size: 2rem;
    margin-bottom: 20px;
}

.program-overview p {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.8;
    margin-bottom: 15px;
}

/* How It Works Section */
.how-it-works {
    background: #f7fafc;
    padding: 80px 0;
}

.how-it-works .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-title {
    font-size: 2rem;
    font-weight: 600;
    color: #1a365d;
    margin-bottom: 15px;
}

.lead {
    font-size: 1.2rem;
    color: #4a5568;
    font-weight: 600;
}

.how-it-works .row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.how-it-works .col-lg-6 {
    flex: 0 0 calc(50% - 10px);
}

.benefit-box {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    border-left: 5px solid #1a365d;
    transition: all 0.3s ease;
    min-height: 80px;
    display: flex;
    align-items: center;
}

.benefit-box:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    transform: translateY(-3px);
}

.benefit-box h4 {
    color: #1a365d;
    font-weight: 600;
    font-size: 1.1rem;
    margin: 0;
    line-height: 1.6;
}

/* Why Partner With Us Section */
.why-choose {
    background: #ffffff;
    padding: 80px 0;
}

.why-choose .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.why-choose .row {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    justify-content: center;
}

.why-choose .col-lg-4 {
    flex: 0 0 calc(33.333% - 17px);
}

.value-card {
    background: #f7fafc;
    padding: 35px 25px;
    border-radius: 8px;
    text-align: center;
    transition: all 0.3s ease;
    border-top: 4px solid #1a365d;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.value-card:hover {
    background: white;
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.value-card i {
    font-size: 2.5rem;
    color: #1a365d;
    margin-bottom: 20px;
}

.value-card h4 {
    color: #1a365d;
    font-weight: 600;
    font-size: 1.1rem;
    line-height: 1.6;
    margin: 0;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #1a1a2e 0%, #2d1b3d 100%);
   
    padding: 80px 0;
    color: white;
    text-align: center;
}

.cta-section .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.cta-section h2 {
    color: white;
    font-weight: 600;
    font-size: 2rem;
    margin-bottom: 20px;
}

.cta-section p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
    line-height: 1.8;
    margin-bottom: 30px;
}

.btn-light {
    background-color: white;
    color: #1a365d;
    border: none;
    font-weight: 600;
    padding: 15px 40px;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    display: inline-block;
    border-radius: 4px;
    cursor: pointer;
}

.btn-light:hover {
    background-color: #edf2f7;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    color: #1a365d;
}

/* Responsive Design */
@media (max-width: 992px) {
    .program-overview .col-lg-6 {
        flex: 0 0 100%;
    }

    .how-it-works .col-lg-6 {
        flex: 0 0 100%;
    }

    .why-choose .col-lg-4 {
        flex: 0 0 calc(50% - 12.5px);
    }

    .section-title {
        font-size: 1.7rem;
    }
}

@media (max-width: 768px) {
    .program-overview,
    .how-it-works,
    .why-choose,
    .cta-section {
        padding: 60px 0;
    }

    .section-title {
        font-size: 1.4rem;
    }

    .why-choose .col-lg-4 {
        flex: 0 0 100%;
    }

    .cta-section h2 {
        font-size: 1.4rem;
    }

    .program-overview .row,
    .how-it-works .row {
        gap: 20px;
    }
}



</style>


    <!-- Page Hero (same as About Us) -->
    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Business-Ready Fresh Talent Program</h1>
                    <p class="page-subtitle">Build job-ready talent that delivers from Day One</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <img src="programs-img/business-ready.png" alt="Fresh Talent Training Program">
                </div>
                <div class="col-lg-6">
                    <h2>What's This Program All About?</h2>
                    <p>Build job-ready talent that delivers from Day One.</p>
                    <p>Our Business-Ready Fresh Talent Program prepares graduates and early-career hires with role-specific skills, real-world training, and workplace readiness — cutting onboarding time, reducing training costs, and boosting productivity faster.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">How Does This Program Work?</h2>
                <p class="lead">Select. Train. Track. Deploy.</p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="benefit-box">
                        <h4>Role-based talent selection aligned with your business needs</h4>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="benefit-box">
                        <h4>3-month structured, real-world training program</h4>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="benefit-box">
                        <h4>Continuous performance tracking and feedback</h4>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="benefit-box">
                        <h4>Weekly coaching to ensure readiness and results</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Partner With Us -->
    <section class="why-choose">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Why Partner with Us</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <i class="fas fa-bolt"></i>
                        <h4>Faster productivity from Day One</h4>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <i class="fas fa-coins"></i>
                        <h4>Lower onboarding and training expenses</h4>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <i class="fas fa-users"></i>
                        <h4>Higher retention and engagement</h4>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <i class="fas fa-handshake"></i>
                        <h4>Stronger team culture fit</h4>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <i class="fas fa-shield-alt"></i>
                        <h4>Reduced hiring and turnover risk</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div style="text-align: center;">
                <h2>Ready to Transform Your Career or Business?</h2>
                <p>Join thousands of professionals and businesses that have elevated their success with our comprehensive coaching and development programs.</p>
                <a href="contact-us.php" class="btn-light">Get Started Today</a>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>