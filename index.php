<?php 
include 'includes/header.php'; 
require_once 'config/db.php';

// 1. Fetch Active Offers strictly from Database
$offersStmt = $pdo->query("SELECT * FROM offers WHERE status='active' ORDER BY sort_order ASC, id DESC");
$dbOffers = $offersStmt->fetchAll();

// 2. Fetch Products strictly from Database (Limit 8 for Home Page)
$productsStmt = $pdo->query("SELECT * FROM products ORDER BY is_featured DESC, id DESC LIMIT 8");
$dbProducts = $productsStmt->fetchAll();

// 3. Fetch Approved Reviews strictly from Database
$reviewsStmt = $pdo->query("SELECT * FROM product_reviews WHERE is_approved=1 ORDER BY id DESC");
$dbReviews = $reviewsStmt->fetchAll();

// 4. Fetch All Projects strictly from Database for Slider
$projectsStmt = $pdo->query("SELECT * FROM projects ORDER BY is_recent DESC, id DESC");
$dbProjects = $projectsStmt->fetchAll();

// Curated Distinct High-Quality Real Human Face Avatars Array
$faceAvatars = [
    'https://randomuser.me/api/portraits/men/32.jpg',
    'https://randomuser.me/api/portraits/men/46.jpg',
    'https://randomuser.me/api/portraits/men/75.jpg',
    'https://randomuser.me/api/portraits/women/44.jpg',
    'https://randomuser.me/api/portraits/men/85.jpg',
    'https://randomuser.me/api/portraits/women/68.jpg'
];
?>

<!-- Swiper Slider CSS for Testimonials, Offers & Projects -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Comprehensive Responsive & Premium Design CSS -->
<style>
/* Global Smooth Enhancements & Flicker Prevention */
.isaro-main-wrapper {
    font-family: 'Poppins', sans-serif;
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

/* Hero Section Layered Automatic Background Slider */
.isaro-hero-section {
    min-height: 480px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.hero-bg-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    opacity: 0;
    transition: opacity 1.5s ease-in-out, transform 6s ease-out;
    transform: scale(1.05);
    z-index: 1;
}

.hero-bg-slide.active {
    opacity: 1;
    transform: scale(1);
}

/* ENHANCED ANIMATED OUR PARTNERS SECTION */
.hero-partners-title {
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 14px;
    display: inline-block;
    opacity: 0;
    animation: appleHeroText 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.35s forwards;
}

.partner-badge {
    background: rgba(255, 255, 255, 0.95);
    padding: 8px 18px;
    border-radius: 50px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.22);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid rgba(255, 255, 255, 0.4);
    opacity: 0;
    animation: appleHeroText 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.45s forwards;
}

.partner-badge:hover {
    transform: translateY(-5px) scale(1.06);
    background: #ffffff;
    box-shadow: 0 8px 22px rgba(176, 48, 48, 0.4);
    border-color: #b03030;
}

.partner-badge img {
    height: 28px;
    width: auto;
    object-fit: contain;
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

/* Product Cards Hover & Typography */
.product-card-box {
    border: 1px solid #e2e2e2;
    border-radius: 12px;
    overflow: hidden;
    background: #ffffff;
    height: 100%;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    cursor: pointer;
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
    cursor: pointer;
}
.product-action-btn:hover,
.product-action-btn.active {
    background: #c82333;
    color: #ffffff !important;
    border-color: #c82333;
}

/* TESTIMONIALS BACKGROUND AUTOMATIC SLIDER STYLES */
.testimonials-section {
    position: relative;
    overflow: hidden;
}

.testimonial-bg-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    opacity: 0;
    transition: opacity 1.5s ease-in-out, transform 6s ease-out;
    transform: scale(1.05);
    z-index: 1;
}

.testimonial-bg-slide.active {
    opacity: 1;
    transform: scale(1);
}

.avatar-stack-img {
    width: 38px;
    height: 38px;
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
    cursor: pointer;
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
    .about-badge-circle { width: 55px !important; height: 55px !important; }
    .offer-banner-bg { min-height: 380px !important; }
    .whatsapp-float { width: 52px !important; height: 52px !important; font-size: 28px !important; }
    .isaro-hero-section { min-height: 360px; }
}
</style>

