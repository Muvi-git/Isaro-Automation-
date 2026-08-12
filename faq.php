<?php 
include 'includes/header.php'; 
require_once 'config/db.php';

// Fetch FAQs purely from Database (No hardcoded fallback arrays)
$faqs = [];
try {
    $stmt = $pdo->query("SELECT * FROM faqs ORDER BY sort_order ASC, id DESC");
    $faqs = $stmt->fetchAll();
} catch (PDOException $e) {
    $faqs = [];
}
?>

<!-- FAQ Page Custom Styles -->
<style>
.isaro-faq-wrapper {
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

/* Breadcrumb */
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

/* FAQ Hero */
.faq-hero-section {
    background: linear-gradient(rgba(0, 0, 0, 0.72), rgba(0, 0, 0, 0.72)), url('assets/images/feedf7b7a69a5cfc65e4d847497ca581f69a9a4d.jpg') center/cover no-repeat;
    min-height: 280px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #ffffff;
    margin-bottom: 40px;
}

/* Accordion Customization */
.accordion-item {
    border: 1px solid #e5e5e5 !important;
    border-radius: 12px !important;
    overflow: hidden;
    margin-bottom: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
}

.accordion-button {
    font-weight: 700;
    font-size: 0.95rem;
    color: #1e2125;
    background-color: #ffffff;
    padding: 18px 22px;
}

.accordion-button:not(.collapsed) {
    color: #b03030;
    background-color: #fff8f8;
    box-shadow: none;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: #b03030;
}

.accordion-body {
    font-size: 0.85rem;
    color: #555555;
    line-height: 1.7;
    padding: 20px 22px;
    background-color: #ffffff;
    text-align: left !important; /* Prevents awkward word gaps */
}

/* Help Sidebar */
.faq-help-card {
    background: #ffffff;
    border: 1px solid #e8e8e8;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    position: sticky;
    top: 110px;
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
   APPLE-GRADE MOBILE RESPONSIVENESS (MATCHING ALL PAGES)
   ========================================================= */
@media (max-width: 991.98px) {
    .faq-hero-section { min-height: 240px; margin-bottom: 30px; }
}

@media (max-width: 575.98px) {
    /* 1. Hero & Breadcrumbs Mobile Optimization */
    .custom-breadcrumb { padding: 10px 0 !important; }
    .custom-breadcrumb a, .custom-breadcrumb .active { font-size: 0.75rem !important; }
    .faq-hero-section { min-height: 220px !important; padding: 2rem 0 !important; margin-bottom: 25px !important; }
    .faq-hero-section h1 { font-size: clamp(1.5rem, 5.5vw, 2rem) !important; }
    .faq-hero-section p { font-size: 0.78rem !important; line-height: 1.5 !important; padding: 0 10px; }

    /* 2. Accordion Mobile Optimization */
    .accordion-button { padding: 14px 16px !important; font-size: 0.85rem !important; line-height: 1.35 !important; }
    .accordion-body { padding: 14px 16px !important; font-size: 0.8rem !important; line-height: 1.55 !important; }
    
    /* 3. Help Card Mobile Optimization */
    .faq-help-card { padding: 20px 16px !important; border-radius: 14px !important; margin-top: 10px; }
    .faq-help-card h5 { font-size: 1.1rem !important; }
    .faq-help-card p { font-size: 0.78rem !important; }

    /* 4. Floating WhatsApp Button Mobile Placement */
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

<div class="isaro-faq-wrapper">

<!-- BREADCRUMB -->
<div class="custom-breadcrumb">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            <a href="index.php"><i class="fas fa-home me-1"></i> Home</a>
            <span class="text-muted fs-7">/</span>
            <span class="active">Frequently Asked Questions</span>
        </div>
    </div>
</div>

<!-- FAQ HERO SECTION -->
<section class="faq-hero-section">
    <div class="container py-4">
        <h1 class="fw-bold fs-1 text-danger mb-2">Frequently Asked Questions</h1>
        <p class="text-white-50 fs-7 mb-0" style="max-width: 650px; margin: 0 auto;">
            Find quick answers regarding our industrial equipment warranties, B2B credit terms, technical installation support, and islandwide delivery.
        </p>
    </div>
</section>

<!-- MAIN FAQ CONTAINER -->
<div class="container pb-5">
    <div class="row g-4 g-lg-5">
        
        <!-- Left Column: Accordion Questions (Dynamic from Database) -->
        <div class="col-12 col-lg-8">
            <div class="accordion" id="isaroFaqAccordion">
                <?php if (!empty($faqs)): ?>
                    <?php foreach ($faqs as $index => $faq): 
                        $collapseId = 'collapse' . $faq['id'];
                        $headingId = 'heading' . $faq['id'];
                        $isFirst = ($index === 0);
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                            <button class="accordion-button <?php echo $isFirst ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapseId; ?>" aria-expanded="<?php echo $isFirst ? 'true' : 'false'; ?>" aria-controls="<?php echo $collapseId; ?>">
                                <?php echo ($index + 1) . '. ' . htmlspecialchars($faq['question']); ?>
                            </button>
                        </h2>
                        <div id="<?php echo $collapseId; ?>" class="accordion-collapse collapse <?php echo $isFirst ? 'show' : ''; ?>" aria-labelledby="<?php echo $headingId; ?>" data-bs-parent="#isaroFaqAccordion">
                            <div class="accordion-body">
                                <?php echo nl2br(htmlspecialchars($faq['answer'])); ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-white p-4 rounded-3 text-center border shadow-sm">
                        <p class="text-muted mb-0">No frequently asked questions available in the database.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column: Help Card Sidebar -->
        <div class="col-12 col-lg-4">
            <div class="faq-help-card text-center">
                <div class="mb-3">
                    <i class="fas fa-headset text-danger fa-3x"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Have More Questions?</h5>
                <p class="text-secondary fs-7 mb-4">Can't find what you're looking for? Feel free to reach out to our technical engineering team directly.</p>
                <a href="contact.php" class="btn text-white w-100 py-2 fw-semibold rounded-2" style="background-color: #b03030;">Contact Support</a>
            </div>
        </div>

    </div>
</div>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/94114216784" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

</div>

<script>
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

    const animatableFaqElements = document.querySelectorAll(
        ".accordion-item, .faq-help-card"
    );

    animatableFaqElements.forEach(function(el, idx) {
        el.classList.add("apple-reveal");
        el.style.transitionDelay = ((idx % 6) * 0.1) + 's';
        revealObserver.observe(el);
    });
});
</script>

<?php include 'includes/footer.php'; ?>