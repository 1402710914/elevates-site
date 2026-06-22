<?php include 'header.php'; ?>

    <!-- Contact Page Hero -->
    <section class="page-hero">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="page-title">Get in Touch</h1>
                    <p class="page-subtitle">We'd love to hear from you. Whether you have a question about our services, pricing, or anything else, our team is ready to answer all your questions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="contact-info-section py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Visit Us</h4>
                        <p>Level 5, Tower C, Green Boulevard,<br>Block B, Sector 62, Noida,<br>Uttar Pradesh 201309, India</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h4>Call Us</h4>
                        <p><a href="tel:+919667309208">+91 9667309208</a><br>
                           <a href="tel:+919717393173">+91 9717393173</a><br>
                           <a href="tel:+919910805621">+91 9910805621</a></p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email Us</h4>
                        <p>General Inquiries / Sales:<br><a href="mailto:info@elevates.pro">info@elevates.pro</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form-wrapper">
                        <h2 class="text-center mb-4">Send Us a Message</h2>

                        <form id="contactForm" class="contact-form" onsubmit="return false;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label">First Name *</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name" required>
                                    <div class="invalid-feedback">Please enter your first name.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name">
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">Please enter a valid email.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                                
                                <div class="col-12">
                                    <label for="company" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="company" name="company">
                                </div>
                                
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject *</label>
                                    <select class="form-select" id="subject" name="subject" required>
                                        <option value="">Select a subject</option>
                                        <option value="general">General Inquiry</option>
                                        <option value="sales">Sales Inquiry</option>
                                        <option value="support">Technical Support</option>
                                        <option value="partnership">Partnership Opportunity</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a subject.</div>
                                </div>
                                
                                <div class="col-12">
                                    <label for="message" class="form-label">Message *</label>
                                    <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                                    <div class="invalid-feedback">Please enter your message.</div>
                                </div>
                                
                                <input type="hidden" name="source" value="contact-us">
                                
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="privacy" name="privacy" required>
                                        <label class="form-check-label" for="privacy">
                                            I agree to the <a href="privacy.html" target="_blank">Privacy Policy</a> and Terms of Service *
                                        </label>
                                        <div class="invalid-feedback">You must agree to continue.</div>
                                    </div>
                                </div>
                                
                                <!-- Message appears here -->
                                <div class="col-12">
                                    <div id="formMessage"></div>
                                </div>
                                
                                <div class="col-12 text-center mt-3">
                                    <button type="button" onclick="submitContactForm()" class="btn btn-primary btn-lg px-5" id="submitBtn">
                                        <span id="btnText">Send Message</span>
                                        <span id="btnSpinner" class="spinner-border spinner-border-sm d-none ms-2"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Find Us on the Map</h2>
            <div class="map-wrapper">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.2138292676796!2d77.36471147563667!3d28.623352784497214!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce55ad673c86f%3A0x428875166eb17bc5!2sGreen%20Boulevard!5e0!3m2!1sen!2sin!4v1766860378967!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

<script>
function submitContactForm() {
    const form = document.getElementById('contactForm');
    const messageDiv = document.getElementById('formMessage');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');
    
    // Validate
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return false;
    }
    
    // Get form data
    const formData = new FormData(form);
    
    // Show loading
    btnText.textContent = 'Sending...';
    btnSpinner.classList.remove('d-none');
    submitBtn.disabled = true;
    messageDiv.innerHTML = '';
    
    // AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_enquiry.php', true);
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = xhr.responseText.trim();
            
            if (response === 'success' || response.includes('success')) {
                messageDiv.innerHTML = '<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle"></i> <strong>Thank you!</strong> Your message has been sent successfully. We\'ll get back to you soon.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                form.reset();
                form.classList.remove('was-validated');
            } else {
                messageDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-triangle"></i> <strong>Error!</strong> Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
            }
            
            setTimeout(function() {
                const alert = messageDiv.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => messageDiv.innerHTML = '', 150);
                }
            }, 5000);
        } else {
            messageDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-times-circle"></i> <strong>Error!</strong> Network error.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
        
        btnText.textContent = 'Send Message';
        btnSpinner.classList.add('d-none');
        submitBtn.disabled = false;
    };
    
    xhr.onerror = function() {
        messageDiv.innerHTML = '<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-times-circle"></i> <strong>Error!</strong> Network error.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        btnText.textContent = 'Send Message';
        btnSpinner.classList.add('d-none');
        submitBtn.disabled = false;
    };
    
    xhr.send(formData);
    return false;
}
</script>

<?php include 'footer.php'; ?>