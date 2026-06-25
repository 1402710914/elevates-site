<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/testimonial_helpers.php';
$landing_testimonials = get_published_testimonials($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Career Growth Workshop</title>
      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <!-- Swiper CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11.0.5/swiper-bundle.min.css" />
      <!-- Google Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="landing-page.css">
      <link rel="icon" href="img/fav.png" type="image/x-icon">
<!-- Meta Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;
  n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];
  t=b.createElement(e);t.async=!0;
  t.src=v;
  s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}
  (window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');

  fbq('init', '2445197435901493');
  fbq('track', 'PageView');
</script>

<noscript>
  <img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=2445197435901493&ev=PageView&noscript=1"/>
</noscript>
<!-- End Meta Pixel Code -->
         <style>
            .video-wrapper{position:relative; display:block;}
            .video-wrapper video{display:block; width:100%; height:auto;}
            .video-play-button{position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); background:rgba(0,0,0,0.6); border:none; color:#fff; width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:28px; cursor:pointer; z-index:2; opacity:0; transition:opacity 0.3s ease;}
            .video-wrapper:hover .video-play-button{opacity:1;}
            .video-play-button:focus{outline:none;}
         </style>
   </head>
   <body>
      <!-- ==================== HERO/HEADER SECTION ==================== -->
      <section class="hero-section">
         <div class="hero-content">
            <div class="hero-badge">
               <i class="fas fa-star"></i> Trusted by 1000+ professionals <br>
               Break Career Stagnation and <span class="gold-text">Move Forward</span>
            </div>
            <h1 class="hero-highlight">
               <span class="gradient-text-1">Double your salary in 3-6 months</span>
               
            </h1>
            <h1 class="hero-highlight">
               
               <span class="gradient-text-2">NOT through hustle, BUT through</span>
               <span class="gradient-text-3">better positioning and communication</span>
            </h1>
            <p class="hero-description">
               <strong><i>Experience alone doesn't grow careers. The right strategy does.</i></strong><br>
               This live <strong>2-hour workshop</strong> will give you exactly what you NEED!<br>
               <!-- Today, growth comes from how clearly your value is communicated, how visible your work is, and how confidently you execute, not just from certifications or years on your resume. -->
            </strong>
            </p>
         </div>
      </section>
      <section style="background-color: #fff; padding: 40px 0;">
         <div class="container">
            <div class="row align-items-center g-5 pb-5">
               <!-- Instructor Image -->
               <div class="col-lg-5 col-md-6 text-center">
                  <div class="instructor-image-wrapper">
                     <img src="./founder.jpeg" alt="Instructor" class="instructor-image">
                  </div>
                  <!-- <p class="instructor-bio pt-2 text-center">
                     Best-Selling Author · 20+ Years in IT · Worked with Leading MNCs<br>
                     Career Growth Mentor · Founder Elevates
                  </p> -->
               </div>
               <!-- Instructor Details -->
               <div class="col-lg-7 col-md-6">
                  <h2 class="instructor-title">It's not your hard work — it's your <span class="gold-text">growth strategy.</span></h2>
                  <p class="instructor-description">
                     Helping professionals move from experience-rich to opportunity-ready.
                  </p>
                 
                  <!-- Workshop Details -->
                  <div class="workshop-details">
                     <div class="row g-3">
                        <div class="col-sm-6">
                           <div class="detail-card">
                              <div class="detail-icon">
                                 <i class="far fa-calendar"></i>
                              </div>
                              <div class="detail-content">
                                 <p class="detail-label">Date</p>
                                 <p class="detail-value">26th April 2026</p>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="detail-card">
                              <div class="detail-icon">
                                 <i class="far fa-clock"></i>
                              </div>
                              <div class="detail-content">
                                 <p class="detail-label">Time</p>
                                 <p class="detail-value">11:30 A.M. - 1:30 P.M. IST</p>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="detail-card">
                              <div class="detail-icon">
                                 <i class="fas fa-video"></i>
                              </div>
                              <div class="detail-content">
                                 <p class="detail-label">Workshop</p>
                                 <p class="detail-value">Zoom</p>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="detail-card">
                              <div class="detail-icon">
                                 <i class="fas fa-globe"></i>
                              </div>
                              <div class="detail-content">
                                 <p class="detail-label">Language</p>
                                 <p class="detail-value">English</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <p class="recording-text text-dark">We will provide you with a recording of workshop by paying a nominal fee.</p>
                  <!-- CTA Button -->
                  <a href="https://elevates.exlyapp.com/checkout/a3ff1bd9-5026-4036-8224-d4a99a87d147" style="text-decoration: none;"><button class="instructor-cta">Register Now at ₹99/- <span class="strikethrough">₹999</span></button></a>
                  <!-- Footer Text -->
                  <p class="workshop-footer">Live session Only : Not a Recorded one</p>
               </div>
            </div>
         </div>
      </section>
      <!-- ==================== WHAT WILL CHANGE SECTION ==================== -->
     <section class="change-section">
  <div class="container">
    <div class="row align-items-center g-4">
      <!-- Left Side - Content -->
      <div class="col-md-9">
        <h2 class="change-title">What will change after this workshop!!</h2>
        <ul class="change-list">
          <li class="change-list-item">You will start communicating <b>confidently</b>, without overselling or self-doubt</li>
          <li class="change-list-item">Position yourself as a <b>go-to professional</b>, not just a hard worker</li>
          <li class="change-list-item"><b>Handle senior-level conversations</b> with structure and clarity</li>
          <li class="change-list-item">Stop being overlooked — and start being <b>taken seriously</b></li>
          <li class="change-list-item"><b>Make your value clear</b> and visible in meetings, reviews, and interviews</li>
        </ul>
        <div class="button-wrapper">
          <a href="https://elevates.exlyapp.com/checkout/a3ff1bd9-5026-4036-8224-d4a99a87d147" style="text-decoration: none;"><button class="change-button">Register Now at just ₹99/- Only</button></a>
        </div>
      </div>

      <!-- Right Side - Video -->
         <div class="col-md-3">
            <div class="change-video">
               <div class="video-wrapper">
                  <video id="promoVideo" width="100%" playsinline poster="preview.png">
                     <source src="video.mp4" type="video/mp4">
                     Your browser does not support the video tag.
                  </video>
                  <button id="videoPlayBtn" class="video-play-button" aria-label="Play video">
                     <i class="fas fa-play"></i>
                  </button>
               </div>
            </div>
         </div>
    </div>
  </div>
</section>



 <!-- ==================== TESTIMONIALS SECTION ==================== -->
      <section class="testimonials-section">
         <div class="container">
            <h2 class="testimonials-title">What Professionals Like You Are Saying</h2>
            <p class="testimonials-subtitle">Real feedback from real professionals who've transformed their careers</p>
            <div class="testimonials-wrapper">
               <div class="swiper testimonials-swiper">
                  <div class="swiper-wrapper">
                     <?php $testimonials = $landing_testimonials; include __DIR__ . '/includes/testimonials_carousel_slides.php'; ?>

                  </div>
                  <!-- Navigation & Pagination: Left Arrow | Dots | Right Arrow -->
                  <div class="testimonials-nav-wrapper">
                     <div class="swiper-button-prev testimonials-swiper-prev"></div>
                     <div class="swiper-pagination testimonials-pagination"></div>
                     <div class="swiper-button-next testimonials-swiper-next"></div>
                  </div>
               </div>
            </div>
         </div>
      </section>


      <!-- ==================== 360° APPROACH SECTION ==================== -->
      <section class="approach-section">
         <div class="container">
            <h2 class="section-title">Career Growth Needs a <span class="gold-accent">360° Approach</span></h2>
            <div class="row g-4 justify-content-center">
               <div class="col-lg-4 col-md-6">
                  <div class="approach-card">
                     <div class="card-icon">
                        <i class="fas fa-brain"></i>
                     </div>
                     <h3 class="card-title">Mindset</h3>
                     <p class="card-description">Better decisions → Better opportunities</p>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="approach-card">
                     <div class="card-icon">
                        <i class="fas fa-eye"></i>
                     </div>
                     <h3 class="card-title">Visibility</h3>
                     <p class="card-description">Right people notice your work</p>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="approach-card">
                     <div class="card-icon">
                        <i class="fas fa-file-alt"></i>
                     </div>
                     <h3 class="card-title">Resume</h3>
                     <p class="card-description">Results, not responsibilities</p>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="approach-card">
                     <div class="card-icon">
                        <i class="fas fa-comments"></i>
                     </div>
                     <h3 class="card-title">Communication</h3>
                     <p class="card-description">Better roles → Better pay</p>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="approach-card">
                     <div class="card-icon">
                        <i class="fas fa-handshake"></i>
                     </div>
                     <h3 class="card-title">Interviews</h3>
                     <p class="card-description">Confidence & clarity</p>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- ==================== WHY STUCK SECTION ==================== -->
      <section class="why-stuck-section">
         <div class="container">
            <h2 class="why-stuck-title">Why Most Professionals Stay Stuck?</h2>
            <div class="row g-4 justify-content-center">
               <div class="col-lg-4 col-md-6">
                  <div class="stuck-card">
                     <p class="stuck-card-text">Certifications, but low confidence</p>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="stuck-card">
                     <p class="stuck-card-text">Hard work, low visibility</p>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6">
                  <div class="stuck-card">
                     <p class="stuck-card-text">Interviews stalled by weak communication</p>
                  </div>
               </div>
            </div>
         </div>
      </section>



      <!-- ==================== PARTNERS SECTION ==================== -->
      <section class="partners-section">
         <div class="container">
            <h2 class="partners-title">Trusted <span class="gold-accent">Partners</span></h2>
            <p class="partners-subtitle">We've had the privilege of partnering with leading organisations across diverse industries, helping their professionals achieve significant career advancements and strategic growth. Our methodology is trusted by global innovators and market leaders.</p>
            <div class="partners-wrapper">
               <div class="swiper partners-swiper">
                  <div class="swiper-wrapper">
                     <!-- Partner Logo 1 - Accenture -->
                     <div class="swiper-slide">
                        <div class="partner-logo-card">
                           <img src="logo/logo1.jpeg" alt="Accenture">
                        </div>
                     </div>
                     <!-- Partner Logo 2 - IIBM -->
                     <div class="swiper-slide">
                        <div class="partner-logo-card">
                           <img src="logo/logo2.png" alt="IIBM">
                        </div>
                     </div>
                     <!-- Partner Logo 3 - Microsoft -->
                     <div class="swiper-slide">
                        <div class="partner-logo-card">
                           <img src="logo/logo3.jpg" alt="Microsoft">
                        </div>
                     </div>
                     <!-- Partner Logo 4 - Google -->
                     <div class="swiper-slide">
                        <div class="partner-logo-card">
                           <img src="logo/logo4.png" alt="Google">
                        </div>
                     </div>
                     <!-- Partner Logo 5 - Deloitte -->
                     <div class="swiper-slide">
                        <div class="partner-logo-card">
                           <img src="logo/logo5.jpg" alt="Deloitte">
                        </div>
                     </div>
                     <!-- Partner Logo 6 - Deloitte -->
                     <div class="swiper-slide">
                        <div class="partner-logo-card">
                           <img src="logo/logo6.jpg" alt="Deloitte">
                        </div>
                     </div>

                     <!-- Partner Logo 7 - Deloitte -->
                     <div class="swiper-slide">
                        <div class="partner-logo-card">
                           <img src="logo/logo7.jpg" alt="Deloitte">
                        </div>
                     </div>

                      <!-- Partner Logo 8 - Deloitte -->
                      <div class="swiper-slide">
                        <div class="partner-logo-card">
                           <img src="logo/logo8.jpg" alt="Deloitte">
                        </div>
                     </div>

                      <!-- Partner Logo 9 - Deloitte -->
                      <div class="swiper-slide">
                        <div class="partner-logo-card">
                           <img src="logo/logo9.jpg" alt="Deloitte">
                        </div>
                     </div>

                      <!-- Partner Logo 10 - Deloitte -->
                      <div class="swiper-slide">
                        <div class="partner-logo-card">
                           <img src="logo/logo10.jpg" alt="Deloitte">
                        </div>
                     </div>

                  </div>
                  <!-- Navigation buttons -->
                   <div class="logo-nav-wrapper">
                  <div class="swiper-button-prev"></div>
                   <div class="swiper-pagination partners-pagination"></div>
                  <div class="swiper-button-next"></div>
               </div>
                  <!-- Pagination dots -->
                 
               </div>
            </div>
         </div>
      </section>
     
      <!-- ==================== FAQ SECTION ==================== -->
      <section class="faq-section pt-3">
         <div class="container">
            <h2 class="faq-title">Frequently Asked Questions</h2>
            <div class="faq-container">
               <div class="accordion" id="faqAccordion">
                  <div class="accordion-item">
                     <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        Who is this workshop for?
                        </button>
                     </h2>
                     <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                           This workshop is designed for working professionals with a few years of experience who feel their growth has slowed down despite strong skills and consistent effort. If you feel undervalued, overlooked, or stuck at the same level, this session will be highly relevant.
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item">
                     <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        Is this just a communication or English-speaking workshop?
                        </button>
                     </h2>
                     <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                           No. This is not an English-speaking or soft-skills class. The focus is on how communication, visibility, and mindset directly impact career growth, senior-level conversations, and opportunities.
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item">
                     <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        I already have experience and certifications. Will this still help me?
                        </button>
                     </h2>
                     <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                           Yes, especially if you already have experience. This workshop addresses why experience and certifications alone don't always translate into growth, and how to position your work and impact so it gets recognized and rewarded.
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item">
                     <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        Is this a live session or a recorded one?
                        </button>
                     </h2>
                     <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                          This is a live, mentor-led session. A recording will also be shared afterward for better understanding and future reference.
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item">
                     <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                        What will I actually gain after attending?
                        </button>
                     </h2>
                     <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                           You'll walk away with clear understanding of why your growth may feel stuck, practical ways to communicate your value with confidence, better clarity for meetings, reviews, interviews, and senior conversations, and a more structured approach to career growth moving forward.
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item">
                     <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                        How long is the workshop?
                        </button>
                     </h2>
                     <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                           The workshop is 2 hours long, designed to be focused, practical, and respectful of your time.
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item">
                     <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                        Why is there a ₹99 fee?
                        </button>
                     </h2>
                     <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                           The ₹99 fee helps keep the session focused and high-quality, ensures participation from serious professionals, and maintains an interactive, mentor-led experience. It's a small commitment that leads to high-value clarity.
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item">
                     <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                        Do I need to prepare anything before attending?
                        </button>
                     </h2>
                     <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                           No preparation is required. Just come with an open mindset and real career questions.
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item">
                     <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                        Is this suitable for freshers or students?
                        </button>
                     </h2>
                     <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                           This workshop is best suited for working professionals. If you're a fresher or student, some concepts may feel advanced or less relevant at this stage.
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item">
                     <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">
                        What's the refund policy?
                        </button>
                     </h2>
                     <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                           We're confident you'll find value in this workshop. However, if you have concerns, please contact us before the session for clarification or adjustments.
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- ==================== REGISTRATION FOOTER ==================== -->
      <section class="registration-footer" id="registrationFooter">
         <div class="container">
            <div class="registration-content">
               <div class="registration-text">
                  <h3>Register for the Live Webinar</h3>
                  <p class="registration-price">Register for <span class="price">₹99/-</span> Only</p>
                  <p class="registration-features">One-time fee · Secure payment · No upselling</p>
               </div>
               <div class="registration-button">
                  <a href="https://elevates.exlyapp.com/checkout/a3ff1bd9-5026-4036-8224-d4a99a87d147" style="text-decoration: none;"><button class="btn-register">Register Now</button></a>
               </div>
            </div>
         </div>
      </section>
      <!-- Modal -->
      <div class="modal fade" id="approachModal" tabindex="-1" aria-labelledby="approachModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
               <div class="modal-header" style="background: linear-gradient(135deg, #6a0dad, #a9167e); color: white; border-radius: 15px 15px 0 0; border-bottom: none;">
                  <h5 class="modal-title" id="approachModalLabel" style="font-weight: 700; font-size: 24px;">🚀 Unlock Your Career Growth</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body" style="padding: 30px 30px 0px 30px; text-align: center;">
                  <div style="font-size: 48px; margin-bottom: 20px;">🎯</div>
                  <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">Discover the 360° Approach</h4>
                  <p style="color: #666; font-size: 16px; line-height: 1.6; margin-bottom: 25px;">
                     Transform your career with our proven methodology that has helped thousands of professionals break through stagnation and achieve their goals.
                  </p>
                  <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; ">
                     <p style="margin: 0; color: #333; font-weight: 600;">⏰ Limited Time: Register now for just ₹99/-</p>
                  </div>
               </div>
               <div class="modal-footer" style="border-top: none; justify-content: center; padding: 20px 30px;">
                  <a href="https://elevates.exlyapp.com/checkout/a3ff1bd9-5026-4036-8224-d4a99a87d147" style="text-decoration: none;"><button type="button" class="btn" style="background: linear-gradient(135deg, #6a0dad, #a9167e); color: white; border: none; padding: 12px 40px; font-size: 16px; font-weight: 700; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; margin-right: 10px;">Register Now at ₹99/-</button></a>
                  
               </div>
            </div>
         </div>
      </div>
      <!-- Bootstrap JS -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
      <!-- Swiper JS -->
      <script src="https://cdn.jsdelivr.net/npm/swiper@11.0.5/swiper-bundle.min.js"></script>
      <script>
         // Testimonials Slider - Auto slide + Arrows left/right of dots
         const testimonialsSwiper = new Swiper('.testimonials-swiper', {
             slidesPerView: 3,
             spaceBetween: 30,
             loop: true,
             autoplay: {
                 delay: 4000,
                 disableOnInteraction: false,
             },
             pagination: {
                 el: '.testimonials-pagination',
                 clickable: true,
                 dynamicBullets: false,
             },
             navigation: {
                 nextEl: '.testimonials-swiper-next',
                 prevEl: '.testimonials-swiper-prev',
             },
             breakpoints: {
                 320: {
                     slidesPerView: 1,
                     spaceBetween: 20,
                 },
                 768: {
                     slidesPerView: 2,
                     spaceBetween: 25,
                 },
                 1024: {
                     slidesPerView: 3,
                     spaceBetween: 30,
                 }
             }
         });
         
         // Partners Slider
         const partnerSwiper = new Swiper('.partners-swiper', {
             slidesPerView: 4,
             spaceBetween: 30,
             loop: true,
             autoplay: {
                 delay: 3000,
                 disableOnInteraction: false,
             },
             pagination: {
                 el: '.partners-pagination',
                 clickable: true,
                 dynamicBullets: false,
             },
             navigation: {
                 nextEl: '.partners-swiper .swiper-button-next',
                 prevEl: '.partners-swiper .swiper-button-prev',
             },
             breakpoints: {
                 320: {
                     slidesPerView: 1,
                     spaceBetween: 20,
                 },
                 640: {
                     slidesPerView: 2,
                     spaceBetween: 20,
                 },
                 768: {
                     slidesPerView: 3,
                     spaceBetween: 25,
                 },
                 1024: {
                     slidesPerView: 4,
                     spaceBetween: 30,
                 }
             }
         });
         
         // Scroll trigger for registration footer - improved behavior
         const registrationFooter = document.getElementById('registrationFooter');
         let previousScrollPercent = 0;
         
         window.addEventListener('scroll', function() {
             const scrollTop = window.scrollY;
             const docHeight = document.documentElement.scrollHeight - window.innerHeight;
             const scrollPercent = (scrollTop / docHeight) * 100;
             
             // Show between 20% and 40% scroll
             if (scrollPercent >= 20 && scrollPercent <= 110) {
                 if (!registrationFooter.classList.contains('show')) {
                     registrationFooter.classList.add('show');
                 }
             } 
             // Hide when scrolling to top or bottom
             else {
                 if (registrationFooter.classList.contains('show')) {
                     registrationFooter.classList.remove('show');
                 }
             }
             
             previousScrollPercent = scrollPercent;
         }, { passive: true});
         
         // Custom video: hide native controls, show overlay play/pause button
         (function(){
            const video = document.getElementById('promoVideo');
            const btn = document.getElementById('videoPlayBtn');
            const icon = btn.querySelector('i');
            if(!video || !btn || !icon) return;
            // Ensure native controls are hidden
            video.controls = false;
            // Update button icon and aria-label based on video state
            function updateButton() {
               if (video.paused) {
                  icon.className = 'fas fa-play';
                  btn.setAttribute('aria-label', 'Play video');
               } else {
                  icon.className = 'fas fa-pause';
                  btn.setAttribute('aria-label', 'Pause video');
               }
            }
            // Initial state
            updateButton();
            // Update on play/pause events
            video.addEventListener('play', updateButton);
            video.addEventListener('pause', updateButton);
            // Toggle play/pause on button click
            btn.addEventListener('click', function(){
               if (video.paused) {
                  video.muted = false;
                  video.play();
               } else {
                  video.pause();
               }
            });
         })();
         
         // Modal trigger for approach section
         let modalShown = false;
         const approachSection = document.querySelector('.approach-section');
         const observer = new IntersectionObserver((entries) => {
             entries.forEach(entry => {
                 if (entry.isIntersecting && !modalShown) {
                     const modal = new bootstrap.Modal(document.getElementById('approachModal'));
                     modal.show();
                     modalShown = true;
                 }
             });
         }, { threshold: 0.5 });
         
         if (approachSection) {
             observer.observe(approachSection);
         }
         
         // Function for register button
         function registerNow() {
             window.location.href = 'https://elevates.exlyapp.com/checkout/a3ff1bd9-5026-4036-8224-d4a99a87d147';
         }
      </script>
   </body>
</html>