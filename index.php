<?php include 'header.php'; ?>
<?php include __DIR__ . '/db.php'; ?>


    <section class="hero-section">
    <div class="container hero-section-inner">
        <div class="row align-items-center hero-content-row">
            <div class="col-lg-8 col-md-10 mx-auto text-center text-lg-start">
                <center><h1 class="hero-title">Elevate Yourself, Elevate Your Team, Elevate Your Business</h1>
                <p class="hero-subtitle">A Unified platform Where Job Ready talents Meet the Potential Employers</p>
                <p class="hero-subtitle">All-In-One Personalized & Result Oriented Expert Coaching and Mentoring for <span>EARLY AND MID CAREER</span> Professionals & 
                SMALL AND MID SIZE BUSINESSES to achieve 360 degree transformation.</p></center>
                <!-- <a onclick="openDiscoveryPopup()" class="btn  btn-lg btn-hero">Book a Discovery Session</a> -->
            </div>
        </div>
        <div class="hero-impact">
            <div class="hero-impact-inner">
                <div class="hero-impact-item">
                    <span class="hero-impact-number" data-target="1500" data-suffix="+">0</span>
                    <span class="hero-impact-label">Professionals Coached</span>
                </div>
                <div class="hero-impact-divider"></div>
                <div class="hero-impact-item">
                    <span class="hero-impact-number" data-target="50" data-suffix="+">0</span>
                    <span class="hero-impact-label">Businesses Transformed</span>
                </div>
                <div class="hero-impact-divider"></div>
                <div class="hero-impact-item">
                    <span class="hero-impact-number" data-target="99" data-suffix="%">0</span>
                    <span class="hero-impact-label">Client Satisfaction Rate</span>
                </div>
                <!-- <div class="hero-impact-divider"></div> -->
                <!-- <div class="hero-impact-item">
                    <span class="hero-impact-number" data-target="15" data-suffix="+">0</span>
                    <span class="hero-impact-label">Countries<br>Reached</span>
                </div> -->
            </div>
        </div>
        <div class="hero-mobile-assessment-wrap">
            <a onclick="openDiscoveryPopup()" class="btn btn-demo btn-demo-wave hero-mobile-assessment-btn">
                AI-Powered Skill Gap Assessment
            </a>
        </div>
    </div>