<div class="isaro-main-wrapper">

<!-- 1. HERO BANNER WITH AUTOMATIC BACKGROUND SLIDESHOW (EXACT 0.68 OVERLAY CONTRAST MATCHING ABOUT US PAGE) -->
<section class="isaro-hero-section text-white py-5">
    <!-- 3 Layered Background Images with Exact 0.68 Dark Opacity Overlay -->
    <div class="hero-bg-slide active" style="background-image: linear-gradient(rgba(0, 0, 0, 0.68), rgba(0, 0, 0, 0.68)), url('assets/images/7530266532463de32d07c4ca427023eb7147db57.png');"></div>
    <div class="hero-bg-slide" style="background-image: linear-gradient(rgba(0, 0, 0, 0.68), rgba(0, 0, 0, 0.68)), url('assets/images/feedf7b7a69a5cfc65e4d847497ca581f69a9a4d (1).jpg');"></div>
    <div class="hero-bg-slide" style="background-image: linear-gradient(rgba(0, 0, 0, 0.68), rgba(0, 0, 0, 0.68)), url('assets/images/b95b4009ce4b6e877bde5514673695345345fdcc.png');"></div>

    <div class="container text-center py-4 position-relative" style="z-index: 5;">
        <h1 class="hero-title fw-bold mb-3" style="font-size: 2.8rem; line-height: 1.25; letter-spacing: -0.3px;">
            Reliable Electrical, Hydraulic &<br>
            Pneumatic<br>
            <span style="color: #ff0000;" class="fw-extrabold">Automation</span> Systems
        </h1>
        <p class="lead mb-4 text-white mx-auto fs-6 fs-md-5" style="max-width: 680px; font-weight: 400; opacity: 0.9; line-height: 1.5;">
            Delivering advanced electrical, pneumatic, and hydraulic solutions for over 17 years.
        </p>
        <a href="products.php" class="btn btn-danger btn-lg px-4 py-2 fs-6 mb-5 shadow-sm rounded-2 fw-semibold" style="background-color: #b03030; border: none;">Explore More</a>

        <!-- Premium Animated Partners Section -->
        <div class="pt-2">
            <div>
                <span class="hero-partners-title">Our Partners</span>
            </div>
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

<!-- 2. ABOUT US -->
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
                    <img src="assets/images/c84739eb2ed88a5d12b5a4eaa2f2b5d9cc173fe8.jpg" alt="Automation Systems" class="img-fluid shadow-sm" style="width: 68%; height: 350px; object-fit: cover; border-radius: 18px;">
                    <img src="assets/images/7e3d191a15ac23b17a1f8a34d1a0cbed7c03be85.jpg" alt="Quality Control" class="img-fluid shadow border border-white border-4 position-absolute" style="width: 48%; height: 200px; object-fit: cover; border-radius: 16px; left: 0; bottom: 12px; z-index: 2;">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 3. SPECIAL OFFER (DYNAMIC FROM DATABASE ONLY WITH DARK OVERLAY) -->
