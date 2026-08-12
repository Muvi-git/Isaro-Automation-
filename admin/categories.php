<?php
include 'includes/header.php';

// Handle Delete Category
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$del_id]);
    echo "<script>alert('Category deleted successfully!'); window.location.href='categories.php';</script>";
    exit();
}

// Handle Status Toggle (Active / Inactive)
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $cat_id = intval($_GET['id']);
    $new_status = ($_GET['toggle_status'] === 'active') ? 'active' : 'inactive';
    $stmt = $pdo->prepare("UPDATE categories SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $cat_id]);
    echo "<script>window.location.href='categories.php';</script>";
    exit();
}

// Handle Add / Edit Category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_category'])) {
    $name = trim($_POST['name']);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $status = $_POST['status'] ?? 'active';
    $cat_id = !empty($_POST['cat_id']) ? intval($_POST['cat_id']) : null;

    $image = $_POST['existing_image'] ?? 'assets/images/32aa4dfd4e0fe44f84107df06e8e281fd9c2f2e6.png';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $file_name)) {
            $image = "assets/images/uploads/" . $file_name;
        }
    }

    if ($cat_id) {
        $stmt = $pdo->prepare("UPDATE categories SET name=?, slug=?, image=?, status=? WHERE id=?");
        $stmt->execute([$name, $slug, $image, $status, $cat_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO categories (name, slug, image, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $slug, $image, $status]);
    }
    echo "<script>alert('Category saved successfully!'); window.location.href='categories.php';</script>";
    exit();
}

// --- PAGINATION LOGIC (10 Categories Per Page) ---
$items_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

$total_categories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$total_pages = ceil($total_categories / $items_per_page);

