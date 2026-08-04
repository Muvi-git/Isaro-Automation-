<?php include 'includes/header.php'; ?>

<!-- Comprehensive Responsive & Premium Design CSS -->
<style>
/* Global Smooth Enhancements & Flicker Prevention */
.isaro-main-wrapper {
    font-family: 'Poppins', sans-serif;
}

/* Hero Section Height Lock to Prevent FOUC / Layout Shift Flicker */
.isaro-hero-section {
    min-height: 480px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* WhatsApp Icon Size & Hover Animation Enhancement */
.whatsapp-float {
    width: 58px !important;
    height: 58px !important;
    font-size: 32px !important;
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

/* About Us Section Styles */
.about-badge-circle {
    width: 65px;
    height: 65px;
    background-color: #b03030;
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px auto;
    box-shadow: 0 4px 12px rgba(176, 48, 48, 0.22);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.about-badge-circle:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 18px rgba(176, 48, 48, 0.38);
}

/* Special Offer Carousel Adjustments */
.offer-dot-btn {
    width: 10px !important;
    height: 10px !important;
    border-radius: 50% !important;
    background-color: transparent !important;
    border: 2px solid #c82333 !important;
    margin: 0 !important;
    opacity: 0.5 !important;
    transition: all 0.3s ease !important;
    padding: 0 !important;
}
.offer-dot-btn.active {
    background-color: #c82333 !important;
    opacity: 1 !important;
    transform: scale(1.3);
}

/* Product Cards Hover & Typography */
.product-card-box {
    border: 1px solid #e2e2e2;
    border-radius: 12px;
    overflow: hidden;
    background: #ffffff;
    height: 100%;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.product-card-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
    border-color: #c82333;
}
.product-action-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid #e0e0e0;
    color: #333333;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    transition: all 0.2s ease;
}
.product-action-btn:hover {
    background: #c82333;
    color: #ffffff !important;
    border-color: #c82333;
}

/* Testimonial Section Adjustments */
.avatar-stack-img {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 2px solid #ffffff;
    margin-right: -10px;
    object-fit: cover;
    transition: transform 0.2s ease;
}
.avatar-stack-img:hover {
    transform: scale(1.18);
    z-index: 10;
}

/* Project Cards Hover */
.project-card-item {
    transition: all 0.3s ease;
}
.project-card-item:hover img {
    transform: scale(1.05);
}
.project-card-item img {
    transition: transform 0.4s ease;
}

/* Mobile & Tablet Responsiveness Fine-Tuning */
@media (max-width: 991.98px) {
    .hero-title { font-size: 2.2rem !important; }
    .about-img-container { min-height: 320px !important; }
    .offer-control-prev-custom { left: 15px !important; }
    .offer-control-next-custom { right: 15px !important; }
    .offer-banner-bg { min-height: 420px !important; }
    .isaro-hero-section { min-height: 400px; }
}

@media (max-width: 575.98px) {
    .hero-title { font-size: 1.65rem !important; }
    .offer-card-box { padding: 1.5rem 1.25rem !important; }
    .offer-card-box h3 { font-size: 1.1rem !important; }
    .offer-card-box h2 { font-size: 1.35rem !important; }
    .offer-control-prev-custom,
    .offer-control-next-custom {
        width: 38px !important;
        height: 38px !important;
    }
    .offer-control-prev-custom { left: 8px !important; }
    .offer-control-next-custom { right: 8px !important; }
    .about-badge-circle { width: 55px !important; height: 55px !important; }
    .offer-banner-bg { min-height: 380px !important; }
    .whatsapp-float { width: 52px !important; height: 52px !important; font-size: 28px !important; }
    .isaro-hero-section { min-height: 360px; }
}
</style>

<div class="isaro-main-wrapper">

<!-- 1. HERO BANNER -->
<section class="isaro-hero-section text-white py-5">
    <div class="container text-center py-4">
        <h1 class="hero-title fw-bold mb-3" style="font-size: 2.8rem; line-height: 1.25; letter-spacing: -0.3px;">
            Reliable Electrical, Hydraulic &<br>
            Pneumatic<br>
            <span style="color: #ff0000;" class="fw-extrabold">Automation</span> Systems
        </h1>
        <p class="lead mb-4 text-white mx-auto fs-6 fs-md-5" style="max-width: 680px; font-weight: 400; opacity: 0.9; line-height: 1.5;">
            Delivering advanced electrical, pneumatic, and hydraulic solutions for over 17 years.
        </p>
        <a href="products.php" class="btn btn-danger btn-lg px-4 py-2 fs-6 mb-5 shadow-sm rounded-2 fw-semibold" style="background-color: #b03030; border: none;">Explore More</a>

        <!-- Partners -->
        <div class="pt-2">
            <p class="small text-white mb-3" style="text-decoration: underline; font-size: 0.85rem;">Our Partners</p>
            <div class="d-flex justify-content-center align-items-center gap-3 gap-md-4 flex-wrap">
                <span class="partner-badge" title="Partner 1">
                    <img src="assets/images/b97bd4048a2dd2dd3ee7c2ea479d2d1ff89544a0.png" alt="Partner 1">
                </span>
                <span class="partner-badge" title="Partner 2">
                    <img src="assets/images/917982249a9f4c83b6d4f7784103acdb8d996119.png" alt="Partner 2">
                </span>
                <span class="partner-badge" title="Partner 3">
                    <img src="assets/images/50a7eb1b6abbb4c99ef16008ef997b1312d81a9c.png" alt="Partner 3">
                </span>
                <span class="partner-badge" title="Partner 4">
                    <img src="assets/images/c45b1ebfbd6f48f997f5c4d29db97a0c626996a8.png" alt="Partner 4">
                </span>
            </div>
        </div>
    </div>
</section>

<!-- 2. ABOUT US (RESTORED EXACT APPROVED ALIGNMENT & WRAP) -->
<section class="py-5" style="background-color: #f4f4f4;">
    <div class="container py-3">
        <div class="row align-items-center g-4">
            
            <!-- Content Left Column -->
            <div class="col-12 col-lg-7">
                <span class="text-secondary small fw-medium d-block mb-1" style="font-size: 0.88rem; color: #555555 !important;">About Us</span>
                <h2 class="fw-bold mb-3 fs-3" style="color: #b03030; line-height: 1.25;">
                    Experience Best Automation<br>Systems
                </h2>
                
                <p class="text-muted fs-7 mb-3" style="text-align: justify; text-justify: inter-word; max-width: 470px; line-height: 1.6;">
                    ISARO Automation Systems is a trusted leader in providing complete industrial automation solutions across Sri Lanka. With over 17 years of industry experience, we specialize in electrical, pneumatic, and hydraulic systems that power a wide range of industries. Our solutions are designed to improve operational efficiency, enhance reliability, and drive innovation.
                </p>
                <p class="text-muted fs-7 mb-4" style="text-align: justify; text-justify: inter-word; max-width: 470px; line-height: 1.6;">
                    We are committed to delivering not only high-quality products but also expert technical support, project consultancy, and customized services tailored to our clients' needs.
                </p>

                <!-- Round Image Badges Section -->
                <div class="row g-3 text-center" style="max-width: 470px;">
                    <div class="col-4">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle overflow-hidden shadow-sm mb-2 d-flex align-items-center justify-content-center bg-danger" style="width: 65px; height: 65px; background-color: #b03030 !important;">
                                <img src="assets/images/badge_quality.png" alt="Guaranteed Quality" class="img-fluid w-100 h-100 object-fit-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fas fa-ribbon text-white fs-3" style="display:none;"></i>
                            </div>
                            <h6 class="fw-bold text-secondary x-small mb-0" style="font-size: 0.76rem; line-height: 1.35; color: #4a5568;">Guaranteed Quality<br>and Reliability</h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle overflow-hidden shadow-sm mb-2 d-flex align-items-center justify-content-center bg-danger" style="width: 65px; height: 65px; background-color: #b03030 !important;">
                                <img src="assets/images/badge_partner.png" alt="Trusted Partner" class="img-fluid w-100 h-100 object-fit-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fas fa-thumbs-up text-white fs-3" style="display:none;"></i>
                            </div>
                            <h6 class="fw-bold text-secondary x-small mb-0" style="font-size: 0.76rem; line-height: 1.35; color: #4a5568;">Your Trusted Partner in<br>Automation</h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle overflow-hidden shadow-sm mb-2 d-flex align-items-center justify-content-center bg-danger" style="width: 65px; height: 65px; background-color: #b03030 !important;">
                                <img src="assets/images/badge_leading.png" alt="Leading Company" class="img-fluid w-100 h-100 object-fit-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <i class="fas fa-chart-line text-white fs-3" style="display:none;"></i>
                            </div>
                            <h6 class="fw-bold text-secondary x-small mb-0" style="font-size: 0.76rem; line-height: 1.35; color: #4a5568;">Leading Company in<br>Industries</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Images: Balanced Overlay -->
            <div class="col-12 col-lg-5">
                <div class="position-relative d-flex justify-content-end align-items-center about-img-container" style="min-height: 380px;">
                    <!-- Main Right Image -->
                    <img src="assets/images/c84739eb2ed88a5d12b5a4eaa2f2b5d9cc173fe8.jpg" alt="Automation Systems" class="img-fluid shadow-sm" style="width: 68%; height: 350px; object-fit: cover; border-radius: 18px;">
                    
                    <!-- Overlapping Left Bottom Image -->
                    <img src="assets/images/7e3d191a15ac23b17a1f8a34d1a0cbed7c03be85.jpg" alt="Quality Control" class="img-fluid shadow border border-white border-4 position-absolute" style="width: 48%; height: 200px; object-fit: cover; border-radius: 16px; left: 0; bottom: 12px; z-index: 2;">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 3. SPECIAL OFFER -->
<section class="offer-section py-0 bg-light">
    <div class="container-fluid px-0">
        <div id="offerBannerCarousel" class="carousel slide carousel-fade position-relative" data-bs-ride="carousel" data-bs-interval="3000" style="overflow: hidden;">
            
            <!-- Top-Right Diagonal "Hurry Up!" Ribbon -->
            <div style="position: absolute; top: 0; right: 0; width: 150px; height: 150px; overflow: hidden; z-index: 20; pointer-events: none;">
                <span style="position: absolute; display: block; width: 220px; padding: 8px 0; background-color: #b03030; color: #ffffff; font-size: 0.82rem; font-weight: 700; text-transform: uppercase; text-align: center; left: -25px; top: 32px; transform: rotate(45deg); box-shadow: 0 3px 10px rgba(0,0,0,0.25); letter-spacing: 0.5px;">Hurry Up!</span>
            </div>

            <!-- Carousel Slides -->
            <div class="carousel-inner">
                
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="d-flex align-items-center justify-content-center offer-banner-bg" style="background: url('assets/images/71455c53cbed251be21bbb31286a64a1ebe232e4 (2).png') center top / cover no-repeat; min-height: 520px; position: relative;">
                        <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.1); z-index: 1;"></div>
                        <div class="text-center p-4 p-md-5 offer-card-box" style="position: relative; z-index: 2; background: rgba(255, 255, 255, 0.55); backdrop-filter: blur(8px); border-radius: 18px; max-width: 580px; width: 88%; box-shadow: 0 10px 30px rgba(0,0,0,0.12);">
                            <h3 class="fw-bold text-dark fs-4 mb-1">Free installation for orders over</h3>
                            <h2 class="fw-extrabold fs-3 mb-2" style="color: #b03030;">Rs:5000</h2>
                            <p class="text-secondary x-small mb-4 mx-auto" style="max-width: 460px; line-height: 1.5; font-size: 0.78rem; color: #444444 !important;">
                                elementum vehicula, Donec tempor Cras commodo non, sit Nam urna. Ut ex adipiscing gravida venenatis vitae commodo lacus nisi diam quis felis, fringilla diam x scelerisque tempor elit. varius vitae tincidunt Donec Nunc Nam luctus turpis nec risus ex Lorem eu
                            </p>
                            <a href="products.php" class="btn text-white px-4 py-2 fw-semibold rounded-2 shadow-sm" style="background-color: #b03030; border: none;">Limited Time Offer</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="d-flex align-items-center justify-content-center offer-banner-bg" style="background: url('assets/images/shutterstock_165341882.jpg') center top / cover no-repeat; min-height: 520px; position: relative;">
                        <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.1); z-index: 1;"></div>
                        <div class="text-center p-4 p-md-5 offer-card-box" style="position: relative; z-index: 2; background: rgba(255, 255, 255, 0.55); backdrop-filter: blur(8px); border-radius: 18px; max-width: 580px; width: 88%; box-shadow: 0 10px 30px rgba(0,0,0,0.12);">
                            <h3 class="fw-bold text-dark fs-4 mb-1">Free installation for orders over</h3>
                            <h2 class="fw-extrabold fs-3 mb-2" style="color: #b03030;">Rs:5000</h2>
                            <p class="text-secondary x-small mb-4 mx-auto" style="max-width: 460px; line-height: 1.5; font-size: 0.78rem; color: #444444 !important;">
                                elementum vehicula, Donec tempor Cras commodo non, sit Nam urna. Ut ex adipiscing gravida venenatis vitae commodo lacus nisi diam quis felis, fringilla diam x scelerisque tempor elit. varius vitae tincidunt Donec Nunc Nam luctus turpis nec risus ex Lorem eu
                            </p>
                            <a href="products.php" class="btn text-white px-4 py-2 fw-semibold rounded-2 shadow-sm" style="background-color: #b03030; border: none;">Limited Time Offer</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <div class="d-flex align-items-center justify-content-center offer-banner-bg" style="background: url('assets/images/ac-maintenance-grande-prairie.jpg') center top / cover no-repeat; min-height: 520px; position: relative;">
                        <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.1); z-index: 1;"></div>
                        <div class="text-center p-4 p-md-5 offer-card-box" style="position: relative; z-index: 2; background: rgba(255, 255, 255, 0.55); backdrop-filter: blur(8px); border-radius: 18px; max-width: 580px; width: 88%; box-shadow: 0 10px 30px rgba(0,0,0,0.12);">
                            <h3 class="fw-bold text-dark fs-4 mb-1">Free installation for orders over</h3>
                            <h2 class="fw-extrabold fs-3 mb-2" style="color: #b03030;">Rs:5000</h2>
                            <p class="text-secondary x-small mb-4 mx-auto" style="max-width: 460px; line-height: 1.5; font-size: 0.78rem; color: #444444 !important;">
                                elementum vehicula, Donec tempor Cras commodo non, sit Nam urna. Ut ex adipiscing gravida venenatis vitae commodo lacus nisi diam quis felis, fringilla diam x scelerisque tempor elit. varius vitae tincidunt Donec Nunc Nam luctus turpis nec risus ex Lorem eu
                            </p>
                            <a href="products.php" class="btn text-white px-4 py-2 fw-semibold rounded-2 shadow-sm" style="background-color: #b03030; border: none;">Limited Time Offer</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="carousel-item">
                    <div class="d-flex align-items-center justify-content-center offer-banner-bg" style="background: url('assets/images/images.jpg') center top / cover no-repeat; min-height: 520px; position: relative;">
                        <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.1); z-index: 1;"></div>
                        <div class="text-center p-4 p-md-5 offer-card-box" style="position: relative; z-index: 2; background: rgba(255, 255, 255, 0.55); backdrop-filter: blur(8px); border-radius: 18px; max-width: 580px; width: 88%; box-shadow: 0 10px 30px rgba(0,0,0,0.12);">
                            <h3 class="fw-bold text-dark fs-4 mb-1">Free installation for orders over</h3>
                            <h2 class="fw-extrabold fs-3 mb-2" style="color: #b03030;">Rs:5000</h2>
                            <p class="text-secondary x-small mb-4 mx-auto" style="max-width: 460px; line-height: 1.5; font-size: 0.78rem; color: #444444 !important;">
                                elementum vehicula, Donec tempor Cras commodo non, sit Nam urna. Ut ex adipiscing gravida venenatis vitae commodo lacus nisi diam quis felis, fringilla diam x scelerisque tempor elit. varius vitae tincidunt Donec Nunc Nam luctus turpis nec risus ex Lorem eu
                            </p>
                            <a href="products.php" class="btn text-white px-4 py-2 fw-semibold rounded-2 shadow-sm" style="background-color: #b03030; border: none;">Limited Time Offer</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 5 -->
                <div class="carousel-item">
                    <div class="carousel-item-inner d-flex align-items-center justify-content-center offer-banner-bg" style="background: url('assets/images/Control-Panel-Integration.jpg') center top / cover no-repeat; min-height: 520px; position: relative;">
                        <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.1); z-index: 1;"></div>
                        <div class="text-center p-4 p-md-5 offer-card-box" style="position: relative; z-index: 2; background: rgba(255, 255, 255, 0.55); backdrop-filter: blur(8px); border-radius: 18px; max-width: 580px; width: 88%; box-shadow: 0 10px 30px rgba(0,0,0,0.12);">
                            <h3 class="fw-bold text-dark fs-4 mb-1">Free installation for orders over</h3>
                            <h2 class="fw-extrabold fs-3 mb-2" style="color: #b03030;">Rs:5000</h2>
                            <p class="text-secondary x-small mb-4 mx-auto" style="max-width: 460px; line-height: 1.5; font-size: 0.78rem; color: #444444 !important;">
                                elementum vehicula, Donec tempor Cras commodo non, sit Nam urna. Ut ex adipiscing gravida venenatis vitae commodo lacus nisi diam quis felis, fringilla diam x scelerisque tempor elit. varius vitae tincidunt Donec Nunc Nam luctus turpis nec risus ex Lorem eu
                            </p>
                            <a href="products.php" class="btn text-white px-4 py-2 fw-semibold rounded-2 shadow-sm" style="background-color: #b03030; border: none;">Limited Time Offer</a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Left & Right Circular Red Arrow Buttons -->
            <button class="carousel-control-prev offer-control-prev-custom" type="button" data-bs-target="#offerBannerCarousel" data-bs-slide="prev" style="position: absolute; top: 50%; transform: translateY(-50%); left: 12%; width: 46px; height: 46px; background-color: #b03030; color: #ffffff; border-radius: 50%; border: none; z-index: 15; opacity: 1; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.25);">
                <i class="fas fa-chevron-left" style="font-size: 1rem; color: #ffffff;"></i>
            </button>
            <button class="carousel-control-next offer-control-next-custom" type="button" data-bs-target="#offerBannerCarousel" data-bs-slide="next" style="position: absolute; top: 50%; transform: translateY(-50%); right: 12%; width: 46px; height: 46px; background-color: #b03030; color: #ffffff; border-radius: 50%; border: none; z-index: 15; opacity: 1; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(176,48,48,0.35);">
                <i class="fas fa-chevron-right" style="font-size: 1.1rem; color: #ffffff;"></i>
            </button>

            <!-- Bottom 5 Dot Indicators -->
            <div class="carousel-indicators position-relative d-flex justify-content-center align-items-center gap-2 py-3 bg-light m-0">
                <button type="button" data-bs-target="#offerBannerCarousel" data-bs-slide-to="0" class="offer-dot-btn active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#offerBannerCarousel" data-bs-slide-to="1" class="offer-dot-btn" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#offerBannerCarousel" data-bs-slide-to="2" class="offer-dot-btn" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#offerBannerCarousel" data-bs-slide-to="3" class="offer-dot-btn" aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#offerBannerCarousel" data-bs-slide-to="4" class="offer-dot-btn" aria-label="Slide 5"></button>
            </div>

        </div>
    </div>