</section>
<script>
(function() {
    function easeOutQuart(t) { return 1 - Math.pow(1 - t, 4); }
    function animateValue(el, start, end, suffix, duration) {
        var startTime = null;
        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = easeOutQuart(progress);
            var current = Math.floor(start + (end - start) * eased);
            el.textContent = current + suffix;
            if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }
    function runImpactCountUp() {
        var nodes = document.querySelectorAll('.hero-impact-number[data-target]');
        nodes.forEach(function(el) {
            var target = parseInt(el.getAttribute('data-target'), 10);
            var suffix = el.getAttribute('data-suffix') || '';
            animateValue(el, 0, target, suffix, 1800);
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() { setTimeout(runImpactCountUp, 300); });
    } else {
        setTimeout(runImpactCountUp, 300);
    }
})();
</script>
<style>
        :root {
            --text-dark: #333;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* ==========================================
           HERO OUR IMPACT (home page - high specificity)
           ========================================== */
        .hero-section .hero-section-inner {
           
            display: flex !important;
            flex-direction: column;
            padding-bottom: 0;
        }
        .hero-section .hero-content-row {
            flex: 0 0 auto;
        }
        .hero-section .hero-impact {
           
           
            width: 100%;
        }
        .hero-section .hero-impact-inner {
            display: flex !important;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0;
           
            padding: 28px 24px;
            border-radius: 12px;
            max-width: 1120px;
            margin: 0 auto;
        }
        .hero-section .hero-impact-item {
            flex: 1;
            min-width: 140px;
            text-align: center;
            padding: 0 24px;
        }
        .hero-section .hero-impact-number {
            display: block;
            font-size: 3.35rem;
            font-weight: 700;
            color: #8f8cd4;
            font-family: 'Playfair Display', serif;
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .hero-section .hero-impact-label {
            display: block;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.98);
            line-height: 1.45;
        }
        .hero-section .hero-impact-divider {
            width: 1px;
            height: 48px;
            background: rgba(255, 255, 255, 0.4);
            flex-shrink: 0;
        }
        .hero-mobile-assessment-wrap {
            display: none;
            width: 100%;
            text-align: center;
            margin-top: 14px;
        }
        .hero-mobile-assessment-btn {
            display: inline-flex;
            justify-content: center;
            width: 100%;
            max-width: 360px;
            padding: 10px 18px;
            font-size: 0.94rem;
        }
        @media (max-width: 767px) {
            .main-header .btn-demo-wave {
                display: none !important;
            }
            .hero-mobile-assessment-wrap {
                display: block;
            }
            .hero-section .hero-impact-inner {
                flex-direction: column !important;
                gap: 16px;
                padding: 22px 16px;
            }
            .hero-section .hero-impact-divider {
                width: 70%;
                height: 1px;
            }
            .hero-section .hero-impact-number {
                font-size: 1.9rem;
            }
            .hero-section .hero-impact-item {
                min-width: auto;
                padding: 0;
            }
        }

        /* ==========================================
           WHAT WE DO SECTION
           ========================================== */

        .wwd-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            position: relative;
            overflow: hidden;
            padding: 80px 0;
        }

        .wwd-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(233, 30, 140, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .wwd-section::after {
            content: '';
            position: absolute;
            bottom: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .wwd-section .container {
            position: relative;
            z-index: 1;
        }

        .wwd-section .wwd-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.3;
        }

        .wwd-lead {
            font-size: 1.15rem;
            color: #555;
            line-height: 1.8;
        }

        /* Service Cards */
        .wwd-card {
            background: white;
            padding: 40px 30px;
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            margin: 10px;
        }

        /* Gradient Backgrounds */
        .wwd-gradient-career {
            background: linear-gradient(135deg, #99138a 0%, #764ba2 100%);
        }

        .wwd-gradient-sales {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .wwd-gradient-leadership {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .wwd-gradient-business {
            background: linear-gradient(135deg, #3874a8ff 0%, rgba(58, 203, 177, 1) 100%);
        }

        /* Decorative Elements */
        .wwd-card::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transition: all 0.5s ease;
        }

        .wwd-card::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            transition: all 0.5s ease;
        }

        /* Hover Effects */
        .wwd-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.2);
        }

        .wwd-card:hover::before {
            transform: scale(1.5);
            opacity: 0.5;
        }

        .wwd-card:hover::after {
            transform: scale(1.3);
            opacity: 0.4;
        }

        /* Service Icon */
        .wwd-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
            transition: all 0.4s ease;
        }

        .wwd-icon i {
            font-size: 2.5rem;
            color: white;
            transition: all 0.4s ease;
        }

        .wwd-card:hover .wwd-icon {
            transform: scale(1.1) rotate(5deg);
            background: rgba(255, 255, 255, 0.3);
        }

        .wwd-card:hover .wwd-icon i {
            transform: scale(1.1) rotate(-5deg);
        }

        /* Service Title */
        .wwd-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 12px;
            line-height: 1.3;
            position: relative;
            z-index: 2;
            min-height: 60px;
        }

        /* Service Subtitle */
        .wwd-card-subtitle {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }

        /* Service Description */
        .wwd-card-description {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.6;
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }

        /* Service Features */
        .wwd-features {
            position: relative;
            z-index: 2;
            margin-bottom: 25px;
            flex-grow: 1;
        }

        .wwd-features-heading {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
        }

        .wwd-features-list {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .wwd-features-list li {
            padding-left: 25px;
            position: relative;
            margin-bottom: 12px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.6;
        }

        .wwd-features-list li:last-child {
            margin-bottom: 0;
        }

        .wwd-features-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        /* Service CTA */
        .wwd-cta {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
            backdrop-filter: blur(10px);
        }

        .wwd-cta:hover {
            background: white;
            color: var(--text-dark);
            transform: translateX(5px);
            border-color: white;
        }

        .wwd-cta i {
            transition: transform 0.3s ease;
        }

        .wwd-cta:hover i {
            transform: translateX(5px);
        }

        /* Swiper Customization for Desktop */
        .wwd-swiper {
            padding: 20px 0 100px 0;
            position: relative;
        }

        /* Pagination Container with Arrows */
        .wwd-pagination {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            width: auto;
            padding: 20px;
        }

        .wwd-pagination .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #ddd;
            opacity: 1;
            transition: var(--transition);
            margin: 0 5px;
            cursor: pointer;
        }

        .wwd-pagination .swiper-pagination-bullet-active {
            background: #99138a;
            width: 30px;
            border-radius: 6px;
        }

        .wwd-dots-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wwd-button-next,
        .wwd-button-prev {
            color: #99138a !important;
            background: white !important;
            width: 50px !important;
            height: 50px !important;
            border-radius: 50% !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.3s ease !important;
            border: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            flex-shrink: 0 !important;
            z-index: 10 !important;
            padding: 0 !important;
        }

        .wwd-button-next svg,
        .wwd-button-prev svg {
            width: 24px;
            height: 24px;
            stroke: #99138a;
        }

        .wwd-button-next:hover,
        .wwd-button-prev:hover {
            background: #99138a !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2) !important;
        }

        .wwd-button-next:hover svg,
        .wwd-button-prev:hover svg {
            stroke: white;
        }

        /* Desktop - Show slider */
        @media (min-width: 768px) {
            .wwd-grid-mobile {
                display: none;
            }
            .wwd-swiper {
                display: block;
            }
        }

        /* Mobile - Show grid, hide slider */
        @media (max-width: 767px) {
            .wwd-swiper {
                display: none;
            }
            .wwd-grid-mobile {
                display: block;
            }
            
            .wwd-card {
                margin: 0 0 20px 0;
            }

            .wwd-button-next,
            .wwd-button-prev {
                display: none !important;
            }
        }

        /* Responsive Styles */
        @media (max-width: 1199px) {
            .wwd-card-title {
                font-size: 1.35rem;
                min-height: 55px;
            }

            .wwd-card-description {
                font-size: 0.95rem;
            }

            .wwd-features-list li {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 991px) {
            .wwd-section .wwd-title {
                font-size: 2rem;
            }

            .wwd-lead {
                font-size: 1.05rem;
            }

            .wwd-card {
                padding: 35px 25px;
            }

            .wwd-icon {
                width: 70px;
                height: 70px;
                margin-bottom: 20px;
            }

            .wwd-icon i {
                font-size: 2.2rem;
            }

            .wwd-card-title {
                font-size: 1.3rem;
                min-height: 50px;
            }

            .wwd-card-subtitle {
                font-size: 0.9rem;
            }

            .wwd-card-description {
                font-size: 0.9rem;
                margin-bottom: 20px;
            }

            .wwd-features-heading {
                font-size: 1rem;
            }

            .wwd-features-list li {
                font-size: 0.85rem;
                margin-bottom: 10px;
            }

            .wwd-cta {
                font-size: 0.9rem;
                padding: 10px 20px;
            }

            .wwd-button-next,
            .wwd-button-prev {
                width: 45px;
                height: 45px;
            }

            .wwd-button-next::after,
            .wwd-button-prev::after {
                font-size: 18px;
            }
        }

        @media (max-width: 767px) {
            .wwd-section {
                padding: 60px 0;
            }

            .wwd-section .wwd-title {
                font-size: 1.75rem;
            }

            .wwd-lead {
                font-size: 1rem;
            }

            .wwd-card {
                padding: 30px 20px;
            }

            .wwd-icon {
                width: 65px;
                height: 65px;
                border-radius: 15px;
            }

            .wwd-icon i {
                font-size: 2rem;
            }

            .wwd-card-title {
                font-size: 1.25rem;
                min-height: auto;
                margin-bottom: 10px;
            }

            .wwd-card-subtitle {
                font-size: 0.85rem;
                margin-bottom: 12px;
            }

            .wwd-card-description {
                font-size: 0.85rem;
                margin-bottom: 18px;
            }

            .wwd-features-heading {
                font-size: 0.95rem;
                margin-bottom: 12px;
            }

            .wwd-features-list li {
                font-size: 0.8rem;
                padding-left: 22px;
                margin-bottom: 8px;
            }

            .wwd-features-list li::before {
                font-size: 1.1rem;
            }

            .wwd-cta {
                font-size: 0.85rem;
                padding: 10px 18px;
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .wwd-section .wwd-title {
                font-size: 1.5rem;
            }

            .wwd-lead {
                font-size: 0.95rem;
            }

            .wwd-card {
                padding: 25px 18px;
            }

            .wwd-icon {
                width: 60px;
                height: 60px;
            }

            .wwd-icon i {
                font-size: 1.8rem;
            }

            .wwd-card-title {
                font-size: 1.15rem;
            }
        }

        /* Pulse Animation for Icons */
        @keyframes wwdIconPulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }
            50% {
                box-shadow: 0 0 0 15px rgba(255, 255, 255, 0);
            }
        }

        .wwd-card:hover .wwd-icon {
            animation: wwdIconPulse 1.5s ease-out infinite;
        }
    </style>



    <!-- What We Do Section -->
    <section class="wwd-section">
        <div class="container">
            
            <!-- Section Header -->
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-10">
                    <h2 class="wwd-title mb-4">What We Do at Elevates</h2>
                    <p class="about-bold-line">We Hold Your Hands Until you reach your Destination</p>
                    <p class="wwd-lead">Structured & custom enablement programs designed for real-world career and business growth.</p>
                </div>
            </div>

            <!-- Desktop Swiper Slider -->
            <div class="swiper wwd-swiper">
                <div class="swiper-wrapper">
                    
                    <!-- Slide 1: Career Enablement -->
                    <div class="swiper-slide">
                        <div class="wwd-card wwd-gradient-career">
                            <div class="wwd-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h3 class="wwd-card-title">Career Enablement Programs</h3>
                            <p class="wwd-card-subtitle">For Early & Mid-Career Professionals</p>
                            <p class="wwd-card-description">We help professionals gain clarity, confidence, and capability to grow faster in their careers.</p>
                            
                            <div class="wwd-features">
                                <h4 class="wwd-features-heading">What you get:</h4>
                                <ul class="wwd-features-list">
                                    <li>Career clarity & growth roadmap, Building positive Mindset</li>
                                    <li>Skill readiness (Client handling & Value selling, Effective communication, Personality Development, Trending Technical skills)</li>
                                    <li>Interview readiness (Resume building and mock sessions) & professional confidence</li>
                                    <li>Accountability-driven execution and hand holding</li>
                                </ul>
                            </div>
                            
                            <a href="#" class="wwd-cta">
                                Explore Our Career Programs
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Slide 2: Sales Enablement -->
                    <div class="swiper-slide">
                        <div class="wwd-card wwd-gradient-sales">
                            <div class="wwd-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h3 class="wwd-card-title">Sales & Value-Selling Enablement</h3>
                            <p class="wwd-card-subtitle">For Professionals & Business Teams</p>
                            <p class="wwd-card-description">We strengthen value selling, client handling, and deal closure through proven frameworks.</p>
                            
                            <div class="wwd-features">
                                <h4 class="wwd-features-heading">What you get:</h4>
                                <ul class="wwd-features-list">
                                    <li>Value selling & consultative approach</li>
                                    <li>Client handling & objection management</li>
                                    <li>Structured sales conversations & becoming Trusted Advisor</li>
                                    <li>Practical frameworks with real use cases</li>
                                </ul>
                            </div>
                            
                            <a href="#" class="wwd-cta">
                                Explore Our Sales Enablement Programs
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Slide 3: Leadership Development -->
                    <div class="swiper-slide">
                        <div class="wwd-card wwd-gradient-leadership">
                            <div class="wwd-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h3 class="wwd-card-title">Leadership & Mindset Development</h3>
                            <p class="wwd-card-subtitle">For Individuals & Business Leaders</p>
                            <p class="wwd-card-description">We build leaders who think clearly, act decisively, and lead with confidence.</p>
                            
                            <div class="wwd-features">
                                <h4 class="wwd-features-heading">What you get:</h4>
                                <ul class="wwd-features-list">
                                    <li>Leadership mindset & decision-making</li>
                                    <li>Ownership & accountability frameworks</li>
                                    <li>Effective Public Speaking, Networking & influencing skills</li>
                                    <li>Personal effectiveness & mental resilience</li>
                                </ul>
                            </div>
                            
                            <a href="#" class="wwd-cta">
                                Explore Our Leadership Programs
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Slide 4: Business Enablement -->
                    <div class="swiper-slide">
                        <div class="wwd-card wwd-gradient-business">
                            <div class="wwd-icon">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <h3 class="wwd-card-title">Business Enablement & Growth Consulting</h3>
                            <p class="wwd-card-subtitle">For Small & Mid-Sized Businesses</p>
                            <p class="wwd-card-description">We help businesses scale with structure, strong teams, and execution clarity.</p>
                            
                            <div class="wwd-features">
                                <h4 class="wwd-features-heading">What you get:</h4>
                                <ul class="wwd-features-list">
                                    <li>Team accountability & leadership alignment</li>
                                    <li>Sales & growth frameworks</li>
                                    <li>Process clarity & execution discipline</li>
                                    <li>Sustainable business growth roadmap</li>
                                    <li>Hiring Assistance</li>
                                    <li>Powerful Branding and Market Visibility</li>
                                </ul>
                            </div>
                            
                            <a href="#" class="wwd-cta">
                                Explore Our Business Enablement Programs
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                </div>
                
                <!-- Pagination with Navigation Buttons -->
                <div class="wwd-pagination">
                    <button class="wwd-button-prev">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>
                    <div class="wwd-dots-container"></div>
                    <button class="wwd-button-next">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Grid (No Slider) -->
            <div class="wwd-grid-mobile">
                <div class="row g-4">
                    
                    <!-- Card 1: Career Enablement -->
                    <div class="col-12">
                        <div class="wwd-card wwd-gradient-career">
                            <div class="wwd-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h3 class="wwd-card-title">Career Enablement Programs</h3>
                            <p class="wwd-card-subtitle">For Early & Mid-Career Professionals</p>
                            <p class="wwd-card-description">We help professionals gain clarity, confidence, and capability to grow faster in their careers.</p>
                            
                            <div class="wwd-features">
                                <h4 class="wwd-features-heading">What you get:</h4>
                                <ul class="wwd-features-list">
                                    <li>Career clarity & growth roadmap, Building positive Mindset</li>
                                    <li>Skill readiness (Client handling & Value selling, Effective communication, Personality Development, Trending Technical skills)</li>
                                    <li>Interview readiness (Resume building and mock sessions) & professional confidence</li>
                                    <li>Accountability-driven execution and hand holding</li>
                                </ul>
                            </div>
                            
                            <a href="#" class="wwd-cta">
                                Explore Our Career Programs
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Card 2: Sales Enablement -->
                    <div class="col-12">
                        <div class="wwd-card wwd-gradient-sales">
                            <div class="wwd-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h3 class="wwd-card-title">Sales & Value-Selling Enablement</h3>
                            <p class="wwd-card-subtitle">For Professionals & Business Teams</p>
                            <p class="wwd-card-description">We strengthen value selling, client handling, and deal closure through proven frameworks.</p>
                            
                            <div class="wwd-features">
                                <h4 class="wwd-features-heading">What you get:</h4>
                                <ul class="wwd-features-list">
                                    <li>Value selling & consultative approach</li>
                                    <li>Client handling & objection management</li>
                                    <li>Structured sales conversations & becoming Trusted Advisor</li>
                                    <li>Practical frameworks with real use cases</li>
                                </ul>
                            </div>
                            
                            <a href="#" class="wwd-cta">
                                Explore Our Sales Enablement Programs
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Card 3: Leadership Development -->
                    <div class="col-12">
                        <div class="wwd-card wwd-gradient-leadership">
                            <div class="wwd-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h3 class="wwd-card-title">Leadership & Mindset Development</h3>
                            <p class="wwd-card-subtitle">For Individuals & Business Leaders</p>
                            <p class="wwd-card-description">We build leaders who think clearly, act decisively, and lead with confidence.</p>
                            
                            <div class="wwd-features">
                                <h4 class="wwd-features-heading">What you get:</h4>
                                <ul class="wwd-features-list">
                                    <li>Leadership mindset & decision-making</li>
                                    <li>Ownership & accountability frameworks</li>
                                    <li>Effective Public Speaking, Networking & influencing skills</li>
                                    <li>Personal effectiveness & mental resilience</li>
                                </ul>
                            </div>
                            
                            <a href="#" class="wwd-cta">
                                Explore Our Leadership Programs
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Card 4: Business Enablement -->
                    <div class="col-12">
                        <div class="wwd-card wwd-gradient-business">
                            <div class="wwd-icon">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <h3 class="wwd-card-title">Business Enablement & Growth Consulting</h3>
                            <p class="wwd-card-subtitle">For Small & Mid-Sized Businesses</p>
                            <p class="wwd-card-description">We help businesses scale with structure, strong teams, and execution clarity.</p>
                            
                            <div class="wwd-features">
                                <h4 class="wwd-features-heading">What you get:</h4>
                                <ul class="wwd-features-list">
                                    <li>Team accountability & leadership alignment</li>
                                    <li>Sales & growth frameworks</li>
                                    <li>Process clarity & execution discipline</li>
                                    <li>Sustainable business growth roadmap</li>
                                </ul>
                            </div>
                            
                            <a href="#" class="wwd-cta">
                                Explore Our Business Enablement Programs
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- Initialize Swiper -->
    <script>
        // Initialize Swiper only on desktop
        if (window.innerWidth >= 768) {
            const swiper = new Swiper('.wwd-swiper', {
                // Slider parameters
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                
                // Autoplay
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                
                // Speed
                speed: 800,
                
                // Pagination
                pagination: {
                    el: '.wwd-dots-container',
                    clickable: true,
                },
                
                // Navigation arrows
                navigation: {
                    nextEl: '.wwd-button-next',
                    prevEl: '.wwd-button-prev',
                },
                
                // Responsive breakpoints
                breakpoints: {
                    // When window width is >= 768px (Tablet)
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    // When window width is >= 992px (Desktop)
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                },
                
                // Accessibility
                a11y: {
                    enabled: true,
                },
            });
        }
    </script>



