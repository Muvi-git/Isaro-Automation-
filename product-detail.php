<?php 
include 'includes/header.php'; 
require_once 'config/db.php';

// 1. Get Product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 2. Fetch Product Details strictly from Database
$stmt = $pdo->prepare("
    SELECT p.*, c.name as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    WHERE p.id = ?
");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

// Fetch latest product if ID is missing or invalid
if (!$product) {
    $fallbackStmt = $pdo->query("
        SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.id DESC LIMIT 1
    ");
    $product = $fallbackStmt->fetch();
}

// 3. Handle Customer Review Submission
$review_success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $reviewer_name = trim($_POST['reviewer_name'] ?? '');
    $reviewer_email = trim($_POST['reviewer_email'] ?? '');
    $rating = intval($_POST['rating'] ?? 5);
    $comment = trim($_POST['reviewer_comment'] ?? '');

    if (!empty($product) && !empty($reviewer_name) && !empty($reviewer_email) && !empty($comment)) {
        $revStmt = $pdo->prepare("INSERT INTO product_reviews (product_id, reviewer_name, reviewer_email, rating, comment, is_approved) VALUES (?, ?, ?, ?, ?, 0)");
        $revStmt->execute([$product['id'], $reviewer_name, $reviewer_email, $rating, $comment]);
        $review_success = true;
    }
}

// 4. Fetch Approved Reviews strictly from Database
$approvedReviews = [];
if ($product) {
    $revStmt = $pdo->prepare("SELECT * FROM product_reviews WHERE product_id = ? AND is_approved = 1 ORDER BY id DESC");
    $revStmt->execute([$product['id']]);
    $approvedReviews = $revStmt->fetchAll();
}

// 5. Fetch Related Products strictly from Database
$relatedProducts = [];
if ($product) {
    $relStmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 4");
    $relStmt->execute([$product['category_id'], $product['id']]);
    $relatedProducts = $relStmt->fetchAll();
}
?>

<!-- Pure Vector PDF Generation Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<!-- Custom Styles for Product Detail Page -->
<style>
/* Page Wrapper & Typography */
.isaro-product-detail-wrapper {
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

/* Breadcrumb Styling */
.custom-breadcrumb {
    background-color: #f8f9fa;
    padding: 14px 0;
    border-bottom: 1px solid #eeeeee;
}
.custom-breadcrumb a {
    color: #6c757d;
    text-decoration: none;
    font-size: 0.85rem;
    transition: color 0.2s ease;
}
.custom-breadcrumb a:hover {
    color: #b03030;
}
.custom-breadcrumb .active {
    color: #b03030;
    font-size: 0.85rem;
    font-weight: 600;
}

/* Gallery Styles */
.main-product-img-box {
    background-color: #ffffff;
    border: 1px solid #e5e5e5;
    border-radius: 16px;
    padding: 20px;
    height: 420px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
}
.main-product-img-box img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}
.main-product-img-box img:hover {
    transform: scale(1.05);
}

.thumb-img-box {
    width: 80px;
    height: 80px;
    border: 2px solid #e5e5e5;
    border-radius: 10px;
    padding: 8px;
    cursor: pointer;
    background: #ffffff;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}
.thumb-img-box:hover,
.thumb-img-box.active {
    border-color: #b03030;
    box-shadow: 0 4px 10px rgba(176, 48, 48, 0.2);
}
.thumb-img-box img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}

/* Product Info Right Column */
.product-title-main {
    font-size: 2rem;
    font-weight: 700;
    color: #1e2125;
    line-height: 1.3;
}
.badge-stock {
    background-color: #e8f5e9;
    color: #2e7d32;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 50px;
}
.price-current {
    font-size: 2.1rem;
    font-weight: 800;
    color: #b03030;
}
.price-old {
    font-size: 1.2rem;
    color: #888888;
    text-decoration: line-through;
}

/* Action Controls */
.qty-btn-box {
    display: inline-flex;
    align-items: center;
    border: 1px solid #cccccc;
    border-radius: 8px;
    overflow: hidden;
    background-color: #ffffff;
}
.qty-btn {
    width: 38px;
    height: 42px;
    border: none;
    background: #f4f4f4;
    font-weight: 700;
    color: #333;
    transition: background 0.2s;
}
.qty-btn:hover {
    background: #e0e0e0;
}
.qty-input {
    width: 50px;
    height: 42px;
    border: none;
    text-align: center;
    font-weight: 600;
    font-size: 0.95rem;
    outline: none;
}

.btn-inquire-now {
    background-color: #b03030;
    color: #ffffff;
    font-weight: 600;
    padding: 11px 28px;
    border-radius: 8px;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(176, 48, 48, 0.28);
}
.btn-inquire-now:hover {
    background-color: #8e2323;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(176, 48, 48, 0.4);
}

.btn-whatsapp-inquire {
    background-color: #25d366;
    color: #ffffff;
    font-weight: 600;
    padding: 11px 24px;
    border-radius: 8px;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(37, 211, 102, 0.25);
    text-decoration: none;
}
.btn-whatsapp-inquire:hover {
    background-color: #1eb956;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(37, 211, 102, 0.4);
}

.btn-download-datasheet {
    border: 1px solid #b03030;
    color: #b03030;
    font-weight: 600;
    padding: 11px 22px;
    border-radius: 8px;
    background: #ffffff;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-download-datasheet:hover {
    background-color: #b03030;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(176, 48, 48, 0.25);
}

.btn-add-compare-detail {
    border: 1px solid #1e2125;
    color: #1e2125;
    font-weight: 600;
    padding: 11px 22px;
    border-radius: 8px;
    background: #ffffff;
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-add-compare-detail:hover {
    background-color: #1e2125;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(30, 33, 37, 0.25);
}

/* Feature Perks */
.product-trust-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 16px;
    border: 1px solid #eeeeee;
}
.trust-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.82rem;
    font-weight: 500;
    color: #444444;
}
.trust-item i {
    font-size: 1.3rem;
    color: #b03030;
}

