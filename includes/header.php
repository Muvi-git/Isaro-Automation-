<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isaro Automation Systems (Pvt) Ltd</title>

    <!-- Google Fonts Preconnect (Speed & Font Flicker Fix) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom Master Style -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- ALL PAGE STYLES & LAYOUT SHIFT FIXES LOADED DIRECTLY IN HEAD -->
    <style>
/* 1. Global Layout Stabilization & Scrollbar Jump Fix */
html {
    overflow-y: scroll; /* Forces permanent scrollbar space so navbar never shifts left/right */
}

html, body {
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    margin: 0;
    padding: 0;
}

body {
    overflow-x: hidden;
    background-color: #ffffff;
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
    text-align: justify;
    text-justify: inter-word;
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


/* ===================================================
   FLOATING WHATSAPP & RESPONSIVE FIXES
=================================================== */
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
    .about-hero-title, .contact-hero-title { font-size: 1.8rem; }
    .who-title, .team-section-title, .form-section-title { font-size: 1.5rem; }
    .pill-image-wrapper { height: 230px; border-radius: 30px; }
    .whatsapp-float { width: 52px; height: 52px; font-size: 28px; }
    .vm-card { padding: 20px 15px; min-height: auto; }
    .contact-info-card { padding: 30px 22px; }
}
    </style>
</head>
<body>

<header class="isaro-navbar navbar navbar-expand-lg sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/images/industrial_automation_logo 1.png" alt="Isaro Automation Logo" class="img-fluid">
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

            <!-- Search Form -->
            <form class="d-flex isaro-search-box mt-2 mt-lg-0" action="products.php" method="GET">
                <input class="form-control isaro-search-input w-100" type="search" name="query" placeholder="Search..." aria-label="Search" required>
                <button class="isaro-search-btn" type="submit" title="Search">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</header>