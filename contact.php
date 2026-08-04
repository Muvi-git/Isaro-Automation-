<?php include 'includes/header.php'; ?>

<!-- Page Specific Responsive & Figma Exact Styles -->
<style>
/* Page Scope Wrapper */
.isaro-contact-page {
    font-family: 'Poppins', sans-serif;
    color: #333333;
}

/* 1. Hero Section */
.contact-hero-section {
    position: relative;
    /* IMAGE PLACEHOLDER: Hero Dark Industrial Background Image */
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

/* Decorative Overlapping Circles Overlay on Dark Card Bottom-Right */
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

/* 3. Form & Map Section (Map & Form Bottom Alignment Perfect Match) */
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

/* Message Textarea Height Matching Map Bottom Line */
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

/* Responsiveness Fine-Tuning */
@media (max-width: 991.98px) {
    .contact-hero-title { font-size: 2.2rem; }
    .form-section-title { font-size: 1.6rem; }
    .contact-form-wrapper { padding-left: 0; margin-top: 25px; }
    .contact-info-card, .contact-img-box { min-height: 400px; }
    .contact-map-box, .contact-map-box iframe { min-height: 380px; }
}

@media (max-width: 575.98px) {
    .contact-hero-title { font-size: 1.8rem; }
    .form-section-title { font-size: 1.4rem; }
    .whatsapp-float { width: 52px; height: 52px; font-size: 28px; }
    .contact-info-card { padding: 30px 22px; }
}
</style>

<div class="isaro-main-wrapper isaro-contact-page">

    <!-- 1. HERO SECTION -->
    <section class="contact-hero-section py-5">
        <div class="container py-4">
            <h1 class="contact-hero-title">Contact Us</h1>
            <p class="contact-hero-p">
                elementum vehicula. Donec tempor Cras commodo non, sit Nam urna. Ut ex adipiscing gravida venenatis vitae commodo lacus nisi diam quis felis, fringilla diam x scelerisque tempor elit. varius vitae tincidunt Donec Nunc Nam luctus turpis nec risus ex Lorem eu
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
                        <!-- IMAGE PLACEHOLDER: Technician Cable Testing Image -->
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
                        <!-- Google Maps Live Embed for Rawathawatte, Moratuwa -->
                        <iframe src="https://maps.google.com/maps?q=Rawathawatte%20Junction,%20Galle%20Road,%20Moratuwa,%20Sri%20Lanka&t=&z=14&ie=UTF8&iwloc=&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <!-- Right Column: Contact Question Form -->
                <div class="col-12 col-lg-6">
                    <div class="contact-form-wrapper">
                        <div>
                            <h2 class="form-section-title">Mention Your Question Here!</h2>

                            <form action="" method="POST" class="contact-form">
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

                                    <!-- Submit Button (Aligned Right Under Bottom Underline) -->
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
    <a href="https://wa.me/94719847787" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

</div>

<?php include 'includes/footer.php'; ?>