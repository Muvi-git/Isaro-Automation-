<?php include 'includes/header.php'; ?>

<!-- Compare Page Custom Styles -->
<style>
.isaro-compare-wrapper {
    font-family: 'Poppins', sans-serif;
    color: #333333;
    background-color: #f8f9fa;
    min-height: 70vh;
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

/* Compare Table Styling - Uniform Column Alignment & Heights */
.compare-table-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e8e8e8;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    overflow-x: auto;
}

.compare-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
    table-layout: fixed;
}

.compare-table th {
    background-color: #f8f9fa;
    color: #b03030;
    font-weight: 700;
    font-size: 0.88rem;
    padding: 16px;
    width: 200px;
    border-bottom: 1px solid #e5e5e5;
    border-right: 1px solid #e5e5e5;
    vertical-align: middle;
}

.compare-table td {
    padding: 16px;
    text-align: center;
    border-bottom: 1px solid #eee;
    border-right: 1px solid #eee;
    vertical-align: middle;
    font-size: 0.82rem;
    color: #444;
}

/* Product Header Info Box - Fixed Layout & Equal Heights */
.compare-product-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    height: 100%;
}

.compare-img-box {
    width: 110px;
    height: 110px;
    margin: 0 auto 12px auto;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #ffffff;
    border-radius: 8px;
    padding: 6px;
    cursor: pointer;
}

.compare-img-box img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    display: block;
}

.compare-product-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #1e2125;
    min-height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    line-height: 1.3;
    margin-bottom: 4px;
}

.compare-product-title a {
    color: #1e2125;
    text-decoration: none;
    transition: color 0.2s ease;
}

.compare-product-title a:hover {
    color: #b03030;
}

.compare-sku {
    font-size: 0.72rem;
    color: #888888;
    display: block;
    min-height: 18px;
    margin-bottom: 10px;
}

.btn-remove-compare {
    color: #dc3545;
    background: #fff0f1;
    border: none;
    padding: 5px 12px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-remove-compare:hover {
    background: #dc3545;
    color: #ffffff;
}

/* Empty State */
.empty-compare-box {
    text-align: center;
    padding: 60px 20px;
}

.empty-compare-icon {
    font-size: 3.5rem;
    color: #cccccc;
    margin-bottom: 15px;
}
</style>

<div class="isaro-compare-wrapper">

<!-- BREADCRUMB -->
<div class="custom-breadcrumb mb-4">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            <a href="index.php"><i class="fas fa-home me-1"></i> Home</a>
            <span class="text-muted fs-7">/</span>
            <a href="products.php">Our Products</a>
            <span class="text-muted fs-7">/</span>
            <span class="active">Product Comparison</span>
        </div>
    </div>
</div>

<div class="container pb-5">
    
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #b03030;">Compare Technical Specifications</h2>
            <p class="text-secondary x-small mb-0">Compare side-by-side specifications of selected automation products.</p>
        </div>
        <button type="button" class="btn btn-outline-danger btn-sm fs-7 fw-medium" onclick="clearCompareList()">
            <i class="far fa-trash-alt me-1"></i> Clear Comparison
        </button>
    </div>

    <!-- Table Container -->
    <div class="compare-table-card" id="compareContainer">
        <!-- Rendered via JS -->
    </div>

</div>

</div>

<script>
// Strictly read from LocalStorage without dummy default arrays
function getCompareList() {
    var stored = localStorage.getItem('isaro_compare');
    if (!stored) {
        return [];
    }
    return JSON.parse(stored);
}

function renderCompareTable() {
    var items = getCompareList();
    var container = document.getElementById('compareContainer');

    if (items.length === 0) {
        container.innerHTML = `
            <div class="empty-compare-box">
                <i class="fas fa-balance-scale empty-compare-icon"></i>
                <h5 class="fw-bold text-dark mb-2">No Products Added to Comparison</h5>
                <p class="text-muted fs-7 mb-4">Select products from our catalog to compare specifications side-by-side.</p>
                <a href="products.php" class="btn text-white px-4 py-2 fw-semibold rounded-2 fs-7" style="background-color: #b03030;">Browse Products</a>
            </div>
        `;
        return;
    }

    var html = '<table class="compare-table"><tbody>';
    
    // Row 1: Image & Title & Remove Action
    html += '<tr><th>Product Image & Info</th>';
    items.forEach(function(item, idx) {
        html += `
            <td>
                <div class="compare-product-box">
                    <div class="compare-img-box" onclick="window.location.href='product-detail.php'">
                        <img src="${item.img}" alt="${item.title}">
                    </div>
                    <h6 class="compare-product-title">
                        <a href="product-detail.php">${item.title}</a>
                    </h6>
                    <span class="compare-sku">${item.sku || ''}</span>
                    <button type="button" class="btn-remove-compare" onclick="removeCompareItem(${idx})">
                        <i class="fas fa-times me-1"></i> Remove
                    </button>
                </div>
            </td>
        `;
    });
    html += '</tr>';

    // Row 2: Price
    html += '<tr><th>Price</th>';
    items.forEach(function(item) {
        html += `<td class="fw-bold text-danger fs-6">${item.price || 'N/A'}</td>`;
    });
    html += '</tr>';

    // Row 3: Operating Voltage
    html += '<tr><th>Operating Voltage</th>';
    items.forEach(function(item) {
        html += `<td>${item.voltage || 'N/A'}</td>`;
    });
    html += '</tr>';

    // Row 4: Accuracy Level
    html += '<tr><th>Accuracy Class</th>';
    items.forEach(function(item) {
        html += `<td>${item.accuracy || 'N/A'}</td>`;
    });
    html += '</tr>';

    // Row 5: Operating Range
    html += '<tr><th>Operating Range</th>';
    items.forEach(function(item) {
        html += `<td>${item.range || 'N/A'}</td>`;
    });
    html += '</tr>';

    // Row 6: Warranty
    html += '<tr><th>Official Warranty</th>';
    items.forEach(function(item) {
        html += `<td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">${item.warranty || '1 Year'}</span></td>`;
    });
    html += '</tr>';

    // Row 7: Action Buttons
    html += '<tr><th>Action</th>';
    items.forEach(function(item) {
        html += `
            <td>
                <a href="product-detail.php" class="btn btn-sm text-white fw-semibold px-3 py-1 mb-1 d-block" style="background-color: #b03030;">View Details</a>
                <a href="https://wa.me/94114216784?text=Inquiry%20regarding%20product:%20${encodeURIComponent(item.title)}" target="_blank" class="btn btn-sm btn-outline-success fw-semibold px-3 py-1 d-block"><i class="fab fa-whatsapp me-1"></i> Inquire</a>
            </td>
        `;
    });
    html += '</tr>';

    html += '</tbody></table>';
    container.innerHTML = html;
}

function removeCompareItem(index) {
    var items = getCompareList();
    items.splice(index, 1);
    localStorage.setItem('isaro_compare', JSON.stringify(items));
    renderCompareTable();
}

function clearCompareList() {
    if (confirm('Clear all items from comparison?')) {
        localStorage.setItem('isaro_compare', JSON.stringify([]));
        renderCompareTable();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    renderCompareTable();
});
</script>

<?php include 'includes/footer.php'; ?>