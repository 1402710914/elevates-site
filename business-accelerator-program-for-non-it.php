<?php include 'header.php'; ?>

<style>
/* Business Accelerator Program - Complete Styles */

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

/* 6-Step Process Section */
.process-section {
    background: #f7fafc;
    padding: 80px 0;
}

.process-section .container {
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

.process-row {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
}

.process-col {
    flex: 0 0 calc(33.333% - 20px);
}

.process-card {
    background: white;
    padding: 35px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border-top: 5px solid #1a365d;
    transition: all 0.3s ease;
    text-align: center;
}

.process-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    transform: translateY(-5px);
}

.process-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #1a365d 0%, #2d3748 100%);
    color: white;
    border-radius: 50%;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.process-card h4 {
    color: #1a365d;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 10px;
}

.process-card p {
    color: #4a5568;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0;
}

/* Why This Program Section */
.benefits-section {
    background: #ffffff;
    padding: 80px 0;
}

.benefits-section .container {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 15px;
}

.benefits-intro {
    text-align: center;
    margin-bottom: 50px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.benefits-intro p {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.8;
    margin-bottom: 30px;
}

.benefits-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.benefit-item {
    flex: 0 0 calc(50% - 10px);
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: #f7fafc;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.benefit-item:hover {
    background: #edf2f7;
}

.benefit-check {
    width: 40px;
    height: 40px;
    background: #1a365d;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex-shrink: 0;
}

.benefit-item h5 {
    color: #1a365d;
    font-weight: 600;
    font-size: 1rem;
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

    .process-col {
        flex: 0 0 calc(50% - 15px);
    }

    .benefit-item {
        flex: 0 0 100%;
    }

    .section-title {
        font-size: 1.7rem;
    }
}

@media (max-width: 768px) {
    .program-overview,
    .process-section,
    .benefits-section,
    .cta-section {
        padding: 60px 0;
    }

    .section-title {
        font-size: 1.4rem;
    }

    .process-col {
        flex: 0 0 100%;
    }

    .cta-section h2 {
        font-size: 1.4rem;
    }

    .program-overview .row {
        gap: 20px;
    }

    .benefit-item {
        flex-direction: column;
        text-align: center;
    }

    .benefit-check {
        margin: 0 auto;
    }
}


</style>

    <!-- Page Hero (same as About Us) -->
    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="page-title page-title-with-tm">Business Accelerator Program for Non-IT<span class="page-title-tm-circle">TM</span></h1>
                    <p class="page-subtitle">A data-driven approach to fixing bottlenecks and accelerating business growth</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Overview -->
    <section class="program-overview">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <img src="programs-img/business.png" alt="Business Growth Program">
                </div>
                <div class="col-lg-6">
                    <h2>What's This Program All About?</h2>
                    <p>We assess your people, processes, and operations, identify performance gaps, and implement tailored solutions that drive efficiency, stronger teams, and measurable business results.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6-Step Process -->
    <section class="process-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our 6-Step Process</h2>
            </div>
            <div class="process-row">
                <div class="process-col">
                    <div class="process-card">
                        <div class="process-number">1</div>
                        <h4>Business Assessment</h4>
                        <p>We evaluate your current state across people, processes, tools, and key performance metrics to understand what's working and what's limiting growth.</p>
                    </div>
                </div>
                <div class="process-col">
                    <div class="process-card">
                        <div class="process-number">2</div>
                        <h4>Gap Analysis</h4>
                        <p>Critical gaps, inefficiencies, and performance barriers are identified along with their impact on revenue, productivity, and operations.</p>
                    </div>
                </div>
                <div class="process-col">
                    <div class="process-card">
                        <div class="process-number">3</div>
                        <h4>Customized Action Plan</h4>
                        <p>A tailored improvement roadmap is created, combining coaching, process optimization, and targeted training aligned with your business goals.</p>
                    </div>
                </div>
                <div class="process-col">
                    <div class="process-card">
                        <div class="process-number">4</div>
                        <h4>Implementation & Engagement</h4>
                        <p>Live sessions, hands-on execution, and accountability checkpoints ensure strategies are applied effectively across teams.</p>
                    </div>
                </div>
                <div class="process-col">
                    <div class="process-card">
                        <div class="process-number">5</div>
                        <h4>Performance Measurement</h4>
                        <p>Progress is tracked using clear metrics to ensure improvements in efficiency, team performance, and business outcomes.</p>
                    </div>
                </div>
                <div class="process-col">
                    <div class="process-card">
                        <div class="process-number">6</div>
                        <h4>Continuous Growth</h4>
                        <p>Ongoing refinements drive sustained results, helping you consistently achieve and exceed your business targets.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why This Program -->
    <section class="benefits-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Why This Program</h2>
            </div>
            <div class="benefits-intro">
                <p>Get strategic results with our proven methodology designed to transform your business operations and accelerate growth.</p>
            </div>
            <div class="benefits-row">
                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    <h5>Tailored improvement strategies</h5>
                </div>
                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    <h5>Higher efficiency and performance</h5>
                </div>
                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    <h5>Ongoing accountability & expert guidance</h5>
                </div>
                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    <h5>Measurable growth outcomes</h5>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div style="text-align: center;">
                <h2>Ready to Accelerate Your Business Growth?</h2>
                <p>Let's assess your business, identify opportunities, and create a roadmap for sustainable success. Start your transformation today.</p>
                <a href="contact-us.php" class="btn-light">Get Started Today</a>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>