</section>

<!-- 4. OUR PRODUCTS -->
<section class="py-5 bg-light">
    <div class="container">
        <!-- Section Header -->
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-secondary small fw-medium d-block mb-2" style="font-size: 0.88rem; color: #555555 !important;">Our Products</span>
                <h2 class="fw-bold mb-0 fs-2" style="color: #b03030; line-height: 1.25;">Automation, Electrical, Pneumatic & Hydraulic Products</h2>
            </div>
            <a href="products.php" class="btn text-white px-4 py-2 fw-semibold rounded-3 shadow-sm" style="background-color: #b03030; font-size: 0.88rem;">View All</a>
        </div>

        <!-- Product Grid (8 Cards) -->
        <div class="row g-4">
            <?php 
            $products = [
                ['title' => 'Digital Panel Meters', 'price' => 'Rs 5000', 'old' => 'Rs 6600', 'img' => 'assets/images/a12a78c9cade7fe7b8aca146cb4b39e47c28dd5f.png'],
                ['title' => 'Switching Power Supplies', 'price' => 'Rs 5000', 'old' => 'Rs 6600', 'img' => 'assets/images/ba017a87ff65aa4424f3158620d5d1b168f9d5f7.png'],
                ['title' => 'Gear Pumps', 'price' => 'Rs 5000', 'old' => 'Rs 6600', 'img' => 'assets/images/c01a988540e693f11d5c4fc56b9fbb442ae38559.png'],
                ['title' => 'Gear Pumps', 'price' => 'Rs 5000', 'old' => 'Rs 6600', 'img' => 'assets/images/bd47cb0f41091484059c3187fcdd4108809182e4.png'],
                ['title' => 'Power packages', 'price' => 'Rs 5000', 'old' => 'Rs 6600', 'img' => 'assets/images/68f25238d73c93408ba9cb5224338e0c49c1260d.png'],
                ['title' => 'Filter water separator', 'price' => 'Rs 5000', 'old' => 'Rs 6600', 'img' => 'assets/images/4b0b4ee85c33c0cfaa3799b6ced5b435328ad404.png'],
                ['title' => 'Rotary Encoder', 'price' => 'Rs 5000', 'old' => 'Rs 6600', 'img' => 'assets/images/676f11f923eb9a41fb729105586e56777f3d3320.png'],
                ['title' => 'Pressure Regulator', 'price' => 'Rs 5000', 'old' => 'Rs 6600', 'img' => 'assets/images/b4c48a7f53e0efa294b27e121ea8aaf4b0af7eac.png'],
            ];

            foreach($products as $p):
            ?>
            <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                <div class="product-card-box">
                    <!-- Top Image Area -->
                    <div class="position-relative bg-white text-center p-3" style="height: 180px; display: flex; align-items: center; justify-content: center;">
                        <img src="<?php echo $p['img']; ?>" class="img-fluid" style="max-height: 135px; width: auto; object-fit: contain;" alt="<?php echo $p['title']; ?>">
                        
                        <!-- Heart & Eye Action Icons (Top Right) -->
                        <div class="position-absolute top-0 end-0 p-2 d-flex flex-column gap-2" style="z-index: 5;">
                            <button type="button" class="product-action-btn shadow-sm" title="Wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                            <button type="button" class="product-action-btn shadow-sm" title="Quick View">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Bottom Details Area -->
                    <div class="p-3 text-start" style="background-color: #ececec; border-top: 1px solid #ddd;">
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.85rem; height: 38px; display: flex; align-items: center;"><?php echo $p['title']; ?></h6>
                        <div class="mb-1" style="font-size: 0.85rem;">
                            <span class="fw-bold" style="color: #e54d42;"><?php echo $p['price']; ?></span>
                            <span class="text-muted text-decoration-line-through ms-2" style="font-size: 0.78rem; color: #888888 !important;"><?php echo $p['old']; ?></span>
                        </div>
                        <div class="d-flex align-items-center" style="font-size: 0.75rem;">
                            <span class="text-warning me-1">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </span>
                            <span class="text-secondary fw-medium">(65)</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 5. TESTIMONIALS -->
