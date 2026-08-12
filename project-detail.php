<?php 
include 'includes/header.php'; 
require_once 'config/db.php';

// 1. Get Project ID from URL
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 2. Fetch Project strictly from Database
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$project_id]);
$project = $stmt->fetch();

// Fetch latest project if ID is invalid or missing
if (!$project) {
    $fallbackStmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC LIMIT 1");
    $project = $fallbackStmt->fetch();
}

// 3. Fetch Related Projects strictly from Database (Limit 4)
$relatedProjects = [];
if ($project) {
    $relStmt = $pdo->prepare("SELECT * FROM projects WHERE id != ? ORDER BY id DESC LIMIT 4");
    $relStmt->execute([$project['id']]);
    $relatedProjects = $relStmt->fetchAll();
}
?>

<!-- Custom Styles for Project Detail Page -->
<style>
.isaro-project-detail-wrapper {
    font-family: 'Poppins', sans-serif;
    color: #333333;
    background-color: #f8f9fa;
    min-height: 70vh;
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
    background-color: #ffffff;
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

/* Project Main Cover Image */
.project-main-img-box {
    width: 100%;
    height: 420px;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    background-color: #ffffff;
}
.project-main-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}

/* Project Meta Info Sidebar Box */
.project-meta-card {
    background: #ffffff;
    border: 1px solid #e8e8e8;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    position: sticky;
    top: 110px;
}

.project-meta-item {
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 14px;
    margin-bottom: 14px;
}
.project-meta-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.btn-project-inquire {
    background-color: #b03030;
    color: #ffffff;
    font-weight: 600;
    padding: 12px 20px;
    border-radius: 8px;
    border: none;
    width: 100%;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(176, 48, 48, 0.25);
}
.btn-project-inquire:hover {
    background-color: #8e2323;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(176, 48, 48, 0.4);
}

.btn-project-whatsapp {
    background-color: #25d366;
    color: #ffffff;
    font-weight: 600;
    padding: 12px 20px;
    border-radius: 8px;
    border: none;
    width: 100%;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(37, 211, 102, 0.25);
}
.btn-project-whatsapp:hover {
    background-color: #1eb956;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(37, 211, 102, 0.4);
}

/* Related Projects Equal Height Cards */
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
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-color: #b03030;
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
    .project-main-img-box { height: 320px; }
}