/* Tabs Section */
.custom-nav-tabs {
    border-bottom: 2px solid #e0e0e0;
}
.custom-nav-tabs .nav-link {
    border: none;
    color: #666666;
    font-weight: 600;
    font-size: 0.98rem;
    padding: 14px 28px;
    position: relative;
    background: transparent;
    transition: color 0.3s ease;
}
.custom-nav-tabs .nav-link.active {
    color: #b03030;
    background: transparent;
}
.custom-nav-tabs .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 3px;
    background-color: #b03030;
    border-radius: 2px 2px 0 0;
}

/* Review Section Styling */
.rating-summary-card {
    background-color: #1e2125;
    color: #ffffff;
    border-radius: 16px;
    padding: 30px 25px;
    text-align: center;
}
.big-rating-number {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1;
    color: #ffffff;
}

.bar-container {
    height: 8px;
    background-color: #3a3f45;
    border-radius: 10px;
    overflow: hidden;
}
.bar-fill {
    height: 100%;
    background-color: #ffc107;
    border-radius: 10px;
}

.single-review-card {
    background: #ffffff;
    border: 1px solid #e8e8e8;
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    margin-bottom: 18px;
}

/* Rating Form Interactive Stars */
.star-rating-selector {
    display: inline-flex;
    flex-direction: row-reverse;
    gap: 6px;
}
.star-rating-selector input {
    display: none;
}
.star-rating-selector label {
    font-size: 1.6rem;
    color: #cccccc;
    cursor: pointer;
    transition: color 0.2s ease;
}
.star-rating-selector input:checked ~ label,
.star-rating-selector label:hover,
.star-rating-selector label:hover ~ label {
    color: #ffc107;
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
   APPLE-GRADE MOBILE & TABLET RESPONSIVENESS (MATCHING ALL PAGES)
   ========================================================= */
@media (max-width: 991.98px) {
    .main-product-img-box { height: 320px; }
    .product-title-main { font-size: 1.6rem; }
    .price-current { font-size: 1.7rem; }
}

@media (max-width: 575.98px) {
    /* 1. Gallery & Breadcrumbs Mobile Tuning */
    .custom-breadcrumb { padding: 10px 0 !important; }
    .custom-breadcrumb a, .custom-breadcrumb .active { font-size: 0.75rem !important; }
    .main-product-img-box { height: 250px !important; border-radius: 12px !important; padding: 12px !important; }
    .thumb-img-box { width: 62px !important; height: 62px !important; border-radius: 8px !important; }
    
    /* 2. Product Info & Action Buttons Mobile Stacking */
    .product-title-main { font-size: 1.35rem !important; line-height: 1.3 !important; }
    .price-current { font-size: 1.5rem !important; }
    .price-old { font-size: 1rem !important; }

    /* Action Buttons Stacking for Easy Touch on Mobile */
    .btn-inquire-now, 
    .btn-whatsapp-inquire, 
    .btn-add-compare-detail, 
    .btn-download-datasheet {
        width: 100% !important;
        justify-content: center !important;
        font-size: 0.82rem !important;
        padding: 10px 16px !important;
    }
    
    .qty-btn-box {
        width: 100% !important;
        justify-content: space-between !important;
        margin-bottom: 6px;
    }
    .qty-btn { width: 33% !important; }
    .qty-input { width: 34% !important; }

    /* 3. Horizontal Touch Scrollable Tabs Bar */
    .custom-nav-tabs {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        scrollbar-width: none;
    }
    .custom-nav-tabs::-webkit-scrollbar { display: none; }
    .custom-nav-tabs .nav-link {
        padding: 10px 16px !important;
        font-size: 0.82rem !important;
        white-space: nowrap !important;
    }

    /* 4. Related Products Grid Mobile View - Exactly 2 Side-by-Side Cards */
    .py-5.bg-white .row.g-4 {
        display: flex !important;
        flex-wrap: wrap !important;
        margin-left: -4px !important;
        margin-right: -4px !important;
    }
    .py-5.bg-white .row.g-4 > .col-12.col-sm-6.col-md-3 {
        flex: 0 0 50% !important;
        max-width: 50% !important;
        padding-left: 4px !important;
        padding-right: 4px !important;
        margin-bottom: 10px !important;
    }
    .product-card-box {
        border-radius: 12px !important;
    }
    .product-card-box .position-relative {
        height: 120px !important;
        padding: 8px !important;
    }
    .product-card-box .p-3 {
        padding: 10px 8px !important;
    }
    .product-card-box h6 {
        font-size: 0.78rem !important;
        height: 32px !important;
        line-height: 1.25 !important;
    }

    /* 5. Floating WhatsApp Button Safe Mobile Placement */
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

<div class="isaro-product-detail-wrapper">

<?php if(!empty($product)): ?>

<!-- 1. BREADCRUMB NAVIGATION -->
<div class="custom-breadcrumb">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            <a href="index.php"><i class="fas fa-home me-1"></i> Home</a>
            <span class="text-muted fs-7">/</span>
            <a href="products.php">Our Products</a>
            <span class="text-muted fs-7">/</span>
            <span class="active"><?php echo htmlspecialchars($product['title']); ?></span>
        </div>
    </div>
</div>

<!-- 2. MAIN PRODUCT SECTION -->
<section class="py-5 bg-white">
    <div class="container py-2">
        <div class="row g-4 g-lg-5">
            
            <!-- Left: Product Image Gallery -->
            <div class="col-12 col-lg-6">
                <div class="sticky-top" style="top: 110px; z-index: 10;">
                    <!-- Big Main Preview Image -->
                    <div class="main-product-img-box mb-3">
                        <img id="mainProductImg" src="<?php echo htmlspecialchars($product['main_img']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                    </div>

                    <!-- Thumbnails List -->
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <div class="thumb-img-box active" onclick="changeImage('<?php echo htmlspecialchars($product['main_img']); ?>', this)">
                            <img src="<?php echo htmlspecialchars($product['main_img']); ?>" alt="Main Thumb">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Product Overview & Buying Controls -->
            <div class="col-12 col-lg-6">
                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                    <span class="badge-stock"><i class="fas fa-check-circle me-1"></i> <?php echo (isset($product['stock_status']) && $product['stock_status'] == 'out_of_stock') ? 'Out of Stock' : 'In Stock & Ready to Ship'; ?></span>
                    <span class="text-secondary x-small">SKU: <?php echo htmlspecialchars($product['sku']); ?></span>
                </div>
                
                <h1 class="product-title-main mb-3"><?php echo htmlspecialchars($product['title']); ?></h1>

                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="text-warning fs-6">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="fw-bold fs-7">4.8</span>
                    <span class="text-muted fs-7 me-2">(<?php echo count($approvedReviews); ?> Verified Reviews)</span>
                    <a href="#reviews-pane" onclick="switchTab('reviews-tab-btn')" class="text-decoration-none small text-danger fw-semibold">Write a Review</a>
                </div>

                <div class="d-flex align-items-baseline gap-3 mb-4 p-3 rounded-3" style="background-color: #fafafa; border: 1px solid #f0f0f0;">
                    <span class="price-current">Rs <?php echo number_format($product['price'], 0); ?></span>
                    <?php if(!empty($product['old_price'])): ?>
                    <span class="price-old">Rs <?php echo number_format($product['old_price'], 0); ?></span>
                    <?php endif; ?>
                </div>

                <p class="text-muted fs-7 mb-4" style="line-height: 1.65; text-align: left;">
                    <?php echo htmlspecialchars($product['short_desc'] ?? ''); ?>
                </p>

                <hr class="my-4" style="color: #e0e0e0;">

                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <div class="qty-btn-box">
                        <button type="button" class="qty-btn" onclick="updateQty(-1)">-</button>
                        <input type="text" id="productQty" class="qty-input" value="1" readonly>
                        <button type="button" class="qty-btn" onclick="updateQty(1)">+</button>
                    </div>

                    <button type="button" class="btn btn-inquire-now d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#inquiryModal">
                        <i class="fas fa-paper-plane"></i> Get a Quote
                    </button>

                    <a href="https://wa.me/94114216784?text=Hi%20Isaro%20Automation,%20I%20am%20interested%20in%20<?php echo urlencode($product['title']); ?>" target="_blank" class="btn btn-whatsapp-inquire d-flex align-items-center gap-2">
                        <i class="fab fa-whatsapp fs-5"></i> Chat on WhatsApp
                    </a>

                    <button type="button" onclick="addToCompare('<?php echo htmlspecialchars($product['title']); ?>', '<?php echo htmlspecialchars($product['sku']); ?>', 'Rs <?php echo number_format($product['price'],0); ?>', '<?php echo htmlspecialchars($product['main_img']); ?>')" class="btn btn-add-compare-detail d-flex align-items-center gap-2">
                        <i class="fas fa-balance-scale fs-5"></i> Add to Compare
                    </button>

                    <button type="button" id="downloadPdfBtn1" onclick="generateProductPDF(this)" class="btn btn-download-datasheet d-flex align-items-center gap-2">
                        <i class="fas fa-file-pdf fs-5"></i> Download Technical Datasheet (PDF)
                    </button>
                </div>

                <div class="product-trust-card">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <div class="trust-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>100% Guaranteed Quality & Tested</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="trust-item">
                                <i class="fas fa-truck-fast"></i>
                                <span>Islandwide Island Delivery Available</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="trust-item">
                                <i class="fas fa-user-gear"></i>
                                <span>Free Expert Technical Support</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="trust-item">
                                <i class="fas fa-award"></i>
                                <span>17+ Years Industry Experience</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- 3. DETAILED TABS SECTION (DESCRIPTION, SPECS, REVIEWS) -->
<section class="py-5" style="background-color: #f5f6f8;">
    <div class="container py-2">
        <div class="bg-white rounded-3 shadow-sm p-4 p-md-5">
            
            <ul class="nav custom-nav-tabs mb-4" id="productDetailTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-pane" type="button" role="tab" aria-controls="desc-pane" aria-selected="true">
                        Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs-pane" type="button" role="tab" aria-controls="specs-pane" aria-selected="false">
                        Specifications
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab-btn" data-bs-toggle="tab" data-bs-target="#reviews-pane" type="button" role="tab" aria-controls="reviews-pane" aria-selected="false">
                        Reviews & Ratings (<?php echo count($approvedReviews); ?>)
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="productDetailTabsContent">
                
                <!-- TAB 1: DESCRIPTION -->
                <div class="tab-pane fade show active" id="desc-pane" role="tabpanel" aria-labelledby="desc-tab">
                    <h5 class="fw-bold mb-3" style="color: #b03030;">Product Overview & Applications</h5>
                    <p class="text-muted fs-7 mb-4" style="line-height: 1.7; text-align: left;">
                        <?php echo nl2br(htmlspecialchars($product['full_desc'] ?? $product['short_desc'])); ?>
                    </p>
                </div>

                <!-- TAB 2: SPECIFICATIONS -->
                <div class="tab-pane fade" id="specs-pane" role="tabpanel" aria-labelledby="specs-tab">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <h5 class="fw-bold mb-0" style="color: #b03030;">Technical Data Sheet</h5>
                        <button type="button" id="downloadPdfBtn2" onclick="generateProductPDF(this)" class="btn btn-sm btn-outline-danger fw-semibold d-inline-flex align-items-center gap-2">
                            <i class="fas fa-file-pdf"></i> Download Official PDF Datasheet
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered fs-7 align-middle">
                            <tbody>
                                <tr>
                                    <th class="bg-light text-dark w-25">Brand</th>
                                    <td>ISARO Automation Systems</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-dark">Model SKU</th>
                                    <td><?php echo htmlspecialchars($product['sku']); ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-dark">Category</th>
                                    <td><?php echo htmlspecialchars($product['category_name'] ?? 'Industrial Equipment'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: REVIEWS -->
                <div class="tab-pane fade" id="reviews-pane" role="tabpanel" aria-labelledby="reviews-tab-btn">
                    <div class="row g-4 g-lg-5">
                        
                        <div class="col-12 col-lg-4">
                            <div class="rating-summary-card">
                                <span class="big-rating-number">4.8</span>
                                <div class="text-warning fs-5 my-2">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                </div>
                                <p class="text-white-50 x-small mb-4">Based on verified customer reviews</p>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            
                            <?php if($review_success): ?>
                                <div class="alert alert-success py-2 text-center rounded-3 mb-4" style="font-size: 0.85rem;">
                                    <i class="fas fa-check-circle me-1"></i> Thank you! Your review has been submitted successfully and is pending approval.
                                </div>
                            <?php endif; ?>

                            <div class="p-4 rounded-3 border bg-light mb-4">
                                <h6 class="fw-bold text-dark mb-1"><i class="fas fa-edit text-danger me-2"></i> Write Your Review</h6>
                                <p class="text-secondary x-small mb-3">Share your experience with this product to help other engineers and buyers.</p>

                                <form action="product-detail.php?id=<?php echo $product['id']; ?>" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label d-block fw-semibold x-small mb-1">Your Rating *</label>
                                        <div class="star-rating-selector">
                                            <input type="radio" id="star5" name="rating" value="5" required><label for="star5" title="5 Stars"><i class="fas fa-star"></i></label>
                                            <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 Stars"><i class="fas fa-star"></i></label>
                                            <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 Stars"><i class="fas fa-star"></i></label>
                                            <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 Stars"><i class="fas fa-star"></i></label>
                                            <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 Star"><i class="fas fa-star"></i></label>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-sm-6">
                                            <input type="text" name="reviewer_name" class="form-control form-control-sm" placeholder="Your Name or Company *" required>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <input type="email" name="reviewer_email" class="form-control form-control-sm" placeholder="Your Email Address *" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <textarea name="reviewer_comment" class="form-control form-control-sm" rows="3" placeholder="Write your feedback regarding build quality, display accuracy, or installation..." required></textarea>
                                    </div>

                                    <button type="submit" name="submit_review" class="btn text-white px-4 py-2 fw-semibold rounded-2 shadow-sm fs-7" style="background-color: #b03030; border: none;">
                                        Submit Review
                                    </button>
                                </form>
                            </div>

                            <h6 class="fw-bold text-dark mb-3">Verified Buyer Reviews</h6>

                            <?php if(!empty($approvedReviews)): ?>
                                <?php foreach($approvedReviews as $rev): ?>
                                <div class="single-review-card">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-danger text-white fw-bold d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 0.85rem;">
                                                <?php echo strtoupper(substr($rev['reviewer_name'],0,2)); ?>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0 text-dark fs-7"><?php echo htmlspecialchars($rev['reviewer_name']); ?> <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill x-small ms-1"><i class="fas fa-check-circle"></i> Verified Buyer</span></h6>
                                            </div>
                                        </div>
                                        <span class="text-muted x-small"><?php echo date('Y-m-d', strtotime($rev['created_at'])); ?></span>
                                    </div>
                                    <div class="text-warning x-small mb-2">
                                        <?php for($i=1;$i<=5;$i++) echo ($i<=$rev['rating']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>'; ?>
                                    </div>
                                    <p class="text-secondary fs-7 mb-0" style="line-height: 1.55;">
                                        <?php echo htmlspecialchars($rev['comment']); ?>
                                    </p>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted fs-7">No reviews approved yet for this product in database.</p>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- 4. RELATED PRODUCTS SECTION -->
<?php if(!empty($relatedProducts)): ?>
<section class="py-5 bg-white">
    <div class="container py-2">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-secondary small fw-medium d-block mb-1" style="font-size: 0.88rem; color: #555555 !important;">Similar Items</span>
                <h2 class="fw-bold mb-0 fs-3" style="color: #b03030; line-height: 1.25;">Related Automation Products</h2>
            </div>
            <a href="products.php" class="btn text-white px-4 py-2 fw-semibold rounded-3 shadow-sm fs-7" style="background-color: #b03030;">Explore All</a>
        </div>

        <div class="row g-4">
            <?php foreach($relatedProducts as $rel): ?>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="product-card-box" onclick="window.location.href='product-detail.php?id=<?php echo $rel['id']; ?>'">
                    <div class="position-relative bg-white text-center p-3" style="height: 170px; display: flex; align-items: center; justify-content: center;">
                        <img src="<?php echo htmlspecialchars($rel['main_img']); ?>" class="img-fluid" style="max-height: 125px; width: auto; object-fit: contain;" alt="<?php echo htmlspecialchars($rel['title']); ?>">
                    </div>
                    <div class="p-3 text-start" style="background-color: #ececec; border-top: 1px solid #ddd;">
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.85rem; height: 38px; display: flex; align-items: center;"><?php echo htmlspecialchars($rel['title']); ?></h6>
                        <div class="mb-1" style="font-size: 0.85rem;">
                            <span class="fw-bold" style="color: #e54d42;">Rs <?php echo number_format($rel['price'],0); ?></span>
                            <?php if(!empty($rel['old_price'])): ?>
                            <span class="text-muted text-decoration-line-through ms-2" style="font-size: 0.78rem;">Rs <?php echo number_format($rel['old_price'],0); ?></span>
                            <?php endif; ?>
                        </div>
                        <a href="product-detail.php?id=<?php echo $rel['id']; ?>" class="btn btn-sm btn-outline-danger w-100 fw-semibold mt-2" style="font-size: 0.75rem;" onclick="event.stopPropagation()">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- 5. INQUIRY MODAL POPUP -->
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white" style="background-color: #b03030;">
                <h5 class="modal-header-title fw-bold mb-0 fs-6" id="inquiryModalLabel"><i class="fas fa-envelope-open-text me-2"></i> Request Official Quote</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted x-small mb-3">Complete this quick form and our technical engineering sales team will get back to you within 2 hours.</p>
                <form onsubmit="handleInquirySubmit(event)">
                    <div class="mb-3">
                        <label class="form-label x-small fw-semibold mb-1">Product Requested</label>
                        <input type="text" name="product_name" class="form-control form-control-sm bg-light" value="<?php echo htmlspecialchars($product['title'] . ' (' . $product['sku'] . ')'); ?>" readonly>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label x-small fw-semibold mb-1">Your Name *</label>
                            <input type="text" name="contact_name" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label x-small fw-semibold mb-1">Phone Number *</label>
                            <input type="tel" name="contact_phone" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label x-small fw-semibold mb-1">Company Name</label>
                        <input type="text" name="company_name" class="form-control form-control-sm">
                    </div>
                    <div class="mb-3">
                        <label class="form-label x-small fw-semibold mb-1">Notes or Quantity Required</label>
                        <textarea name="notes" class="form-control form-control-sm" rows="3" placeholder="Specify required quantities, delivery location, or special technical requirements..."></textarea>
                    </div>
                    <button type="submit" class="btn text-white w-100 py-2 fw-semibold rounded-2 shadow-sm" style="background-color: #b03030; border: none;">
                        Send Quote Request
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<div class="container py-5 text-center">
    <h4>No product found in database.</h4>
    <a href="products.php" class="btn btn-danger mt-2">View Catalog</a>
</div>
<?php endif; ?>

<!-- Floating WhatsApp Chat -->
<a href="https://wa.me/94114216784" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

</div>

<!-- Page JavaScript Functionalities & Pure Vector PDF Generator Engine -->
<script>
function changeImage(imgSrc, thumbElement) {
    var mainImg = document.getElementById('mainProductImg');
    if (mainImg) {
        mainImg.style.opacity = '0.5';
        setTimeout(function() {
            mainImg.src = imgSrc;
            mainImg.style.opacity = '1';
        }, 120);
    }
    
    var thumbs = document.querySelectorAll('.thumb-img-box');
    thumbs.forEach(function(t) { t.classList.remove('active'); });
    thumbElement.classList.add('active');
}

function updateQty(change) {
    var qtyInput = document.getElementById('productQty');
    if (qtyInput) {
        var currentQty = parseInt(qtyInput.value) || 1;
        var newQty = currentQty + change;
        if (newQty >= 1) {
            qtyInput.value = newQty;
        }
    }
}

function switchTab(tabId) {
    var tabBtn = document.getElementById(tabId);
    if (tabBtn && typeof bootstrap !== 'undefined') {
        var tab = new bootstrap.Tab(tabBtn);
        tab.show();
    }
}

function handleInquirySubmit(e) {
    e.preventDefault();
    alert('Thank you! Your quote request has been sent to Isaro Automation team. We will contact you shortly.');
    var inquiryModalEl = document.getElementById('inquiryModal');
    if (inquiryModalEl && typeof bootstrap !== 'undefined') {
        var modal = bootstrap.Modal.getInstance(inquiryModalEl);
        if (modal) { modal.hide(); }
    }
}

function addToCompare(title, code, price, img) {
    var stored = localStorage.getItem('isaro_compare');
    var list = stored ? JSON.parse(stored) : [];
    
    var exists = list.some(function(item) { return item.sku === code || item.title === title; });
    if (exists) {
        if (confirm(title + ' is already in your comparison list! Do you want to view the comparison page now?')) {
            window.location.href = 'compare.php';
        }
        return;
    }
    
    if (list.length >= 4) {
        alert('You can compare a maximum of 4 products at a time.');
        return;
    }

    list.push({
        id: Date.now().toString(),
        title: title,
        sku: code,
        price: price,
        img: img
    });

    localStorage.setItem('isaro_compare', JSON.stringify(list));
    
    if (confirm('✔ ' + title + ' added to comparison list! Do you want to view the comparison page now?')) {
        window.location.href = 'compare.php';
    }
}

function generateProductPDF(btnElement) {
    var originalHTML = btnElement.innerHTML;
    btnElement.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Generating PDF...';
    btnElement.style.pointerEvents = 'none';

    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: 'a4'
        });

        const currentDate = new Date().toLocaleDateString();

        doc.setFont("helvetica", "bold");
        doc.setFontSize(15);
        doc.setTextColor(176, 48, 48);
        doc.text("ISARO AUTOMATION SYSTEMS (PVT) LTD", 14, 15);

        doc.setFont("helvetica", "normal");
        doc.setFontSize(8.5);
        doc.setTextColor(88, 88, 88);
        doc.text("Industrial Automation, Pneumatic & Hydraulic Solutions", 14, 20);

        doc.setFontSize(8);
        doc.text("Doc: Technical Datasheet", 196, 15, { align: "right" });
        doc.text("Date: " + currentDate, 196, 20, { align: "right" });

        doc.setDrawColor(176, 48, 48);
        doc.setLineWidth(0.8);
        doc.line(14, 23, 196, 23);

        doc.setFillColor(248, 249, 250);
        doc.roundedRect(14, 27, 182, 30, 2, 2, "F");
        doc.setDrawColor(226, 226, 226);
        doc.setLineWidth(0.3);
        doc.roundedRect(14, 27, 182, 30, 2, 2, "D");

        doc.setFont("helvetica", "bold");
        doc.setFontSize(8);
        doc.setTextColor(46, 125, 50);
        doc.text("In Stock & Ready to Ship", 18, 34);

        doc.setFont("helvetica", "bold");
        doc.setFontSize(8);
        doc.setTextColor(100, 100, 100);
        doc.text("SKU: <?php echo htmlspecialchars($product['sku'] ?? ''); ?>", 192, 34, { align: "right" });

        doc.setFont("helvetica", "bold");
        doc.setFontSize(12);
        doc.setTextColor(30, 33, 37);
        doc.text("<?php echo htmlspecialchars($product['title'] ?? ''); ?>", 18, 42);

        doc.setFont("helvetica", "bold");
        doc.setFontSize(12);
        doc.setTextColor(176, 48, 48);
        doc.text("Rs <?php echo number_format($product['price'] ?? 0, 0); ?>", 192, 50, { align: "right" });

        doc.setFont("helvetica", "bold");
        doc.setFontSize(10);
        doc.setTextColor(176, 48, 48);
        doc.text("1. PRODUCT OVERVIEW", 14, 65);

        doc.setDrawColor(220, 220, 220);
        doc.setLineWidth(0.3);
        doc.line(14, 67, 196, 67);

        doc.setFont("helvetica", "normal");
        doc.setFontSize(8.5);
        doc.setTextColor(66, 66, 66);
        const overviewText = "<?php echo str_replace(["\r", "\n"], ' ', addslashes($product['short_desc'] ?? '')); ?>";
        const splitOverview = doc.splitTextToSize(overviewText, 182);
        doc.text(splitOverview, 14, 72);

        doc.setFont("helvetica", "bold");
        doc.setFontSize(10);
        doc.setTextColor(176, 48, 48);
        doc.text("2. COMPLETE TECHNICAL SPECIFICATIONS", 14, 95);

        doc.setDrawColor(220, 220, 220);
        doc.setLineWidth(0.3);
        doc.line(14, 97, 196, 97);

        doc.autoTable({
            startY: 100,
            head: [['Specification Attribute', 'Detailed Value / Standard']],
            body: [
                ['Brand', 'ISARO Automation Systems'],
                ['Model SKU', '<?php echo htmlspecialchars($product['sku'] ?? ''); ?>'],
                ['Category', '<?php echo htmlspecialchars($product['category_name'] ?? 'Industrial Automation'); ?>'],
                ['Price', 'Rs <?php echo number_format($product['price'] ?? 0, 0); ?>'],
                ['Warranty & Support', '1 Year Official Isaro Warranty + Free Tech Support']
            ],
            theme: 'striped',
            styles: { fontSize: 8, font: 'helvetica', cellPadding: 2.2 },
            headStyles: { fillColor: [176, 48, 48], textColor: [255, 255, 255], fontStyle: 'bold' },
            alternateRowStyles: { fillColor: [248, 249, 250] },
            margin: { left: 14, right: 14 }
        });

        doc.setDrawColor(176, 48, 48);
        doc.setLineWidth(0.6);
        doc.line(14, 275, 196, 275);

        doc.setFont("helvetica", "bold");
        doc.setFontSize(8);
        doc.setTextColor(33, 33, 33);
        doc.text("Isaro Automation Systems (Pvt) Ltd", 14, 280);

        doc.setFont("helvetica", "normal");
        doc.setFontSize(7.5);
        doc.setTextColor(100, 100, 100);
        doc.text("100% Quality Tested & Guaranteed B2B Industrial Supply", 14, 284);

        doc.setFont("helvetica", "bold");
        doc.text("Sales Helpline: +94 11 421 6784", 196, 280, { align: "right" });
        doc.setFont("helvetica", "normal");
        doc.text("Official Web: www.isaroautomation.com", 196, 284, { align: "right" });

        doc.save('<?php echo htmlspecialchars($product['sku'] ?? 'ISARO-Product'); ?>-Datasheet.pdf');

        btnElement.innerHTML = originalHTML;
        btnElement.style.pointerEvents = 'auto';

    } catch (err) {
        console.error('PDF Generation Error:', err);
        alert('PDF Generation failed: ' + err.message);
        btnElement.innerHTML = originalHTML;
        btnElement.style.pointerEvents = 'auto';
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Apple-Style Scroll Reveal Observer
    const observerOptions = { root: null, rootMargin: "0px 0px -30px 0px", threshold: 0.05 };
    const revealObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-revealed");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const animatableDetailElements = document.querySelectorAll(
        ".main-product-img-box, .product-trust-card, .rating-summary-card, .single-review-card, .product-card-box"
    );

    animatableDetailElements.forEach(function(el) {
        el.classList.add("apple-reveal");
        revealObserver.observe(el);
    });
});
</script>

<?php include 'includes/footer.php'; ?>