<!-- Alternative Design: Bottom Text Overlay Always Visible -->
<section class="five-pillars-alt py-5 bg-light">
    <div class="container">
        
        <!-- Section Header -->
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-10">
                <h2 class="section-title mb-4">How do I build Five Pillars of Success</h2>
                <p class="section-lead">Our custom coaching & mentoring frameworks focus on five essential areas that drive long-term personal and professional success.</p>
            </div>
        </div>

        <!-- Pillars Row -->
        <div class="row g-4 mb-5">
            
            <!-- Pillar 1 -->
            <div class="col-lg col-md-4 col-sm-6">
                <div class="pillar-card-alt">
                    <div class="pillar-image-wrapper">
                        <img src="img/pdp.png" alt="PDP & Communication">
                        <div class="gradient-overlay"></div>
                        <div class="pillar-badge">01</div>
                        <div class="pillar-text-overlay">
                            <div class="pillar-icon-small">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h5>PDP & Communication Skills</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pillar 2 -->
            <div class="col-lg col-md-4 col-sm-6">
                <div class="pillar-card-alt">
                    <div class="pillar-image-wrapper">
                        <img src="img/men.png" alt="Mental Wellness">
                        <div class="gradient-overlay"></div>
                        <div class="pillar-badge">02</div>
                        <div class="pillar-text-overlay">
                            <div class="pillar-icon-small">
                                <i class="fas fa-brain"></i>
                            </div>
                            <h5>Mental Wellness</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pillar 3 -->
            <div class="col-lg col-md-4 col-sm-6">
                <div class="pillar-card-alt">
                    <div class="pillar-image-wrapper">
                        <img src="img/ad.png" alt="Trusted Advisor">
                        <div class="gradient-overlay"></div>
                        <div class="pillar-badge">03</div>
                        <div class="pillar-text-overlay">
                            <div class="pillar-icon-small">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h5>Trusted Advisor, Value Selling and Client Handling</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pillar 4 -->
            <div class="col-lg col-md-4 col-sm-6">
                <div class="pillar-card-alt">
                    <div class="pillar-image-wrapper">
                        <img src="img/tech.png" alt="Technology Skills">
                        <div class="gradient-overlay"></div>
                        <div class="pillar-badge">04</div>
                        <div class="pillar-text-overlay">
                            <div class="pillar-icon-small">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <h5>Technology Skills</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pillar 5 -->
            <div class="col-lg col-md-4 col-sm-6">
                <div class="pillar-card-alt">
                    <div class="pillar-image-wrapper">
                        <img src="img/leader.png" alt="Leadership">
                        <div class="gradient-overlay"></div>
                        <div class="pillar-badge">05</div>
                        <div class="pillar-text-overlay">
                            <div class="pillar-icon-small">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h5>Leadership</h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- CTA -->
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="cta-box">
                    <p class="cta-question">Want to work on your success journey?</p>
                    <a onclick="openDiscoveryPopup()" class="btn-cta-alt">
                        Book a Discovery Session
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- CSS for Alternative Design -->
<style>
.five-pillars-alt {
    background: #f8f9fa;
}

.pillar-card-alt {
    transition: all 0.4s ease;
}

.pillar-card-alt:hover {
    transform: translateY(-10px);
}

.pillar-image-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    aspect-ratio: 3 / 4;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
}

.pillar-card-alt:hover .pillar-image-wrapper {
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
}

.pillar-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.pillar-card-alt:hover .pillar-image-wrapper img {
    transform: scale(1.1);
}

.gradient-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60%;
    background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.9) 100%);
}

.pillar-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #6a0dad, #a9167e);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
    color: white;
    box-shadow: 0 5px 20px rgba(233, 30, 140, 0.4);
}

.pillar-text-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 25px 20px;
    z-index: 2;
}

.pillar-icon-small {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
}

.pillar-icon-small i {
    font-size: 1.5rem;
    color: white;
}

.pillar-text-overlay h5 {
    font-family: 'Ivar Headline', 'Times New Roman', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: white;
    margin: 0;
    line-height: 1.3;
}

.cta-box {
    padding: 40px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
}

.cta-question {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 20px;
}

.btn-cta-alt {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #6a0dad, #a9167e);
    color: white;
    padding: 16px 40px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.05rem;
    box-shadow: 0 10px 30px rgba(233, 30, 140, 0.3);
    transition: all 0.3s ease;
}

.btn-cta-alt:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(233, 30, 140, 0.5);
    color: white;
}

@media (max-width: 991px) {
    .pillar-image-wrapper {
        aspect-ratio: 1 / 1;
    }
    
    .pillar-badge {
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
    }
    
    .pillar-text-overlay h5 {
        font-size: 1rem;
    }
}

@media (max-width: 767px) {
    .pillar-text-overlay {
        padding: 20px 15px;
    }
    
    .pillar-icon-small {
        width: 45px;
        height: 45px;
    }
    
    .pillar-icon-small i {
        font-size: 1.3rem;
    }
    
    .pillar-text-overlay h5 {
        font-size: 0.95rem;
    }
    
    .btn-cta-alt {
        width: 100%;
        justify-content: center;
    }
}
</style>

    <!-- About Us Section -->
    <section class="about-us-section py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800" alt="About Us" class="img-fluid rounded shadow">
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title text-start mb-3">About Us</h2>
                    <p class="about-bold-line">Who we work with - Early & mid-career professionals and growing Businesses</p>
                    <p class="about-text">At Elevates, our commitment is to support early and mid-career professionals, as well as small and medium businesses, on their transformational journey. Our tailored, results-driven approach strengthens:</p>
                    <ul class="about-list">
                        <li>Accelerated Career Growth, Increased Visibility and Advanced Technical Proficiency</li>
                        <li>Refined Communication Skills and Personality Development</li>
                        <li>Holistic Mental Well-being</li>
                        <li>Strong Personal Brand and Effective Leadership Skills</li>
                        <li>Developing High-Performing Teams to Achieve Business Outcomes</li>
                        <li>Business Scaling through Streamlined, Efficient Processes</li>
                    </ul>
                    <a href="about-us.php" class="btn  btn-demo  mt-3">Read More</a>
                </div>
            </div>
        </div>
    </section>