<section class="offer-section py-0 bg-light">
    <div class="container-fluid px-0">
        <div id="offerBannerCarousel" class="carousel slide carousel-fade position-relative" data-bs-ride="carousel" data-bs-interval="3000" style="overflow: hidden;">
            
            <div style="position: absolute; top: 0; right: 0; width: 150px; height: 150px; overflow: hidden; z-index: 20; pointer-events: none;">
                <span style="position: absolute; display: block; width: 220px; padding: 8px 0; background-color: #b03030; color: #ffffff; font-size: 0.82rem; font-weight: 700; text-transform: uppercase; text-align: center; left: -25px; top: 32px; transform: rotate(45deg); box-shadow: 0 3px 10px rgba(0,0,0,0.25); letter-spacing: 0.5px;">Hurry Up!</span>
            </div>

            <!-- Carousel Slides strictly from DB -->
            <div class="carousel-inner">
                <?php if(!empty($dbOffers)): ?>
                    <?php foreach($dbOffers as $idx => $off): ?>
                    <div class="carousel-item <?php echo ($idx === 0) ? 'active' : ''; ?>">
                        <div class="d-flex align-items-center justify-content-center offer-banner-bg" style="background: url('<?php echo htmlspecialchars($off['bg_image']); ?>') center top / cover no-repeat; min-height: 520px; position: relative;">
                            <!-- Darkened Overlay for Banner Image -->
                            <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0, 0, 0, 0.45); z-index: 1;"></div>
                            <div class="text-center p-4 p-md-5 offer-card-box" style="position: relative; z-index: 2; background: rgba(255, 255, 255, 0.78); backdrop-filter: blur(10px); border-radius: 18px; max-width: 580px; width: 88%; box-shadow: 0 10px 30px rgba(0,0,0,0.22);">
                                <h3 class="fw-bold text-dark fs-4 mb-1"><?php echo htmlspecialchars($off['title']); ?></h3>
                                <h2 class="fw-extrabold fs-3 mb-2" style="color: #b03030;"><?php echo htmlspecialchars($off['highlight_price']); ?></h2>
                                <p class="text-secondary x-small mb-4 mx-auto" style="max-width: 460px; line-height: 1.5; font-size: 0.78rem; color: #333333 !important;">
                                    <?php echo htmlspecialchars($off['description']); ?>
                                </p>
                                <a href="<?php echo htmlspecialchars($off['btn_link'] ?? 'products.php'); ?>" class="btn text-white px-4 py-2 fw-semibold rounded-2 shadow-sm" style="background-color: #b03030; border: none;">Limited Time Offer</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item active">
                        <div class="d-flex align-items-center justify-content-center offer-banner-bg" style="background: #111; min-height: 300px;">
                            <p class="text-white mb-0">No active offers available in database.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Left & Right Control Arrows -->
            <button class="carousel-control-prev offer-control-prev-custom" type="button" data-bs-target="#offerBannerCarousel" data-bs-slide="prev" style="position: absolute; top: 50%; transform: translateY(-50%); left: 12%; width: 46px; height: 46px; background-color: #b03030; color: #ffffff; border-radius: 50%; border: none; z-index: 15; opacity: 1; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.25);">
                <i class="fas fa-chevron-left" style="font-size: 1rem; color: #ffffff;"></i>
            </button>
            <button class="carousel-control-next offer-control-next-custom" type="button" data-bs-target="#offerBannerCarousel" data-bs-slide="next" style="position: absolute; top: 50%; transform: translateY(-50%); right: 12%; width: 46px; height: 46px; background-color: #b03030; color: #ffffff; border-radius: 50%; border: none; z-index: 15; opacity: 1; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(176,48,48,0.35);">
                <i class="fas fa-chevron-right" style="font-size: 1.1rem; color: #ffffff;"></i>
            </button>

        </div>
    </div>
</section>