<section class="testimonials-section py-5 text-white position-relative" style="background: linear-gradient(rgba(18, 20, 24, 0.88), rgba(18, 20, 24, 0.88)), url('assets/images/b95b4009ce4b6e877bde5514673695345345fdcc.png') center/cover no-repeat;">
    <div class="container py-3">
        <div class="row align-items-center g-4">
            
            <!-- Left Side: Google Info & Avatar Stack -->
            <div class="col-12 col-lg-4 text-center text-lg-start ps-lg-4">
                <!-- Enlarged Google Text in Official Style (Removed 'Testimonials' text) -->
                <div class="mb-3">
                    <span style="font-family: 'Product Sans', 'Poppins', sans-serif; font-size: 3.2rem; font-weight: 600; letter-spacing: -1.5px; line-height: 1;">
                        <span style="color:#4285F4">G</span><span style="color:#EA4335">o</span><span style="color:#FBBC05">o</span><span style="color:#4285F4">g</span><span style="color:#34A853">l</span><span style="color:#EA4335">e</span>
                    </span>
                </div>
                <h2 class="fw-bold mb-2 fs-2 text-white" style="line-height: 1.25;">Excellent</h2>
                
                <!-- 4.5 Stars -->
                <div class="text-warning fs-5 mb-2">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text-white fs-6 mb-3 font-semibold">120+ Reviews</p>

                <!-- Overlapping Avatars Stack -->
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start pt-1">
                    <img src="assets/images/a12a78c9cade7fe7b8aca146cb4b39e47c28dd5f.png" class="avatar-stack-img" alt="user1">
                    <img src="assets/images/71455c53cbed251be21bbb31286a64a1ebe232e4.png" class="avatar-stack-img" alt="user2">
                    <img src="assets/images/392744f084c3a79733ea661cd02d6fe277cf9f4a.png" class="avatar-stack-img" alt="user3">
                    <img src="assets/images/68f25238d73c93408ba9cb5224338e0c49c1260d.png" class="avatar-stack-img" alt="user4">
                    <img src="assets/images/b97bd4048a2dd2dd3ee7c2ea479d2d1ff89544a0.png" class="avatar-stack-img" alt="user5">
                    <img src="assets/images/676f11f923eb9a41fb729105586e56777f3d3320.png" class="avatar-stack-img" alt="user6">
                    <img src="assets/images/b4c48a7f53e0efa294b27e121ea8aaf4b0af7eac.png" class="avatar-stack-img" alt="user7">
                </div>
            </div>

            <!-- Right Side: Testimonial Cards & Arrow -->
            <div class="col-12 col-lg-8 position-relative pe-lg-5">
                <div class="row g-3 g-md-4">
                    
                    <!-- Card 1 -->
                    <div class="col-12 col-md-6">
                        <div class="p-4" style="background: rgba(215, 215, 215, 0.8); backdrop-filter: blur(6px); border-radius: 18px; color: #111;">
                            <div class="d-flex align-items-center mb-3">
                                <img src="assets/images/5872a08cd669c3cadda08e29a9ba3eff4d6a5c52.png" alt="Arun Perera" class="rounded-circle me-3 shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: #b03030; font-size: 1.15rem;">Arun Perera</h5>
                                    <span class="text-secondary small fw-medium" style="font-size: 0.8rem;">ABCD Company</span>
                                </div>
                            </div>
                            <p class="text-dark mb-3" style="font-size: 0.82rem; line-height: 1.55; text-align: justify; text-justify: inter-word;">
                                ISARO Automation Systems transformed our production line with their expert automation solutions. Their team was professional, responsive, and delivered a high-quality setup that exceeded our expectations.
                            </p>
                            <div>
                                <div class="text-warning x-small mb-1" style="font-size: 0.85rem;">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star text-white"></i>
                                </div>
                                <span class="text-dark fw-normal" style="font-size: 0.75rem;">4-star review</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-12 col-md-6">
                        <div class="p-4" style="background: rgba(215, 215, 215, 0.8); backdrop-filter: blur(6px); border-radius: 18px; color: #111;">
                            <div class="d-flex align-items-center mb-3">
                                <img src="assets/images/b10b887974d8e0008333dcd07eaebd4ca713ff26.png" alt="Kasun Silva" class="rounded-circle me-3 shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: #b03030; font-size: 1.15rem;">Kasun Silva</h5>
                                    <span class="text-secondary small fw-medium" style="font-size: 0.8rem;">XYZ Company</span>
                                </div>
                            </div>
                            <p class="text-dark mb-3" style="font-size: 0.82rem; line-height: 1.55; text-align: justify; text-justify: inter-word;">
                                ISARO Automation Systems transformed our production line with their expert automation solutions. Their team was professional, responsive, and delivered a high-quality setup that exceeded our expectations.
                            </p>
                            <div>
                                <div class="text-warning x-small mb-1" style="font-size: 0.85rem;">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star text-white"></i>
                                </div>
                                <span class="text-dark fw-normal" style="font-size: 0.75rem;">4-star review</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Circular Chevron Arrow Button -->
                <button type="button" class="btn btn-light rounded-circle shadow-sm position-absolute top-50 end-0 translate-middle-y d-none d-md-flex align-items-center justify-content-center" style="width: 44px; height: 44px; z-index: 10; border: none; margin-right: -15px;" aria-label="Next Testimonial">
                    <i class="fas fa-chevron-right text-dark" style="font-size: 1.1rem;"></i>
                </button>
            </div>

        </div>
    </div>
