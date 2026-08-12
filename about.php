<?php 
include 'includes/header.php'; 
require_once 'config/db.php';

// Fetch Team Members purely from Database (No hardcoded fallback arrays)
$teamMembers = [];
try {
    $stmt = $pdo->query("SELECT * FROM team_members ORDER BY sort_order ASC, id DESC");
    $teamMembers = $stmt->fetchAll();
} catch (PDOException $e) {
    $teamMembers = [];
}
?>

<!-- Swiper Slider CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Page Specific Responsive & Figma Exact Styles -->
<style>
/* Page Scope Wrapper */
.isaro-about-page {
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

/* 1. Hero Section */
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

/* 2. Who Are We Section */
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

/* Vertical Capsule / Pill Images (Single Image Split Crop Across 3 Pills) */
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

/* Slicing single wide image across 3 pill capsules */
.pill-1 img {
    object-position: 0% center; /* Left Portion */
}

.pill-2 img {
    object-position: 50% center; /* Center Portion */
}

.pill-3 img {
    object-position: 100% center; /* Right Portion */
}

/* 3. Vision & Mission Section */
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

/* Vision Card Background */
.vm-card-vision {
    background: linear-gradient(rgba(22, 24, 30, 0.78), rgba(22, 24, 30, 0.78)), url('assets/images/a79d7ea9dab8d052004fc56a5ef5adc16635039a.png') center/cover no-repeat;
}

/* Mission Card Background */
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

/* 4. Meet Our Team Section & Auto Background Slider Styles */
.team-section {
    position: relative;
    overflow: hidden;
    padding: 75px 0 85px 0;
    color: #ffffff;
    text-align: center;
}

.team-bg-slide {
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

.team-bg-slide.active {
    opacity: 1;
    transform: scale(1);
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

/* Responsiveness Fine-Tuning */
@media (max-width: 991.98px) {
    .about-hero-title { font-size: 2.2rem; }
    .who-title, .team-section-title { font-size: 1.8rem; }
    .who-text-col { padding-right: 12px; }
    .pill-image-wrapper { height: 320px; border-radius: 35px; }
    .vm-card { max-width: 100%; aspect-ratio: auto; padding: 25px 20px; min-height: 220px; }
}

@media (max-width: 575.98px) {
    .about-hero-title { font-size: 1.8rem; }
    .who-title, .team-section-title { font-size: 1.5rem; }
    .pill-image-wrapper { height: 230px; border-radius: 30px; }
    .whatsapp-float { width: 52px; height: 52px; font-size: 28px; }
    .vm-card { padding: 20px 15px; min-height: auto; }
}
</style>

<div class="isaro-main-wrapper isaro-about-page">

   <!-- 1. HERO SECTION -->
    <section class="about-hero-section py-5">
        <div class="container py-4">
            <h1 class="about-hero-title">About Us</h1>
            <p class="about-hero-p">
                Leading Sri Lanka’s industrial automation sector since 1999. We deliver cutting-edge electrical, pneumatic, and hydraulic systems backed by world-class global technology and expert engineering excellence.
            </p>
        </div>
    </section>

    <!-- 2. WHO ARE WE SECTION -->
    <section class="who-we-are-section">
        <div class="container">
            <div class="row align-items-center g-4 g-lg-5">
                <!-- Text Left Side -->
                <div class="col-12 col-lg-6 who-text-col">
                    <h2 class="who-title">WHO ARE WE?</h2>
                    <p class="who-p">
                        Isaro Automation Systems (Pvt) Ltd was set up in 1999 with the mission of providing automation solutions and engineering services to the industry in Sri Lanka at the accelerated industrial automation competition. Isaro Automation Systems (Pvt) Ltd is the authorized sole agent in Sri Lanka for the ORIGA pneumatic control components from Germany, MD-DELL sensors from Italy, Autonics Industrial control components from Korea, Ifm sensor products from Germany.
                    </p>
                    <p class="who-p">
                        Further we wish to inform you that our principal in Singapore are distributor for OMRON, FUJI, VICKERS, CKD, BOSH, SICK and over forty brands of world leading industrial control components.
                    </p>
                    <p class="who-p">
                        So we can attend your control component requirements faster and at competitive prices with warranty. Isaro Automation Systems (Pvt) Ltd has many years of experience in the sales and marketing of the products we represent. We are geared toward providing services to our customers with the level of quality that is dictated by today's highly competitive global market. This strategy will serve as our pinion to ensure our continual success in Sri Lanka.
                    </p>
                </div>

                <!-- 3 Vertical Capsule/Pill Images Right Side (Single Image Sliced Across 3 Pills) -->
                <div class="col-12 col-lg-6">
                    <div class="row g-2 justify-content-center">
                        <div class="col-4">
                            <div class="pill-image-wrapper pill-1">
                                <img src="assets/images/abfd49b7e97dcf378347005350484625b559a265 (2).png" alt="Who We Are Image Part 1">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="pill-image-wrapper pill-2">
                                <img src="assets/images/abfd49b7e97dcf378347005350484625b559a265 (2).png" alt="Who We Are Image Part 2">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="pill-image-wrapper pill-3">
                                <img src="assets/images/abfd49b7e97dcf378347005350484625b559a265 (2).png" alt="Who We Are Image Part 3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. VISION & MISSION SECTION -->
    <section class="vm-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-12 col-md-6 d-flex justify-content-center">
                    <div class="vm-card vm-card-vision">
                        <div class="vm-icon-circle">
                            <i class="fa-regular fa-eye"></i>
                        </div>
                        <h3 class="vm-title">Vision</h3>
                        <p class="vm-p">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6 d-flex justify-content-center">
                    <div class="vm-card vm-card-mission">
                        <div class="vm-icon-circle">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>
                        <h3 class="vm-title">Mission</h3>
                        <p class="vm-p">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. MEET OUR TEAM SECTION (AUTO SLIDING BACKGROUND & STRICTLY 4 VISIBLE MEMBER CARDS) -->
    <section class="team-section">
        <!-- 3 Layered Background Images for Automatic Crossfade -->
        <div class="team-bg-slide active" style="background-image: linear-gradient(rgba(0, 0, 0, 0.58), rgba(0, 0, 0, 0.58)), url('assets/images/67d12759ce882ac6dba72d274c24e0c3e3f0bc10.png');"></div>
        <div class="team-bg-slide" style="background-image: linear-gradient(rgba(0, 0, 0, 0.58), rgba(0, 0, 0, 0.58)), url('assets/images/feedf7b7a69a5cfc65e4d847497ca581f69a9a4d.jpg');"></div>
        <div class="team-bg-slide" style="background-image: linear-gradient(rgba(0, 0, 0, 0.58), rgba(0, 0, 0, 0.58)), url('assets/images/b95b4009ce4b6e877bde5514673695345345fdcc.png');"></div>

        <div class="container position-relative" style="z-index: 5;">
            <h2 class="team-section-title">Meet Our Team</h2>

            <div class="swiper team-swiper">
                <div class="swiper-wrapper">
                    <?php if(!empty($teamMembers)): ?>
                        <?php foreach($teamMembers as $tm): ?>
                        <div class="swiper-slide h-auto py-2">
                            <div class="team-card-item h-100">
                                <div class="team-member-img-box">
                                    <img src="<?php echo htmlspecialchars($tm['image']); ?>" alt="<?php echo htmlspecialchars($tm['name']); ?>">
                                </div>
                                <h4 class="team-member-name"><?php echo htmlspecialchars($tm['name']); ?></h4>
                                <p class="team-member-desc"><?php echo htmlspecialchars($tm['designation'] ?? ''); ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="swiper-slide text-center">
                            <p class="text-white mb-0">No team members available in database.</p>
                        </div>
                    <?php endif; ?>
                </div>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Automatic Background Image Slideshow Logic for Team Section
    const teamSlides = document.querySelectorAll('.team-bg-slide');
    if (teamSlides.length > 0) {
        let currentTeamSlide = 0;
        setInterval(function() {
            teamSlides[currentTeamSlide].classList.remove('active');
            currentTeamSlide = (currentTeamSlide + 1) % teamSlides.length;
            teamSlides[currentTeamSlide].classList.add('active');
        }, 4000);
    }

    // 2. Meet Our Team Cards Swiper
    if (typeof Swiper !== 'undefined' && document.querySelector('.team-swiper')) {
        new Swiper('.team-swiper', {
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
                768: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                },
                992: {
                    slidesPerView: 4,
                    spaceBetween: 24,
                }
            }
        });
    }

    // 3. LANDING SCROLL REVEAL OBSERVER FOR ABOUT PAGE
    const observerOptions = { root: null, rootMargin: "0px 0px -30px 0px", threshold: 0.05 };
    const revealObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-revealed");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const aboutAnimElements = document.querySelectorAll(
        ".who-text-col, .pill-image-wrapper, .vm-card, .team-card-item"
    );

    aboutAnimElements.forEach(function(el) {
        el.classList.add("apple-reveal");
        let delay = 0;
        if (el.closest('.row')) {
            let col = el.closest('[class*="col-"]');
            if (col && col.parentElement) {
                let siblings = Array.from(col.parentElement.children);
                let idx = siblings.indexOf(col);
                delay = (idx % 4) * 0.14;
            }
        }
        el.style.transitionDelay = delay + 's';
        revealObserver.observe(el);
    });
});
</script>

<?php include 'includes/footer.php'; ?> 