<!--    
<section class="why-programs-section py-5 bg-light">
    <div class="container">
     
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-10">
                <h2 class="section-title mb-4">Why Most Generic Enablement Programs Don't Work</h2>
                <p class="section-intro">Elevates helps you build a successful career and a strong business. We deliver a practical, proven, and custom plan, developed after thorough assessments and Gap Analysis. By equipping you with the right processes and tools, we ensure you move forward with clarity and confidence.</p>
            </div>
        </div>

       
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="failure-card-single">
                    <div class="row g-4">
                       
                        <div class="col-md-6">
                            <div class="failure-column">
                                <div class="failure-icon-small">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <h4 class="failure-subtitle">Professionals Fail Because of</h4>
                                <ul class="failure-list-compact">
                                    <li>Poor Mindset & Procrastination</li>
                                    <li>Absence of Right Guidance & Not Taking Actions</li>
                                    <li>Stagnant Career Growth</li>
                                    <li>Organizational & Market Visibility</li>
                                    <li>Lack of Functional & Vital Skills</li>
                                </ul>
                            </div>
                        </div>

                       
                        <div class="col-md-6">
                            <div class="failure-column">
                                <div class="failure-icon-small">
                                    <i class="fas fa-building"></i>
                                </div>
                                <h4 class="failure-subtitle">Businesses Fail Because of</h4>
                                <ul class="failure-list-compact">
                                    <li>Structured mindset & accountability framework</li>
                                    <li>Personalized career guidance with action plans</li>
                                    <li>Clear career growth roadmaps</li>
                                    <li>Personal branding & professional visibility</li>
                                    <li>Functional & future-ready skill development</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->



    <style>
        :root {
            --primary-color: #99138a;
            --text-dark: #333;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Problem Solution Section */
        .problem-solution-section-tabs {
            background: #ffffff;
            padding: 80px 0;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.3;
        }

        .section-intro {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.8;
        }

        /* Desktop Tab Navigation - Hover Effect */
        .nav-custom {
            gap: 20px;
            display: flex;
            justify-content: center;
        }

        .nav-custom .nav-link {
            background: #16162b;
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            cursor: pointer;
        }

        .nav-custom .nav-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            background: linear-gradient(135deg, #e530ad, #6eafe3);
            color: white;
            border-color: var(--primary-color);
        }

        .nav-custom .nav-link.active {
            background: linear-gradient(135deg, #6a0dad, #a9167e);
            color: white;
            border-color: var(--primary-color);
        }

        /* Tab Content */
        .tab-content {
            margin-top: 50px;
        }

        .tab-pane {
            display: none;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .tab-pane.show {
            display: block;
            opacity: 1;
        }

        /* Compare Cards */
        .compare-card {
            background: white;
            padding: 40px 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            height: 100%;
            transition: all 0.3s ease;
        }

        .compare-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .problem-side {
            border-left: 4px solid #e331ad;
        }

        .solution-side {
            border-left: 4px solid #a11385;
        }

        .compare-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .compare-header i {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
        }

        .problem-side .compare-header i {
            color: #a11385;
        }

        .solution-side .compare-header i {
            color: #a11385;
        }

        .compare-header h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .compare-list {
            list-style: none;
            padding: 0;
        }

        .compare-list li {
            padding-left: 35px;
            position: relative;
            margin-bottom: 16px;
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
        }

        .problem-side .compare-list li::before {
            content: "✗";
            position: absolute;
            left: 0;
            color: #e331ad;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .solution-side .compare-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #e331ad;
            font-weight: 700;
            font-size: 1.4rem;
        }

        /* Mobile Section Heading */
        .mobile-section-heading {
            display: none;
            
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        .mobile-section-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(135deg, var(--primary-color), #ff6b9d);
            border-radius: 2px;
        }

        /* Desktop View - Tabs visible */
        @media (min-width: 768px) {
            .nav-custom {
                display: flex;
            }

            .tab-content {
                display: block;
            }

            .mobile-section-heading {
                display: none;
            }

            .mobile-content-section {
                display: none;
            }
        }

        /* Mobile View - No tabs, stacked content */
        @media (max-width: 767px) {
            .problem-solution-section-tabs {
                padding: 60px 0;
            }

            .section-title {
                font-size: 1.75rem;
            }

            .section-intro {
                font-size: 1rem;
            }

            /* Hide desktop tabs and content */
            .nav-custom {
                display: none;
            }

            .tab-content {
                display: none;
            }

            /* Show mobile content */
            .mobile-content-section {
                display: block;
                margin-top: 30px;
            }

            .mobile-section-heading {
                display: block;
                font-size: 1.5rem;
                margin-top: 40px;
                margin-bottom: 25px;
            }

            .mobile-section-heading:first-of-type {
                margin-top: 0;
            }

            .compare-card {
                padding: 30px 25px;
                margin-bottom: 20px;
            }

            .compare-header i {
                font-size: 2.5rem;
            }

            .compare-header h4 {
                font-size: 1.3rem;
            }

            .compare-list li {
                font-size: 0.95rem;
                padding-left: 30px;
                margin-bottom: 14px;
            }
        }

        @media (max-width: 576px) {
            .section-title {
                font-size: 1.5rem;
            }

            .section-intro {
                font-size: 0.95rem;
            }

            .mobile-section-heading {
                font-size: 1.3rem;
            }

            .compare-card {
                padding: 25px 20px;
            }

            .compare-header i {
                font-size: 2rem;
            }

            .compare-header h4 {
                font-size: 1.2rem;
            }

            .compare-list li {
                font-size: 0.9rem;
                padding-left: 28px;
            }
        }

        /* Smooth Fade Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-pane.show {
            animation: fadeIn 0.5s ease;
        }
    </style>


    <!-- Problem Solution Section -->
    <section class="problem-solution-section-tabs">
        <div class="container">
            
            <!-- Section Header -->
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-10">
                    <h2 class="section-title mb-4">Why Most Generic Enablement Programs Don't Work</h2>
                    <p class="section-intro">We deliver a practical, proven, and custom plan, developed after thorough assessments and Gap Analysis. By equipping you with the right processes and tools, we ensure you move forward with clarity and confidence.</p>
                </div>
            </div>

            <!-- Desktop: Tab Navigation (Visible on desktop, hidden on mobile) -->
            <ul class="nav nav-pills nav-custom justify-content-center mb-5" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="professionals-tab" data-target="professionals" type="button">
                        <i class="fas fa-user-tie me-2"></i> For Professionals
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="businesses-tab" data-target="businesses" type="button">
                        <i class="fas fa-building me-2"></i> For Businesses
                    </button>
                </li>
            </ul>

            <!-- Desktop: Tab Content (Visible on desktop, hidden on mobile) -->
            <div class="tab-content" id="myTabContent">
                
                <!-- Professionals Tab -->
                <div class="tab-pane show" id="professionals" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="compare-card problem-side">
                                <div class="compare-header">
                                    <i class="fas fa-times-circle"></i>
                                    <h4>Why Professionals Struggle</h4>
                                </div>
                                <ul class="compare-list">
                                    <li>Poor mindset & procrastination</li>
                                    <li>Lack of right guidance & action</li>
                                    <li>Stagnant career growth</li>
                                    <li>Low personal & market visibility</li>
                                    <li>Skill gaps for next-level roles</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="compare-card solution-side">
                                <div class="compare-header">
                                    <i class="fas fa-check-circle"></i>
                                    <h4>How Elevates Helps</h4>
                                </div>
                                <ul class="compare-list">
                                    <li>Structured mindset & accountability framework</li>
                                    <li>Personalized career guidance with action plans</li>
                                    <li>Clear career growth roadmaps</li>
                                    <li>Personal branding & professional visibility</li>
                                    <li>Functional & future-ready skill development</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Businesses Tab -->
                <div class="tab-pane" id="businesses" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="compare-card problem-side">
                                <div class="compare-header">
                                    <i class="fas fa-times-circle"></i>
                                    <h4>Why Businesses Struggle</h4>
                                </div>
                                <ul class="compare-list">
                                    <li>Unstructured teams & low ownership</li>
                                    <li>Weak sales & value-selling processes</li>
                                    <li>Leadership & execution gaps</li>
                                    <li>Limited market differentiation</li>
                                    <li>Inconsistent growth & scalability issues</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="compare-card solution-side">
                                <div class="compare-header">
                                    <i class="fas fa-check-circle"></i>
                                    <h4>How Elevates Helps</h4>
                                </div>
                                <ul class="compare-list">
                                    <li>Accountability-driven team frameworks</li>
                                    <li>Proven sales & client-handling processes</li>
                                    <li>Leadership & decision-making enablement</li>
                                    <li>Brand positioning & market visibility</li>
                                    <li>Scalable growth & execution roadmaps</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Mobile: Stacked Content (Visible on mobile, hidden on desktop) -->
            <div class="mobile-content-section">
                
                <!-- Professionals Section -->
                <div>
                    <h3 class="mobile-section-heading">
                        <i class="fas fa-user-tie me-2"></i> For Professionals
                    </h3>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="compare-card problem-side">
                                <div class="compare-header">
                                    <i class="fas fa-times-circle"></i>
                                    <h4>Why Professionals Struggle</h4>
                                </div>
                                <ul class="compare-list">
                                    <li>Poor mindset & procrastination</li>
                                    <li>Lack of right guidance & action</li>
                                    <li>Stagnant career growth</li>
                                    <li>Low personal & market visibility</li>
                                    <li>Skill gaps for next-level roles</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="compare-card solution-side">
                                <div class="compare-header">
                                    <i class="fas fa-check-circle"></i>
                                    <h4>How Elevates Helps</h4>
                                </div>
                                <ul class="compare-list">
                                    <li>Structured mindset & accountability framework</li>
                                    <li>Personalized career guidance with action plans</li>
                                    <li>Clear career growth roadmaps</li>
                                    <li>Personal branding & professional visibility</li>
                                    <li>Functional & future-ready skill development</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Businesses Section -->
                <div>
                    <h3 class="mobile-section-heading pt-2">
                        <i class="fas fa-building me-2"></i> For Businesses
                    </h3>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="compare-card problem-side">
                                <div class="compare-header">
                                    <i class="fas fa-times-circle"></i>
                                    <h4>Why Businesses Struggle</h4>
                                </div>
                                <ul class="compare-list">
                                    <li>Unstructured teams & low ownership</li>
                                    <li>Weak sales & value-selling processes</li>
                                    <li>Leadership & execution gaps</li>
                                    <li>Limited market differentiation</li>
                                    <li>Inconsistent growth & scalability issues</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="compare-card solution-side">
                                <div class="compare-header">
                                    <i class="fas fa-check-circle"></i>
                                    <h4>How Elevates Helps</h4>
                                </div>
                                <ul class="compare-list">
                                    <li>Accountability-driven team frameworks</li>
                                    <li>Proven sales & client-handling processes</li>
                                    <li>Leadership & decision-making enablement</li>
                                    <li>Brand positioning & market visibility</li>
                                    <li>Scalable growth & execution roadmaps</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>








    

  
    <!-- Custom Tab Hover Script -->
    <script>
        // Only run on desktop
        if (window.innerWidth >= 768) {
            const tabButtons = document.querySelectorAll('.nav-custom .nav-link');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabButtons.forEach(button => {
                // On hover, show the corresponding tab content
                button.addEventListener('mouseenter', function() {
                    const targetId = this.getAttribute('data-target');
                    
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to hovered button
                    this.classList.add('active');
                    
                    // Hide all tab panes
                    tabPanes.forEach(pane => {
                        pane.classList.remove('show');
                    });
                    
                    // Show target tab pane
                    const targetPane = document.getElementById(targetId);
                    if (targetPane) {
                        targetPane.classList.add('show');
                    }
                });
            });

            // Optional: Click functionality for mobile touch devices
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Hide all tab panes
                    tabPanes.forEach(pane => {
                        pane.classList.remove('show');
                    });
                    
                    // Show target tab pane
                    const targetPane = document.getElementById(targetId);
                    if (targetPane) {
                        targetPane.classList.add('show');
                    }
                });
            });
        }
    </script>




<!-- Alternative Design: Image Background with Overlay Content -->
<section class="questions-section-alt py-5 bg-light">
    <div class="container">
        
        <!-- Section Header -->
      

        <!-- Questions Row -->
        <div class="row g-4 mb-5">
            
            <!-- Professionals Column -->
            <div class="col-lg-6">
                <div class="question-card-overlay" style="background-image: url('img/image.png');">
                    <div class="card-overlay-content">
                        <div class="icon-badge">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h3 class="overlay-title">The Questions Professionals Can't Afford to Ignore</h3>
                        <ul class="overlay-list">
                            <li>Career transition?</li>
                            <li>Dream career & dream life?</li>
                            <li>Job security, stagnant career & layoffs?</li>
                            <li>Limited growth & promotions?</li>
                            <li>Skills & cracking the interviews?</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Businesses Column -->
            <div class="col-lg-6">
                <div class="question-card-overlay" style="background-image: url('img/right.png');">
                    <div class="card-overlay-content">
                        <div class="icon-badge">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3 class="overlay-title">The Questions Businesses Can't Afford to Ignore</h3>
                        <ul class="overlay-list">
                            <li>Sustainable growth?</li>
                            <li>Lead conversion to sales closure?</li>
                            <li>Value selling & customer acquisition?</li>
                            <li>Improved revenue & profit margin?</li>
                            <li>Winning team & leadership skills?</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

       <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-10">
                <h3 class=" mb-3">Whether you’re an individual professional or a growing business, the right guidance changes everything.</h3>
                
            </div>
        </div>

        <!-- CTA Button -->
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <a onclick="openDiscoveryPopup()" class="btn-discover">
                    <span class="btn-text">Book a Discovery Session</span>
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

    </div>
</section>

<!-- Alternative Design: Bordered Cards with Gradient Accents -->
<section class="fall-short-section-alt py-5 bg-light">
    <div class="container">
        
        <!-- Section Header -->
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-10">
                <h2 class="section-title mb-4">Where Generic Enablement Programs Fall Short</h2>
                <p class="section-lead">Elevates provides a practical, proven approach to building strong careers and successful businesses. Our structured processes and tools bring clarity, confidence, and measurable progress.</p>
            </div>
        </div>

        <!-- Grid Row -->
        <div class="row g-4">
            
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="bordered-card">
                    <!-- <div class="number-badge gradient-badge-1">01</div> -->
                    <div class="icon-circle gradient-circle-1">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="bordered-title">Ineffective Assessment</h3>
                    <p class="bordered-text">Generic programs often fail to assess unique needs and skill gaps accurately, resulting in one-size-fits-all approaches that miss the mark.</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="bordered-card">
                    <!-- <div class="number-badge gradient-badge-2">02</div> -->
                    <div class="icon-circle gradient-circle-2">
                        <i class="fas fa-users-slash"></i>
                    </div>
                    <h3 class="bordered-title">Lack of Engagement</h3>
                    <p class="bordered-text">Without understanding what motivates teams, generic programs struggle to capture attention and drive meaningful participation.</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="bordered-card">
                    <!-- <div class="number-badge gradient-badge-3">03</div> -->
                    <div class="icon-circle gradient-circle-3">
                        <i class="fas fa-user-times"></i>
                    </div>
                    <h3 class="bordered-title">No Accountability</h3>
                    <p class="bordered-text">When teams aren't held accountable for progress and outcomes, programs fail to create real change or results.</p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-4 col-md-6">
                <div class="bordered-card">
                    <!-- <div class="number-badge gradient-badge-4">04</div> -->
                    <div class="icon-circle gradient-circle-4">
                        <i class="fas fa-route"></i>
                    </div>
                    <h3 class="bordered-title">No Clear Path</h3>
                    <p class="bordered-text">The absence of a clear roadmap leaves teams feeling lost and unsure how to achieve their goals.</p>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-lg-4 col-md-6">
                <div class="bordered-card">
                    <!-- <div class="number-badge gradient-badge-5">05</div> -->
                    <div class="icon-circle gradient-circle-5">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="bordered-title">Inadequate Monitoring</h3>
                    <p class="bordered-text">Without regular tracking and evaluation, programs miss improvement opportunities and stagnate.</p>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="col-lg-4 col-md-6">
                <div class="bordered-card">
                    <!-- <div class="number-badge gradient-badge-6">06</div> -->
                    <div class="icon-circle gradient-circle-6">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="bordered-title">Insufficient Feedback</h3>
                    <p class="bordered-text">Generic programs often lack timely, relevant feedback, limiting learning and continuous improvement.</p>
                </div>
            </div>

        </div>

    </div>
</section>


    <!-- Features Section -->
    <!-- <section class="features-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="section-title">Why Choose BetterUp?</h2>
                    <p class="lead">Discover the advantages that set us apart</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4>AI-Powered Insights</h4>
                        <p>Leverage cutting-edge artificial intelligence combined with human expertise for personalized coaching experiences.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Expert Coaches</h4>
                        <p>Access a global network of certified coaches with diverse expertise across industries and specializations.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Measurable Results</h4>
                        <p>Track your progress with data-driven insights and see real, quantifiable improvements in performance.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h4>Secure & Confidential</h4>
                        <p>Your privacy is our priority. All coaching sessions and data are protected with enterprise-grade security.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Anytime, Anywhere</h4>
                        <p>Access coaching through our mobile app or web platform, fitting seamlessly into your schedule.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4>Proven Success</h4>
                        <p>Join thousands of satisfied clients who have transformed their careers and lives through our platform.</p>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Stats Section -->
   

    <!-- Alternative Design: Horizontal Cards with Image Backgrounds -->
<!-- <section class="build-success-alt py-5">
    <div class="container">
        
      
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-10">
                <h2 class="section-title mb-4">How do I build a successful career & thriving business?</h2>
                <p class="section-lead">Learn how Elevates helps early & mid-career professionals grow with clarity, confidence, and proven execution.</p>
            </div>
        </div>

       
        <div class="growth-section career-section mb-5">
            <div class="section-badge">
                <i class="fas fa-briefcase me-2"></i>
                Career Growth
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="horizontal-card card-purple">
                        <div class="h-card-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div class="h-card-content">
                            <h5>Transform Your Career</h5>
                            <p>Move from average to top performer by building the right mindset, core skills, and a strong professional identity.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="horizontal-card card-purple">
                        <div class="h-card-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="h-card-content">
                            <h5>Practical Knowledge & Proven Frameworks</h5>
                            <p>Learn field-tested frameworks from experienced mentors and industry leaders with real execution expertise.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="horizontal-card card-purple">
                        <div class="h-card-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="h-card-content">
                            <h5>Unlock Your Success</h5>
                            <p>Get clarity, speed, and direction to achieve meaningful success in your career and life.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="growth-section business-section">
            <div class="section-badge badge-pink">
                <i class="fas fa-building me-2"></i>
                Business Growth
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="horizontal-card card-pink">
                        <div class="h-card-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="h-card-content">
                            <h5>Transform Your Business</h5>
                            <p>Tailor-made coaching and consulting for SMBs, focused on People, Process, and Sustainable Business Growth.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="horizontal-card card-pink">
                        <div class="h-card-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="h-card-content">
                            <h5>Unlock Your Business Potential</h5>
                            <p>Solve core business challenges, build leadership capability, and create long-term competitive advantage.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="horizontal-card card-pink">
                        <div class="h-card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="h-card-content">
                            <h5>Learn from Experts & Industry Leaders</h5>
                            <p>Build an exclusive and trusted brand using proven strategies that scale in competitive markets.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section> -->

<!-- CSS for Alternative Design -->
<!-- <style>
.build-success-alt {
    background: white;
}

.growth-section {
    position: relative;
    padding: 40px 30px;
    border-radius: 20px;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.section-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #99138a 0%, #764ba2 100%);
    color: white;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 30px;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
}

.badge-pink {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    box-shadow: 0 5px 20px rgba(245, 87, 108, 0.3);
}

.horizontal-card {
    display: flex;
    gap: 20px;
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.horizontal-card:hover {
    transform: translateX(5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.h-card-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.8rem;
    color: white;
}

.card-purple .h-card-icon {
    background: linear-gradient(135deg, #99138a 0%, #764ba2 100%);
}

.card-pink .h-card-icon {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.h-card-content h5 {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.h-card-content p {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.6;
    margin: 0;
}

@media (max-width: 991px) {
    .horizontal-card {
        flex-direction: column;
        text-align: center;
    }
    
    .h-card-icon {
        margin: 0 auto;
    }
}
</style> -->

<section class="build-success-alt py-5">
    <div class="container">
        
        <!-- Section Header -->
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-10">
                <h2 class="section-title mb-4">How do I build a successful career & thriving business?</h2>
                <p class="section-lead">Learn how Elevates helps early & mid-career professionals grow with clarity, confidence, and proven execution.</p>
            </div>
        </div>

        <!-- Two Column Layout: Career Left, Business Right -->
        <div class="row g-5 align-items-start">
            
            <!-- Left Side: Career Growth -->
            <div class="col-lg-6">
                <div class="growth-section career-section">
                    <div class="section-badge">
                        <i class="fas fa-briefcase me-2"></i>
                        Career Growth
                    </div>
                    
                    <div class="vertical-cards">
                        <div class="horizontal-card card-purple mb-4">
                            <div class="h-card-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div class="h-card-content">
                                <h5>Transform Your Career</h5>
                                <p>Move from average to top performer by building the right mindset, core skills, and a strong professional identity.</p>
                            </div>
                        </div>
                        
                        <div class="horizontal-card card-purple mb-4">
                            <div class="h-card-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="h-card-content">
                                <h5>Practical Knowledge & Proven Frameworks</h5>
                                <p>Learn field-tested frameworks from experienced mentors and industry leaders with real execution expertise.</p>
                            </div>
                        </div>
                        
                        <div class="horizontal-card card-purple">
                            <div class="h-card-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="h-card-content">
                                <h5>Unlock Your Success</h5>
                                <p>Get clarity, speed, and direction to achieve meaningful success in your career and life.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Side: Business Growth -->
            <div class="col-lg-6">
                <div class="growth-section business-section">
                    <div class="section-badge badge-pink">
                        <i class="fas fa-building me-2"></i>
                        Business Growth
                    </div>
                    
                    <div class="vertical-cards">
                        <div class="horizontal-card card-pink mb-4">
                            <div class="h-card-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="h-card-content">
                                <h5>Transform Your Business</h5>
                                <p>Tailor-made coaching and consulting for SMBs, focused on People, Process, and Sustainable Business Growth.</p>
                            </div>
                        </div>
                        
                        <div class="horizontal-card card-pink mb-4">
                            <div class="h-card-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="h-card-content">
                                <h5>Unlock Your Business Potential</h5>
                                <p>Solve core business challenges, build leadership capability, and create long-term competitive advantage.</p>
                            </div>
                        </div>
                        
                        <div class="horizontal-card card-pink">
                            <div class="h-card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="h-card-content">
                                <h5>Learn from Experts & Industry Leaders</h5>
                                <p>Build an exclusive and trusted brand using proven strategies that scale in competitive markets.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
</section>



    <style>
        :root {
            --primary-color: #007bff;
            --text-dark: #333;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Testimonials Section */
        .testimonials-section {
            background: white;
            padding: 80px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .lead {
            color: #666;
            font-size: 1.1rem;
        }

        /* Testimonial Card */
        .testimonial-card {
            background: white;
            padding: 35px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            margin: 10px;
            flex: 1 1 auto;
            min-height: 320px; /* ensure a baseline so cards look uniform */
        }

        /* Make swiper slides stretch so cards get equal height */
        .testimonials-swiper .swiper-wrapper {
            align-items: stretch;
        }

        .testimonials-swiper .swiper-slide {
            display: flex;
            height: auto;
        }

        .testimonial-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .testimonial-rating {
            color: #ffc107;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .testimonial-text {
            color: #555;
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 25px;
            font-style: italic;
            flex-grow: 1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .testimonial-author img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            background: #f0f0f0;
        }

        .testimonial-author h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 3px;
        }

        .testimonial-author p {
            font-size: 0.85rem;
            color: #999;
            margin-bottom: 0;
        }

        /* Swiper: Arrows + Dots in one row (same as What We Do) */
        .testimonials-swiper {
            padding: 20px 0 100px 0;
            position: relative;
        }

        .testimonials-pagination {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 30px;
            width: auto;
            padding: 20px;
        }

        .testimonials-dots-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .testimonials-pagination .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #ddd;
            opacity: 1;
            transition: var(--transition);
            margin: 0;
            cursor: pointer;
            border: none;
            border-radius: 50%;
        }

        .testimonials-pagination .swiper-pagination-bullet-active {
            background: #99138a;
            width: 30px;
            border-radius: 6px;
        }

        .testimonials-button-prev,
        .testimonials-button-next {
            color: #99138a;
            background: #fff;
            width: 50px;
            height: 50px;
            min-width: 50px;
            min-height: 50px;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            z-index: 10;
            padding: 0;
            appearance: none;
            -webkit-appearance: none;
        }

        .testimonials-button-prev svg,
        .testimonials-button-next svg {
            width: 24px;
            height: 24px;
            stroke: #99138a;
            pointer-events: none;
        }

        .testimonials-button-prev:hover,
        .testimonials-button-next:hover {
            background: #99138a;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .testimonials-button-prev:hover svg,
        .testimonials-button-next:hover svg {
            stroke: #fff;
        }

        /* CTA Button */
        .btn-discover {
            display: inline-flex;
            align-items: center;
            padding: 15px 35px;
            background: linear-gradient(135deg, #6a0dad, #a9167e);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-discover:hover {
            background: linear-gradient(135deg, #6a0dad, #a9167e);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
        }

        .btn-discover i {
            transition: var(--transition);
        }

        .btn-discover:hover i {
            transform: translateX(5px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .section-title {
                font-size: 2rem;
            }

            .swiper-button-next,
            .swiper-button-prev {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .testimonials-section {
                padding: 60px 0;
            }

            .section-title {
                font-size: 1.75rem;
            }

            .testimonial-card {
                padding: 25px 20px;
            }

            .btn-discover {
                padding: 12px 25px;
                font-size: 0.95rem;
            }

            /* Hide arrows on mobile - same as What We Do */
            .testimonials-button-next,
            .testimonials-button-prev {
                display: none !important;
            }
        }

        @media (max-width: 576px) {
            .testimonial-author {
                flex-direction: column;
                text-align: center;
            }

            .testimonial-author img {
                width: 70px;
                height: 70px;
            }
        }
    </style>


    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="section-title">What Our Clients Say</h2>
                    <p class="lead">Real stories from real people who transformed their lives</p>
                </div>
            </div>

            <?php
            $testimonials = [];
            if (isset($mysqli)) {
                $stmt = $mysqli->prepare("SELECT * FROM testimonials WHERE status = 'published' ORDER BY created_at DESC");
                if ($stmt) {
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_assoc()) {
                        $testimonials[] = $row;
                    }
                    $stmt->close();
                }
            }
            // Fallback: static slides when no published testimonials (same layout as DB-driven cards)
            if (empty($testimonials)) {
                $testimonials = [
                    [
                        'name' => 'Priya S.',
                        'role' => 'Senior Analyst',
                        'company' => 'Financial Services',
                        'text' => "The coaching sessions gave me clarity on my strengths and a concrete plan for my next role. I felt supported at every step.",
                        'rating' => 5,
                        'photo_url' => '',
                    ],
                    [
                        'name' => 'Rahul M.',
                        'role' => 'Engineering Lead',
                        'company' => 'Technology',
                        'text' => "Elevates helped our team align on goals and communication. The approach was practical and immediately useful at work.",
                        'rating' => 5,
                        'photo_url' => '',
                    ],
                    [
                        'name' => 'Neha K.',
                        'role' => 'Founder',
                        'company' => 'SMB',
                        'text' => "As a small business owner, I needed structure and accountability. The mentoring helped me prioritise and grow with confidence.",
                        'rating' => 5,
                        'photo_url' => '',
                    ],
                    [
                        'name' => 'Vikram D.',
                        'role' => 'Sales Manager',
                        'company' => 'B2B',
                        'text' => "Professional, result-oriented, and genuinely invested in outcomes. I recommend Elevates to anyone looking to level up their career.",
                        'rating' => 5,
                        'photo_url' => '',
                    ],
                ];
            }
            ?>

            <?php if (!empty($testimonials)): ?>
            <!-- Swiper Slider -->
            <div class="swiper testimonials-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($testimonials as $t): ?>
                        <div class="swiper-slide">
                            <div class="testimonial-card">
                                <div class="testimonial-rating">
                                    <?php
                                    $stars = max(1, min(5, (int)($t['rating'] ?? 5)));
                                    for ($i = 0; $i < $stars; $i++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="testimonial-text"><?= nl2br(htmlspecialchars($t['text'])) ?></p>
                                <div class="testimonial-author">
                                    <?php
                                    $nameForAvatar = urlencode($t['name'] ?: 'Client');
                                    $avatarFallback = "https://ui-avatars.com/api/?name={$nameForAvatar}&size=60&background=007bff&color=fff";
                                    $photo = trim($t['photo_url'] ?? '');
                                    $photoSrc = $photo !== '' ? htmlspecialchars($photo) : $avatarFallback;
                                    ?>
                                    <img src="<?= $photoSrc ?>" alt="<?= htmlspecialchars($t['name']) ?>" onerror="this.src='<?= $avatarFallback ?>'">
                                    <div>
                                        <h5><?= htmlspecialchars(strtoupper($t['name'])) ?></h5>
                                        <p>
                                            <?= htmlspecialchars($t['role']) ?>
                                            <?php if (!empty($t['company'])): ?>
                                                <?= $t['role'] ? ' - ' : '' ?><?= htmlspecialchars($t['company']) ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination with Navigation Buttons (same as What We Do) -->
                <div class="testimonials-pagination">
                    <button class="testimonials-button-prev" type="button" aria-label="Previous">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>
                    <div class="testimonials-dots-container"></div>
                    <button class="testimonials-button-next" type="button" aria-label="Next">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
            <?php endif; ?>

            <!-- CTA Button -->
            <div class="row justify-content-center mt-5">
                <div class="col-lg-6 text-center">
                    <a href="contact-us.php" class="btn-discover">
                        <span class="btn-text">See how Elevates can support your journey.</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Initialize Swiper -->
    <script>
        const swiper = new Swiper('.testimonials-swiper', {
            // Slider parameters
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            
            // Autoplay
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            
            // Speed
            speed: 800,
            
            // Pagination (dots - same as What We Do)
            pagination: {
                el: '.testimonials-dots-container',
                clickable: true,
            },
            
            // Navigation arrows (same as What We Do)
            navigation: {
                nextEl: '.testimonials-button-next',
                prevEl: '.testimonials-button-prev',
            },
            
            // Responsive breakpoints
            breakpoints: {
                // When window width is >= 768px
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                // When window width is >= 1024px
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
            
            // Accessibility
            a11y: {
                enabled: true,
            },
        });
    </script>



    <!-- Latest Blog Posts -->
    <!-- <section class="home-blog-section py-5 bg-light">
        <div class="container">
            <div class="row justify-content-between align-items-center mb-5">
                <div class="col-lg-6">
                    <h2 class="section-title">Latest Insights</h2>
                    <p class="lead">Stay updated with our latest articles and resources</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="blog.html" class="btn btn-outline-primary">View All Articles</a>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600" alt="Blog Post">
                            <span class="blog-category-tag leadership">Leadership</span>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta mb-3">
                                <span><i class="far fa-calendar"></i> Dec 20, 2025</span>
                                <span><i class="far fa-clock"></i> 8 min</span>
                            </div>
                            <h3 class="blog-title">The Future of Leadership: How AI is Transforming Workplace</h3>
                            <p class="blog-excerpt">Discover how artificial intelligence is reshaping leadership strategies.</p>
                            <a href="blog-detail.html" class="blog-link">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="img/blog2.png" alt="Blog Post">
                            <span class="blog-category-tag">Coaching</span>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta mb-3">
                                <span><i class="far fa-calendar"></i> Dec 18, 2025</span>
                                <span><i class="far fa-clock"></i> 5 min</span>
                            </div>
                            <h3 class="blog-title">5 Essential Coaching Techniques for Personal Growth</h3>
                            <p class="blog-excerpt">Learn powerful methods to unlock your potential and achieve goals.</p>
                            <a href="blog-detail.html" class="blog-link">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=600" alt="Blog Post">
                            <span class="blog-category-tag wellness">Wellness</span>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta mb-3">
                                <span><i class="far fa-calendar"></i> Dec 15, 2025</span>
                                <span><i class="far fa-clock"></i> 6 min</span>
                            </div>
                            <h3 class="blog-title">Building Resilience: A Guide to Mental Wellness at Work</h3>
                            <p class="blog-excerpt">Practical strategies to maintain mental health in work environments.</p>
                            <a href="blog-detail.html" class="blog-link">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- FAQ Section -->
   <section class="faq-section py-5">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="lead">Got questions? We've got answers</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                What is Elevates and who is it for?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Elevates is a personalized coaching and mentorship platform designed to help early and mid-career professionals grow confidently in their careers and small to medium business owners scale and lead with clarity. For individuals, sessions are delivered 100% remotely, while business programs can include hybrid formats (online + in-person) based on your needs.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Who are Elevates coaches and mentors?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Elevates coaches and mentors are experienced industry professionals and leaders who bring real world insights and practical frameworks to help you grow. They guide you with proven strategies tailored to your unique goals whether career acceleration or business leadership.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                What areas do your coaching and mentorship cover?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Elevates supports growth in multiple areas, including career development, value selling, mental wellness, personality development, leadership &amp; communication skills, personal branding, team performance, business processes, and revenue growth strategies all structured around your goals.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                How is Elevates different from traditional training programs or courses?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Unlike standard programs, Elevates offers personalized coaching and mentorship, focusing on your individual challenges and goals. The programs are practical, actionable, and tailored as per the requirements which makes real progress faster.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                What results can I expect from working with Elevates?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can expect clear direction, enhanced confidence, measurable progress, and practical tools to accelerate your career or grow your business. Professionals often see growth in performance, decision-making, and opportunities, while businesses see better team performance and structured growth.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                Are the sessions conducted online or offline?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                For individual B2C clients, all coaching and mentorship sessions are conducted remotely online for convenience and flexibility. For B2B / business programs, formats can be hybrid combining remote sessions with optional in person meetings as needed.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                Can coaching be customized for my specific career stage or business size?
                            </button>
                        </h2>
                        <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes. Every engagement is personalized based on your goals and stage. Early and mid-career professionals receive focused guidance on growth, clarity, and leadership, while businesses get strategic mentorship tailored to their size, challenges, and growth objectives.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                                How flexible are the coaching schedules?
                            </button>
                        </h2>
                        <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Coaching schedules are designed to be flexible and convenient. Sessions are planned around your availability, making it easy for working professionals and business owners to stay consistent without disrupting their daily commitments.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                                Will Elevates help me gain clarity on my career direction?
                            </button>
                        </h2>
                        <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes. Elevates customizes every coaching engagement based on your career stage or business size. Whether you are an early-career professional, a mid-career leader, or a growing business, the approach, tools, and goals are tailored to your specific challenges and aspirations.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">
                                What makes Elevates suitable for small and medium businesses?
                            </button>
                        </h2>
                        <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Elevates understands the real world challenges of growing businesses. The mentorship is practical, growth focused, and tailored to your stage without overwhelming you with rigid or overly complex corporate frameworks.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq11">
                                How can I approach Team Elevates?
                            </button>
                        </h2>
                        <div id="faq11" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Please provide details in Registration section or Book a Discovery Session or email us at success@elevates.pro
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Contact Form Section -->
    <section class="home-contact-section py-5 bg-light">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h2 class="section-title mb-4">All That changes when you join Elevates</h2>
                    <p class="lead mb-4">If you want to learn more, enrol for a complimentary 15-day email learning to start building a successful career and business which would just take daily 5 mins to start small and yet a powerful step in your transformational journey</p>
                    <div class="contact-info-list">
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h5>Call Us</h5>
                                 <p>
                        +91 9667309208<br>
                        +91 9717393173<br>
                        +91 9910805621</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h5>Email Us</h5>
                                <p>info@elevates.pro</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h5>Visit Us</h5>
                                <p>Level 5, Tower C, Green Boulevard, Block B, <br>Sector 62, Noida, Uttar Pradesh 201309</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form-box">
                        <h3 class="mb-4">Send us a Message</h3>
                         <form id="homeContactForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="first_name" placeholder="First Name *" required>
                                <div class="invalid-feedback">Required</div>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" placeholder="Last Name *" required>
                                <div class="invalid-feedback">Required</div>
                            </div>
                            <div class="col-12">
                                <input type="email" class="form-control" name="email" placeholder="Email Address *" required>
                                <div class="invalid-feedback">Valid email required</div>
                            </div>
                            <div class="col-12">
                                <input type="tel" class="form-control" name="phone" placeholder="Phone Number">
                            </div>
                            <div class="col-12">
                                <select class="form-select" name="subject" required>
                                    <option value="">I'm interested in... *</option>
                                    <option value="individual">Individual Professional</option>
                                    <option value="business">Business owners</option>
                                </select>
                                <div class="invalid-feedback">Please select an option</div>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" name="message" rows="4" placeholder="Your Message *" required></textarea>
                                <div class="invalid-feedback">Message required</div>
                            </div>
                            <input type="hidden" name="source" value="home-page">
                            
                            <!-- Message appears here -->
                            <div class="col-12">
                                <div id="homeFormMessage"></div>
                            </div>
                            
                            <div class="col-12">
                                <button type="submit" class="btn btn-demo w-100" id="homeSubmitBtn">
                                    <span id="homeBtnText">Send Message</span>
                                    <span id="homeBtnSpinner" class="spinner-border spinner-border-sm d-none ms-2" role="status"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


<script>
// AJAX Form Submission for Home Form - NO PAGE RELOAD
document.getElementById('homeContactForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Stop normal form submission
    
    const form = this;
    const formData = new FormData(form);
    const messageDiv = document.getElementById('homeFormMessage');
    const submitBtn = document.getElementById('homeSubmitBtn');
    const btnText = document.getElementById('homeBtnText');
    const btnSpinner = document.getElementById('homeBtnSpinner');
    
    // Validate form
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }
    
    // Show loading
    btnText.textContent = 'Sending...';
    btnSpinner.classList.remove('d-none');
    submitBtn.disabled = true;
    messageDiv.innerHTML = '';
    
    // Send AJAX request
    fetch('save_enquiry.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Check response
        if (data.includes('success') || data.includes('Success') || data.trim() === '1') {
            // Success
            messageDiv.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> 
                    <strong>Success!</strong> We'll contact you soon.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
            
        } else {
            // Error
            messageDiv.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>Error!</strong> Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            const alert = messageDiv.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => messageDiv.innerHTML = '', 150);
            }
        }, 5000);
        
    })
    .catch(error => {
        // Network error
        messageDiv.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-times-circle"></i> 
                <strong>Error!</strong> Network error. Please check your connection.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    })
    .finally(() => {
        // Reset button
        btnText.textContent = 'Send Message';
        btnSpinner.classList.add('d-none');
        submitBtn.disabled = false;
    });
});
</script>

    <!-- Home Page Lead Popup (20s or 50% scroll) -->
    <div class="modal fade" id="homeLeadPopup" tabindex="-1" aria-labelledby="homeLeadPopupLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable home-lead-popup-dialog">
            <div class="modal-content home-lead-popup-content">
                <div class="home-lead-popup-header">
                    <div class="home-lead-popup-header-inner">
                        <span class="home-lead-popup-icon"><i class="fas fa-handshake"></i></span>
                        <div>
                        <h5 class="home-lead-popup-title" id="homeLeadPopupLabel">Let's Connect</h5>
                        <p class="home-lead-popup-subtitle">Share your details and we'll get in touch</p>
                        </div>
                        
                    </div>
                    <button type="button" class="home-lead-popup-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <div class="home-lead-popup-body">
                    <div class="home-lead-popup-grid">
                        <div class="home-lead-contact-col">
                            <h6 class="home-lead-contact-title">Let’s connect on WhatsApp.</h6>
                            <p class="home-lead-contact-text"> Just type “Hi” to get started.
                            Chat with our team by clicking the button below or scan the QR code for quick AI-powered assistance.</p>
                            <a href="https://wa.me/919311799336" target="_blank" rel="noopener noreferrer" class="home-lead-chat-btn">
                                <i class="fab fa-whatsapp"></i>
                                Start WhatsApp Chat
                            </a>
                            <div class="home-lead-qr-box">
                                <img src="img/whatsap-qr.jpeg" alt="Elevates WhatsApp QR Code" class="home-lead-qr-image">
                            </div>
                        </div>
                        <div class="home-lead-form-col">
                            <form id="homeLeadPopupForm">
                                <div class="home-lead-field">
                                    <input type="text" class="home-lead-input" id="popupName" name="name" required placeholder="Name *">
                                </div>
                                <div class="home-lead-row-2col">
                                    <div class="home-lead-field">
                                        <input type="email" class="home-lead-input" id="popupEmail" name="email" required placeholder="Email *">
                                    </div>
                                    <div class="home-lead-field">
                                        <input type="tel" class="home-lead-input" id="popupNumber" name="number" required placeholder="Phone Number *">
                                    </div>
                                </div>
                                <div class="home-lead-field mt-3">
                                    <label class="home-lead-label">Program Selection <span class="text-danger">*</span></label>
                                    <div class="home-lead-program-options">
                                        <label class="home-lead-radio-card">
                                            <input type="radio" name="program" value="Individual" required>
                                            <span class="home-lead-radio-inner"><i class="fas fa-user"></i> Individual</span>
                                        </label>
                                        <label class="home-lead-radio-card">
                                            <input type="radio" name="program" value="Business">
                                            <span class="home-lead-radio-inner"><i class="fas fa-briefcase"></i> Business</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="home-lead-field">
                                    <label class="home-lead-consent-label">
                                        <input type="checkbox" name="data_consent" required>
                                        <span style="font-size: 0.7rem; ">I agree to share my information with Elevates considering the fact that my data will be kept secret and will not be shared with any third party without my permission.</span>
                                    </label>
                                </div>
                                <div class="home-lead-whatsapp-row">
                                    <span class="home-lead-whatsapp-label"><i class="fab fa-whatsapp text-success me-2"></i> Connect on WhatsApp?</span>
                                    <label class="home-lead-toggle">
                                        <input type="checkbox" id="popupWhatsAppToggle" name="whatsapp_connect" checked disabled>
                                        <span class="home-lead-toggle-slider"></span>
                                    </label>
                                </div>

                                <button type="submit" class="home-lead-submit-btn">Submit</button>
                                <div class="col-12">
                                    <div id="homeLeadPopupMessage"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .home-lead-popup-dialog { max-width: 920px; }
        .home-lead-popup-content { border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 80px rgba(0,0,0,0.2); }
        .home-lead-popup-header { background: linear-gradient(135deg, #6a0dad 0%, #a9167e 100%); color: #fff; padding: 28px 24px 24px; position: relative; }
        .home-lead-popup-header-inner { padding-right: 36px; display:flex; gap:10px; }
        .home-lead-popup-icon { width: 52px; height: 52px; background: rgba(255,255,255,0.2); border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 12px; }
        .home-lead-popup-title { font-size: 1.5rem; font-weight: 700; margin: 0 0 6px; font-family: 'Playfair Display', serif; }
        .home-lead-popup-subtitle { font-size: 0.9rem; opacity: 0.9; margin: 0; }
        .home-lead-popup-close { position: absolute; top: 20px; right: 20px; width: 40px; height: 40px; border: none; background: rgba(255,255,255,0.2); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s; }
        .home-lead-popup-close:hover { background: rgba(255,255,255,0.35); color: #fff; }
        .home-lead-popup-body { padding: 18px 14px 12px; }
        .home-lead-popup-grid { display: grid; grid-template-columns: minmax(260px, 0.9fr) minmax(0, 1.1fr); gap: 16px; align-items: start; }
        .home-lead-contact-col { background: linear-gradient(180deg, #f7f3ff 0%, #ffffff 100%); border: 1px solid #ece3fb; border-radius: 16px; padding: 16px; }
        .home-lead-contact-title { margin: 0 0 8px; font-size: 1.1rem; font-weight: 700; color: #3f2365; }
        .home-lead-contact-text { margin: 0 0 14px; color: #5f5b6b; font-size: 0.92rem; line-height: 1.5; }
        .home-lead-chat-btn { width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 14px; background: #25d366; border-radius: 12px; color: #fff; font-weight: 600; text-decoration: none; }
        .home-lead-chat-btn:hover { color: #fff; background: #1faf55; }
        .home-lead-qr-box { margin-top: 14px; border-radius: 12px; border: 1px solid #e7e7e7; background: #fff; padding: 10px; text-align: center; }
        .home-lead-qr-image { width: 100%; max-width: 220px; height: auto; border-radius: 8px; }
        .home-lead-form-col { border: 1px solid #efefef; border-radius: 16px; padding: 14px; background: #fff; }
        .home-lead-field { margin-bottom: 10px; }
        .home-lead-row-2col { display:flex; gap:12px; }
        .home-lead-row-2col .home-lead-field { flex:1; margin-bottom:0; }
        .home-lead-label { display: block; font-size: 0.9rem; font-weight: 600; color: #333; margin-bottom: 8px; }
        .home-lead-input { width: 100%; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 12px; font-size: 1rem; transition: border-color 0.2s, box-shadow 0.2s; }
        .home-lead-input:focus { outline: none; border-color: #6a0dad; box-shadow: 0 0 0 3px rgba(106, 13, 173, 0.15); }
        .home-lead-input::placeholder { color: #999; }
        .home-lead-program-options { display: flex; gap: 12px; flex-wrap: wrap; }
        .home-lead-radio-card { flex: 1; min-width: 120px; cursor: pointer; margin: 0; }
        .home-lead-radio-card input { position: absolute; opacity: 0; }
        .home-lead-radio-inner { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 14px 16px; border: 2px solid #e8e8e8; border-radius: 12px; font-weight: 500; color: #555; transition: all 0.2s; }
        .home-lead-radio-card input:checked + .home-lead-radio-inner { border-color: #6a0dad; background: rgba(106, 13, 173, 0.08); color: #6a0dad; }
        .home-lead-radio-card:hover .home-lead-radio-inner { border-color: #ccc; }
        .home-lead-whatsapp-row { display: flex; align-items: center; justify-content: space-between; padding: 18px 20px; background: #f8f9fa; border-radius: 14px; margin-bottom: 24px; }
        .home-lead-whatsapp-label { font-weight: 600; color: #333; font-size: 0.95rem; }
        .home-lead-toggle { position: relative; display: inline-block; width: 52px; height: 28px; }
        .home-lead-toggle input { opacity: 0; width: 0; height: 0; }
        .home-lead-toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: #ccc; border-radius: 28px; transition: 0.3s; }
        .home-lead-toggle-slider:before { position: absolute; content: ""; height: 22px; width: 22px; left: 3px; bottom: 3px; background: #fff; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.2); transition: 0.3s; }
        .home-lead-toggle input:checked + .home-lead-toggle-slider { background: #25D366; }
        .home-lead-toggle input:checked + .home-lead-toggle-slider:before { transform: translateX(24px); }
        .home-lead-submit-btn { width: 100%; padding: 16px 24px; background: linear-gradient(135deg, #6a0dad 0%, #a9167e 100%); color: #fff; border: none; border-radius: 14px; font-size: 1.05rem; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
        .home-lead-submit-btn:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(106, 13, 173, 0.4); }
        @media (max-width: 991.98px) {
            .home-lead-popup-dialog { max-width: 680px; }
            .home-lead-popup-grid { grid-template-columns: 1fr; }
            .home-lead-qr-image { max-width: 180px; }
        }
        @media (max-width: 575.98px) {
            #homeLeadPopup .modal-dialog {
                margin: 0.5rem;
                max-height: calc(100vh - 1rem);
            }

            #homeLeadPopup .modal-content {
                max-height: calc(100vh - 1rem);
                overflow: hidden;
            }

            #homeLeadPopup .modal-body,
            #homeLeadPopup .home-lead-popup-body {
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .home-lead-popup-header { padding: 16px 14px 14px; }
            .home-lead-popup-close { top: 14px; right: 14px; width: 34px; height: 34px; }
            .home-lead-popup-icon { width: 42px; height: 42px; font-size: 1.05rem; border-radius: 10px; margin-bottom: 8px; }
            .home-lead-popup-title { font-size: 1.15rem; margin-bottom: 3px; }
            .home-lead-popup-subtitle { font-size: 0.8rem; }
            .home-lead-popup-body { padding: 10px 8px 8px; }
            .home-lead-form-col, .home-lead-contact-col { padding: 10px; border-radius: 12px; }
            .home-lead-contact-title { font-size: 0.95rem; margin-bottom: 4px; }
            .home-lead-contact-text { font-size: 0.8rem; margin-bottom: 10px; line-height: 1.35; }
            .home-lead-chat-btn { padding: 10px 12px; font-size: 0.88rem; border-radius: 10px; }
            .home-lead-field { margin-bottom: 8px; }
            .home-lead-row-2col { flex-direction: column; gap: 8px; }
            .home-lead-input { padding: 10px 12px; font-size: 0.9rem; border-radius: 10px; }
            .home-lead-label { font-size: 0.82rem; margin-bottom: 6px; }
            .home-lead-radio-inner { padding: 10px 12px; font-size: 0.85rem; border-radius: 10px; }
            .home-lead-whatsapp-row { padding: 10px 10px; margin-bottom: 12px; border-radius: 10px; }
            .home-lead-whatsapp-label { font-size: 0.82rem; }
            .home-lead-consent-label span { font-size: 0.64rem !important; line-height: 1.35; display: inline-block; }
            .home-lead-submit-btn { padding: 11px 14px; font-size: 0.92rem; border-radius: 10px; }
            .home-lead-qr-box { display: block; margin-top: 10px; padding: 8px; }
            .home-lead-qr-image { max-width: 140px; }
        }
    </style>
    <script>
(function() {
    var POPUP_KEY = 'elevate_home_lead_popup_shown';
    var popupShown = false;
    var scrollTargetReached = false;
    var timeTargetReached = false;
    var startTime = Date.now();
    var timerId = null;

    function tryShowPopup() {
        if (popupShown) return;
        if (sessionStorage.getItem(POPUP_KEY)) return;
        if (!scrollTargetReached && !timeTargetReached) return;

        popupShown = true;
        sessionStorage.setItem(POPUP_KEY, '1');
        var el = document.getElementById('homeLeadPopup');
        if (el) {
            var modal = new bootstrap.Modal(el);
            modal.show();
        }
    }

    function onScroll() {
        var doc = document.documentElement;
        var scrollTop = window.pageYOffset || doc.scrollTop;
        var scrollHeight = (doc.scrollHeight - window.innerHeight) || 1;
        var pct = (scrollTop / scrollHeight) * 100;
        if (pct >= 50) {
            scrollTargetReached = true;
            tryShowPopup();
        }
    }

    function onTime() {
        timeTargetReached = true;
        tryShowPopup();
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    timerId = setTimeout(onTime, 20000);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            onScroll();
            if ((Date.now() - startTime) >= 20000) onTime();
        });
    } else {
        onScroll();
    }
})();
document.getElementById('homeLeadPopupForm') && document.getElementById('homeLeadPopupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    var messageDiv = document.getElementById('homeLeadPopupMessage');
    if (messageDiv) messageDiv.innerHTML = '';

    // Map popup form fields -> enquiries table required fields (save_enquiry.php)
    var popupName = (form.name && form.name.value ? form.name.value : '').trim();
    var popupEmail = (form.email && form.email.value ? form.email.value : '').trim();
    var popupPhone = (form.number && form.number.value ? form.number.value : '').trim();
    var popupProgram = (form.program && form.program.value ? form.program.value : '').trim();
    var popupConsent = form.data_consent ? !!form.data_consent.checked : false;

    var formData = new FormData();
    formData.append('first_name', popupName);
    formData.append('last_name', '');
    formData.append('email', popupEmail);
    formData.append('phone', popupPhone);
    formData.append('company', '');
    formData.append('subject', 'Home Lead - ' + (popupProgram || 'Program'));
    formData.append(
        'message',
        'Program: ' + (popupProgram || 'Program') + '\n' +
        'Consent: ' + (popupConsent ? 'Yes' : 'No')
    );
    formData.append('source', 'home-lead-popup');

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_enquiry.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = (xhr.responseText || '').trim();
            if (response === 'success' || response.includes('success')) {
                var modal = bootstrap.Modal.getInstance(document.getElementById('homeLeadPopup'));
                if (modal) modal.hide();
                form.reset();
            } else {
                if (messageDiv) {
                    messageDiv.innerHTML =
                        '<div class="alert alert-danger alert-dismissible fade show">' +
                        '<i class="fas fa-exclamation-triangle"></i> <strong>Error!</strong> Please try again.' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>';
                }
            }
        } else {
            if (messageDiv) {
                messageDiv.innerHTML =
                    '<div class="alert alert-danger alert-dismissible fade show">' +
                    '<i class="fas fa-times-circle"></i> <strong>Error!</strong> Network error.' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                    '</div>';
            }
        }
    };
    xhr.onerror = function() {
        if (messageDiv) {
            messageDiv.innerHTML =
                '<div class="alert alert-danger alert-dismissible fade show">' +
                '<i class="fas fa-times-circle"></i> <strong>Error!</strong> Network error.' +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                '</div>';
        }
    };

    xhr.send(formData);
});
    </script>

    <!-- Our Presence Section: proper SVG world map + stable labels -->
    <!-- <style>
    .presence-section { background: #ffffff !important; position: relative; overflow: hidden; padding: 60px 0 !important; }
    .presence-section-title { font-family: 'Playfair Display', serif !important; font-size: 2.75rem !important; font-weight: 700 !important; color: #1e293b !important; margin-bottom: 12px !important; }
    .presence-section-subtitle { font-size: 1.1rem !important; color: #64748b !important; margin: 0 !important; }
    .presence-map-wrap { position: relative; max-width: 960px; margin: 0 auto 24px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.06); background: #fafafa; aspect-ratio: 1000/500; border: 1px solid #e5e7eb; }
    .presence-map-svg { width: 100% !important; height: 100% !important; display: block !important; object-fit: cover; }
    .presence-map-img { opacity: 0.5; }
    .presence-dot { fill: #dc2626; }
    .presence-marker { pointer-events: none; }
    .presence-label-name { font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; fill: #374151; pointer-events: none; }
    .presence-label-line2 { font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 400; fill: #6b7280; pointer-events: none; }
    .presence-label-name, .presence-label-line2 { dominant-baseline: hanging; }
    @media (max-width: 768px) { .presence-section-title { font-size: 2rem !important; } .presence-label-name { font-size: 10px; } .presence-label-line2 { font-size: 9px; } }
    </style>
    <section class="presence-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="presence-section-title">Our Presence</h2>
                    <p class="presence-section-subtitle">Serving professionals and businesses across 18 countries worldwide</p>
                </div>
            </div>
            <div class="presence-map-wrap">
                <svg class="presence-map-svg" viewBox="0 0 1000 500" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <filter id="presenceMapGrey" x="0" y="0">
                            <feColorMatrix type="saturate" values="0"/>
                        </filter>
                    </defs>
                    <rect width="1000" height="500" fill="#f8f9fa"/>
                    <image class="presence-map-img" href="https://upload.wikimedia.org/wikipedia/commons/8/83/Equirectangular_projection_SW.jpg" x="0" y="0" width="1000" height="500" preserveAspectRatio="xMidYMid meet" filter="url(#presenceMapGrey)" opacity="0.5"/>
                    <g class="presence-markers">
                        <g class="presence-marker"><circle class="presence-dot" cx="716" cy="193" r="5"/><text class="presence-label-name" x="726" y="193">India</text><text class="presence-label-line2" x="726" y="204">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="789" cy="246" r="5"/><text class="presence-label-name" x="799" y="246">Singapore</text><text class="presence-label-line2" x="799" y="257">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="205" cy="94" r="5"/><text class="presence-label-name" x="215" y="94">Canada</text><text class="presence-label-line2" x="215" y="105">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="230" cy="144" r="5"/><text class="presence-label-name" x="240" y="144">United States</text><text class="presence-label-line2" x="240" y="155">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="494" cy="100" r="5"/><text class="presence-label-name" x="504" y="100">UK</text><text class="presence-label-line2" x="504" y="111">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="534" cy="131" r="5"/><text class="presence-label-name" x="544" y="131">Italy</text><text class="presence-label-line2" x="544" y="142">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="650" cy="183" r="5"/><text class="presence-label-name" x="660" y="183">UAE</text><text class="presence-label-line2" x="660" y="194">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="655" cy="191" r="5"/><text class="presence-label-name" x="665" y="191">Oman</text><text class="presence-label-line2" x="665" y="202">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="625" cy="183" r="5"/><text class="presence-label-name" x="635" y="183">Saudi Arabia</text><text class="presence-label-line2" x="635" y="194">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="643" cy="179" r="5"/><text class="presence-label-name" x="653" y="179">Qatar</text><text class="presence-label-line2" x="653" y="190">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="639" cy="177" r="5"/><text class="presence-label-name" x="649" y="177">Bahrain</text><text class="presence-label-line2" x="649" y="188">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="725" cy="230" r="5"/><text class="presence-label-name" x="735" y="230">Sri Lanka</text><text class="presence-label-line2" x="735" y="241">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="703" cy="241" r="5"/><text class="presence-label-name" x="713" y="241">Maldives</text><text class="presence-label-line2" x="713" y="252">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="750" cy="183" r="5"/><text class="presence-label-name" x="760" y="183">Bangladesh</text><text class="presence-label-line2" x="760" y="194">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="869" cy="319" r="5"/><text class="presence-label-name" x="879" y="319">Australia</text><text class="presence-label-line2" x="879" y="330">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="522" cy="225" r="5"/><text class="presence-label-name" x="532" y="225">Nigeria</text><text class="presence-label-line2" x="532" y="236">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="605" cy="250" r="5"/><text class="presence-label-name" x="615" y="250">Kenya</text><text class="presence-label-line2" x="615" y="261">Presence</text></g>
                        <g class="presence-marker"><circle class="presence-dot" cx="567" cy="169" r="5"/><text class="presence-label-name" x="577" y="169">South Africa</text><text class="presence-label-line2" x="577" y="180">Presence</text></g>
                    </g>
                </svg>
            </div>
        </div>
    </section> -->

   

    <!-- Logo Slider (bottom, JS continuous loop - no gap) -->
    <section class="home-logo-slider-section py-4">
        <div class="home-logo-slider-track-wrap">
            <div class="home-logo-slider-track" id="homeLogoSliderTrack">
                <div class="home-logo-slider-item"><img src="home-logo-slider/1.jpeg" alt="Partner 1"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/2.jpeg" alt="Partner 2"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/3.jpeg" alt="Partner 3"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/4.jpeg" alt="Partner 4"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/1.jpeg" alt="Partner 1"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/2.jpeg" alt="Partner 2"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/3.jpeg" alt="Partner 3"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/4.jpeg" alt="Partner 4"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/1.jpeg" alt="Partner 1"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/2.jpeg" alt="Partner 2"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/3.jpeg" alt="Partner 3"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/4.jpeg" alt="Partner 4"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/1.jpeg" alt="Partner 1"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/2.jpeg" alt="Partner 2"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/3.jpeg" alt="Partner 3"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/4.jpeg" alt="Partner 4"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/1.jpeg" alt="Partner 1"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/2.jpeg" alt="Partner 2"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/3.jpeg" alt="Partner 3"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/4.jpeg" alt="Partner 4"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/1.jpeg" alt="Partner 1"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/2.jpeg" alt="Partner 2"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/3.jpeg" alt="Partner 3"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/4.jpeg" alt="Partner 4"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/1.jpeg" alt="Partner 1"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/2.jpeg" alt="Partner 2"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/3.jpeg" alt="Partner 3"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/4.jpeg" alt="Partner 4"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/1.jpeg" alt="Partner 1"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/2.jpeg" alt="Partner 2"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/3.jpeg" alt="Partner 3"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/4.jpeg" alt="Partner 4"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/1.jpeg" alt="Partner 1"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/2.jpeg" alt="Partner 2"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/3.jpeg" alt="Partner 3"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/4.jpeg" alt="Partner 4"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/1.jpeg" alt="Partner 1"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/2.jpeg" alt="Partner 2"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/3.jpeg" alt="Partner 3"></div>
                <div class="home-logo-slider-item"><img src="home-logo-slider/4.jpeg" alt="Partner 4"></div>
            </div>
        </div>
    </section>
    <style>
    .home-logo-slider-section { background: #f7f7f7; overflow: hidden; }
    .home-logo-slider-track-wrap { overflow: hidden; width: 100%; }
    .home-logo-slider-track {
        display: flex; flex-wrap: nowrap; width: max-content;
        will-change: transform;
    }
    .home-logo-slider-item {
        flex: 0 0 auto; width: 160px; height: 80px;
        padding: 0 32px; box-sizing: content-box;
        display: flex; align-items: center; justify-content: center;
    }
    .home-logo-slider-item img { max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain; display: block; }
    @media (max-width: 768px) {
        .home-logo-slider-item { width: 120px; height: 60px; padding: 0 24px; }
    }
    </style>
    <script>
    (function() {
        var track = document.getElementById('homeLogoSliderTrack');
        var section = document.querySelector('.home-logo-slider-section');
        if (!track || !section) return;
        var stepPx = 0.8;
        var setWidth = 896;
        var offset = 0;
        var paused = false;
        function getSetWidth() { return window.innerWidth <= 768 ? 672 : 896; }
        section.addEventListener('mouseenter', function() { paused = true; });
        section.addEventListener('mouseleave', function() { paused = false; });
        function tick() {
            if (!paused) {
                offset -= stepPx;
                if (offset <= -getSetWidth()) offset += getSetWidth();
                track.style.transform = 'translate3d(' + offset + 'px, 0, 0)';
            }
            requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    })();
    </script>


 <!-- CTA Section -->
 <section class="cta-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-4">Start Your Transformation Today</h2>
                    <p class="text-white mb-4 lead">Join thousands of professionals who have unlocked their potential with Elevates.</p>
                    <div class="cta-buttons">
                        <a href="contact-us.php" class="btn btn-light btn-lg px-5 me-3 mb-3 rounded">Get Started</a>
                        <!-- <a href="about-us.php" class="btn btn-outline-light btn-lg px-5 mb-3 rounded">Learn More</a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>