</section>

<!-- 6. PROJECTS -->
<section class="py-5" style="background-color: #f2f2f2;">
    <div class="container py-2">
        <!-- Section Header Matching Image Style -->
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-secondary small fw-medium d-block mb-2" style="font-size: 0.88rem; color: #555555 !important;">Our Projects</span>
                <h2 class="fw-bold mb-0 fs-2" style="color: #b03030; line-height: 1.25;">A Quick Summary of The Work</h2>
            </div>
            <a href="projects.php" class="btn text-white px-4 py-2 fw-semibold rounded-3 shadow-sm" style="background-color: #b03030; font-size: 0.88rem;">View All</a>
        </div>

        <!-- 4 Projects Cards Grid -->
        <div class="row g-4">
            <?php
            $projects = [
                ['img' => 'assets/images/e0ba8d58efa004b1ac9afae79bf8c83837b8b6b9.png', 'title' => 'Smart Factory PLC Integration'],
                ['img' => 'assets/images/abfe2a759945e5458aa42bb255a9f6a4c17ab686.png', 'title' => 'Smart Factory PLC Integration'],
                ['img' => 'assets/images/2f9058cda797988dc0788f626d5eb70c856ef2bb.png', 'title' => 'Smart Factory PLC Integration'],
                ['img' => 'assets/images/392744f084c3a79733ea661cd02d6fe277cf9f4a.png', 'title' => 'Smart Factory PLC Integration'],
            ];
            foreach($projects as $project): ?>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="text-center project-card-item">
                    <div class="mb-3 overflow-hidden rounded-2 shadow-sm">
                        <img src="<?php echo $project['img']; ?>" alt="<?php echo $project['title']; ?>" class="img-fluid w-100" style="height: 190px; object-fit: cover;">
                    </div>
                    <h6 class="fw-bold mb-2 fs-6" style="color: #b03030; font-size: 0.95rem;"><?php echo $project['title']; ?></h6>
                    <p class="text-secondary mx-auto mb-0" style="font-size: 0.76rem; line-height: 1.48; max-width: 95%; text-align: center;">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- WhatsApp Button -->
<a href="https://wa.me/94719847787" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

</div>

<!-- JavaScript to Ensure Guaranteed Auto-play Every 3 Seconds (3000ms) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var offerCarouselEl = document.querySelector('#offerBannerCarousel');
    if (offerCarouselEl && typeof bootstrap !== 'undefined') {
        var offerCarousel = new bootstrap.Carousel(offerCarouselEl, {
            interval: 3000,
            ride: 'carousel',
            pause: false
        });
        offerCarousel.cycle();
    }
});
</script>

<?php include 'includes/footer.php'; ?>