<?php 
include 'includes/header.php'; 
require_once 'config/db.php';

// 1. Fetch Recent / Featured Projects strictly from Database
$recentProjects = [];
try {
    $recStmt = $pdo->query("SELECT * FROM projects WHERE is_recent = 1 ORDER BY id DESC LIMIT 3");
    $recentProjects = $recStmt->fetchAll();
    if (empty($recentProjects)) {
        $recStmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC LIMIT 3");
        $recentProjects = $recStmt->fetchAll();
    }
} catch (PDOException $e) {
    $recentProjects = [];
}

// Separate large featured and small stacked recent projects
$largeRecent = $recentProjects[0] ?? null;
$smallRecent1 = $recentProjects[1] ?? null;
$smallRecent2 = $recentProjects[2] ?? null;

// 2. Fetch All Projects strictly from Database for the Grid Section
$allProjects = [];
try {
    $allStmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
    $allProjects = $allStmt->fetchAll();
} catch (PDOException $e) {
    $allProjects = [];
}
?>

<!-- Page Specific Responsive & Figma Exact Styles -->
<style>
/* Page Scope Wrapper */
.isaro-projects-page {
    font-family: 'Poppins', sans-serif;
    color: #333333;
    background-color: #f4f4f4;
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
.projects-hero-section {
    position: relative;
    background: linear-gradient(rgba(0, 0, 0, 0.68), rgba(0, 0, 0, 0.68)), url('assets/images/feedf7b7a69a5cfc65e4d847497ca581f69a9a4d.jpg') center/cover no-repeat;
    min-height: 340px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

/* Apple-Style Hero Entrance Animation */
.projects-hero-title {
    color: #ff0000;
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 15px;
    letter-spacing: -0.5px;
    opacity: 0;
    animation: appleHeroText 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards;
}

.projects-hero-p {
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
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.recent-card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2) !important;
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
    cursor: pointer;
    padding: 12px;
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e2e2;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
}

.project-grid-card:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    border-color: #b03030 !important;
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
    transition: transform 0.4s ease;
}

.project-grid-card:hover .project-img-box img {
    transform: scale(1.05);
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

/* Floating WhatsApp Button */
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
    .projects-hero-title { font-size: 2.2rem; }
    .section-main-title { font-size: 1.8rem; }
    .recent-card-large { height: 320px; }
    .recent-card-small { height: 220px; }
    .recent-title { font-size: 1rem; }
    .project-img-box { height: 160px; }
}

