// ==========================================
// SMOOTH SCROLLING FOR ANCHOR LINKS
// ==========================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    const href = anchor.getAttribute('href');
    // Skip plain '#' anchors and any anchor used by Bootstrap (dropdown toggles, collapse toggles, etc.)
    if (!href || href === '#') return;
    if (anchor.hasAttribute('data-bs-toggle') || anchor.hasAttribute('data-bs-target')) return;

    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ==========================================
// NAVBAR SCROLL EFFECT (ADDITIONAL)
// ==========================================
window.addEventListener('scroll', function() {
    const header = document.querySelector('.main-header');
    
    if (window.scrollY > 100) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// ==========================================
// MOBILE MENU CLOSE ON LINK CLICK
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (!navbarToggler || !navbarCollapse) return;

    const navLinks = document.querySelectorAll('.navbar-nav .nav-link:not(.dropdown-toggle)');
    const dropdownToggles = document.querySelectorAll('.navbar-nav .dropdown-toggle');

    // Remove Bootstrap dropdown attributes
    dropdownToggles.forEach(toggle => {
        toggle.removeAttribute('data-bs-toggle');
        toggle.removeAttribute('data-bs-auto-close');
    });

    // Function to close menu
    function closeMenu() {
        navbarCollapse.classList.remove('show');
        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
            menu.classList.remove('show');
        });
        // Reset all rotated arrows
        document.querySelectorAll('.dropdown-toggle.rotated').forEach(toggle => {
            toggle.classList.remove('rotated');
        });
    }

    // Toggle button click handler
    navbarToggler.addEventListener('click', function(e) {
        e.stopPropagation();
        
        if (window.innerWidth < 992) {
            if (navbarCollapse.classList.contains('show')) {
                closeMenu();
            } else {
                navbarCollapse.classList.add('show');
            }
        }
    });

    // Close menu when clicking any non-dropdown nav link
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (window.innerWidth < 992) {
                closeMenu();
            }
        });
    });

    // Handle dropdown toggle click in mobile view
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (window.innerWidth < 992) {
                const parent = this.closest('.dropdown');
                const dropdownMenu = parent ? parent.querySelector('.dropdown-menu') : null;
                
                if (dropdownMenu) {
                    const isOpen = dropdownMenu.classList.contains('show');
                    
                    // Close all dropdowns
                    document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                        menu.classList.remove('show');
                        // Reset arrow rotation
                        const toggleBtn = menu.closest('.dropdown')?.querySelector('.dropdown-toggle');
                        if (toggleBtn) {
                            toggleBtn.classList.remove('rotated');
                        }
                    });
                    
                    // Toggle current dropdown
                    if (!isOpen) {
                        dropdownMenu.classList.add('show');
                        this.classList.add('rotated');
                    } else {
                        this.classList.remove('rotated');
                    }
                }
            }
        });
    });

    // Close menu when clicking a dropdown item
    const dropdownItems = document.querySelectorAll('.dropdown-menu .dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            if (window.innerWidth < 992) {
                setTimeout(() => {
                    closeMenu();
                }, 50);
            }
        });
    });

    // Close menu when clicking outside - with proper event handling
    document.addEventListener('click', function(event) {
        if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
            const isClickOnToggler = navbarToggler.contains(event.target);
            const isClickInsideMenu = navbarCollapse.contains(event.target);
            
            if (!isClickOnToggler && !isClickInsideMenu) {
                closeMenu();
            }
        }
    }, true); // Use capture phase for better control

    // Close menu on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
            closeMenu();
        }
    });
});

// ==========================================
// ANIMATE ON SCROLL (OPTIONAL)
// ==========================================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe elements with fade-in animation
document.querySelectorAll('.hero-image img').forEach(element => {
    element.style.opacity = '0';
    element.style.transform = 'translateY(30px)';
    element.style.transition = 'all 0.8s ease-out';
    observer.observe(element);
});

// NOTE: Removed global demo form-preventing handler so real forms can submit.
// If you need to block or intercept a specific form for demo, add a
// selector for that form only, e.g. document.querySelector('#demoForm').

// ==========================================
// DROPDOWN HOVER EFFECT (DESKTOP ONLY)
// ==========================================
if (window.innerWidth >= 992) {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('mouseenter', function() {
            const menu = this.querySelector('.dropdown-menu');
            if (menu) {
                menu.classList.add('show');
            }
        });
        
        dropdown.addEventListener('mouseleave', function() {
            const menu = this.querySelector('.dropdown-menu');
            if (menu) {
                menu.classList.remove('show');
            }
        });
    });
}

// ==========================================
// BUTTON RIPPLE EFFECT
// ==========================================
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            // Check if ripple element is still in the DOM before removing
            if (ripple.parentElement) {
                ripple.remove();
            }
        }, 600);
    });
});

// Add ripple CSS
const style = document.createElement('style');
style.textContent = `
    .btn {
        position: relative;
        overflow: hidden;
    }
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

console.log('🚀 Website loaded successfully!');