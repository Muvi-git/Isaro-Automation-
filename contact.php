<?php 
include 'includes/header.php'; 
require_once 'config/db.php';

$form_success = false;
$form_error = '';

// Handle Contact Form Submission to Database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $full_name = trim($first_name . ' ' . $last_name);

    if (!empty($full_name) && !empty($email) && !empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO inquiries (full_name, email, phone, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$full_name, $email, $phone, $message]);
            $form_success = true;
        } catch (PDOException $e) {
            $form_error = 'Error submitting inquiry. Please try again.';
        }
    } else {
        $form_error = 'Please fill in all required fields.';
    }
}
?>

<!-- Page Specific Responsive & Figma Exact Styles -->
<style>
/* Page Scope Wrapper */
.isaro-contact-page {
    font-family: 'Poppins', sans-serif;
    color: #333333;
}

/* Apple-Style Smooth Animation Classes */
.apple-reveal {
    opacity: 0 !important;
    transform: translateY(35px) scale(0.98) !important;
    transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), 
                transform 0.85s cubic-bezier(0.16, 1, 0.3, 1) !important;
    will-change: opacity, transform;
}

.apple-reveal.is-revealed {
    opacity: 1 !important;
    transform: translateY(0) scale(1) !important;
}

/* 1. Hero Section */
.contact-hero-section {
    position: relative;
    background: linear-gradient(rgba(0, 0, 0, 0.68), rgba(0, 0, 0, 0.68)), url('assets/images/feedf7b7a69a5cfc65e4d847497ca581f69a9a4d.jpg') center/cover no-repeat;
    min-height: 340px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.contact-hero-title {
    color: #ff0000;
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 15px;
    letter-spacing: -0.5px;
}

.contact-hero-p {
    color: #ffffff;
    font-size: 0.78rem;
    line-height: 1.6;
    max-width: 820px;
    margin: 0 auto;
    font-weight: 300;
    opacity: 0.9;
}

/* 2. Contact Info & Technician Image Section */
.contact-info-section {
    background-color: #f4f4f4;
    padding: 70px 0 50px 0;
}

/* Dark Contact Information Card */
.contact-info-card {
    background-color: #1e2125;
    border-radius: 18px;
    padding: 40px 35px;
    color: #ffffff;
    position: relative;
    overflow: hidden;
    height: 100%;
    min-height: 480px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.contact-card-content {
    position: relative;
    z-index: 2;
}

.contact-info-card::after {
    content: '';
    position: absolute;
    bottom: -110px;
    right: -80px;
    width: 340px;
    height: 340px;
    background-color: rgba(176, 48, 48, 0.35);
    border-radius: 50%;
    pointer-events: none;
    z-index: 1;
}

.contact-info-card::before {
    content: '';
    position: absolute;
    bottom: 50px;
    right: 80px;
    width: 175px;
    height: 175px;
    background-color: rgba(176, 48, 48, 0.25);
    border-radius: 50%;
    pointer-events: none;
    z-index: 1;
}

.contact-card-title {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 6px;
    color: #ffffff;
}

.contact-card-sub {
    font-size: 0.85rem;
    color: #aaaaaa;
    margin-bottom: 35px;
    font-weight: 300;
}

.contact-detail-list {
    list-style: none;
    padding: 0;
    margin: 0 0 30px 0;
}

.contact-detail-item {
    display: flex;
    align-items: flex-start;
    gap: 18px;
    margin-bottom: 20px;
    font-size: 0.82rem;
    color: #dddddd;
    line-height: 1.5;
}

.contact-detail-item i {
    font-size: 1rem;
    color: #ffffff;
    margin-top: 3px;
    width: 20px;
    text-align: center;
}

.contact-detail-item a {
    color: #dddddd;
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-detail-item a:hover {
    color: #b03030;
}

/* Social Buttons */
.contact-socials {
    display: flex;
    gap: 12px;
    position: relative;
    z-index: 5;
}

.contact-social-btn {
    width: 34px;
    height: 34px;
    background-color: #ffffff;
    color: #1e2125;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.88rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.contact-social-btn:hover {
    background-color: #b03030;
    color: #ffffff;
    transform: translateY(-3px);
}

/* Right Technician Image Card */
.contact-img-box {
    width: 100%;
    height: 100%;
    min-height: 480px;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
}

.contact-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* 3. Form & Map Section */
.contact-form-section {
    background-color: #f4f4f4;
    padding-bottom: 75px;
}

.contact-map-box {
    width: 100%;
    height: 100%;
    min-height: 460px;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    background-color: #e5e5e5;
}

.contact-map-box iframe {
    width: 100%;
    height: 100%;
    min-height: 460px;
    border: 0;
    display: block;
}

/* Form Styles */
.contact-form-wrapper {
    padding-left: 15px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.form-section-title {
    color: #b03030;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 25px;
    letter-spacing: -0.3px;
}

.contact-form .form-label-custom {
    font-size: 0.76rem;
    font-weight: 600;
    color: #333333;
    margin-bottom: 4px;
    display: block;
}

.contact-form .form-control-custom {
    width: 100%;
    background: transparent;
    border: none;
    border-bottom: 1px solid #777777;
    border-radius: 0;
    padding: 6px 0 10px 0;
    font-size: 0.82rem;
    color: #333333;
    outline: none;
    transition: border-color 0.3s ease;
}

.contact-form .form-control-custom:focus {
    border-bottom-color: #b03030;
}

.contact-form .form-control-custom::placeholder {
    color: #888888;
    font-size: 0.8rem;
    font-weight: 300;
}

.contact-form textarea.form-control-custom {
    min-height: 135px;
    resize: none;
}

.btn-contact-submit {
    background-color: #b03030;
    color: #ffffff;
    border: none;
    padding: 10px 38px;
    font-size: 0.88rem;
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(176, 48, 48, 0.25);
}

.btn-contact-submit:hover {
    background-color: #8e2323;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(176, 48, 48, 0.38);
}

/* Floating WhatsApp Icon Animation */
.whatsapp-float {
    position: fixed;
    width: 58px;
    height: 58px;
    bottom: 25px;
    right: 25px;
    background-color: #25d366;
    color: #FFFFFF !important;
    border-radius: 50px;
    font-size: 32px;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
}

.whatsapp-float:hover {
    transform: scale(1.15) translateY(-5px);
    box-shadow: 0 10px 25px rgba(37, 211, 102, 0.5) !important;
    background-color: #20ba5a !important;
}

.whatsapp-float:hover i {
    animation: whatsapp-shake 0.4s ease-in-out infinite alternate;
}

@keyframes whatsapp-shake {
    0% { transform: rotate(-12deg); }
    100% { transform: rotate(12deg); }
}

/* =========================================================
   APPLE-GRADE MOBILE & TABLET RESPONSIVENESS (MATCHING INDEX & ABOUT)
   ========================================================= */
@media (max-width: 991.98px) {
    .contact-hero-title { font-size: 2.2rem; }
    .form-section-title { font-size: 1.6rem; }
    .contact-form-wrapper { padding-left: 0; margin-top: 25px; }
    .contact-info-card, .contact-img-box { min-height: 400px; }
    .contact-map-box, .contact-map-box iframe { min-height: 380px; }
}

@media (max-width: 575.98px) {
    /* 1. Hero Section Mobile Optimization */
    .contact-hero-section { min-height: 280px !important; padding: 2.5rem 0 !important; }
    .contact-hero-title { font-size: clamp(1.6rem, 6vw, 2.2rem) !important; margin-bottom: 10px !important; }
    .contact-hero-p { font-size: 0.8rem !important; line-height: 1.5 !important; padding: 0 10px; }

    /* 2. Contact Info & Technician Image Mobile Optimization */
    .contact-info-section { padding: 45px 0 35px 0 !important; }
    .contact-info-card { padding: 26px 20px !important; min-height: auto !important; border-radius: 16px !important; }
    .contact-card-title { font-size: 1.35rem !important; }
    .contact-card-sub { font-size: 0.78rem !important; margin-bottom: 22px !important; }
    .contact-detail-item { font-size: 0.78rem !important; gap: 12px !important; margin-bottom: 15px !important; }
    .contact-img-box { min-height: 260px !important; border-radius: 16px !important; }

    /* 3. Form & Map Section Mobile Optimization */
    .contact-form-section { padding-bottom: 45px !important; }
    .contact-map-box, .contact-map-box iframe { min-height: 300px !important; border-radius: 16px !important; }
    .form-section-title { font-size: 1.35rem !important; margin-bottom: 18px !important; }
    .btn-contact-submit { width: 100% !important; padding: 12px 0 !important; font-size: 0.85rem !important; }

    /* 4. Floating WhatsApp Icon Mobile Safe Position */
    .whatsapp-float {
        width: 48px !important;
        height: 48px !important;
        font-size: 26px !important;
        bottom: 18px !important;
        right: 18px !important;
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4) !important;
    }
}
</style>

<div class="isaro-main-wrapper isaro-contact-page">

    <!-- 1. HERO SECTION -->
    <section class="contact-hero-section py-5">
        <div class="container py-4">
            <h1 class="contact-hero-title">Contact Us</h1>
            <p class="contact-hero-p">
                Get in touch with our engineering team for technical support, product inquiries, and custom industrial automation solutions tailored to your operational needs.
            </p>
        </div>
    </section>

    <!-- 2. CONTACT INFO & TECHNICIAN IMAGE SECTION -->
    <section class="contact-info-section">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <!-- Left Column: Dark Contact Information Card -->
                <div class="col-12 col-lg-6">
                    <div class="contact-info-card">
                        <div class="contact-card-content">
                            <h3 class="contact-card-title">Contact Information</h3>
                            <p class="contact-card-sub">Say something to start a live chat!</p>

                            <ul class="contact-detail-list">
                                <li class="contact-detail-item">
                                    <i class="fas fa-phone"></i>
                                    <a href="tel:+94114011784">+ 94 11 4011784</a>
                                </li>
                                <li class="contact-detail-item">
                                    <i class="fas fa-phone"></i>
                                    <a href="tel:+94114216784">+ 94 11 4216784</a>
                                </li>
                                <li class="contact-detail-item">
                                    <i class="fas fa-phone"></i>
                                    <a href="tel:+94115746784">+ 94 11 5746784</a>
                                </li>
                                <li class="contact-detail-item">
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:info@isaroautomation.com">info@isaroautomation.com</a>
                                </li>
                                <li class="contact-detail-item">
                                    <i class="fas fa-globe"></i>
                                    <a href="http://www.isaroautomation.com" target="_blank">www.isaroautomation.com</a>
                                </li>
                                <li class="contact-detail-item">
                                    <i class="fas fa-location-dot"></i>
                                    <span>
                                        Isaro Automation Systems (Pvt) Ltd<br>
                                        No. 400,Galle Road<br>
                                        Rawathawatte, Moratuwa<br>
                                        Sri Lanka
                                    </span>
                                </li>
                            </ul>
                        </div>

                        <!-- Social Media Circle Buttons -->
                        <div class="contact-socials">
                            <a href="#" class="contact-social-btn" title="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="contact-social-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="contact-social-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Technician Image Box -->
                <div class="col-12 col-lg-6">
                    <div class="contact-img-box">
                        <img src="assets/images/2eaf6daacbcfeb54ef8944e2eb85c527772da507 (1).png" alt="Contact Technician Working">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. FORM & MAP SECTION (ALIGNED BOTTOM WITH MAP) -->
    <section class="contact-form-section">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <!-- Left Column: Google Map Live Embed -->
                <div class="col-12 col-lg-6">
                    <div class="contact-map-box">
                        <iframe src="https://maps.google.com/maps?q=Rawathawatte%20Junction,%20Galle%20Road,%20Moratuwa,%20Sri%20Lanka&t=&z=14&ie=UTF8&iwloc=&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <!-- Right Column: Contact Question Form -->
                <div class="col-12 col-lg-6">
                    <div class="contact-form-wrapper">
                        <div>
                            <h2 class="form-section-title">Mention Your Question Here!</h2>

                            <?php if($form_success): ?>
                                <div class="alert alert-success py-2 text-center rounded-3 mb-4" style="font-size: 0.85rem;">
                                    <i class="fas fa-check-circle me-1"></i> Thank you! Your message has been saved successfully.
                                </div>
                            <?php endif; ?>

                            <?php if(!empty($form_error)): ?>
                                <div class="alert alert-danger py-2 text-center rounded-3 mb-4" style="font-size: 0.85rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i> <?php echo $form_error; ?>
                                </div>
                            <?php endif; ?>

                            <form action="contact.php" method="POST" class="contact-form">
                                <div class="row g-4">
                                    <!-- First Name -->
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label-custom">First Name</label>
                                        <input type="text" name="first_name" class="form-control-custom" placeholder="John" required>
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label-custom">Last Name</label>
                                        <input type="text" name="last_name" class="form-control-custom" placeholder="Doe" required>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label-custom">Email</label>
                                        <input type="email" name="email" class="form-control-custom" placeholder="kumara5672@rrxxx.com" required>
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label-custom">Phone Number</label>
                                        <input type="text" name="phone" class="form-control-custom" placeholder="+94 xx xx xx xxx">
                                    </div>

                                    <!-- Message -->
                                    <div class="col-12">
                                        <label class="form-label-custom">Message</label>
                                        <textarea name="message" class="form-control-custom" placeholder="Write your message.." required></textarea>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12 text-end pt-2">
                                        <button type="submit" class="btn btn-contact-submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/94114216784" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // LANDING SCROLL REVEAL OBSERVER FOR CONTACT PAGE
    const observerOptions = { root: null, rootMargin: "0px 0px -30px 0px", threshold: 0.05 };
    const revealObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-revealed");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const contactAnimElements = document.querySelectorAll(
        ".contact-info-card, .contact-img-box, .contact-map-box, .contact-form-wrapper"
    );

    contactAnimElements.forEach(function(el) {
        el.classList.add("apple-reveal");
        revealObserver.observe(el);
    });
});
</script>

<?php include 'includes/footer.php'; ?>