<!-- 4. OUR PRODUCTS (DYNAMIC FROM DATABASE ONLY) -->
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

        <!-- Product Grid (Dynamic DB Products) -->
        <div class="row g-4">
            <?php if(!empty($dbProducts)): ?>
                <?php foreach($dbProducts as $p): ?>
                <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="product-card-box" onclick="navigateToDetail(event, 'product-detail.php?id=<?php echo $p['id']; ?>')">
                        <!-- Top Image Area -->
                        <div class="position-relative bg-white text-center p-3" style="height: 180px; display: flex; align-items: center; justify-content: center;">
                            <img src="<?php echo htmlspecialchars($p['main_img']); ?>" class="img-fluid" style="max-height: 135px; width: auto; object-fit: contain;" alt="<?php echo htmlspecialchars($p['title']); ?>">
                            
                            <!-- Heart & Eye Action Icons (Top Right) -->
                            <div class="position-absolute top-0 end-0 p-2 d-flex flex-column gap-2" style="z-index: 5;">
                                <button type="button" class="product-action-btn shadow-sm btn-wishlist-index" data-sku="<?php echo htmlspecialchars($p['sku']); ?>" onclick="toggleWishlistIndex(event, '<?php echo htmlspecialchars($p['title']); ?>', '<?php echo htmlspecialchars($p['sku']); ?>', 'Rs <?php echo number_format($p['price'], 0); ?>', '<?php echo htmlspecialchars($p['main_img']); ?>')" title="Save to Wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                                <a href="product-detail.php?id=<?php echo $p['id']; ?>" class="product-action-btn shadow-sm text-decoration-none" onclick="event.stopPropagation()" title="Quick View">
                                    <i class="far fa-eye"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Bottom Details Area -->
                        <div class="p-3 text-start" style="background-color: #ececec; border-top: 1px solid #ddd;">
                            <h6 class="fw-bold mb-1" style="font-size: 0.85rem; height: 38px; display: flex; align-items: center; color: #333;">
                                <?php echo htmlspecialchars($p['title']); ?>
                            </h6>
                            <div class="mb-1" style="font-size: 0.85rem;">
                                <span class="fw-bold" style="color: #e54d42;">Rs <?php echo number_format($p['price'], 0); ?></span>
                                <?php if(!empty($p['old_price'])): ?>
                                <span class="text-muted text-decoration-line-through ms-2" style="font-size: 0.78rem; color: #888888 !important;">Rs <?php echo number_format($p['old_price'], 0); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex align-items-center" style="font-size: 0.75rem;">
                                <span class="text-warning me-1">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </span>
                                <span class="text-secondary fw-medium">(<?php echo $p['review_count'] ?? '65'; ?>)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-4">
                    <p class="text-muted">No products found in database.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- 5. TESTIMONIALS (AUTO SLIDESHOW BACKGROUND & EXACT 2 REVIEWS VISIBLE SWIPER SLIDER) -->
