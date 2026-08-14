<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isaro Automation Systems (Pvt) Ltd</title>

    <!-- Ultra-HD Crisp Vector Circular Favicon (Lossless Upscaled SVG) -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cdefs%3E%3ClinearGradient id='isaroGlow' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23900c3f'/%3E%3Cstop offset='50%25' stop-color='%23c71585'/%3E%3Cstop offset='100%25' stop-color='%23e65c9c'/%3E%3C/linearGradient%3E%3C/defs%3E%3Ccircle cx='50' cy='50' r='48' fill='url(%23isaroGlow)' stroke='%23ffffff' stroke-width='2'/%3E%3Ccircle cx='50' cy='22' r='7' fill='%23ffd700' stroke='%23333333' stroke-width='0.8'/%3E%3Ccircle cx='50' cy='22' r='3.2' fill='%23000000'/%3E%3Cpolyline points='12,47 40,47 50,28 62,75 72,54 88,47' fill='none' stroke='%23ffd700' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3Cpolyline points='12,54 38,54 50,35 62,82 72,61 88,54' fill='none' stroke='%23ffd700' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E">

    <!-- Google Fonts Preconnect (Speed, Font Flicker & Swap Fix) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom Master Style -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- APPLE-STYLE ZERO-SHIFT PREMIUM ANIMATION ENGINE -->
    <style>
/* 1. ROCK-SOLID GLOBAL STABILITY & SCROLLBAR GUTTER (PREVENTS HORIZONTAL SHIFT ACROSS PAGES) */
html {
    scrollbar-gutter: stable;
    overflow-y: scroll !important;
}

html, body {
    margin: 0 !important;
    padding: 0 !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    background-color: #ffffff;
    scroll-behavior: smooth;
    overflow-x: clip !important; 
}

/* 2. TOP SLIM ACCENT PROGRESS BAR */
#top-progress-bar {
    position: fixed;
    top: 0;
    left: 0;
    height: 3px;
    width: 0%;
    background: linear-gradient(90deg, #b03030, #ff0000);
    box-shadow: 0 0 12px rgba(255, 0, 0, 0.75);
    z-index: 999999;
    opacity: 0;
    transition: width 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
    pointer-events: none;
}

#top-progress-bar.is-loading {
    opacity: 1;
}

/* 3. 100% STABLE STICKY HEADER (PERFECT PROPORTION & ZERO SHIFT) */
header.isaro-navbar {
    position: sticky !important;
    top: 0 !important;
    z-index: 1050 !important;
    background-color: rgba(255, 255, 255, 0.98) !important;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    margin-top: 0 !important;
    padding: 15px 0 !important; /* Elegant balanced padding */
    min-height: 88px !important; /* Ideal balanced height */
    display: flex;
    align-items: center;
    transform: translateZ(0);
}

.navbar-brand img {
    height: 54px !important; /* Perfectly sized logo */
    width: auto !important;
    max-height: 54px !important;
    object-fit: contain;
    display: block;
}

.isaro-header-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

/* 4. LIVE SEARCH DROPDOWN */
.isaro-search-box {
    position: relative;
    min-width: 250px;
}

#liveSearchResults {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    min-width: 280px;
    background: #ffffff;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    margin-top: 6px;
    z-index: 1080;
    max-height: 320px;
    overflow-y: auto;
    display: none;
    padding: 6px;
}

#liveSearchResults .dropdown-item {
    padding: 8px 10px;
    border-radius: 6px;
    transition: background-color 0.2s ease;
    white-space: normal;
}

#liveSearchResults .dropdown-item:hover {
    background-color: #f8f9fa;
}

/* 5. APPLE-STYLE CINEMATIC SCROLL REVEAL */
.apple-reveal {
    opacity: 0;
    transform: translateY(45px) scale(0.98);
    transition: opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1), 
                transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
    will-change: opacity, transform;
}

.apple-reveal.is-revealed {
    opacity: 1 !important;
    transform: translateY(0) scale(1) !important;
}

/* 6. APPLE-STYLE CINEMATIC HERO ENTRANCE */
.hero-title, .about-hero-title, .contact-hero-title, .page-hero-title {
    opacity: 0;
    animation: appleHeroText 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards;
}

.lead, .about-hero-p, .contact-hero-p, .who-title, .form-section-title, .page-hero-desc {
    opacity: 0;
    animation: appleHeroText 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.25s forwards;
}

