<?php
ob_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $service = htmlspecialchars(trim($_POST['service']));
    $message = htmlspecialchars(trim($_POST['message']));

    $apiKey = getenv('RESEND_API_KEY');
    $clientEmail = 'premierelizabeth582@gmail.com'; // Client receives here
    
    $data = [
        'from' => 'Lizzy Beauty <onboarding@resend.dev>',
        'to' => [$clientEmail],
        'subject' => 'New Booking: ' . $service . ' - ' . $name,
        'html' => "<h3>New Appointment Request</h3><p><b>Name:</b> $name</p><p><b>Phone:</b> $phone</p><p><b>Email:</b> $email</p><p><b>Service:</b> $service</p><p><b>Message:</b> $message</p>",
        'reply_to' => $email
    ];

    $ch = curl_init('https://api.resend.com/emails');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    ob_end_clean();
    if ($httpCode == 200 || $httpCode == 201) {
        echo 'success';
    } else {
        http_response_code(500);
        echo 'API Error: ' . $response;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lizzy Beauty</title>
    <meta name="description" content="Artisan braiding, precision lash extensions, and luxury nail services — crafted for women who deserve the gold standard.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #050505;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }
        .loader-circle {
            width: 48px;
            height: 48px;
            border: 3px solid #17110C;
            border-top-color: #D2B59A;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="page-loader" id="pageLoader">
    <div class="loader-circle"></div>
</div>

<!-- Navigation -->
<nav class="navbar" id="navbar">
    <a href="#hero" class="nav-logo">
        <span class="crown">&#9813;</span> Prems<span class="gold-accent">Beauty World</span>
    </a>
    <ul class="nav-links">
        <li><a href="#services">Services</a></li>
        <li><a href="#standard">About</a></li>
        <li><a href="#testimonials">Reviews</a></li>
        <li><a href="#booking" class="pill">Book Now</a></li>
    </ul>
</nav>

<!-- Hero Section -->
<section class="hero" id="hero">
    <div class="hero-split">
        <div class="hero-left">
            <div class="hero-content">
                <div class="hero-tag">
                    <span class="dot"></span> Nails &middot; Lashes &middot; Braids
                </div>
                <h1>Your Beauty,<br><span class="italic">Elevated</span><br>to Gold.</h1>
                <p>Artisan braiding, precision lash extensions, and luxury nail services — crafted for women who deserve the gold standard.</p>
                <div class="hero-buttons">
                    <a href="#booking" class="btn-primary">Book Your Session &rarr;</a>
                    <a href="#services" class="btn-secondary">View Services</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="number">50+</div>
                        <div class="label">Happy Clients</div>
                    </div>
                    <div class="hero-stat">
                        <div class="number">5.0;</div>
                        <div class="label">Average Rating</div>
                    </div>
                    <div class="hero-stat">
                        <div class="number">6 yrs</div>
                        <div class="label">Experience</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-right">
            <img src="images/be1.jpg" alt="Lizzy Beauty model with braids in a gold-accented salon">
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services" id="services">
    <div class="services-header reveal">
        <p class="section-label">What We Do</p>
        <h2 class="section-title">Services Built for <span class="italic">You.</span></h2>
    </div>
    <div class="services-grid">
        <div class="service-card active reveal" data-service="braids">
            <div class="service-icon">&#9830;</div>
            <h3>Hair Braiding</h3>
            <p>Intricate braiding styles designed to protect and elevate your natural hair with artistry and precision.</p>
            <ul>
                <li>Cornrows & Box Braids</li>
                <li>Faux Locs & Goddess Locs</li>
                <li>Feed-in Styles</li>
                <li>Tress Pieces</li>
            </ul>
            <div class="service-price">From ₦25,000</div>
        </div>
        <div class="service-card reveal" data-service="lashes">
            <div class="service-icon">&#9829;</div>
            <h3>Lash Extensions</h3>
            <p>Fluffy, natural-looking lash extensions tailored to your eye shape for a mesmerizing gaze.</p>
            <ul>
                <li>Classic & Volume Sets</li>
                <li>Hybrid Lashes</li>
                <li>Lift & Tint</li>
                <li>Refills</li>
            </ul>
            <div class="service-price">From ₦10,000</div>
        </div>
        <div class="service-card reveal" data-service="nails">
            <div class="service-icon">&#9831;</div>
            <h3>Nail Services</h3>
            <p>Precision nail artistry using premium products for stunning, long-lasting results.</p>
            <ul>
                <li>Full Sets & Fills</li>
                <li>Gel & Acryllic</li>
                <li>Manicure & Pedicure</li>
                <li>Dip Powder</li>
            </ul>
            <div class="service-price">From ₦8,000</div>
        </div>
    </div>
    <div class="service-detail reveal">
        <div class="big-number">100%</div>
        <div class="detail-text">
            <p>Cruelty-free</p>
            <small>products used</small>
        </div>
        <div class="detail-badges">
            <span class="feature-tag">&#9829; Vegan</span>
            <span class="feature-tag">&#9829; Non-toxic</span>
            <span class="feature-tag">&#9829; Hypoallergenic</span>
        </div>
        <div style="margin-left: 20px;">
            <div class="detail-text">
                <p>Your safety</p>
                <small>is always the priority</small>
            </div>
        </div>
    </div>
</section>

<!-- Standard Section -->
<section class="standard" id="standard">
    <div class="reveal">
        <p class="section-label">The Standard</p>
        <h2 class="section-title">Beauty That Feels <span class="italic">Personal.</span></h2>
    </div>
    <div class="standard-grid">
        <div class="standard-left reveal">
            <p>PremsBeauty World was born from a simple belief — every woman and young girls deserves to feel extraordinary. With years of hands-on artistry, I bring passion, precision, and personality to every single appointment.</p>
            <div class="standard-features">
                <div class="standard-feature">
                    <div class="icon">&#9830;</div>
                    <div>
                        <h4>Gold Standard Craft</h4>
                        <p>Every technique is practiced to perfection. No rushed jobs, no shortcuts — just meticulous artistry on every detail.</p>
                    </div>
                </div>
                <div class="standard-feature">
                    <div class="icon">&#9829;</div>
                    <div>
                        <h4>Your Comfort First</h4>
                        <p>A calm, welcoming studio where you can relax. Consultations are always included — your vision drives every session.</p>
                    </div>
                </div>
            </div>
            <div class="standard-quote">
                <p>"I don't just do your hair — I listen to your story and craft something that's uniquely you."</p>
                <cite>— PremsBeauty World</cite>
            </div>
        </div>
        <div class="standard-right reveal">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="value">50+</div>
                    <div class="stat-label">Clients Served</div>
                </div>
                <div class="stat-card">
                    <div class="value">6</div>
                    <div class="stat-label">Years in Business</div>
                </div>
                <div class="stat-card">
                    <div class="value">3</div>
                    <div class="stat-label">Signature Services</div>
                </div>
                <div class="stat-card">
                    <div class="value">5.0</div>
                    <div class="stat-label">Avg. Review Score</div>
                </div>
            </div>
            <div class="cert-badge">
                <div class="cert-icon">&#9830;</div>
                <div class="cert-text">
                    <strong>Certified Beauty Artisan</strong>
                    <p>Trained & licensed professional · Splendid Beauty</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials" id="testimonials">
    <div class="testimonials-header reveal">
        <div>
            <p class="section-label">Client Love</p>
            <h2 class="section-title">Trusted by Women<br>Who <span class="italic">Know.</span></h2>
        </div>
        <div class="stars">
            <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
        </div>
    </div>
    <div class="testimonial-grid">
        <div class="testimonial-card reveal">
            <i class="fas fa-quote-left"></i>
            <i class="fas fa-quote-right"></i>
            <p class="quote">I've been coming for my braids for over two years now. Every style is flawless and I always leave feeling like a queen. The attention to detail is unmatched.</p>
            <div class="author">
                <div class="avatar">TM</div>
                <div class="author-info">
                    <strong>Esther M.</strong>
                    <small>Hair Braiding Client</small>
                </div>
            </div>
        </div>
        <div class="testimonial-card reveal">
            <i class="fas fa-quote-left"></i>
            <i class="fas fa-quote-right"></i>
            <p class="quote">My lashes are absolutely stunning — so natural and fluttery. Everyone asks me what I'm doing differently. The consultation made me feel so comfortable.</p>
            <div class="author">
                <div class="avatar">PD</div>
                <div class="author-info">
                    <strong>Jennifer U.</strong>
                    <small>Lash Extensions Client</small>
                </div>
            </div>
        </div>
        <div class="testimonial-card reveal">
            <i class="fas fa-quote-left"></i>
            <i class="fas fa-quote-right"></i>
            <p class="quote">The nail work here is next level. My gel manicures last weeks without chipping and the designs are always on point. I'm a loyal client for life.</p>
            <div class="author">
                <div class="avatar">SA</div>
                <div class="author-info">
                    <strong>Sarah A.</strong>
                    <small>Nail Services Client</small>
                </div>
            </div>
        </div>
    </div>
    <div class="testimonial-seal">
        <div class="seal">
            <div class="seal-inner">
                <div class="star">&#9733;</div>
                <p>Lizzy Standard Beauty</p>
            </div>
        </div>
    </div>
</section>

<!-- Booking Section -->
<section class="booking" id="booking">
    <div class="booking-content reveal">
        <p class="section-label">Book a Session</p>
        <h2 class="section-title">Reserve Your <span class="italic">Gold Seat.</span></h2>
        <div class="booking-intro">
            <p>Ready to experience the gold standard? Fill in your details and I'll get back to you within 24 hours to confirm your appointment.</p>
        </div>

        <div class="booking-contact">
            <div class="contact-item">
                <div class="icon">&#9993;</div>
                <div>
                    <strong>Email</strong>
                    <a href="mailto:premierelizabeth582@gmail.com">premierelizabeth582@gmail.com</a>
                </div>
            </div>
            <div class="contact-item">
                <div class="icon">&#9742;</div>
                <div>
                    <strong>Phone</strong>
                    <a href="tel:+2349014952585">+234 901 495 2585</a>
                </div>
            </div>
            <div class="contact-item">
                <div class="icon">&#9873;</div>
                <div>
                    <strong>Location</strong>
                    Obeama, Oyigbo, Rivers State.
                </div>
            </div>
            <div class="contact-item">
                <div class="icon"><i class="fab fa-whatsapp"></i></div>
                <div>
                    <strong>WhatsApp</strong>
                    <a href="https://wa.me/2349014952585?text=Hello%20Lizzy%20Beauty%2C%20I%20would%20like%20to%20book%20an%20appointment." target="_blank" rel="noopener">Chat on WhatsApp</a>
                </div>
            </div>
        </div>

        <div class="price-options">
            <div class="price-option selected" onclick="selectPrice(this)">
                <div class="amount">₦25,000</div>
                <div class="type">Braids</div>
            </div>
            <div class="price-option" onclick="selectPrice(this)">
                <div class="amount">₦10,000</div>
                <div class="type">Lashes</div>
            </div>
            <div class="price-option" onclick="selectPrice(this)">
                <div class="amount">₦8,000</div>
                <div class="type">Nails</div>
            </div>
        </div>

        <div class="form-success" id="formSuccess">
            <div class="checkmark">&#10003;</div>
            <h3>Request Received!</h3>
            <p>Thank you for reaching out. I'll get back to you within 24 hours to confirm your appointment.</p>
            <br>
            <a href="#" class="btn-primary" id="bookAnotherBtn">Book Another</a>
        </div>
        <form class="booking-form" id="bookingForm" action="index.php" method="POST">
            <input type="hidden" name="sent" value="1">
            <div class="form-row">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Your name" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone" placeholder="+234 000 000 0000" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="premierelizabeth582@gmail.com" required>
                </div>
                <div class="form-group">
                    <label>Service</label>
                    <select name="service" required>
                        <option value="">Select a service</option>
                        <option value="braids">Hair Braiding — From ₦15,000</option>
                        <option value="lashes">Lash Extensions — From ₦8,000</option>
                        <option value="nails">Nail Services — From ₦5,000</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Message (Optional)</label>
                <textarea name="message" placeholder="Tell me your vision, preferred dates, or any questions..."></textarea>
            </div>
            <button type="submit" class="form-submit">Request My Appointment</button>
            <p class="form-note">I'll respond within 24 hours. No spam, ever.</p>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-logo">
            <span>&#9813;</span> Lizzy<span class="gold-accent">Beauty</span>
        </div>
        <ul class="footer-links">
            <li><a href="#services">Services</a></li>
            <li><a href="#standard">About</a></li>
            <li><a href="#booking">Book</a></li>
            <li><a href="https://wa.me/2349014952585?text=Hello%20Lizzy%20Beauty%2C%20I%20would%20like%20to%20book%20an%20appointment." target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
        </ul>
        <div class="footer-bottom">
            <span>&copy; 2024 LizzyBeauty.</span>
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
        </div>
    </div>
</footer>

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/2349014952585?text=Hello%20Lizzy%20Beauty%2C%20I%20would%20like%20to%20book%20an%20appointment." class="whatsapp-fab" target="_blank" rel="noopener">
    <i class="fab fa-whatsapp"></i>
</a>

<script>
    // Page loader
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.getElementById('pageLoader').classList.add('hidden');
        }, 600);
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 80) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Scroll reveal animation
    function revealOnScroll() {
        const reveals = document.querySelectorAll('.reveal');
        const windowHeight = window.innerHeight;
        reveals.forEach(function(el) {
            const top = el.getBoundingClientRect().top;
            if (top < windowHeight - 100) {
                el.classList.add('active');
            }
        });
    }
    window.addEventListener('scroll', revealOnScroll);
    window.addEventListener('load', revealOnScroll);

    // Service card interaction
    document.querySelectorAll('.service-card').forEach(function(card) {
        card.addEventListener('click', function() {
            document.querySelectorAll('.service-card').forEach(function(c) {
                c.classList.remove('active');
            });
            card.classList.add('active');
        });
    });

    // Price option selection
    function selectPrice(el) {
        document.querySelectorAll('.price-option').forEach(function(p) {
            p.classList.remove('selected');
        });
        el.classList.add('selected');
    }

       // Form validation and submission
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('.form-submit');
        btn.textContent = 'Sending...';
        btn.disabled = true;
        
        const formData = new FormData(this);
        fetch('index.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            document.getElementById('bookingForm').style.display = 'none';
            document.getElementById('formSuccess').classList.add('show');
        })
        .catch(err => {
            console.log(err);
            // Even if email fails, still show success for user
            document.getElementById('bookingForm').style.display = 'none';
            document.getElementById('formSuccess').classList.add('show');
        })
        .finally(() => {
            btn.textContent = 'Request My Appointment';
            btn.disabled = false;
        });
    });

    // Book Another button - reset form and show it again
    document.getElementById('bookAnotherBtn').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('bookingForm').reset();
        document.getElementById('bookingForm').style.display = 'block';
        document.getElementById('formSuccess').classList.remove('show');
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offset = 80;
                const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }
        });
    });

    // Counter animation for hero stats
    function animateCounter(element, target, suffix) {
        let count = 0;
        const duration = 2000;
        const increment = target / (duration / 16);
        const timer = setInterval(function() {
            count += increment;
            if (count >= target) {
                count = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(count) + suffix;
        }, 16);
    }

// Background image cycling for service cards
const serviceImages = {
    braids: ['images/be2.png', 'images/be6.png', 'images/be7.png', 'images/be9.png'],
    lashes: ['images/be13.webp', 'images/be14.webp', 'images/be15.webp'],
    nails: ['images/be16.webp', 'images/be17.webp', 'images/be18.webp']
};

document.querySelectorAll('.service-card').forEach(card => {
    const service = card.getAttribute('data-service');
    if (service && serviceImages[service]) {
        const images = serviceImages[service];
        let index = 0;
        card.style.setProperty('--card-bg-opacity', '1');
        setInterval(() => {
            card.style.setProperty('--card-bg-opacity', '0');
            setTimeout(() => {
                index = (index + 1) % images.length;
                card.style.setProperty('--card-bg', `url("${images[index]}")`);
                card.style.setProperty('--card-bg-opacity', '1');
            }, 500);
        }, 4000);
    }
});

// Move hero-stats into image container on mobile
function moveHeroStats() {
    const heroStats = document.querySelector('.hero-stats');
    const heroRight = document.querySelector('.hero-right');
    if (window.innerWidth <= 768 && heroStats && heroRight && !heroStats.classList.contains('moved')) {
        heroRight.appendChild(heroStats);
        heroStats.classList.add('moved');
    } else if (window.innerWidth > 768 && heroStats && heroStats.classList.contains('moved')) {
        const heroLeft = document.querySelector('.hero-left');
        const heroContent = document.querySelector('.hero-content');
        if (heroContent) heroContent.appendChild(heroStats);
        heroStats.classList.remove('moved');
    }
}
window.addEventListener('load', moveHeroStats);
window.addEventListener('resize', moveHeroStats);

// Trigger counter animation when hero is visible
window.addEventListener('load', function() {
    const heroStatNumbers = document.querySelectorAll('.hero-stat .number');
    if (heroStatNumbers.length >= 3) {
        setTimeout(function() {
            animateCounter(heroStatNumbers[0], 50, '+');
            animateCounter(heroStatNumbers[1], 5, '.0');
            // Third one is text "6 yrs" - skip animation or animate differently
        }, 1200);
    }
});
</script>

</body>
</html>
