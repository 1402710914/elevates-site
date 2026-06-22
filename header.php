<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elevates - Building Successful Careers & Businesses</title>
    
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4ZNFDELCEP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-4ZNFDELCEP');
</script>

<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "wtf1kk2xja");
</script>





    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
   
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <link rel="icon" href="img/fav.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- External CSS -->
    <link rel="stylesheet" href="style.css?v=<?php echo @filemtime(__DIR__ . '/style.css'); ?>">
    <style>
        @media (min-width: 1400px) {
            .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
                max-width: 1600px !important;
            }
        }
        .bg-light {
            background-color: #f8f8f8 !important
        }
        .btn {
            border-radius: 25px !important;
        }

    

        /* Sticky Header */
        .main-header.scrolled {
          
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

     

        /* Logo Transitions */
        .logo-default,
        .logo-sticky {
            transition: opacity 0.3s ease;
        }

        /* Default State */
        .logo-default {
            display: block;
        }

        .logo-sticky {
            display: none;
        }

        /* Sticky State - Logo Change */
        .main-header.scrolled .logo-default {
            display: none;
        }

        .main-header.scrolled .logo-sticky {
            display: block;
        }

        /* Hover State - Logo Change */
        .main-header:hover .logo-default {
            display: none;
        }

        .main-header:hover .logo-sticky {
            display: block;
        }
        
        /* Mobile-specific logo rules */
        @media (max-width: 991px) {
            /* On mobile, show the default (white) logo by default */
            .logo-default {
                display: none !important;
            }

            .logo-sticky {
                display: block !important;
            }

            /* If header gets the scrolled class, swap logos on mobile too */
            .main-header.scrolled .logo-default {
                display: none !important;
            }

            .main-header.scrolled .logo-sticky {
                display: block !important;
            }

            /* Ensure logos don't overflow mobile navbar */
            .navbar-brand img {
                max-width: 72px;
                height: auto;
            }
        }
    </style>
</head>
<body>
    
    <!-- Top Banner -->
    <div class="top-banner">
        <div class="container-fluid">
            <div class="banner-content">
                 <p class="banner-text mb-0">Helping professionals and businesses grow with clarity and capability. </p>
                <button class="btn btn-outline-light btn-sm banner-btn" 
                onclick="openDiscoveryPopup()">Connect Now</button>
            </div>
        </div>
    </div>
   
    <!-- Header/Navbar -->
    <header class="main-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="#">
                    <h2 class="logo-text mb-0">
                        <img src="img/logo-white.png" width="80px" class="logo-default" alt="Elevates Logo" />
                        <img src="img/logo.png" width="80px" class="logo-sticky" alt="Elevates Logo Sticky" />
                    </h2>
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php" >Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                For Business
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="hiring-assistance.php">Hiring Assistance</a></li>
                                <li><a class="dropdown-item" href="business-ready-fresh-talent.php">Business-Ready Fresh Talent Program</a></li>
                                <li><a class="dropdown-item" href="business-accelerator-program-it-technology.php">Business Accelerator Program for IT &amp; Technology Companies</a></li>
                                <li><a class="dropdown-item" href="business-accelerator-program-for-non-it.php">Business Accelerator Program for Non-IT</a></li>
                            </ul>
                        </li> 
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                For Individuals
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="job-placement-assistance.php">Job & Placement Assistance</a></li>
                                <li><a class="dropdown-item" href="ai-based-assessment.php">AI Based Assessment (Skill Gap Analysis)</a></li>
                                <li><a class="dropdown-item" href="success-accelerator-program.php">Success Accelerator Program</a></li>
                                <li><a class="dropdown-item" href="career-accelerator-program.php">Career Accelerator Program</a></li>
                                <!-- <li><a class="dropdown-item" href="dreamchazer-build-your-dream-business.php">DreamChazer (Build Your Dream Business)</a></li> -->
                                <li><a class="dropdown-item" href="corporate-success-program-for-freshers-early-career-professionals.php">Corporate Success Program for Freshers & Early Career Professionals</a></li>
                                <li><a class="dropdown-item" href="train-the-trainer-program.php">Train The Trainer</a></li>
                                <li><a class="dropdown-item" href="work-integrated-learning-programmes.php">Work Integrated Learning Programmes (WILP)</a></li>
                                <li><a class="dropdown-item" href="master-technology-at-your-pace.php">Master Technology at Your Pace</a></li>
                            </ul>
                        </li> 
                        <li class="nav-item"><a class="nav-link" href="about-us.php" >About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="our-team.php" >Our Team</a></li>
                        <li class="nav-item"><a class="nav-link" href="testimonials.php" >Success Stories</a></li>
                        <li class="nav-item"><a class="nav-link" href="blog.php" >Blogs</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact-us.php" >Contact Us</a></li>
                    </ul>

                    <!-- Right Side Buttons -->
                    <div class="d-flex align-items-center">
                        <a onclick="openDiscoveryPopup()" class="btn btn-demo btn-demo-wave">
                            AI-Powered Skill Gap Assessment
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Your other content here -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>
</html>