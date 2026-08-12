<?php 
include 'includes/header.php'; 
require_once 'config/db.php';

// 1. Fetch Categories for Dropdown strictly from Database
$categories = [];
try {
    $catStmt = $pdo->query("SELECT * FROM categories WHERE status='active' ORDER BY name ASC");
    $categories = $catStmt->fetchAll();
} catch (PDOException $e) {
    $categories = [];
}

// 2. Fetch Filtered/All Products strictly from Database
$cat_slug = isset($_GET['cat']) ? trim($_GET['cat']) : '';
$dbProducts = [];

try {
    if (!empty($cat_slug)) {
        $stmt = $pdo->prepare("SELECT p.*, c.slug as cat_slug FROM products p JOIN categories c ON p.category_id = c.id WHERE c.slug = ? ORDER BY p.id DESC");
        $stmt->execute([$cat_slug]);
    } else {
        $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    }
    $dbProducts = $stmt->fetchAll();
} catch (PDOException $e) {
    $dbProducts = [];
}

// Split DB Products into Grid 1 (First 8) and Grid 2 (Remaining) to preserve exact Figma Banner layout
$grid1Products = array_slice($dbProducts, 0, 8);
$grid2Products = array_slice($dbProducts, 8);

// 3. Fetch New Arrivals strictly from Database
$newArrivals = [];
try {
    $newStmt = $pdo->query("SELECT * FROM products WHERE is_new_arrival = 1 ORDER BY id DESC LIMIT 10");
    $newArrivals = $newStmt->fetchAll();
    if (empty($newArrivals) && !empty($dbProducts)) {
        $newArrivals = array_slice($dbProducts, 0, 6);
    }
} catch (PDOException $e) {
    $newArrivals = [];
}
?>

<!-- Swiper Slider CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Page Specific Responsive & Figma Exact Styles -->
<style>
/* Page Scope Wrapper */
.isaro-products-page {
    font-family: 'Poppins', sans-serif;
    color: #333333;
    background-color: #f4f4f4;
}

/* 1. Hero Section */
.products-hero-section {
    position: relative;
    background: linear-gradient(rgba(0, 0, 0, 0.68), rgba(0, 0, 0, 0.68)), url('assets/images/feedf7b7a69a5cfc65e4d847497ca581f69a9a4d.jpg') center/cover no-repeat;
    min-height: 340px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

/* Apple-Style Hero Entrance Animation */
.products-hero-title {
    color: #ff0000;
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 15px;
    letter-spacing: -0.5px;
    opacity: 0;
    animation: appleHeroText 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards;
}

.products-hero-p {
    color: #ffffff;
    font-size: 0.78rem;
    line-height: 1.6;
    max-width: 820px;
    margin: 0 auto;
    font-weight: 300;
    opacity: 0;
    animation: appleHeroText 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.25s forwards;
}

@keyframes appleHeroText {
    0% { opacity: 0; transform: translateY(40px) scale(0.98); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

/* 2. Products Section Header & Filter */
.products-main-section {
    padding: 60px 0;
}

.products-main-title {
    color: #b03030;
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 0;
}

.category-dropdown-btn {
    background: transparent;
    border: none;
    font-size: 0.92rem;
    font-weight: 600;
    color: #333333;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
}

/* Perfect Product Cards Styling with Full Box Clickable */
.product-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px 15px;
    border: 1px solid #e2e2e2;
    text-align: center;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    cursor: pointer;
}

.product-card:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    border-color: #b03030 !important;
}

.product-img-box {
    width: 100%;
    height: 180px;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 15px;
    background-color: #ffffff;
    padding: 0;
}

.product-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}

.product-content-box {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    justify-content: space-between;
}

