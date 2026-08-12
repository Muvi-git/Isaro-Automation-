<?php include 'includes/header.php'; ?>

<!-- Pure Vector PDF Generation Libraries (Zero Canvas Blur / Zero Blank Page Bugs) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<!-- Wishlist Page Specific Styles -->
<style>
.isaro-wishlist-wrapper {
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

/* Wishlist Table & Items */
.wishlist-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e8e8e8;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    overflow: hidden;
}

.wishlist-item-row {
    padding: 16px 20px;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.2s ease;
}
.wishlist-item-row:last-child {
    border-bottom: none;
}
.wishlist-item-row:hover {
    background-color: #fcfcfc;
}

.wishlist-img-box {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    border: 1px solid #e5e5e5;
    padding: 6px;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.wishlist-img-box img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}

.btn-remove-item {
    color: #dc3545;
    background: #fff0f1;
    border: none;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    transition: all 0.2s ease;
}
.btn-remove-item:hover {
    background: #dc3545;
    color: #ffffff;
}

/* Summary Inquiry Box */
.inquiry-summary-box {
    background: #ffffff;
    border: 1px solid #e8e8e8;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    position: sticky;
    top: 110px;
}

.btn-send-whatsapp-bulk {
    background-color: #25d366;
    color: #ffffff;
    font-weight: 600;
    padding: 12px 20px;
    border-radius: 8px;
    border: none;
    width: 100%;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(37, 211, 102, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}
.btn-send-whatsapp-bulk:hover {
    background-color: #1eb956;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(37, 211, 102, 0.4);
}

.btn-submit-quote-bulk {
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
.btn-submit-quote-bulk:hover {
    background-color: #8e2323;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(176, 48, 48, 0.4);
}

.btn-download-pdf-bulk {
    border: 1px solid #b03030;
    color: #b03030;
    font-weight: 600;
    padding: 11px 20px;
    border-radius: 8px;
    background: #ffffff;
    width: 100%;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
}
.btn-download-pdf-bulk:hover {
    background-color: #b03030;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(176, 48, 48, 0.25);
}

/* Empty State */
.empty-wishlist-box {
    text-align: center;
    padding: 60px 20px;
}
.empty-wishlist-icon {
    font-size: 3.5rem;
    color: #cccccc;
    margin-bottom: 15px;
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
@media (max-width: 575.98px) {
    /* 1. Header & Breadcrumbs Mobile Optimization */
    .custom-breadcrumb { padding: 10px 0 !important; }
    .custom-breadcrumb a, .custom-breadcrumb .active { font-size: 0.75rem !important; }
    .isaro-wishlist-wrapper h2 { font-size: 1.35rem !important; }

    /* 2. Wishlist Items Mobile Layout */
    .wishlist-item-row { padding: 12px 14px !important; }
    .wishlist-img-box { width: 65px !important; height: 65px !important; }
    
    /* 3. Inquiry Summary Box Mobile Optimization */
    .inquiry-summary-box { padding: 20px 16px !important; border-radius: 14px !important; margin-top: 10px; }
    .inquiry-summary-box h5 { font-size: 1.1rem !important; }

    .btn-send-whatsapp-bulk,
    .btn-submit-quote-bulk,
    .btn-download-pdf-bulk {
        font-size: 0.82rem !important;
        padding: 10px 16px !important;
    }

    .empty-wishlist-box { padding: 40px 15px !important; }
    .empty-wishlist-icon { font-size: 2.8rem !important; }

    /* 4. Floating WhatsApp Button Mobile Safe Placement */
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

<div class="isaro-wishlist-wrapper">

<!-- BREADCRUMB -->
<div class="custom-breadcrumb mb-4">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            <a href="index.php"><i class="fas fa-home me-1"></i> Home</a>
            <span class="text-muted fs-7">/</span>
            <a href="products.php">Our Products</a>
            <span class="text-muted fs-7">/</span>
            <span class="active">My Inquiry List & Wishlist</span>
        </div>
    </div>
</div>

<div class="container pb-5">
    
    <!-- Page Title Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #b03030;">My Saved Inquiry List</h2>
            <p class="text-secondary x-small mb-0">Select your required items and contact our sales team directly for instant pricing & availability.</p>
        </div>
        <button type="button" class="btn btn-outline-danger btn-sm fs-7 fw-medium" onclick="clearWishlist()">
            <i class="far fa-trash-alt me-1"></i> Clear List
        </button>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-4" id="wishlistContainer">
        
        <!-- Left: Wishlist Items Container -->
        <div class="col-12 col-lg-7 col-xl-8">
            <div class="wishlist-card" id="wishlistItemsBox">
                <!-- Items rendered dynamically via JavaScript strictly from LocalStorage -->
            </div>
        </div>

        <!-- Right: Inquiry & WhatsApp Action Box -->
        <div class="col-12 col-lg-5 col-xl-4">
            <div class="inquiry-summary-box">
                <h5 class="fw-bold text-dark mb-3"><i class="fas fa-file-invoice-dollar text-danger me-2"></i> Request Bulk Quote</h5>
                <p class="text-muted x-small mb-3">No online payment required. Send this list directly to our engineering sales team or download an official PDF quotation.</p>

                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <div class="d-flex justify-content-between fs-7 mb-2">
                        <span class="text-secondary">Selected Items:</span>
                        <span class="fw-bold text-dark" id="summaryCount">0 Items</span>
                    </div>
                    <div class="d-flex justify-content-between fs-7">
                        <span class="text-secondary">Est. Processing Time:</span>
                        <span class="fw-bold text-success"><i class="fas fa-bolt me-1"></i> Within 2 Hours</span>
                    </div>
                </div>

                <!-- Action 1: Send All via WhatsApp -->
                <a href="#" id="whatsappBulkBtn" target="_blank" class="btn-send-whatsapp-bulk mb-2">
                    <i class="fab fa-whatsapp fs-5"></i> Inquire via WhatsApp
                </a>

                <!-- Action 2: Form Quote Request Modal Trigger -->
                <button type="button" class="btn-submit-quote-bulk mb-2 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#bulkQuoteModal">
                    <i class="fas fa-envelope-open-text"></i> Submit Official Quote Request
                </button>

                <!-- Action 3: Download Official PDF Quote -->
                <button type="button" class="btn-download-pdf-bulk d-flex align-items-center justify-content-center gap-2" onclick="generateBulkQuotePDF(this)">
                    <i class="fas fa-file-pdf"></i> Download Official Quote (PDF)
                </button>

                <hr class="my-3" style="color: #eee;">

                <div class="d-flex align-items-center gap-2 x-small text-muted">
                    <i class="fas fa-headset text-danger fs-6"></i>
                    <span>Need technical advice? Call us at <strong>+94 11 4216784</strong></span>
                </div>
            </div>
        </div>

    </div>

</div>

</div>

<!-- BULK QUOTE MODAL POPUP -->
<div class="modal fade" id="bulkQuoteModal" tabindex="-1" aria-labelledby="bulkQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white" style="background-color: #b03030;">
                <h5 class="modal-title fw-bold mb-0 fs-6" id="bulkQuoteModalLabel"><i class="fas fa-paper-plane me-2"></i> Submit Inquiry List for Quote</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted x-small mb-3">Our sales team will prepare an official proforma invoice/quotation for your selected list.</p>
                
                <form onsubmit="handleBulkQuoteSubmit(event)">
                    <div class="mb-3">
                        <label class="form-label x-small fw-semibold mb-1">Your Full Name *</label>
                        <input type="text" name="full_name" class="form-control form-control-sm" required placeholder="e.g. Perera Silva">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label x-small fw-semibold mb-1">Phone Number *</label>
                            <input type="tel" name="phone" class="form-control form-control-sm" required placeholder="071XXXXXXX">
                        </div>
                        <div class="col-6">
                            <label class="form-label x-small fw-semibold mb-1">Email Address *</label>
                            <input type="email" name="email" class="form-control form-control-sm" required placeholder="name@company.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label x-small fw-semibold mb-1">Company / Factory Name</label>
                        <input type="text" name="company" class="form-control form-control-sm" placeholder="e.g. ABC Industrial Pvt Ltd">
                    </div>
                    <div class="mb-3">
                        <label class="form-label x-small fw-semibold mb-1">Additional Requirements / Notes</label>
                        <textarea name="notes" class="form-control form-control-sm" rows="3" placeholder="Add specific model numbers, required quantities, or site delivery location..."></textarea>
                    </div>
                    <button type="submit" class="btn text-white w-100 py-2 fw-semibold rounded-2 shadow-sm fs-7" style="background-color: #b03030; border: none;">
                        Send Inquiry List
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Floating WhatsApp Chat Button -->
<a href="https://wa.me/94114216784" class="whatsapp-float" target="_blank" title="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- Wishlist Dynamic Management Script (NO DUMMY DEFAULT DATA) -->
<script>
function getWishlist() {
    var stored = localStorage.getItem('isaro_wishlist');
    if (!stored) {
        return [];
    }
    try {
        return JSON.parse(stored);
    } catch(e) {
        return [];
    }
}

function renderWishlist() {
    var items = getWishlist();
    var itemsBox = document.getElementById('wishlistItemsBox');
    var summaryCount = document.getElementById('summaryCount');
    var whatsappBtn = document.getElementById('whatsappBulkBtn');

    if (items.length === 0) {
        itemsBox.innerHTML = `
            <div class="empty-wishlist-box">
                <i class="far fa-heart empty-wishlist-icon"></i>
                <h5 class="fw-bold text-dark mb-2">Your Inquiry List is Empty</h5>
                <p class="text-muted fs-7 mb-4">Browse our industrial catalog and click the heart icon to save products for quote requests.</p>
                <a href="products.php" class="btn text-white px-4 py-2 fw-semibold rounded-2 fs-7" style="background-color: #b03030;">Explore Products</a>
            </div>
        `;
        if (summaryCount) summaryCount.innerText = '0 Items';
        if (whatsappBtn) whatsappBtn.href = "https://wa.me/94114216784?text=Hi%20Isaro%20Automation,%20I%20have%20an%20inquiry.";
        return;
    }

    var html = '';
    var textForWhatsApp = "Hi Isaro Automation, I would like to request an official quotation for the following items:\n\n";

    items.forEach(function(item, index) {
        var itemCode = item.sku || item.code || 'N/A';
        html += `
            <div class="wishlist-item-row d-flex align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="wishlist-img-box">
                        <img src="${item.img}" alt="${item.title}">
                    </div>
                    <div>
                        <a href="product-detail.php" class="fw-bold text-dark text-decoration-none fs-7 d-block mb-1">${item.title}</a>
                        <span class="text-secondary x-small d-block mb-1">Code: ${itemCode}</span>
                        <span class="fw-bold" style="color: #b03030; font-size: 0.9rem;">${item.price || 'Rs 5,000'}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="product-detail.php" class="btn btn-sm btn-outline-danger fs-7 fw-medium d-none d-sm-inline-block">View</a>
                    <button type="button" class="btn-remove-item" onclick="removeItem(${index})" title="Remove item">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;

        textForWhatsApp += (index + 1) + ". " + item.title + " (" + itemCode + ")\n";
    });

    itemsBox.innerHTML = html;
    if (summaryCount) summaryCount.innerText = items.length + ' Items';

    var encodedText = encodeURIComponent(textForWhatsApp + "\nPlease send availability & proforma invoice.");
    if (whatsappBtn) {
        whatsappBtn.href = "https://wa.me/94114216784?text=" + encodedText;
    }
}

function removeItem(index) {
    var items = getWishlist();
    items.splice(index, 1);
    localStorage.setItem('isaro_wishlist', JSON.stringify(items));
    renderWishlist();
}

function clearWishlist() {
    if (confirm('Are you sure you want to clear your inquiry list?')) {
        localStorage.setItem('isaro_wishlist', JSON.stringify([]));
        renderWishlist();
    }
}

function handleBulkQuoteSubmit(e) {
    e.preventDefault();
    alert('Thank you! Your bulk quote request for saved items has been sent successfully. Isaro engineering team will contact you shortly.');
    var modalEl = document.getElementById('bulkQuoteModal');
    if (modalEl && typeof bootstrap !== 'undefined') {
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }
}

function generateBulkQuotePDF(btnElement) {
    var items = getWishlist();

    if (items.length === 0) {
        alert('Your wishlist is empty! Please add products before downloading a quotation.');
        return;
    }

    var originalHTML = btnElement.innerHTML;
    btnElement.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Generating Quote PDF...';
    btnElement.style.pointerEvents = 'none';

    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ orientation: 'p', unit: 'mm', format: 'a4' });
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
        doc.text("Doc: Official Proforma Quotation", 196, 15, { align: "right" });
        doc.text("Ref: ISA-RFQ-" + Math.floor(100000 + Math.random() * 900000), 196, 19, { align: "right" });
        doc.text("Date: " + currentDate, 196, 23, { align: "right" });

        doc.setDrawColor(176, 48, 48);
        doc.setLineWidth(0.8);
        doc.line(14, 26, 196, 26);

        doc.setFillColor(248, 249, 250);
        doc.roundedRect(14, 30, 182, 22, 2, 2, "F");
        doc.setDrawColor(226, 226, 226);
        doc.setLineWidth(0.3);
        doc.roundedRect(14, 30, 182, 22, 2, 2, "D");

        doc.setFont("helvetica", "bold");
        doc.setFontSize(11);
        doc.setTextColor(30, 33, 37);
        doc.text("COMMERCIAL BULK PRODUCT QUOTATION", 18, 38);

        doc.setFont("helvetica", "normal");
        doc.setFontSize(8);
        doc.setTextColor(100, 100, 100);
        doc.text("Requested Items Total: " + items.length + " Industrial Products", 18, 45);
        doc.text("Status: Price Inquiry & Availability Check", 192, 45, { align: "right" });

        var tableBody = [];
        items.forEach(function(item, idx) {
            tableBody.push([
                (idx + 1).toString(),
                item.title,
                item.sku || item.code || 'N/A',
                item.price || 'Rs 5,000'
            ]);
        });

        doc.autoTable({
            startY: 56,
            head: [['#', 'Product Description', 'Model Code', 'Unit Est. Price']],
            body: tableBody,
            theme: 'striped',
            styles: { fontSize: 8.5, font: 'helvetica', cellPadding: 3 },
            headStyles: { fillColor: [176, 48, 48], textColor: [255, 255, 255], fontStyle: 'bold' },
            columnStyles: {
                0: { cellWidth: 12, halign: 'center' },
                1: { cellWidth: 105 },
                2: { cellWidth: 35, halign: 'center' },
                3: { cellWidth: 30, halign: 'right' }
            },
            alternateRowStyles: { fillColor: [248, 249, 250] },
            margin: { left: 14, right: 14 }
        });

        let finalY = doc.lastAutoTable.finalY + 10;

        doc.setFillColor(252, 252, 252);
        doc.roundedRect(14, finalY, 182, 28, 1.5, 1.5, "F");
        doc.setDrawColor(220, 220, 220);
        doc.roundedRect(14, finalY, 182, 28, 1.5, 1.5, "D");

        doc.setFont("helvetica", "bold");
        doc.setFontSize(8.5);
        doc.setTextColor(176, 48, 48);
        doc.text("Important B2B Quotation Terms:", 18, finalY + 6);

        doc.setFont("helvetica", "normal");
        doc.setFontSize(7.5);
        doc.setTextColor(66, 66, 66);
        doc.text("1. Prices listed above are subject to final stock confirmation & bulk quantity discounts.", 18, finalY + 12);
        doc.text("2. Official Proforma Invoice with VAT details will be issued upon purchase order submission.", 18, finalY + 17);
        doc.text("3. Islandwide delivery & technical installation guidance available across Sri Lanka.", 18, finalY + 22);

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
        doc.text("Sales Helpline: +94 11 4216784", 196, 280, { align: "right" });
        doc.setFont("helvetica", "normal");
        doc.text("Official Web: www.isaroautomation.com", 196, 284, { align: "right" });

        doc.save('Isaro_Automation_Official_Quote.pdf');

        btnElement.innerHTML = originalHTML;
        btnElement.style.pointerEvents = 'auto';

    } catch (err) {
        console.error('Wishlist PDF Error:', err);
        alert('Wishlist PDF Generation failed: ' + err.message);
        btnElement.innerHTML = originalHTML;
        btnElement.style.pointerEvents = 'auto';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    renderWishlist();

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

    const wishlistElements = document.querySelectorAll(
        "#wishlistItemsBox, .inquiry-summary-box"
    );

    wishlistElements.forEach(function(el) {
        el.classList.add("apple-reveal");
        revealObserver.observe(el);
    });
});
</script>

<?php include 'includes/footer.php'; ?>