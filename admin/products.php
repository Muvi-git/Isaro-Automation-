<?php
include 'includes/header.php';

// Handle Delete Product
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$del_id]);
    echo "<script>alert('Product deleted successfully!'); window.location.href='products.php';</script>";
    exit();
}

// Handle Add / Edit Product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_product'])) {
    $title = $_POST['title'];
    $sku = $_POST['sku'];
    $category_id = intval($_POST['category_id']);
    $price = $_POST['price'];
    $old_price = !empty($_POST['old_price']) ? $_POST['old_price'] : NULL;
    $stock_status = $_POST['stock_status'];
    $short_desc = $_POST['short_desc'];
    $full_desc = $_POST['full_desc'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_new_arrival = isset($_POST['is_new_arrival']) ? 1 : 0;

    $target_dir = "../assets/images/uploads/";
    if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

    // 1. Single Main Image Handler
    $main_img = $_POST['existing_img'] ?? 'assets/images/default.png';
    if (isset($_FILES['main_img']) && $_FILES['main_img']['error'] == 0) {
        $file_name = time() . '_main_' . basename($_FILES["main_img"]["name"]);
        if (move_uploaded_file($_FILES["main_img"]["tmp_name"], $target_dir . $file_name)) {
            $main_img = "assets/images/uploads/" . $file_name;
        }
    }

    // 2. Gallery Images Handler
    $gallery_paths = [];
    if (isset($_POST['keep_existing_gallery']) && is_array($_POST['keep_existing_gallery'])) {
        $gallery_paths = array_values($_POST['keep_existing_gallery']);
    }

    if (isset($_FILES['gallery_imgs']) && !empty($_FILES['gallery_imgs']['name'][0])) {
        foreach ($_FILES['gallery_imgs']['name'] as $key => $val) {
            if ($_FILES['gallery_imgs']['error'][$key] == 0) {
                $gal_file_name = time() . '_thumb_' . rand(100, 999) . '_' . basename($val);
                if (move_uploaded_file($_FILES['gallery_imgs']['tmp_name'][$key], $target_dir . $gal_file_name)) {
                    $gallery_paths[] = "assets/images/uploads/" . $gal_file_name;
                }
            }
        }
    }
    $thumbnails_json = !empty($gallery_paths) ? json_encode(array_values($gallery_paths)) : NULL;

    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        // Update Product
        $stmt = $pdo->prepare("UPDATE products SET category_id=?, sku=?, title=?, price=?, old_price=?, stock_status=?, short_desc=?, full_desc=?, main_img=?, thumbnails_json=?, is_featured=?, is_new_arrival=? WHERE id=?");
        $stmt->execute([$category_id, $sku, $title, $price, $old_price, $stock_status, $short_desc, $full_desc, $main_img, $thumbnails_json, $is_featured, $is_new_arrival, $_POST['product_id']]);
    } else {
        // Insert Product
        $stmt = $pdo->prepare("INSERT INTO products (category_id, sku, title, price, old_price, stock_status, short_desc, full_desc, main_img, thumbnails_json, is_featured, is_new_arrival) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$category_id, $sku, $title, $price, $old_price, $stock_status, $short_desc, $full_desc, $main_img, $thumbnails_json, $is_featured, $is_new_arrival]);
    }
    echo "<script>alert('Product Saved Successfully!'); window.location.href='products.php';</script>";
    exit();
}

$categories = $pdo->query("SELECT * FROM categories WHERE status='active'")->fetchAll();

// --- 12 PRODUCTS PER PAGE PAGINATION LOGIC ---
$items_per_page = 12;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

$total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_pages = ceil($total_products / $items_per_page);

$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!-- Custom Premium Page Styles -->
<style>
.preview-img-box {
    width: 75px;
    height: 75px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    background-color: #f8f9fa;
}
.gallery-preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
    min-height: 40px;
}
.table-img-thumb {
    width: 48px;
    height: 48px;
    object-fit: contain;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    background-color: #ffffff;
    padding: 2px;
}
.remove-thumb-btn {
    width: 20px;
    height: 20px;
    font-size: 10px;
    line-height: 1;
    box-shadow: 0 2px 4px rgba(0,0,0,0.25);
    z-index: 10;
}
.custom-page-btn {
    padding: 6px 14px;
    font-size: 0.85rem;
    transition: all 0.2s ease;
}
.custom-page-btn:hover {
    background-color: #b03030 !important;
    color: #ffffff !important;
    border-color: #b03030 !important;
}
</style>

