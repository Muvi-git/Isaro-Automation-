<?php include 'includes/header.php'; ?>

<!-- Page Specific Responsive & Figma Exact Styles -->
<style>
/* Page Scope Wrapper */
.isaro-projects-page {
    font-family: 'Poppins', sans-serif;
    color: #333333;
    background-color: #f4f4f4;
}

/* 1. Hero Section */
.projects-hero-section {
    position: relative;
    /* IMAGE PLACEHOLDER: Hero Dark Industrial Background Image */
    background: linear-gradient(rgba(0, 0, 0, 0.68), rgba(0, 0, 0, 0.68)), url('assets/images/feedf7b7a69a5cfc65e4d847497ca581f69a9a4d.jpg') center/cover no-repeat;
    min-height: 340px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.projects-hero-title {
    color: #ff0000;
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 15px;
    letter-spacing: -0.5px;
}

.projects-hero-p {
    color: #ffffff;
    font-size: 0.78rem;
    line-height: 1.6;
    max-width: 820px;
    margin: 0 auto;
    font-weight: 300;
    opacity: 0.9;
}

/* 2. Recent Projects Section */
.recent-projects-section {
    padding: 65px 0 50px 0;
}

.section-main-title {
    color: #b03030;
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 35px;
}

.recent-card {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    width: 100%;
}

.recent-card-large {
    height: 420px;
}

.recent-card-small {
    height: 198px;
}

.recent-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}

/* Dark Translucent Bottom Overlay Bar */
.recent-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.82);
    padding: 14px 20px;
    text-align: center;
    color: #ffffff;
}

.recent-title {
    color: #ff3333;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 4px;
    letter-spacing: -0.2px;
}

.recent-desc {
    color: #dddddd;
    font-size: 0.7rem;
    line-height: 1.4;
    margin: 0 auto;
    max-width: 90%;
    font-weight: 300;
}

/* 3. All Projects Grid Section */
.all-projects-section {
    padding-bottom: 85px;
}

.project-grid-card {
    text-align: center;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.project-img-box {
    width: 100%;
    height: 180px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    margin-bottom: 12px;
    background-color: #ffffff;
}

.project-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}

.project-grid-title {
    color: #b03030;
    font-size: 0.95rem;
    font-weight: 700;
    margin-bottom: 6px;
    line-height: 1.35;
}

.project-grid-desc {
    font-size: 0.72rem;
    color: #555555;
    line-height: 1.45;
    margin: 0;
    font-weight: 300;
}

/* Responsiveness Fine-Tuning */
@media (max-width: 991.98px) {
    .projects-hero-title { font-size: 2.2rem; }
    .section-main-title { font-size: 1.8rem; }
    .recent-card-large { height: 320px; }
    .recent-card-small { height: 220px; }
    .recent-title { font-size: 1rem; }
    .project-img-box { height: 160px; }
}

@media (max-width: 575.98px) {
    .projects-hero-title { font-size: 1.8rem; }
    .section-main-title { font-size: 1.5rem; }
    .recent-card-large, .recent-card-small { height: 240px; }
    .whatsapp-float { width: 52px; height: 52px; font-size: 28px; }
    .project-img-box { height: 150px; }
}
</style>