@media (max-width: 575.98px) {
    /* 1. Hero Section Mobile Optimization */
    .projects-hero-section { min-height: 280px !important; padding: 2.5rem 0 !important; }
    .projects-hero-title { font-size: clamp(1.6rem, 6vw, 2.2rem) !important; margin-bottom: 10px !important; }
    .projects-hero-p { font-size: 0.8rem !important; line-height: 1.5 !important; padding: 0 10px; }

    /* 2. Recent Projects Section Mobile Optimization */
    .recent-projects-section { padding: 35px 0 25px 0 !important; }
    .section-main-title { font-size: 1.5rem !important; margin-bottom: 20px !important; }
    .recent-card-large { height: 250px !important; border-radius: 14px !important; }
    .recent-card-small { height: 180px !important; border-radius: 14px !important; }
    .recent-title { font-size: 0.95rem !important; margin-bottom: 2px !important; }
    .recent-desc { font-size: 0.68rem !important; line-height: 1.35 !important; }
    .recent-overlay { padding: 10px 12px !important; }

    /* 3. All Projects Grid Section Mobile Optimization (2 Cards Side-by-Side) */
    .all-projects-section { padding-bottom: 45px !important; }
    .all-projects-section .row {
        display: flex !important;
        flex-wrap: wrap !important;
        margin-left: -4px !important;
        margin-right: -4px !important;
    }
    
    .all-projects-section .row > [class*="col-"] {
        flex: 0 0 50% !important;
        max-width: 50% !important;
        padding-left: 4px !important;
        padding-right: 4px !important;
        margin-bottom: 10px !important;
    }

    .project-grid-card {
        padding: 10px 8px !important;
        border-radius: 12px !important;
        box-shadow: 0 3px 12px rgba(0,0,0,0.05) !important;
    }

    .project-img-box {
        height: 115px !important;
        margin-bottom: 8px !important;
        border-radius: 8px !important;
    }

    .project-grid-title {
        font-size: 0.78rem !important;
        line-height: 1.25 !important;
        margin-bottom: 4px !important;
    }

    .project-grid-desc {
        font-size: 0.68rem !important;
        line-height: 1.3 !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
    }

    /* 4. Floating WhatsApp Button Safe Mobile Placement */
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

<div class="isaro-main-wrapper isaro-projects-page">

    <!-- 1. HERO SECTION -->
    <section class="projects-hero-section py-5">
        <div class="container py-4">
            <h1 class="projects-hero-title">Projects</h1>
            <p class="projects-hero-p">
                Discover our successfully executed engineering projects, showcasing advanced electrical, pneumatic, and hydraulic automation solutions tailored for modern industrial efficiency.
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
                    <?php if($largeRecent): ?>
                    <div class="recent-card recent-card-large" onclick="window.location.href='project-detail.php?id=<?php echo $largeRecent['id']; ?>'">
                        <img src="<?php echo htmlspecialchars($largeRecent['main_img']); ?>" alt="<?php echo htmlspecialchars($largeRecent['title']); ?>">
                        <div class="recent-overlay">
                            <h3 class="recent-title"><?php echo htmlspecialchars($largeRecent['title']); ?></h3>
                            <p class="recent-desc">
                                <?php echo htmlspecialchars($largeRecent['short_desc']); ?>
                            </p>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="recent-card recent-card-large d-flex align-items-center justify-content-center bg-white border">
                        <p class="text-muted mb-0">No recent project found.</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right Column: 2 Small Stacked Featured Projects -->
                <div class="col-12 col-lg-6 d-flex flex-column justify-content-between gap-4">
                    <!-- Featured Small 1 -->
                    <?php if($smallRecent1): ?>
                    <div class="recent-card recent-card-small" onclick="window.location.href='project-detail.php?id=<?php echo $smallRecent1['id']; ?>'">
                        <img src="<?php echo htmlspecialchars($smallRecent1['main_img']); ?>" alt="<?php echo htmlspecialchars($smallRecent1['title']); ?>">
                        <div class="recent-overlay">
                            <h3 class="recent-title"><?php echo htmlspecialchars($smallRecent1['title']); ?></h3>
                            <p class="recent-desc">
                                <?php echo htmlspecialchars($smallRecent1['short_desc']); ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Featured Small 2 -->
                    <?php if($smallRecent2): ?>
                    <div class="recent-card recent-card-small" onclick="window.location.href='project-detail.php?id=<?php echo $smallRecent2['id']; ?>'">
                        <img src="<?php echo htmlspecialchars($smallRecent2['main_img']); ?>" alt="<?php echo htmlspecialchars($smallRecent2['title']); ?>">
                        <div class="recent-overlay">
                            <h3 class="recent-title"><?php echo htmlspecialchars($smallRecent2['title']); ?></h3>
                            <p class="recent-desc">
                                <?php echo htmlspecialchars($smallRecent2['short_desc']); ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. ALL PROJECTS GRID SECTION -->
    <section class="all-projects-section">
        <div class="container">
            <div class="row g-4">
                <?php if(!empty($allProjects)): ?>
                    <?php foreach($allProjects as $proj): ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="project-grid-card" onclick="window.location.href='project-detail.php?id=<?php echo $proj['id']; ?>'">
                            <div class="project-img-box">
                                <img src="<?php echo htmlspecialchars($proj['main_img']); ?>" alt="<?php echo htmlspecialchars($proj['title']); ?>">
                            </div>
                            <h4 class="project-grid-title"><?php echo htmlspecialchars($proj['title']); ?></h4>
                            <p class="project-grid-desc">
                                <?php echo htmlspecialchars($proj['short_desc']); ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No projects found in database.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/94114216784" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

</div>

<!-- Custom Exact Sequence Scroll Reveal for Projects Page -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const observerOptions = { root: null, rootMargin: "0px 0px -30px 0px", threshold: 0.05 };
    const revealObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-revealed");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // 1. Recent Projects Section - Explicit Order: Large Box First (0.05s), then Small 1 (0.25s), then Small 2 (0.43s)
    const largeCard = document.querySelector('.recent-card-large');
    const smallCards = document.querySelectorAll('.recent-card-small');

    if (largeCard) {
        largeCard.classList.add('apple-reveal');
        largeCard.style.transitionDelay = '0.05s';
        revealObserver.observe(largeCard);
    }

    smallCards.forEach((card, idx) => {
        card.classList.add('apple-reveal');
        card.style.transitionDelay = (0.25 + (idx * 0.18)) + 's';
        revealObserver.observe(card);
    });

    // 2. All Projects Grid Section Custom Stagger (Strictly Left to Right)
    document.querySelectorAll('.all-projects-section .row').forEach(row => {
        Array.from(row.children).forEach((col, index) => {
            const card = col.querySelector('.project-grid-card');
            if(card) {
                card.classList.add('apple-reveal');
                card.style.transitionDelay = ((index % 4) * 0.15) + 's';
                revealObserver.observe(card);
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>