$stmt = $pdo->prepare("
    SELECT c.*, COUNT(p.id) as total_products 
    FROM categories c 
    LEFT JOIN products p ON c.id = p.category_id 
    GROUP BY c.id 
    ORDER BY c.id DESC 
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$categories = $stmt->fetchAll();
?>

<!-- Custom Premium Styles -->
<style>
.preview-img-box {
    width: 90px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    background-color: #f8f9fa;
}
.table-banner-thumb {
    width: 60px;
    height: 40px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e9ecef;
    background-color: #ffffff;
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

/* =========================================================
   APPLE-GRADE MOBILE & TABLET ADMIN RESPONSIVENESS
   ========================================================= */
@media (max-width: 991.98px) {
    .admin-card-container {
        padding: 1.25rem !important;
    }
}

@media (max-width: 575.98px) {
    .admin-card-container {
        padding: 1rem !important;
        border-radius: 12px !important;
    }
    .admin-top-banner {
        padding: 1rem !important;
        border-radius: 12px !important;
    }
    .admin-top-banner h4 {
        font-size: 1.2rem !important;
    }
    .admin-top-banner .btn {
        width: 100% !important;
        justify-content: center !important;
    }
    .table-responsive {
        -webkit-overflow-scrolling: touch !important;
        border-radius: 8px !important;
    }
    .table th, .table td {
        padding: 10px 8px !important;
        white-space: nowrap !important;
    }
    .table-banner-thumb {
        width: 48px !important;
        height: 32px !important;
    }
    .admin-pagination-box {
        padding: 0.75rem !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
    }
    .admin-pagination-box .pagination {
        flex-wrap: wrap !important;
        justify-content: center !important;
    }
    .custom-page-btn {
        padding: 4px 10px !important;
        font-size: 0.78rem !important;
    }
    .modal-dialog {
        margin: 0.5rem !important;
    }
    .modal-body {
        padding: 1rem !important;
    }
}
</style>

<!-- Top Title Banner -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 admin-top-banner">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-tags text-danger me-2"></i>Categories Management</h4>
        <p class="text-muted x-small mb-0" style="font-size: 0.83rem;">Manage product categories and category highlight banner images shown across the site.</p>
    </div>
    <div>
        <button class="btn btn-danger fw-semibold px-3 py-2 rounded-2 d-inline-flex align-items-center gap-2" style="background-color: #b03030; border: none;" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="resetCatForm()">
            <i class="fas fa-plus-circle"></i> Add Category
        </button>
    </div>
</div>

<!-- Categories Table -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4 admin-card-container">
    <div class="table-responsive">
        <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold" style="width: 80px;">Banner Image</th>
                    <th class="fw-bold">Category Name</th>
                    <th class="fw-bold">Slug URL</th>
                    <th class="fw-bold">Linked Products</th>
                    <th class="fw-bold">Status</th>
                    <th class="fw-bold text-end" style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($categories)): ?>
                    <?php foreach($categories as $cat): ?>
                    <tr>
                        <td>
                            <img src="../<?php echo htmlspecialchars($cat['image']); ?>" class="table-banner-thumb" onerror="this.src='https://via.placeholder.com/60x40?text=NO+IMG';">
                        </td>
                        <td class="fw-bold text-dark"><?php echo htmlspecialchars($cat['name']); ?></td>
                        <td><code class="text-secondary" style="font-size: 0.78rem;"><?php echo htmlspecialchars($cat['slug']); ?></code></td>
                        <td>
                            <span class="badge bg-light text-danger border px-2 py-1 fw-bold"><?php echo $cat['total_products']; ?> Products</span>
                        </td>
                        <td>
                            <?php if($cat['status'] == 'active'): ?>
                                <a href="categories.php?id=<?php echo $cat['id']; ?>&toggle_status=inactive" class="badge bg-success-subtle text-success border border-success-subtle text-decoration-none px-2 py-1" title="Click to Deactivate">
                                    <i class="fas fa-check-circle me-1"></i> Active
                                </a>
                            <?php else: ?>
                                <a href="categories.php?id=<?php echo $cat['id']; ?>&toggle_status=active" class="badge bg-danger-subtle text-danger border border-danger-subtle text-decoration-none px-2 py-1" title="Click to Activate">
                                    <i class="fas fa-times-circle me-1"></i> Inactive
                                </a>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary me-1" onclick='editCategory(<?php echo json_encode($cat); ?>)' title="Edit Category">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="categories.php?delete=<?php echo $cat['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Deleting this category will affect linked products. Are you sure?')" title="Delete Category">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No categories found in database.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- PROMINENT HIGH-VISIBILITY PAGINATION BAR -->
    <?php if ($total_pages > 1): ?>
    <div class="p-3 bg-light rounded-3 border mt-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 admin-pagination-box">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-white text-dark border px-3 py-2 shadow-sm fs-7 fw-medium" style="font-size: 0.82rem;">
                <i class="fas fa-list me-1 text-danger"></i> Showing <strong class="text-danger"><?php echo $offset + 1; ?> - <?php echo min($offset + $items_per_page, $total_categories); ?></strong> of <strong><?php echo $total_categories; ?></strong> Categories
            </span>
        </div>
        <nav aria-label="Category Pagination">
            <ul class="pagination pagination-sm mb-0 gap-1">
                <!-- Previous Button -->
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="categories.php?page=<?php echo $page - 1; ?>">
                        <i class="fas fa-chevron-left me-1"></i> Prev
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link custom-page-btn rounded-2 shadow-sm fw-bold border" href="categories.php?page=<?php echo $i; ?>" style="<?php echo ($page == $i) ? 'background-color: #b03030 !important; border-color: #b03030 !important; color: #fff !important;' : 'background-color: #ffffff; color: #333;'; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="categories.php?page=<?php echo $page + 1; ?>">
                        Next <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<!-- Category Add/Edit Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <form action="categories.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-dark text-white py-3">
                    <h5 class="modal-title fw-bold fs-6" id="catModalTitle"><i class="fas fa-tags text-danger me-2"></i>Add New Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="cat_id" id="cat_id">
                    <input type="hidden" name="existing_image" id="existing_image">

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Category Name *</label>
                        <input type="text" name="name" id="cat_name" class="form-control form-control-sm" placeholder="e.g. Electrical & Electronics" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Category Banner Image</label>
                        <input type="file" name="image" id="cat_image_input" class="form-control form-control-sm" accept="image/*" onchange="previewCatImage(this)">
                        <small class="text-muted d-block mt-1" style="font-size:0.72rem;">Recommended resolution: 600x400px</small>
                        
                        <!-- Instant Image Live Preview -->
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <span class="small text-muted" style="font-size:0.75rem;">Preview:</span>
                            <img id="catImagePreview" src="https://via.placeholder.com/90x60?text=PREVIEW" class="preview-img-box">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Status</label>
                        <select name="status" id="cat_status" class="form-select form-select-sm">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="save_category" class="btn btn-danger fw-semibold btn-sm px-4" style="background-color: #b03030; border: none;">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Interactive Image Preview & Form JavaScript -->
<script>
function previewCatImage(input) {
    const previewImg = document.getElementById('catImagePreview');
    if (input.files && input.files[0]) {
        previewImg.src = URL.createObjectURL(input.files[0]);
    }
}

function resetCatForm() {
    document.getElementById('catModalTitle').innerHTML = '<i class="fas fa-plus-circle text-danger me-2"></i>Add New Category';
    document.getElementById('cat_id').value = '';
    document.getElementById('existing_image').value = '';
    document.getElementById('cat_name').value = '';
    document.getElementById('cat_status').value = 'active';
    document.getElementById('cat_image_input').value = '';
    document.getElementById('catImagePreview').src = 'https://via.placeholder.com/90x60?text=PREVIEW';
}

function editCategory(cat) {
    document.getElementById('catModalTitle').innerHTML = '<i class="fas fa-edit text-danger me-2"></i>Edit Category: ' + cat.name;
    document.getElementById('cat_id').value = cat.id;
    document.getElementById('existing_image').value = cat.image;
    document.getElementById('cat_name').value = cat.name;
    document.getElementById('cat_status').value = cat.status;
    document.getElementById('cat_image_input').value = '';
    
    var previewImg = document.getElementById('catImagePreview');
    if (cat.image) {
        previewImg.src = '../' + cat.image;
    } else {
        previewImg.src = 'https://via.placeholder.com/90x60?text=NO+IMAGE';
    }
    
    var modal = new bootstrap.Modal(document.getElementById('categoryModal'));
    modal.show();
}
</script>

<?php include 'includes/footer.php'; ?>