<div class="isaro-main-wrapper isaro-projects-page">

    <!-- 1. HERO SECTION -->
    <section class="projects-hero-section py-5">
        <div class="container py-4">
            <h1 class="projects-hero-title">Projects</h1>
            <p class="projects-hero-p">
                elementum vehicula. Donec tempor Cras commodo non, sit Nam urna. Ut ex adipiscing gravida venenatis vitae commodo lacus nisi diam quis felis, fringilla diam x scelerisque tempor elit. varius vitae tincidunt Donec Nunc Nam luctus turpis nec risus ex Lorem eu
            </p>
        </div>
    </section>

    <!-- 2. RECENT PROJECTS SECTION -->
    <section class="recent-projects-section">
        <div class="container">
            <h2 class="section-main-title text-center">Recent Projects</h2>

            <div class="row g-4 align-items-stretch">
                <!-- Left Column: Large Featured Project -->
                <div class="col-12 col-lg-6">
                    <div class="recent-card recent-card-large">
                        <!-- IMAGE PLACEHOLDER: Technician Orange Helmet Integration -->
                        <img src="assets/images/2f9058cda797988dc0788f626d5eb70c856ef2bb.png" alt="Smart Factory PLC Integration">
                        <div class="recent-overlay">
                            <h3 class="recent-title">Smart Factory PLC Integration</h3>
                            <p class="recent-desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: 2 Small Stacked Featured Projects -->
                <div class="col-12 col-lg-6 d-flex flex-column justify-content-between gap-4">
                    <!-- Featured Small 1 -->
                    <div class="recent-card recent-card-small">
                        <!-- IMAGE PLACEHOLDER: Hydraulic Press Control Top View -->
                        <img src="assets/images/7e3d191a15ac23b17a1f8a34d1a0cbed7c03be85.jpg" alt="Automated Hydraulic Press Control">
                        <div class="recent-overlay">
                            <h3 class="recent-title">Automated Hydraulic Press Control</h3>
                            <p class="recent-desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                            </p>
                        </div>
                    </div>

                    <!-- Featured Small 2 -->
                    <div class="recent-card recent-card-small">
                        <!-- IMAGE PLACEHOLDER: Pneumatic Conveyor Line Wiring -->
                        <img src="assets/images/c84739eb2ed88a5d12b5a4eaa2f2b5d9cc173fe8.jpg" alt="Pneumatic Conveyor Line Setup">
                        <div class="recent-overlay">
                            <h3 class="recent-title">Pneumatic Conveyor Line Setup</h3>
                            <p class="recent-desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. ALL PROJECTS GRID SECTION (8 ITEMS) -->
    <section class="all-projects-section">
        <div class="container">
            <div class="row g-4">
                <!-- Item 1 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="project-grid-card">
                        <div class="project-img-box">
                            <!-- IMAGE PLACEHOLDER: Wiring Board Technician -->
                            <img src="assets/images/e0ba8d58efa004b1ac9afae79bf8c83837b8b6b9.png" alt="Smart Factory PLC Integration">
                        </div>
                        <h4 class="project-grid-title">Smart Factory PLC Integration</h4>
                        <p class="project-grid-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                        </p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="project-grid-card">
                        <div class="project-img-box">
                            <!-- IMAGE PLACEHOLDER: White Cabinet Technician -->
                            <img src="assets/images/abfe2a759945e5458aa42bb255a9f6a4c17ab686.png" alt="Smart Factory PLC Integration">
                        </div>
                        <h4 class="project-grid-title">Smart Factory PLC Integration</h4>
                        <p class="project-grid-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                        </p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="project-grid-card">
                        <div class="project-img-box">
                            <!-- IMAGE PLACEHOLDER: Orange Helmet Technician -->
                            <img src="assets/images/2f9058cda797988dc0788f626d5eb70c856ef2bb.png" alt="Smart Factory PLC Integration">
                        </div>
                        <h4 class="project-grid-title">Smart Factory PLC Integration</h4>
                        <p class="project-grid-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                        </p>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="project-grid-card">
                        <div class="project-img-box">
                            <!-- IMAGE PLACEHOLDER: Top View Control Panel -->
                            <img src="assets/images/71455c53cbed251be21bbb31286a64a1ebe232e4.png" alt="Smart Factory PLC Integration">
                        </div>
                        <h4 class="project-grid-title">Smart Factory PLC Integration</h4>
                        <p class="project-grid-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                        </p>
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="project-grid-card">
                        <div class="project-img-box">
                            <!-- IMAGE PLACEHOLDER: Server Rack Engineers -->
                            <img src="assets/images/6ddd2e4b4912893a72b5141fd2dfd674ee5a7268.png" alt="Smart Factory PLC Integration">
                        </div>
                        <h4 class="project-grid-title">Smart Factory PLC Integration</h4>
                        <p class="project-grid-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                        </p>
                    </div>
                </div>

                <!-- Item 6 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="project-grid-card">
                        <div class="project-img-box">
                            <!-- IMAGE PLACEHOLDER: Yellow Testing Device Technician -->
                            <img src="assets/images/2eaf6daacbcfeb54ef8944e2eb85c527772da507 (1).png" alt="Smart Factory PLC Integration">
                        </div>
                        <h4 class="project-grid-title">Smart Factory PLC Integration</h4>
                        <p class="project-grid-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                        </p>
                    </div>
                </div>

                <!-- Item 7 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="project-grid-card">
                        <div class="project-img-box">
                            <!-- IMAGE PLACEHOLDER: Tablet Electrical Cabinet Engineer -->
                            <img src="assets/images/bbec571feac962f13fe6f2847521cc5041768c9c.png" alt="Smart Factory PLC Integration">
                        </div>
                        <h4 class="project-grid-title">Smart Factory PLC Integration</h4>
                        <p class="project-grid-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                        </p>
                    </div>
                </div>

                <!-- Item 8 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="project-grid-card">
                        <div class="project-img-box">
                            <!-- IMAGE PLACEHOLDER: White Helmet Tablet Inspector -->
                            <img src="assets/images/2a46fe30f446fe133675852222bb75faeab163a9.png" alt="Smart Factory PLC Integration">
                        </div>
                        <h4 class="project-grid-title">Smart Factory PLC Integration</h4>
                        <p class="project-grid-desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer at lectus sit amet ipsum vestibulum rutrum vel nec risus. Nullam sed fermentum elit.
                        </p>
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