.product-title {
    color: #b03030;
    font-size: 0.92rem;
    font-weight: 700;
    margin-bottom: 8px;
    line-height: 1.35;
    min-height: 2.7em;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-desc {
    font-size: 0.72rem;
    color: #666666;
    line-height: 1.45;
    margin-bottom: 18px;
    font-weight: 300;
}

.btn-more-details {
    background-color: #b03030;
    color: #ffffff;
    border: none;
    padding: 7px 18px;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-more-details:hover {
    background-color: #8e2323;
    color: #ffffff;
    transform: translateY(-2px);
}

.btn-compare-card {
    background-color: #ffffff;
    color: #b03030;
    border: 1px solid #b03030;
    padding: 6px 10px;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 4px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s ease;
    cursor: pointer;
}

.btn-compare-card:hover {
    background-color: #b03030;
    color: #ffffff;
}

/* 3. Red Category Highlight Banner Slider Section */
.category-banner-section {
    background-color: #b03030;
    padding: 55px 0;
    color: #ffffff;
}

.category-banner-card {
    text-align: center;
    width: 100%;
    max-width: 330px;
    margin: 0 auto;
    transition: transform 0.3s ease;
}

.category-banner-card:hover {
    transform: translateY(-5px);
}

.category-banner-img {
    width: 100%;
    height: 210px;
    border-radius: 18px;
    overflow: hidden;
    margin-bottom: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.22);
}

.category-banner-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.category-banner-title {
    color: #ffffff;
    font-size: 0.98rem;
    font-weight: 600;
    margin: 0;
    letter-spacing: 0.2px;
}

/* Swiper Slider Dots Customization */
.category-swiper-pagination {
    position: relative !important;
    margin-top: 25px !important;
}

.category-swiper-pagination .swiper-pagination-bullet {
    background: #ffffff !important;
    opacity: 0.4 !important;
    width: 10px;
    height: 10px;
    transition: all 0.3s ease;
}

.category-swiper-pagination .swiper-pagination-bullet-active {
    opacity: 1 !important;
    width: 28px;
    border-radius: 6px;
    background: #ffffff !important;
}

/* 4. New Arrivals Scroll Section */
.new-arrivals-section {
    padding: 60px 0 80px 0;
}

.new-arrivals-title {
    color: #b03030;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 30px;
}

.new-arrivals-scroll {
    display: flex;
    gap: 18px;
    overflow-x: auto;
    padding-bottom: 15px;
    scrollbar-width: thin;
    scrollbar-color: #b03030 #e0e0e0;
}

.new-arrivals-card {
    min-width: 190px;
    max-width: 210px;
    flex: 0 0 auto;
}

@media (max-width: 991.98px) {
    .products-hero-title { font-size: 2.2rem; }
    .products-main-title, .new-arrivals-title { font-size: 1.8rem; }
    .category-banner-img { height: 180px; }
    .product-img-box { height: 160px; }
}

@media (max-width: 575.98px) {
    .products-hero-title { font-size: 1.8rem; }
    .products-main-title, .new-arrivals-title { font-size: 1.5rem; }
    .category-banner-img { height: 160px; }
    .product-img-box { height: 150px; }
}
</style>

<div class="isaro-main-wrapper isaro-products-page">

   <!-- 1. HERO SECTION -->
    <section class="products-hero-section py-5">
        <div class="container py-4">
            <h1 class="products-hero-title">Our Products</h1>
            <p class="products-hero-p">
                Explore our extensive range of premium industrial automation products, including top-tier electrical, pneumatic, and hydraulic components sourced from world-renowned global manufacturers.
            </p>
        </div>
    </section>

    <!-- 2. MAIN PRODUCTS GRID 1 -->
    <section class="products-main-section">
        <div class="container">
            <!-- Title & Category Dropdown Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div class="flex-grow-1 text-center">
                    <h2 class="products-main-title">Products</h2>
                </div>
                <div class="dropdown">
                    <button class="category-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="products.php">All Categories</a></li>
                        <?php if(!empty($categories)): ?>
                            <?php foreach($categories as $cat): ?>
                            <li><a class="dropdown-item" href="products.php?cat=<?php echo htmlspecialchars($cat['slug']); ?>"><?php echo htmlspecialchars($cat['name']); ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Product Grid 1 (Strictly Dynamic Database Items) -->
            <div class="row g-4">
                <?php if(!empty($grid1Products)): ?>
                    <?php foreach($grid1Products as $p): ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="product-card" onclick="navigateToDetail(event, 'product-detail.php?id=<?php echo $p['id']; ?>')">
                            <div class="product-img-box">
                                <img src="<?php echo htmlspecialchars($p['main_img']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>">
                            </div>
                            <div class="product-content-box">
                                <div>
                                    <h4 class="product-title"><?php echo htmlspecialchars($p['title']); ?></h4>
                                    <p class="product-desc"><?php echo htmlspecialchars($p['short_desc'] ?? ''); ?></p>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="product-detail.php?id=<?php echo $p['id']; ?>" class="btn-more-details" onclick="event.stopPropagation()">More Details</a>
                                    <button type="button" class="btn-compare-card" onclick="addToCompare(event, '<?php echo htmlspecialchars($p['title']); ?>', '<?php echo htmlspecialchars($p['sku']); ?>', 'Rs <?php echo number_format($p['price'], 0); ?>', '<?php echo htmlspecialchars($p['main_img']); ?>')" title="Compare Product">
                                        <i class="fas fa-balance-scale"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-4">
                        <p class="text-muted mb-0">No products found in database.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 3. RED CATEGORY HIGHLIGHT BANNER SLIDER SECTION (STRICTLY 3 VISIBLE PER SLIDE) -->
    <section class="category-banner-section">
        <div class="container">
            <div class="swiper category-swiper">
                <div class="swiper-wrapper">
                    <?php if(!empty($categories)): ?>
                        <?php foreach($categories as $cat): 
                            $catImg = !empty($cat['image']) ? $cat['image'] : 'assets/images/32aa4dfd4e0fe44f84107df06e8e281fd9c2f2e6.png';
                            if (empty($cat['image'])) {
                                $slug = strtolower($cat['slug']);
                                if (strpos($slug, 'pneumatic') !== false) {
                                    $catImg = 'assets/images/72bc19bc15c652ef1ebab5ea8ebbd18fc7f578e6.png';
                                } elseif (strpos($slug, 'hydraulic') !== false) {
                                    $catImg = 'assets/images/74190591cc61e45aafc1b8fc126a5b8cb44cc169.png';
                                }
                            }
                        ?>
                        <div class="swiper-slide d-flex justify-content-center">
                            <a href="products.php?cat=<?php echo htmlspecialchars($cat['slug']); ?>" class="text-decoration-none w-100">
                                <div class="category-banner-card">
                                    <div class="category-banner-img">
                                        <img src="<?php echo htmlspecialchars($catImg); ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>">
                                    </div>
                                    <h4 class="category-banner-title"><?php echo htmlspecialchars($cat['name']); ?></h4>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Default Static Fallback Banners -->
                        <div class="swiper-slide d-flex justify-content-center">
                            <div class="category-banner-card">
                                <div class="category-banner-img">
                                    <img src="assets/images/32aa4dfd4e0fe44f84107df06e8e281fd9c2f2e6.png" alt="Electrical & Electronics Products">
                                </div>
                                <h4 class="category-banner-title">Electrical & Electronics Products</h4>
                            </div>
                        </div>
                        <div class="swiper-slide d-flex justify-content-center">
                            <div class="category-banner-card">
                                <div class="category-banner-img">
                                    <img src="assets/images/72bc19bc15c652ef1ebab5ea8ebbd18fc7f578e6.png" alt="Pneumatic Products">
                                </div>
                                <h4 class="category-banner-title">Pneumatic Products</h4>
                            </div>
                        </div>
                        <div class="swiper-slide d-flex justify-content-center">
                            <div class="category-banner-card">
                                <div class="category-banner-img">
                                    <img src="assets/images/74190591cc61e45aafc1b8fc126a5b8cb44cc169.png" alt="Hydraulic Products">
                                </div>
                                <h4 class="category-banner-title">Hydraulic Products</h4>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Pagination Dots -->
                <div class="swiper-pagination category-swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- 4. SECOND PRODUCTS GRID (Strictly Dynamic Database Items) -->
    <?php if(!empty($grid2Products)): ?>
    <section class="products-main-section">
        <div class="container">
            <div class="row g-4">
                <?php foreach($grid2Products as $p): ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card" onclick="navigateToDetail(event, 'product-detail.php?id=<?php echo $p['id']; ?>')">
                        <div class="product-img-box">
                            <img src="<?php echo htmlspecialchars($p['main_img']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title"><?php echo htmlspecialchars($p['title']); ?></h4>
                                <p class="product-desc"><?php echo htmlspecialchars($p['short_desc'] ?? ''); ?></p>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <a href="product-detail.php?id=<?php echo $p['id']; ?>" class="btn-more-details" onclick="event.stopPropagation()">More Details</a>
                                <button type="button" class="btn-compare-card" onclick="addToCompare(event, '<?php echo htmlspecialchars($p['title']); ?>', '<?php echo htmlspecialchars($p['sku']); ?>', 'Rs <?php echo number_format($p['price'], 0); ?>', '<?php echo htmlspecialchars($p['main_img']); ?>')" title="Compare Product">
                                    <i class="fas fa-balance-scale"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- 5. NEW ARRIVALS HORIZONTAL SCROLL SECTION (Strictly Dynamic Database Items) -->
    <section class="new-arrivals-section">
        <div class="container">
            <h3 class="new-arrivals-title">New Arrivals</h3>

            <div class="new-arrivals-scroll">
                <?php if(!empty($newArrivals)): ?>
                    <?php foreach($newArrivals as $np): ?>
                    <div class="new-arrivals-card">
                        <div class="product-card" onclick="navigateToDetail(event, 'product-detail.php?id=<?php echo $np['id']; ?>')">
                            <div class="product-img-box" style="height: 120px;">
                                <img src="<?php echo htmlspecialchars($np['main_img']); ?>" alt="<?php echo htmlspecialchars($np['title']); ?>">
                            </div>
                            <div class="product-content-box">
                                <div>
                                    <h5 class="product-title" style="font-size: 0.8rem; min-height: 2.2em;"><?php echo htmlspecialchars($np['title']); ?></h5>
                                    <p class="product-desc" style="font-size: 0.65rem;"><?php echo htmlspecialchars(substr($np['short_desc'] ?? '', 0, 50)); ?></p>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <a href="product-detail.php?id=<?php echo $np['id']; ?>" class="btn-more-details" style="padding: 4px 10px; font-size: 0.68rem;" onclick="event.stopPropagation()">More Details</a>
                                    <button type="button" class="btn-compare-card" style="padding: 4px 8px; font-size: 0.68rem;" onclick="addToCompare(event, '<?php echo htmlspecialchars($np['title']); ?>', '<?php echo htmlspecialchars($np['sku']); ?>', 'Rs <?php echo number_format($np['price'], 0); ?>', '<?php echo htmlspecialchars($np['main_img']); ?>')" title="Compare">
                                        <i class="fas fa-balance-scale"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted small mb-0">No new arrivals in database.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/94114216784" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

</div>

<!-- Swiper Slider JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Navigation, Compare, Slider & Scroll Reveal Script -->
<script>
function navigateToDetail(event, url) {
    if (event.target.closest('button') || event.target.closest('a')) {
        return;
    }
    window.location.href = url;
}

function addToCompare(event, title, code, price, img) {
    event.stopPropagation();
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

document.addEventListener("DOMContentLoaded", function() {
    // 1. Initialize Swiper Slider for Category Banner Section
    const categorySwiper = new Swiper('.category-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.category-swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            576: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 24,
            }
        }
    });

    // 2. Sequential Scroll Reveal for Products Page
    const observerOptions = { root: null, rootMargin: "0px 0px -40px 0px", threshold: 0.05 };
    const revealObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-revealed");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Grid Products Staggering (Strictly L to R)
    document.querySelectorAll('.products-main-section .row').forEach(row => {
        Array.from(row.children).forEach((col, index) => {
            const card = col.querySelector('.product-card');
            if(card) {
                card.classList.add('apple-reveal');
                card.style.transitionDelay = ((index % 4) * 0.15) + 's';
                revealObserver.observe(card);
            }
        });
    });

    // New Arrivals Horizontal Staggering
    document.querySelectorAll('.new-arrivals-card .product-card').forEach((card, index) => {
        card.classList.add('apple-reveal');
        card.style.transitionDelay = ((index % 10) * 0.1) + 's';
        revealObserver.observe(card);
    });
});
</script>

<?php include 'includes/footer.php'; ?>