@media (max-width: 575.98px) {
    /* 1. Gallery & Breadcrumbs Mobile Tuning */
    .custom-breadcrumb { padding: 10px 0 !important; }
    .custom-breadcrumb a, .custom-breadcrumb .active { font-size: 0.75rem !important; }
    .project-main-img-box { height: 230px !important; border-radius: 12px !important; }
    .project-meta-card { padding: 18px 15px !important; border-radius: 14px !important; }

    /* 2. Related Projects Mobile Grid - Exactly 2 Side-by-Side Cards */
    .pt-5.mt-4 .row.g-4 {
        display: flex !important;
        flex-wrap: wrap !important;
        margin-left: -4px !important;
        margin-right: -4px !important;
    }
    .pt-5.mt-4 .row.g-4 > .col-12.col-sm-6.col-lg-3 {
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

    /* 3. Floating WhatsApp Button Safe Mobile Placement */
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

<div class="isaro-project-detail-wrapper">

<?php if(!empty($project)): ?>

<!-- 1. BREADCRUMB NAVIGATION -->
<div class="custom-breadcrumb mb-4">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            <a href="index.php"><i class="fas fa-home me-1"></i> Home</a>
            <span class="text-muted fs-7">/</span>
            <a href="projects.php">Projects</a>
            <span class="text-muted fs-7">/</span>
            <span class="active"><?php echo htmlspecialchars($project['title']); ?></span>
        </div>
    </div>
</div>

<!-- 2. MAIN PROJECT DETAIL SECTION -->
<div class="container pb-5">
    <div class="row g-4 g-lg-5">
        
        <!-- Left Column: Main Photo & Case Study Content -->
        <div class="col-12 col-lg-7 col-xl-8">
            <!-- Main Featured Image -->
            <div class="project-main-img-box mb-4">
                <img src="<?php echo htmlspecialchars($project['main_img']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
            </div>

            <!-- Title & Article Content -->
            <h2 class="fw-bold mb-3" style="color: #b03030;"><?php echo htmlspecialchars($project['title']); ?></h2>
            
            <p class="text-muted fs-7 mb-4" style="line-height: 1.7; text-align: left;">
                <?php echo htmlspecialchars($project['short_desc']); ?>
            </p>

            <!-- Key Engineering Highlights Box -->
            <div class="bg-white p-4 rounded-3 border mb-4 shadow-sm">
                <h5 class="fw-bold text-dark mb-3"><i class="fas fa-cogs text-danger me-2"></i> Project Engineering Scope</h5>
                <div class="row g-3 fs-7 text-secondary">
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-danger mt-1"></i>
                            <span>Centralized PLC & HMI Touch Interface Integration</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-danger mt-1"></i>
                            <span>Heavy-Duty Hydraulic Press Pressure Monitoring</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-danger mt-1"></i>
                            <span>Pneumatic Conveyor Control & Safety Interlocks</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-danger mt-1"></i>
                            <span>Voltage Drop Protection & Power Factor Correction</span>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold text-dark mb-2">Project Results & Details</h5>
            <p class="text-muted fs-7 mb-0" style="line-height: 1.7; text-align: left;">
                <?php echo nl2br(htmlspecialchars($project['full_details'] ?? $project['short_desc'])); ?>
            </p>
        </div>

        <!-- Right Column: Meta Information Box & Quick Inquiry -->
        <div class="col-12 col-lg-5 col-xl-4">
            <div class="project-meta-card">
                <h5 class="fw-bold text-dark mb-4"><i class="fas fa-info-circle text-danger me-2"></i> Project Details</h5>

                <div class="project-meta-item">
                    <span class="text-muted x-small d-block">Client Industry</span>
                    <strong class="text-dark fs-7"><?php echo htmlspecialchars($project['client_industry'] ?? 'Industrial Manufacturing'); ?></strong>
                </div>

                <div class="project-meta-item">
                    <span class="text-muted x-small d-block">Location</span>
                    <strong class="text-dark fs-7"><?php echo htmlspecialchars($project['location'] ?? 'Sri Lanka'); ?></strong>
                </div>

                <div class="project-meta-item">
                    <span class="text-muted x-small d-block">Core Technologies Used</span>
                    <strong class="text-dark fs-7"><?php echo htmlspecialchars($project['technologies'] ?? 'PLC, Pneumatic Control, Digital Panel Meters'); ?></strong>
                </div>

                <div class="project-meta-item">
                    <span class="text-muted x-small d-block">Project Completion</span>
                    <strong class="text-dark fs-7">Completed with 1-Year Warranty Support</strong>
                </div>

                <div class="pt-3">
                    <button type="button" class="btn-project-inquire mb-2 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#projectQuoteModal">
                        <i class="fas fa-envelope"></i> Request Similar Project Quote
                    </button>

                    <a href="https://wa.me/94114216784?text=Hi%20Isaro%20Automation,%20I%20want%20to%20inquire%20about%20your%20<?php echo urlencode($project['title']); ?>%20project." target="_blank" class="btn-project-whatsapp">
                        <i class="fab fa-whatsapp fs-5"></i> Discuss via WhatsApp
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. RELATED PROJECTS SECTION (4 Equal Height Clickable Cards) -->
    <?php if(!empty($relatedProjects)): ?>
    <div class="pt-5 mt-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-secondary small fw-medium d-block mb-1">More Work</span>
                <h3 class="fw-bold mb-0" style="color: #b03030;">Explore Similar Projects</h3>
            </div>
            <a href="projects.php" class="btn text-white px-4 py-2 fw-semibold rounded-3 shadow-sm fs-7" style="background-color: #b03030;">View All Projects</a>
        </div>

        <div class="row g-4">
            <?php foreach($relatedProjects as $rel): ?>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="project-grid-card" onclick="window.location.href='project-detail.php?id=<?php echo $rel['id']; ?>'">
                    <div class="project-img-box">
                        <img src="<?php echo htmlspecialchars($rel['main_img']); ?>" alt="<?php echo htmlspecialchars($rel['title']); ?>">
                    </div>
                    <h4 class="project-grid-title"><?php echo htmlspecialchars($rel['title']); ?></h4>
                    <p class="project-grid-desc">
                        <?php echo htmlspecialchars($rel['short_desc']); ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php else: ?>
<div class="container py-5 text-center">
    <h4 class="fw-bold">No project details found in database.</h4>
    <a href="projects.php" class="btn btn-danger mt-2">View All Projects</a>
</div>
<?php endif; ?>

</div>

<!-- PROJECT INQUIRY MODAL POPUP -->
<div class="modal fade" id="projectQuoteModal" tabindex="-1" aria-labelledby="projectQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white" style="background-color: #b03030;">
                <h5 class="modal-title fw-bold mb-0 fs-6" id="projectQuoteModalLabel"><i class="fas fa-paper-plane me-2"></i> Inquire About Engineering Projects</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted x-small mb-3">Send your technical requirements and our engineering consultancy team will get in touch with you.</p>
                
                <form onsubmit="handleProjectQuoteSubmit(event)">
                    <div class="mb-3">
                        <label class="form-label x-small fw-semibold mb-1">Your Name *</label>
                        <input type="text" name="name" class="form-control form-control-sm" required placeholder="John Doe">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label x-small fw-semibold mb-1">Phone Number *</label>
                            <input type="tel" name="phone" class="form-control form-control-sm" required placeholder="071XXXXXXX">
                        </div>
                        <div class="col-6">
                            <label class="form-label x-small fw-semibold mb-1">Email *</label>
                            <input type="email" name="email" class="form-control form-control-sm" required placeholder="name@company.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label x-small fw-semibold mb-1">Project Requirements / Details</label>
                        <textarea name="details" class="form-control form-control-sm" rows="3" placeholder="Describe your automation, pneumatic, or hydraulic project scope..."></textarea>
                    </div>
                    <button type="submit" class="btn text-white w-100 py-2 fw-semibold rounded-2 shadow-sm fs-7" style="background-color: #b03030; border: none;">
                        Submit Engineering Inquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/94114216784" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<script>
function handleProjectQuoteSubmit(e) {
    e.preventDefault();
    alert('Thank you! Your project inquiry has been submitted to Isaro Automation engineering team.');
    var modalEl = document.getElementById('projectQuoteModal');
    if (modalEl && typeof bootstrap !== 'undefined') {
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
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

    const animatableProjectElements = document.querySelectorAll(
        ".project-main-img-box, .project-meta-card, .bg-white.p-4.rounded-3, .project-grid-card"
    );

    animatableProjectElements.forEach(function(el) {
        el.classList.add("apple-reveal");
        revealObserver.observe(el);
    });
});
</script>

<?php include 'includes/footer.php'; ?>