.isaro-hero-section .btn, .partner-badge {
    opacity: 0;
    animation: appleHeroText 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.4s forwards;
}

@keyframes appleHeroText {
    0% { opacity: 0; transform: translateY(40px) scale(0.98); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

/* 7. FLOATING WHATSAPP BUTTON */
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

/* ===================================================
   ABOUT PAGE STYLES (.isaro-about-page)
=================================================== */
.isaro-about-page {
    font-family: 'Poppins', sans-serif;
    color: #333333;
}

.about-hero-section {
    position: relative;
    background: linear-gradient(rgba(0, 0, 0, 0.68), rgba(0, 0, 0, 0.68)), url('assets/images/feedf7b7a69a5cfc65e4d847497ca581f69a9a4d.jpg') center/cover no-repeat;
    min-height: 340px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.about-hero-title {
    color: #ff0000;
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 15px;
    letter-spacing: -0.5px;
}

.about-hero-p {
    color: #ffffff;
    font-size: 0.78rem;
    line-height: 1.6;
    max-width: 820px;
    margin: 0 auto;
    font-weight: 300;
    opacity: 0.9;
}

.who-we-are-section {
    background-color: #f4f4f4;
    padding: 70px 0 50px 0;
}

.who-text-col {
    padding-right: 45px;
}

.who-title {
    color: #b03030;
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 20px;
}

.who-p {
    font-size: 0.83rem;
    line-height: 1.65;
    color: #333333;
    text-align: left !important;
    margin-bottom: 18px;
}

.pill-image-wrapper {
    height: 390px;
    border-radius: 45px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.pill-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.pill-1 img { object-position: 0% center; }
.pill-2 img { object-position: 50% center; }
.pill-3 img { object-position: 100% center; }

.vm-section {
    background-color: #f4f4f4;
    padding-bottom: 70px;
}

.vm-card {
    position: relative;
    border-radius: 22px;
    padding: 22px 25px;
    text-align: center;
    color: #ffffff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
    overflow: hidden;
    width: 100%;
    max-width: 430px;
    margin: 0 auto;
    aspect-ratio: 1.48 / 1;
    min-height: 230px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.vm-card-vision {
    background: linear-gradient(rgba(22, 24, 30, 0.78), rgba(22, 24, 30, 0.78)), url('assets/images/a79d7ea9dab8d052004fc56a5ef5adc16635039a.png') center/cover no-repeat;
}

.vm-card-mission {
    background: linear-gradient(rgba(22, 24, 30, 0.78), rgba(22, 24, 30, 0.78)), url('assets/images/e12a3b3b258b9e4daf5604024fb2355b4b03576b.png') center/cover no-repeat;
}

.vm-icon-circle {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 4px;
    font-size: 2.5rem;
    color: #ffffff;
}

.vm-title {
    color: #b03030;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 6px;
    letter-spacing: -0.3px;
}

.vm-p {
    font-size: 0.78rem;
    color: #ffffff;
    line-height: 1.45;
    margin: 0 auto;
    max-width: 370px;
    font-weight: 400;
    opacity: 0.95;
}

.team-section {
    position: relative;
    background: linear-gradient(rgba(0, 0, 0, 0.58), rgba(0, 0, 0, 0.58)), url('assets/images/67d12759ce882ac6dba72d274c24e0c3e3f0bc10.png') center/cover no-repeat;
    padding: 75px 0 85px 0;
    color: #ffffff;
    text-align: center;
}

.team-section-title {
    color: #b03030;
    font-size: 2.4rem;
    font-weight: 700;
    margin-bottom: 45px;
    letter-spacing: -0.5px;
}

.team-card-item {
    text-align: center;
}

.team-member-img-box {
    width: 100%;
    aspect-ratio: 1 / 1;
    border-radius: 18px;
    overflow: hidden;
    background-color: #ffffff;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
    transition: transform 0.3s ease;
}

.team-card-item:hover .team-member-img-box {
    transform: translateY(-6px);
}

.team-member-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
}

.team-member-name {
    font-size: 1.05rem;
    font-weight: 600;
    color: #ffffff;
    margin-top: 15px;
    margin-bottom: 3px;
    letter-spacing: 0.2px;
}

.team-member-desc {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.75);
    margin-bottom: 0;
    font-weight: 300;
}

/* ===================================================
   CONTACT PAGE STYLES (.isaro-contact-page)
=================================================== */
.isaro-contact-page {
    font-family: 'Poppins', sans-serif;
    color: #333333;
}

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

.contact-info-section {
    background-color: #f4f4f4;
    padding: 70px 0 50px 0;
}

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

@media (max-width: 991.98px) {
    .about-hero-title, .contact-hero-title { font-size: 2.2rem; }
    .who-title, .team-section-title, .form-section-title { font-size: 1.8rem; }
    .who-text-col, .contact-form-wrapper { padding-right: 0; padding-left: 0; margin-top: 15px; }
    .pill-image-wrapper { height: 320px; border-radius: 35px; }
    .vm-card { max-width: 100%; aspect-ratio: auto; padding: 25px 20px; min-height: 220px; }
    .contact-info-card, .contact-img-box { min-height: 400px; }
    .contact-map-box, .contact-map-box iframe { min-height: 380px; }
}

@media (max-width: 575.98px) {
    header.isaro-navbar { min-height: 72px !important; padding: 10px 0 !important; }
    .navbar-brand img { max-height: 42px !important; height: 42px !important; }
    .about-hero-title, .contact-hero-title { font-size: 1.8rem; }
    .who-title, .team-section-title, .form-section-title { font-size: 1.5rem; }
    .pill-image-wrapper { height: 230px; border-radius: 30px; }
    .whatsapp-float { width: 48px !important; height: 48px !important; font-size: 26px !important; bottom: 18px !important; right: 18px !important; }
    .vm-card { padding: 20px 15px; min-height: auto; }
    .contact-info-card { padding: 30px 22px; }
    .isaro-search-box { min-width: 100% !important; }
}
    </style>
</head>
<body>

<!-- TOP SLIM RED PROGRESS BAR -->
<div id="top-progress-bar"></div>

<header class="isaro-navbar navbar navbar-expand-lg sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/images/Untitled - 12 August 2026 at 09.47.16.png" alt="Isaro Automation Logo" class="img-fluid">
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#isaroNavbarContent" aria-controls="isaroNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Items -->
        <div class="collapse navbar-collapse" id="isaroNavbarContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link isaro-nav-link <?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : ''; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link isaro-nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link isaro-nav-link <?php echo ($current_page == 'products.php' || $current_page == 'product-detail.php') ? 'active' : ''; ?>" href="products.php">Our Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link isaro-nav-link <?php echo ($current_page == 'projects.php') ? 'active' : ''; ?>" href="projects.php">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link isaro-nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="contact.php">Contact Us</a>
                </li>
            </ul>

            <!-- Header Right Actions: Clean Aligned Search Box -->
            <div class="isaro-header-actions mt-2 mt-lg-0">
                <form class="d-flex isaro-search-box position-relative" action="products.php" method="GET" autocomplete="off">
                    <input class="form-control isaro-search-input w-100" type="search" id="headerSearchInput" name="query" placeholder="Search products..." aria-label="Search" onkeyup="handleHeaderLiveSearch(this.value)" required>
                    <button class="isaro-search-btn" type="submit" title="Search">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Live Search Dropdown Results Menu -->
                    <div id="liveSearchResults" class="dropdown-menu shadow-lg border-0 rounded-3 p-2 mt-1 w-100" style="display: none; position: absolute; top: 100%; left: 0;">
                        <!-- Dynamic items rendered here -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/94114216784" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- 100% UNIVERSAL SCROLL REVEAL -->
<script>
// Global Industrial Product Database for Header Live Search
window.isaroGlobalSearchDB = [
    { title: 'Industrial Digital Panel Meters', code: 'ISA-DPM-9021', price: 'Rs 5,000', link: 'product-detail.php', img: 'assets/images/b432d96cfa8f80614741d6f26ee4c84e73ec4f86.png' },
    { title: 'Pressure Regulator', code: 'ISA-PRV-1022', price: 'Rs 5,000', link: 'product-detail.php', img: 'assets/images/811821004797026ac18c9a115f1b50578adfd1d1 (1).png' },
    { title: 'Hand Valve Pneumatic', code: 'ISA-HVL-3011', price: 'Rs 5,000', link: 'product-detail.php', img: 'assets/images/59935624d6a0605b083cee98e98ab5367e12f66d (1).png' },
    { title: 'Hydraulic Cylinders', code: 'ISA-HCY-4050', price: 'Rs 5,000', link: 'product-detail.php', img: 'assets/images/d5383f22ac03dc846865eaef9c1961bdefea7a5e (1).png' },
    { title: 'Programmable Terminals', code: 'ISA-PTM-8010', price: 'Rs 5,000', link: 'product-detail.php', img: 'assets/images/2bd82bccc12a674da93024bcfa909e92c9856c96.png' },
    { title: 'Switching Power Supplies', code: 'ISA-SPS-2405', price: 'Rs 5,000', link: 'product-detail.php', img: 'assets/images/ba017a87ff65aa4424f3158620d5d1b168f9d5f7.png' }
];

function handleHeaderLiveSearch(query) {
    var resultsBox = document.getElementById('liveSearchResults');
    if (!resultsBox) return;

    var trimmedQuery = query.trim().toLowerCase();

    if (trimmedQuery.length === 0) {
        resultsBox.style.display = 'none';
        resultsBox.innerHTML = '';
        return;
    }

    var filtered = window.isaroGlobalSearchDB.filter(function(item) {
        return item.title.toLowerCase().includes(trimmedQuery) || item.code.toLowerCase().includes(trimmedQuery);
    });

    if (filtered.length === 0) {
        resultsBox.style.display = 'block';
        resultsBox.innerHTML = '<div class="p-2 text-muted text-center fs-7" style="font-size: 0.8rem;">No products found</div>';
        return;
    }

    var html = '';
    filtered.forEach(function(item) {
        html += `
            <a href="${item.link}" class="dropdown-item d-flex align-items-center gap-2 py-2 px-2 rounded-2 text-decoration-none border-bottom">
                <img src="${item.img}" alt="${item.title}" style="width: 35px; height: 35px; object-fit: contain; border-radius: 4px; border: 1px solid #eee;">
                <div>
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.78rem; line-height: 1.2;">${item.title}</h6>
                    <span class="text-muted" style="font-size: 0.68rem;">Code: ${item.code} | <strong class="text-danger">${item.price}</strong></span>
                </div>
            </a>
        `;
    });

    resultsBox.style.display = 'block';
    resultsBox.innerHTML = html;
}

// Close live search dropdown when clicking outside
document.addEventListener('click', function(e) {
    var searchInput = document.getElementById('headerSearchInput');
    var resultsBox = document.getElementById('liveSearchResults');
    if (searchInput && resultsBox && !searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
        resultsBox.style.display = 'none';
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const progressBar = document.getElementById("top-progress-bar");

    // 1. Initial Page Load Top Bar Accent
    if (progressBar) {
        requestAnimationFrame(function() {
            progressBar.classList.add("is-loading");
            progressBar.style.width = "70%";
            setTimeout(function() {
                progressBar.style.width = "100%";
                setTimeout(function() {
                    progressBar.classList.remove("is-loading");
                    progressBar.style.width = "0%";
                }, 220);
            }, 160);
        });
    }

    // 2. Trigger Progress Bar on Navigation
    const links = document.querySelectorAll("a[href]");
    links.forEach(function(link) {
        const href = link.getAttribute("href");
        if (href && !href.startsWith("#") && !href.startsWith("javascript") && !href.startsWith("tel:") && !href.startsWith("mailto:") && link.target !== "_blank") {
            link.addEventListener("click", function(e) {
                if (progressBar) {
                    progressBar.style.width = "0%";
                    progressBar.classList.add("is-loading");
                    setTimeout(function() {
                        progressBar.style.width = "80%";
                    }, 20);
                }
            });
        }
    });

   // UNIVERSAL & PRECISE SCROLL REVEAL OBSERVER
    const observerOptions = {
        root: null,
        rootMargin: "0px 0px -40px 0px", 
        threshold: 0.05
    };

    const revealObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-revealed");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const animatableElements = document.querySelectorAll(
        ".row > [class*='col-'] > div, .card, .contact-info-card, .contact-map-box, .contact-form-wrapper, .testimonials-section .p-4, .who-text-col, .pill-image-wrapper, .isaro-footer .col-12"
    );

    animatableElements.forEach(function(el) {
        if(window.getComputedStyle(el).display === 'none') return;

        el.classList.add("apple-reveal");
        
        let delay = 0;
        let parentRow = el.closest('.row');
        if (parentRow) {
            let col = el.closest('[class*="col-"]');
            if (col) {
                let siblings = Array.from(parentRow.children);
                let indexInRow = siblings.indexOf(col);
                delay = (indexInRow % 4) * 0.12; 
            }
        }
        
        el.style.transitionDelay = delay + 's';
        revealObserver.observe(el);
    });
});
</script>
</body>
</html>