<!-- Top Title Banner -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-box text-danger me-2"></i>Products Inventory</h4>
        <p class="text-muted x-small mb-0" style="font-size: 0.83rem;">Manage industrial automation catalog, pricing, stock availability and uploaded images.</p>
    </div>
    <div>
        <button class="btn btn-danger fw-semibold px-3 py-2 rounded-2 d-inline-flex align-items-center gap-2" style="background-color: #b03030; border: none;" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="fas fa-plus-circle"></i> Add New Product
        </button>
    </div>
</div>

<!-- Products Inventory Table Container -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold" style="width: 70px;">Image</th>
                    <th class="fw-bold">Title & SKU</th>
                    <th class="fw-bold">Category</th>
                    <th class="fw-bold">Price</th>
                    <th class="fw-bold">Stock</th>
                    <th class="fw-bold">Status Badges</th>
                    <th class="fw-bold text-end" style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($products)): ?>
                    <?php foreach($products as $prod): 
                        $gallery_imgs = !empty($prod['thumbnails_json']) ? json_decode($prod['thumbnails_json'], true) : [];
                    ?>
                    <tr>
                        <td>
                            <div class="position-relative d-inline-block">
                                <img src="../<?php echo htmlspecialchars($prod['main_img']); ?>" class="table-img-thumb" onerror="this.src='https://via.placeholder.com/48?text=NO+IMG';">
                                <?php if(!empty($gallery_imgs)): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;" title="Multiple Images Uploaded">
                                        +<?php echo count($gallery_imgs); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <strong class="text-dark d-block"><?php echo htmlspecialchars($prod['title']); ?></strong>
                            <small class="text-muted"><i class="fas fa-barcode me-1"></i><?php echo htmlspecialchars($prod['sku']); ?></small>
                        </td>
                        <td><span class="badge bg-light text-dark border px-2 py-1"><?php echo htmlspecialchars($prod['category_name']); ?></span></td>
                        <td class="fw-bold text-danger">Rs <?php echo number_format($prod['price'], 2); ?></td>
                        <td>
                            <?php if($prod['stock_status'] == 'in_stock'): ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="fas fa-check-circle me-1"></i>In Stock</span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="fas fa-times-circle me-1"></i>Out of Stock</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($prod['is_featured']): ?><span class="badge bg-warning text-dark me-1">Featured</span><?php endif; ?>
                            <?php if($prod['is_new_arrival']): ?><span class="badge bg-info text-white">New</span><?php endif; ?>
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $prod['id']; ?>" title="Edit Product">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="products.php?delete=<?php echo $prod['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this product?')" title="Delete Product">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- EDIT PRODUCT MODAL -->
                    <div class="modal fade" id="editModal<?php echo $prod['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content text-start border-0 shadow-lg" style="border-radius: 14px;">
                                <form action="products.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                                    <input type="hidden" name="existing_img" value="<?php echo htmlspecialchars($prod['main_img']); ?>">

                                    <div class="modal-header bg-dark text-white py-3">
                                        <h5 class="modal-title fw-bold fs-6"><i class="fas fa-edit text-danger me-2"></i>Edit Product: <?php echo htmlspecialchars($prod['title']); ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <label class="form-label fw-semibold small">Product Title *</label>
                                                <input type="text" name="title" class="form-control form-control-sm" value="<?php echo htmlspecialchars($prod['title']); ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold small">SKU Code *</label>
                                                <input type="text" name="sku" class="form-control form-control-sm" value="<?php echo htmlspecialchars($prod['sku']); ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold small">Category *</label>
                                                <select name="category_id" class="form-select form-select-sm" required>
                                                    <?php foreach($categories as $cat): ?>
                                                        <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $prod['category_id']) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($cat['name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold small">Regular Price (Rs) *</label>
                                                <input type="number" step="0.01" name="price" class="form-control form-control-sm" value="<?php echo $prod['price']; ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold small">Old Price (Rs)</label>
                                                <input type="number" step="0.01" name="old_price" class="form-control form-control-sm" value="<?php echo $prod['old_price']; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small">Stock Status</label>
                                                <select name="stock_status" class="form-select form-select-sm">
                                                    <option value="in_stock" <?php echo ($prod['stock_status'] == 'in_stock') ? 'selected' : ''; ?>>In Stock & Ready to Ship</option>
                                                    <option value="out_of_stock" <?php echo ($prod['stock_status'] == 'out_of_stock') ? 'selected' : ''; ?>>Out of Stock</option>
                                                </select>
                                            </div>

                                            <!-- Main Image Upload -->
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small">Main Product Image</label>
                                                <input type="file" name="main_img" class="form-control form-control-sm" onchange="previewSingleImg(this, 'editMainPreview<?php echo $prod['id']; ?>')">
                                                <div class="mt-2 d-flex align-items-center gap-2">
                                                    <span class="small text-muted" style="font-size:0.75rem;">Preview:</span>
                                                    <img id="editMainPreview<?php echo $prod['id']; ?>" src="../<?php echo htmlspecialchars($prod['main_img']); ?>" class="preview-img-box" onerror="this.src='https://via.placeholder.com/75?text=NO+IMAGE';">
                                                </div>
                                            </div>

                                            <!-- Multiple Gallery Images Upload with Delete Option -->
                                            <div class="col-12">
                                                <label class="form-label fw-semibold small">Gallery Thumbnails (Multiple Images)</label>
                                                <input type="file" id="editGalleryInput<?php echo $prod['id']; ?>" name="gallery_imgs[]" class="form-control form-control-sm" multiple onchange="handleGallerySelect(this, 'editGalleryPreview<?php echo $prod['id']; ?>')">
                                                <small class="text-muted d-block" style="font-size:0.72rem;">Select multiple photos. Click <i class="fas fa-times text-danger"></i> on any preview to remove it.</small>
                                                
                                                <div id="editGalleryPreview<?php echo $prod['id']; ?>" class="gallery-preview-container">
                                                    <?php if(!empty($gallery_imgs)): ?>
                                                        <?php foreach($gallery_imgs as $gImg): ?>
                                                            <div class="position-relative d-inline-block existing-gallery-item me-1 mb-1">
                                                                <input type="hidden" name="keep_existing_gallery[]" value="<?php echo htmlspecialchars($gImg); ?>">
                                                                <img src="../<?php echo htmlspecialchars($gImg); ?>" class="preview-img-box" onerror="this.src='https://via.placeholder.com/75?text=NO+IMAGE';">
                                                                <button type="button" class="btn btn-danger rounded-circle position-absolute top-0 end-0 translate-middle p-0 d-flex align-items-center justify-content-center remove-thumb-btn" onclick="removeExistingGalleryItem(this)" title="Remove image">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-semibold small">Short Description</label>
                                                <textarea name="short_desc" class="form-control form-control-sm" rows="2"><?php echo htmlspecialchars($prod['short_desc']); ?></textarea>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold small">Full Description & Specifications</label>
                                                <textarea name="full_desc" class="form-control form-control-sm" rows="3"><?php echo htmlspecialchars($prod['full_desc']); ?></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="is_featured" id="featEdit<?php echo $prod['id']; ?>" <?php echo $prod['is_featured'] ? 'checked' : ''; ?>>
                                                    <label class="form-check-label fw-semibold small" for="featEdit<?php echo $prod['id']; ?>">Show on Homepage Featured List</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="is_new_arrival" id="newEdit<?php echo $prod['id']; ?>" <?php echo $prod['is_new_arrival'] ? 'checked' : ''; ?>>
                                                    <label class="form-check-label fw-semibold small" for="newEdit<?php echo $prod['id']; ?>">Show in New Arrivals Carousel</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light py-2">
                                        <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="save_product" class="btn btn-danger fw-semibold btn-sm px-4" style="background-color: #b03030; border: none;">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No products found in catalog.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- PROMINENT HIGH-VISIBILITY PAGINATION BAR -->
    <?php if ($total_pages > 1): ?>
    <div class="p-3 bg-light rounded-3 border mt-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-white text-dark border px-3 py-2 shadow-sm fs-7 fw-medium" style="font-size: 0.82rem;">
                <i class="fas fa-list me-1 text-danger"></i> Showing <strong class="text-danger"><?php echo $offset + 1; ?> - <?php echo min($offset + $items_per_page, $total_products); ?></strong> of <strong><?php echo $total_products; ?></strong> Products
            </span>
        </div>
        <nav aria-label="Product Pagination">
            <ul class="pagination pagination-sm mb-0 gap-1">
                <!-- Previous Button -->
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="products.php?page=<?php echo $page - 1; ?>">
                        <i class="fas fa-chevron-left me-1"></i> Prev
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link custom-page-btn rounded-2 shadow-sm fw-bold border" href="products.php?page=<?php echo $i; ?>" style="<?php echo ($page == $i) ? 'background-color: #b03030 !important; border-color: #b03030 !important; color: #fff !important;' : 'background-color: #ffffff; color: #333;'; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="products.php?page=<?php echo $page + 1; ?>">
                        Next <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>

</div>

<!-- ADD NEW PRODUCT MODAL -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <form action="products.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-dark text-white py-3">
                    <h5 class="modal-title fw-bold fs-6"><i class="fas fa-plus-circle text-danger me-2"></i>Add New Industrial Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Product Title *</label>
                            <input type="text" name="title" class="form-control form-control-sm" placeholder="e.g. Industrial Digital Panel Meter" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">SKU Code *</label>
                            <input type="text" name="sku" class="form-control form-control-sm" placeholder="ISA-XXX-000" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Category *</label>
                            <select name="category_id" class="form-select form-select-sm" required>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Regular Price (Rs) *</label>
                            <input type="number" step="0.01" name="price" class="form-control form-control-sm" value="5000.00" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Old Price (Rs)</label>
                            <input type="number" step="0.01" name="old_price" class="form-control form-control-sm" placeholder="6600.00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Stock Status</label>
                            <select name="stock_status" class="form-select form-select-sm">
                                <option value="in_stock" selected>In Stock & Ready to Ship</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>

                        <!-- Main Image Upload -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Main Product Image *</label>
                            <input type="file" name="main_img" class="form-control form-control-sm" onchange="previewSingleImg(this, 'addMainPreview')">
                            <div class="mt-2 d-flex align-items-center gap-2">
                                <span class="small text-muted" style="font-size:0.75rem;">Preview:</span>
                                <img id="addMainPreview" src="https://via.placeholder.com/75?text=PREVIEW" class="preview-img-box">
                            </div>
                        </div>

                        <!-- Multiple Gallery Images Upload with Delete Option -->
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Gallery Thumbnails (Upload Multiple Images)</label>
                            <input type="file" id="addGalleryInput" name="gallery_imgs[]" class="form-control form-control-sm" multiple onchange="handleGallerySelect(this, 'addGalleryPreview')">
                            <small class="text-muted d-block" style="font-size:0.72rem;">Hold Ctrl / Shift to select multiple images. Click <i class="fas fa-times text-danger"></i> on any preview to remove it.</small>
                            <div id="addGalleryPreview" class="gallery-preview-container"></div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small">Short Description</label>
                            <textarea name="short_desc" class="form-control form-control-sm" rows="2" placeholder="Brief product summary..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Full Description & Technical Specifications</label>
                            <textarea name="full_desc" class="form-control form-control-sm" rows="3" placeholder="Detailed product specifications..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="featAdd">
                                <label class="form-check-label fw-semibold small" for="featAdd">Show on Homepage Featured List</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_new_arrival" id="newAdd" checked>
                                <label class="form-check-label fw-semibold small" for="newAdd">Show in New Arrivals Carousel</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="save_product" class="btn btn-danger fw-semibold btn-sm px-4" style="background-color: #b03030; border: none;">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Interactive DataTransfer & Multi-Image Manager JavaScript -->
<script>
const galleryFilesStores = {};

function previewSingleImg(input, targetImgId) {
    const previewImg = document.getElementById(targetImgId);
    if (input.files && input.files[0]) {
        previewImg.src = URL.createObjectURL(input.files[0]);
    }
}

function handleGallerySelect(input, containerId) {
    if (!galleryFilesStores[input.id]) {
        galleryFilesStores[input.id] = new DataTransfer();
    }
    const dt = galleryFilesStores[input.id];

    if (input.files && input.files.length > 0) {
        Array.from(input.files).forEach(file => {
            dt.items.add(file);
        });
        input.files = dt.files;
        renderGalleryPreviews(input, containerId);
    }
}

function removeNewGalleryFile(inputId, containerId, fileIndex) {
    const input = document.getElementById(inputId);
    const dt = galleryFilesStores[inputId];
    if (dt) {
        dt.items.remove(fileIndex);
        input.files = dt.files;
        renderGalleryPreviews(input, containerId);
    }
}

function renderGalleryPreviews(input, containerId) {
    const container = document.getElementById(containerId);
    
    const existingItems = Array.from(container.querySelectorAll('.existing-gallery-item'));
    container.innerHTML = '';
    existingItems.forEach(item => container.appendChild(item));

    const dt = galleryFilesStores[input.id];
    if (dt && dt.files && dt.files.length > 0) {
        Array.from(dt.files).forEach((file, index) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'position-relative d-inline-block new-gallery-item me-1 mb-1';
            
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'preview-img-box';
            
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-danger rounded-circle position-absolute top-0 end-0 translate-middle p-0 d-flex align-items-center justify-content-center remove-thumb-btn';
            removeBtn.title = 'Remove image';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.onclick = function() {
                removeNewGalleryFile(input.id, containerId, index);
            };

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            container.appendChild(wrapper);
        });
    }
}

function removeExistingGalleryItem(btn) {
    const wrapper = btn.closest('.existing-gallery-item');
    if (wrapper) {
        wrapper.remove();
    }
}
</script>

<?php include 'includes/footer.php'; ?>