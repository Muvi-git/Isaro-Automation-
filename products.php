<?php include 'includes/header.php'; ?>

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
    /* IMAGE PLACEHOLDER: Hero Dark Industrial Background Image */
    background: linear-gradient(rgba(0, 0, 0, 0.68), rgba(0, 0, 0, 0.68)), url('assets/images/feedf7b7a69a5cfc65e4d847497ca581f69a9a4d.jpg') center/cover no-repeat;
    min-height: 340px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.products-hero-title {
    color: #ff0000;
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 15px;
    letter-spacing: -0.5px;
}

.products-hero-p {
    color: #ffffff;
    font-size: 0.78rem;
    line-height: 1.6;
    max-width: 820px;
    margin: 0 auto;
    font-weight: 300;
    opacity: 0.9;
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

/* Perfect Product Cards Styling */
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
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Fixed Image Box Container - Edge-to-Edge Fill */
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

/* Content & Title Equalization */
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
    padding: 7px 22px;
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

/* 3. Red Category Banner Section (Perfect Constrained Proportions) */
.category-banner-section {
    background-color: #b03030;
    padding: 55px 0;
    color: #ffffff;
}

.category-banner-card {
    text-align: center;
    width: 100%;
    max-width: 330px; /* Prevents cards from stretching too wide on desktop */
    margin: 0 auto;
}

.category-banner-img {
    width: 100%;
    height: 210px; /* Balanced height for exact Figma look */
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

/* Responsiveness Fine-Tuning */
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
                elementum vehicula. Donec tempor Cras commodo non, sit Nam urna. Ut ex adipiscing gravida venenatis vitae commodo lacus nisi diam quis felis, fringilla diam x scelerisque tempor elit. varius vitae tincidunt Donec Nunc Nam luctus turpis nec risus ex Lorem eu
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
                        <li><a class="dropdown-item" href="#">All Categories</a></li>
                        <li><a class="dropdown-item" href="#">Electrical & Electronics</a></li>
                        <li><a class="dropdown-item" href="#">Pneumatic Products</a></li>
                        <li><a class="dropdown-item" href="#">Hydraulic Products</a></li>
                    </ul>
                </div>
            </div>

            <!-- Product Grid 1 (Row 1 & 2) -->
            <div class="row g-4">
                <!-- Item 1 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <!-- IMAGE PLACEHOLDER: Digital Panel Meter -->
                            <img src="assets/images/b432d96cfa8f80614741d6f26ee4c84e73ec4f86.png" alt="Digital Panel Meters">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Digital Panel Meters</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <!-- IMAGE PLACEHOLDER: Pressure Regulator -->
                            <img src="assets/images/811821004797026ac18c9a115f1b50578adfd1d1 (1).png" alt="Pressure Regulator">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Pressure Regulator</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <!-- IMAGE PLACEHOLDER: Hand Valve Pneumatic -->
                            <img src="assets/images/59935624d6a0605b083cee98e98ab5367e12f66d (1).png" alt="Hand Valve">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Hand Valve</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <!-- IMAGE PLACEHOLDER: Hydraulic Cylinders -->
                            <img src="assets/images/d5383f22ac03dc846865eaef9c1961bdefea7a5e (1).png" alt="Hydraulic Cylinders">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Hydraulic Cylinders</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <!-- IMAGE PLACEHOLDER: Hand Valve Pneumatic -->
                            <img src="assets/images/ceac3043d20c17c0f960b25773684b03e09b887a.png" alt="Hand Valve">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Hand Valve</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 6 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <!-- IMAGE PLACEHOLDER: Hydraulic Cylinders -->
                            <img src="assets/images/67c202614336eaa91093ee58d47edba33f742723.png" alt="Hydraulic Cylinders">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Hydraulic Cylinders</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 7 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <!-- IMAGE PLACEHOLDER: Programmable Terminals Display -->
                            <img src="assets/images/2bd82bccc12a674da93024bcfa909e92c9856c96.png" alt="Programmable Terminals">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Programmable Terminals</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 8 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <!-- IMAGE PLACEHOLDER: Pressure Regulator -->
                            <img src="assets/images/bd04ef460ec093b3f1760e46ef26e0936acaee06.png" alt="Pressure Regulator">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Pressure Regulator</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. RED CATEGORY HIGHLIGHT BANNER SECTION (FIXED BOX PROPORTIONS) -->
    <section class="category-banner-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <!-- Banner Item 1: Electrical & Electronics -->
                <div class="col-12 col-md-4 d-flex justify-content-center">
                    <div class="category-banner-card">
                        <div class="category-banner-img">
                            <img src="assets/images/32aa4dfd4e0fe44f84107df06e8e281fd9c2f2e6.png" alt="Electrical & Electronics Products">
                        </div>
                        <h4 class="category-banner-title">Electrical & Electronics Products</h4>
                    </div>
                </div>

                <!-- Banner Item 2: Pneumatic Products -->
                <div class="col-12 col-md-4 d-flex justify-content-center">
                    <div class="category-banner-card">
                        <div class="category-banner-img">
                            <img src="assets/images/72bc19bc15c652ef1ebab5ea8ebbd18fc7f578e6.png" alt="Pneumatic Products">
                        </div>
                        <h4 class="category-banner-title">Pneumatic Products</h4>
                    </div>
                </div>

                <!-- Banner Item 3: Hydraulic Products -->
                <div class="col-12 col-md-4 d-flex justify-content-center">
                    <div class="category-banner-card">
                        <div class="category-banner-img">
                            <img src="assets/images/74190591cc61e45aafc1b8fc126a5b8cb44cc169.png" alt="Hydraulic Products">
                        </div>
                        <h4 class="category-banner-title">Hydraulic Products</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. SECOND PRODUCTS GRID -->
    <section class="products-main-section">
        <div class="container">
            <div class="row g-4">
                <!-- Item 9 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="assets/images/053219ad68445b8c69f01a1095e7e31846d4af0d.png" alt="Digital Panel Meters">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Digital Panel Meters</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 10 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="assets/images/bd04ef460ec093b3f1760e46ef26e0936acaee06 (1).png" alt="Pressure Regulator">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Pressure Regulator</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 11 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="assets/images/251fffe4bfeeb2b5ea07a9f20897b874b55fa31e.png" alt="Hand Valve">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Hand Valve</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 12 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="assets/images/c044e1c761f7086a2d5e4441c321b7286ae6a65a.png" alt="Hydraulic Cylinders">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Hydraulic Cylinders</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 13 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="assets/images/b432d96cfa8f80614741d6f26ee4c84e73ec4f86 (1).png" alt="Programmable Logic controller">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Programmable Logic controller</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 14 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="assets/images/811821004797026ac18c9a115f1b50578adfd1d1 (1).png" alt="Programmable Logic controller">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Programmable Logic controller</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 15 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="assets/images/59935624d6a0605b083cee98e98ab5367e12f66d (1).png" alt="Programmable Terminals">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Programmable Terminals</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item 16 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="assets/images/d5383f22ac03dc846865eaef9c1961bdefea7a5e (1).png" alt="Digital Panel Meters">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h4 class="product-title">Digital Panel Meters</h4>
                                <p class="product-desc">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus varius Cras volutpat tincidunt cursus nulla, Nam viverra sit elit lobortis, placerat et non ex</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. NEW ARRIVALS HORIZONTAL SCROLL SECTION -->
    <section class="new-arrivals-section">
        <div class="container">
            <h3 class="new-arrivals-title">New Arrivals</h3>

            <div class="new-arrivals-scroll">
                <!-- Scroll Item 1 -->
                <div class="new-arrivals-card">
                    <div class="product-card">
                        <div class="product-img-box" style="height: 120px;">
                            <img src="assets/images/811821004797026ac18c9a115f1b50578adfd1d1 (1).png" alt="Hand Valve">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h5 class="product-title" style="font-size: 0.8rem; min-height: 2.2em;">Hand Valve</h5>
                                <p class="product-desc" style="font-size: 0.65rem;">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details" style="padding: 4px 14px; font-size: 0.68rem;">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scroll Item 2 -->
                <div class="new-arrivals-card">
                    <div class="product-card">
                        <div class="product-img-box" style="height: 120px;">
                            <img src="assets/images/b432d96cfa8f80614741d6f26ee4c84e73ec4f86 (1).png" alt="Hydraulic Cylinders">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h5 class="product-title" style="font-size: 0.8rem; min-height: 2.2em;">Hydraulic Cylinders</h5>
                                <p class="product-desc" style="font-size: 0.65rem;">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details" style="padding: 4px 14px; font-size: 0.68rem;">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scroll Item 3 -->
                <div class="new-arrivals-card">
                    <div class="product-card">
                        <div class="product-img-box" style="height: 120px;">
                            <img src="assets/images/c044e1c761f7086a2d5e4441c321b7286ae6a65a.png" alt="Programmable Terminals">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h5 class="product-title" style="font-size: 0.8rem; min-height: 2.2em;">Programmable Terminals</h5>
                                <p class="product-desc" style="font-size: 0.65rem;">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details" style="padding: 4px 14px; font-size: 0.68rem;">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scroll Item 4 -->
                <div class="new-arrivals-card">
                    <div class="product-card">
                        <div class="product-img-box" style="height: 120px;">
                            <img src="assets/images/2bd82bccc12a674da93024bcfa909e92c9856c96.png" alt="Pressure Regulator">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h5 class="product-title" style="font-size: 0.8rem; min-height: 2.2em;">Pressure Regulator</h5>
                                <p class="product-desc" style="font-size: 0.65rem;">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details" style="padding: 4px 14px; font-size: 0.68rem;">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scroll Item 5 -->
                <div class="new-arrivals-card">
                    <div class="product-card">
                        <div class="product-img-box" style="height: 120px;">
                            <img src="assets/images/67c202614336eaa91093ee58d47edba33f742723.png" alt="Programmable Logic controller">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h5 class="product-title" style="font-size: 0.8rem; min-height: 2.2em;">Programmable Logic controller</h5>
                                <p class="product-desc" style="font-size: 0.65rem;">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details" style="padding: 4px 14px; font-size: 0.68rem;">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scroll Item 6 -->
                <div class="new-arrivals-card">
                    <div class="product-card">
                        <div class="product-img-box" style="height: 120px;">
                            <img src="assets/images/ceac3043d20c17c0f960b25773684b03e09b887a.png" alt="Programmable Logic controller">
                        </div>
                        <div class="product-content-box">
                            <div>
                                <h5 class="product-title" style="font-size: 0.8rem; min-height: 2.2em;">Programmable Logic controller</h5>
                                <p class="product-desc" style="font-size: 0.65rem;">diam placerat dignissim, Donec Cras non porta Lorem feugiat nec maximus</p>
                            </div>
                            <div>
                                <a href="#" class="btn-more-details" style="padding: 4px 14px; font-size: 0.68rem;">More Details</a>
                            </div>
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