<section class="testimonials-section py-5 text-white position-relative">
    <!-- 3 Layered Background Images for Automatic Crossfade -->
    <div class="testimonial-bg-slide active" style="background-image: linear-gradient(rgba(18, 20, 24, 0.88), rgba(18, 20, 24, 0.88)), url('assets/images/b95b4009ce4b6e877bde5514673695345345fdcc.png');"></div>
    <div class="testimonial-bg-slide" style="background-image: linear-gradient(rgba(18, 20, 24, 0.88), rgba(18, 20, 24, 0.88)), url('assets/images/feedf7b7a69a5cfc65e4d847497ca581f69a9a4d.jpg');"></div>
    <div class="testimonial-bg-slide" style="background-image: linear-gradient(rgba(18, 20, 24, 0.88), rgba(18, 20, 24, 0.88)), url('assets/images/67d12759ce882ac6dba72d274c24e0c3e3f0bc10.png');"></div>

    <div class="container py-3 position-relative" style="z-index: 5;">
        <div class="row align-items-center g-4">
            
            <!-- Left Side: Google Info & 5 Distinct Face Avatars Stack -->
            <div class="col-12 col-lg-4 text-center text-lg-start ps-lg-4">
                <div class="mb-3">
                    <span style="font-family: 'Product Sans', 'Poppins', sans-serif; font-size: 3.2rem; font-weight: 600; letter-spacing: -1.5px; line-height: 1;">
                        <span style="color:#4285F4">G</span><span style="color:#EA4335">o</span><span style="color:#FBBC05">o</span><span style="color:#4285F4">g</span><span style="color:#34A853">l</span><span style="color:#EA4335">e</span>
                    </span>
                </div>
                <h2 class="fw-bold mb-2 fs-2 text-white" style="line-height: 1.25;">Excellent</h2>
                
                <div class="text-warning fs-5 mb-2">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text-white fs-6 mb-3 font-semibold">120+ Reviews</p>

                <!-- 5 Distinct Bulletproof Face Avatars Stack -->
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start pt-1">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="avatar-stack-img" alt="user1">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="avatar-stack-img" alt="user2">
                    <img src="https://randomuser.me/api/portraits/men/85.jpg" class="avatar-stack-img" alt="user3">
                    <img src="https://randomuser.me/api/portraits/women/65.jpg" class="avatar-stack-img" alt="user4">
                    <img src="https://randomuser.me/api/portraits/men/46.jpg" class="avatar-stack-img" alt="user5">
                </div>
            </div>

            <!-- Right Side: Dynamic Testimonial Cards (Strictly 2 visible at a time, auto sliding all DB reviews) -->
            <div class="col-12 col-lg-8 position-relative pe-lg-5">
                <div class="swiper testimonial-swiper">
                    <div class="swiper-wrapper">
                        <?php if(!empty($dbReviews)): ?>
                            <?php foreach($dbReviews as $idx => $rev): 
                                $avatarUrl = $faceAvatars[$idx % count($faceAvatars)];
                            ?>
                            <div class="swiper-slide h-auto d-flex py-2">
                                <div class="p-4 w-100 d-flex flex-column justify-content-between h-100 shadow-sm" style="background: rgba(215, 215, 215, 0.85); backdrop-filter: blur(6px); border-radius: 18px; color: #111;">
                                    <div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="<?php echo $avatarUrl; ?>" alt="<?php echo htmlspecialchars($rev['reviewer_name']); ?>" class="rounded-circle me-3 shadow-sm border border-2 border-white" style="width: 60px; height: 60px; object-fit: cover;">
                                            <div>
                                                <h5 class="fw-bold mb-1" style="color: #b03030; font-size: 1.1rem;"><?php echo htmlspecialchars($rev['reviewer_name']); ?></h5>
                                                <span class="text-secondary small fw-medium" style="font-size: 0.8rem;">Verified Buyer</span>
                                            </div>
                                        </div>
                                        <p class="text-dark mb-3" style="font-size: 0.83rem; line-height: 1.6; text-align: left;">
                                            <?php echo htmlspecialchars($rev['comment']); ?>
                                        </p>
                                    </div>
                                    <div>
                                        <div class="text-warning x-small mb-1" style="font-size: 0.85rem;">
                                            <?php for($s=1;$s<=5;$s++) echo ($s<=$rev['rating']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star text-muted"></i>'; ?>
                                        </div>
                                        <span class="text-dark fw-normal" style="font-size: 0.75rem;"><?php echo $rev['rating']; ?>-star review</span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="swiper-slide text-center py-4 text-white">
                                <p class="mb-0">No approved reviews found in database.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 6. PROJECTS (STRICTLY 4 VISIBLE CARDS PER SLIDE WITH AUTO SLIDING FOR ALL DB PROJECTS) -->
<section class="py-5" style="background-color: #f2f2f2;">
    <div class="container py-2">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-secondary small fw-medium d-block mb-2" style="font-size: 0.88rem; color: #555555 !important;">Our Projects</span>
                <h2 class="fw-bold mb-0 fs-2" style="color: #b03030; line-height: 1.25;">A Quick Summary of The Work</h2>
            </div>
            <a href="projects.php" class="btn text-white px-4 py-2 fw-semibold rounded-3 shadow-sm" style="background-color: #b03030; font-size: 0.88rem;">View All</a>
        </div>

        <div class="swiper project-swiper">
            <div class="swiper-wrapper">
                <?php if(!empty($dbProjects)): ?>
                    <?php foreach($dbProjects as $proj): ?>
                    <div class="swiper-slide h-auto py-2">
                        <div class="text-center project-card-item h-100" onclick="window.location.href='project-detail.php?id=<?php echo $proj['id']; ?>'">
                            <div class="mb-3 overflow-hidden rounded-2 shadow-sm">
                                <img src="<?php echo htmlspecialchars($proj['main_img']); ?>" alt="<?php echo htmlspecialchars($proj['title']); ?>" class="img-fluid w-100" style="height: 190px; object-fit: cover;">
                            </div>
                            <h6 class="fw-bold mb-2 fs-6" style="color: #b03030; font-size: 0.95rem;"><?php echo htmlspecialchars($proj['title']); ?></h6>
                            <p class="text-secondary mx-auto mb-0" style="font-size: 0.76rem; line-height: 1.48; max-width: 95%; text-align: center;">
                                <?php echo htmlspecialchars($proj['short_desc']); ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="swiper-slide text-center py-4">
                        <p class="text-muted mb-0">No completed projects found in database.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- WhatsApp Button -->
<a href="https://wa.me/94719847787" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

</div>

<!-- Swiper Slider JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
function navigateToDetail(event, url) {
    if (event.target.closest('button') || event.target.closest('a')) {
        return;
    }
    window.location.href = url;
}

function toggleWishlistIndex(event, title, sku, price, img) {
    event.stopPropagation();
    var btn = event.currentTarget;
    var stored = localStorage.getItem('isaro_wishlist');
    var list = stored ? JSON.parse(stored) : [];

    var index = list.findIndex(function(item) { return item.sku === sku; });

    if (index > -1) {
        list.splice(index, 1);
        btn.classList.remove('active');
        btn.querySelector('i').className = 'far fa-heart';
    } else {
        list.push({ title: title, sku: sku, price: price, img: img });
        btn.classList.add('active');
        btn.querySelector('i').className = 'fas fa-heart text-white';
    }

    localStorage.setItem('isaro_wishlist', JSON.stringify(list));
    
    var badge = document.getElementById('headerWishlistCount');
    if (badge) {
        badge.innerText = list.length;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // 1. Automatic Background Image Slideshow Logic for Hero Section
    const heroSlides = document.querySelectorAll('.hero-bg-slide');
    if (heroSlides.length > 0) {
        let currentSlide = 0;
        setInterval(function() {
            heroSlides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % heroSlides.length;
            heroSlides[currentSlide].classList.add('active');
        }, 4000);
    }

    // 2. Automatic Background Image Slideshow Logic for Testimonials Section
    const testimonialSlides = document.querySelectorAll('.testimonial-bg-slide');
    if (testimonialSlides.length > 0) {
        let currentTestimonialSlide = 0;
        setInterval(function() {
            testimonialSlides[currentTestimonialSlide].classList.remove('active');
            currentTestimonialSlide = (currentTestimonialSlide + 1) % testimonialSlides.length;
            testimonialSlides[currentTestimonialSlide].classList.add('active');
        }, 4000);
    }

    // 3. Testimonial Cards Swiper
    if (typeof Swiper !== 'undefined' && document.querySelector('.testimonial-swiper')) {
        new Swiper('.testimonial-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 24,
                }
            }
        });
    }

    // 4. Our Projects Swiper
    if (typeof Swiper !== 'undefined' && document.querySelector('.project-swiper')) {
        new Swiper('.project-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                992: {
                    slidesPerView: 4,
                    spaceBetween: 24,
                }
            }
        });
    }

    var offerCarouselEl = document.querySelector('#offerBannerCarousel');
    if (offerCarouselEl && typeof bootstrap !== 'undefined') {
        var offerCarousel = new bootstrap.Carousel(offerCarouselEl, {
            interval: 3000,
            ride: 'carousel',
            pause: false
        });
        offerCarousel.cycle();
    }

    var stored = localStorage.getItem('isaro_wishlist');
    var list = stored ? JSON.parse(stored) : [];

    document.querySelectorAll('.btn-wishlist-index').forEach(function(btn) {
        var sku = btn.getAttribute('data-sku');
        var exists = list.some(function(item) { return item.sku === sku; });
        if (exists) {
            btn.classList.add('active');
            btn.querySelector('i').className = 'fas fa-heart text-white';
        }
    });

    // 5. LANDING SCROLL REVEAL OBSERVER FOR INDEX PAGE
    const observerOptions = { root: null, rootMargin: "0px 0px -30px 0px", threshold: 0.05 };
    const revealObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-revealed");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const indexAnimElements = document.querySelectorAll(
        ".about-badge-circle, .product-card-box, .project-card-item, .offer-card-box, .about-img-container img, .testimonials-section .swiper-slide > div"
    );

    indexAnimElements.forEach(function(el) {
        el.classList.add("apple-reveal");
        let delay = 0;
        if (el.closest('.row')) {
            let col = el.closest('[class*="col-"]');
            if (col && col.parentElement) {
                let siblings = Array.from(col.parentElement.children);
                let idx = siblings.indexOf(col);
                delay = (idx % 4) * 0.12;
            }
        }
        el.style.transitionDelay = delay + 's';
        revealObserver.observe(el);
    });
});
</script>

<?php include 'includes/footer.php'; ?>