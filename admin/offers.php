<?php
include 'includes/header.php';

// Handle Delete Offer Slide
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM offers WHERE id = ?");
    $stmt->execute([$del_id]);
    echo "<script>alert('Banner slide deleted successfully!'); window.location.href='offers.php';</script>";
    exit();
}

// Handle Status Toggle (Active / Inactive)
if (isset($_GET['toggle_status']) && isset($_GET['id'])) {
    $offer_id = intval($_GET['id']);
    $new_status = ($_GET['toggle_status'] === 'active') ? 'active' : 'inactive';
    $stmt = $pdo->prepare("UPDATE offers SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $offer_id]);
    echo "<script>window.location.href='offers.php';</script>";
    exit();
}

// Handle Add / Edit Offer Slide
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_offer'])) {
    $title = trim($_POST['title']);
    $highlight_price = trim($_POST['highlight_price']);
    $description = trim($_POST['description']);
    $btn_link = trim($_POST['btn_link']) ?: 'products.php';
    $sort_order = intval($_POST['sort_order']);
    $status = $_POST['status'] ?? 'active';
    $offer_id = !empty($_POST['offer_id']) ? intval($_POST['offer_id']) : null;

    $bg_image = $_POST['existing_img'] ?? 'assets/images/71455c53cbed251be21bbb31286a64a1ebe232e4 (2).png';
    if (isset($_FILES['bg_image']) && $_FILES['bg_image']['error'] == 0) {
        $target_dir = "../assets/images/uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $file_name = time() . '_' . basename($_FILES["bg_image"]["name"]);
        if (move_uploaded_file($_FILES["bg_image"]["tmp_name"], $target_dir . $file_name)) {
            $bg_image = "assets/images/uploads/" . $file_name;
        }
    }

    if ($offer_id) {
        $stmt = $pdo->prepare("UPDATE offers SET title=?, highlight_price=?, description=?, bg_image=?, btn_link=?, sort_order=?, status=? WHERE id=?");
        $stmt->execute([$title, $highlight_price, $description, $bg_image, $btn_link, $sort_order, $status, $offer_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO offers (title, highlight_price, description, bg_image, btn_link, sort_order, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $highlight_price, $description, $bg_image, $btn_link, $sort_order, $status]);
    }
    echo "<script>alert('Banner offer slide saved successfully!'); window.location.href='offers.php';</script>";
    exit();
}

// --- PAGINATION LOGIC (10 Offer Slides Per Page) ---
$items_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

$total_offers = $pdo->query("SELECT COUNT(*) FROM offers")->fetchColumn();
$total_pages = ceil($total_offers / $items_per_page);

$stmt = $pdo->prepare("SELECT * FROM offers ORDER BY sort_order ASC, id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$offers = $stmt->fetchAll();
?>

<!-- Custom Premium Styles -->
<style>
.preview-img-box {
    width: 120px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    background-color: #f8f9fa;
}
.table-banner-thumb {
    width: 70px;
    height: 42px;
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
</style>

<!-- Top Title Banner -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-sliders-h text-danger me-2"></i>Banner Carousel & Offers Manager</h4>
        <p class="text-muted x-small mb-0" style="font-size: 0.83rem;">Manage special offer slides and promotional banners displayed on the homepage slider.</p>
    </div>
    <div>
        <button class="btn btn-danger fw-semibold px-3 py-2 rounded-2 d-inline-flex align-items-center gap-2" style="background-color: #b03030; border: none;" data-bs-toggle="modal" data-bs-target="#offerModal" onclick="resetOfferForm()">
            <i class="fas fa-plus-circle"></i> Add New Banner Slide
        </button>
    </div>
</div>

<!-- Offers Table -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold" style="width: 80px;">Order</th>
                    <th class="fw-bold" style="width: 90px;">Background</th>
                    <th class="fw-bold">Offer Title & Highlight</th>
                    <th class="fw-bold">Target Link</th>
                    <th class="fw-bold">Status</th>
                    <th class="fw-bold text-end" style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($offers)): ?>
                    <?php foreach($offers as $off): ?>
                    <tr>
                        <td><span class="badge bg-light text-dark border fw-bold px-2 py-1"><?php echo $off['sort_order']; ?></span></td>
                        <td>
                            <img src="../<?php echo htmlspecialchars($off['bg_image']); ?>" class="table-banner-thumb" onerror="this.src='https://via.placeholder.com/70x42?text=NO+IMG';">
                        </td>
                        <td>
                            <strong class="text-dark d-block mb-1"><?php echo htmlspecialchars($off['title']); ?></strong>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><?php echo htmlspecialchars($off['highlight_price']); ?></span>
                        </td>
                        <td><code class="text-secondary" style="font-size: 0.78rem;"><?php echo htmlspecialchars($off['btn_link']); ?></code></td>
                        <td>
                            <?php if($off['status'] == 'active'): ?>
                                <a href="offers.php?id=<?php echo $off['id']; ?>&toggle_status=inactive" class="badge bg-success-subtle text-success border border-success-subtle text-decoration-none px-2 py-1" title="Click to Deactivate">
                                    <i class="fas fa-check-circle me-1"></i> Active
                                </a>
                            <?php else: ?>
                                <a href="offers.php?id=<?php echo $off['id']; ?>&toggle_status=active" class="badge bg-danger-subtle text-danger border border-danger-subtle text-decoration-none px-2 py-1" title="Click to Activate">
                                    <i class="fas fa-times-circle me-1"></i> Inactive
                                </a>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary me-1" onclick='editOffer(<?php echo json_encode($off); ?>)' title="Edit Slide">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="offers.php?delete=<?php echo $off['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this banner slide permanently?')" title="Delete Slide">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No offer banner slides found. Click "Add New Banner Slide" to create one.</td>
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
                <i class="fas fa-list me-1 text-danger"></i> Showing <strong class="text-danger"><?php echo $offset + 1; ?> - <?php echo min($offset + $items_per_page, $total_offers); ?></strong> of <strong><?php echo $total_offers; ?></strong> Banner Slides
            </span>
        </div>
        <nav aria-label="Offer Pagination">
            <ul class="pagination pagination-sm mb-0 gap-1">
                <!-- Previous Button -->
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="offers.php?page=<?php echo $page - 1; ?>">
                        <i class="fas fa-chevron-left me-1"></i> Prev
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link custom-page-btn rounded-2 shadow-sm fw-bold border" href="offers.php?page=<?php echo $i; ?>" style="<?php echo ($page == $i) ? 'background-color: #b03030 !important; border-color: #b03030 !important; color: #fff !important;' : 'background-color: #ffffff; color: #333;'; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="offers.php?page=<?php echo $page + 1; ?>">
                        Next <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<!-- Offer Add/Edit Modal -->
<div class="modal fade" id="offerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <form action="offers.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-dark text-white py-3">
                    <h5 class="modal-title fw-bold fs-6" id="offerModalTitle"><i class="fas fa-sliders-h text-danger me-2"></i>Add New Banner Slide</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="offer_id" id="offer_id">
                    <input type="hidden" name="existing_img" id="existing_img">

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Offer Headline Title *</label>
                            <input type="text" name="title" id="offer_title" class="form-control form-control-sm" placeholder="e.g. Free installation for orders over" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Highlight Price / Text *</label>
                            <input type="text" name="highlight_price" id="offer_price" class="form-control form-control-sm" placeholder="e.g. Rs:5000" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Button Target URL</label>
                            <input type="text" name="btn_link" id="offer_link" class="form-control form-control-sm" placeholder="products.php">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Sort Display Order</label>
                            <input type="number" name="sort_order" id="offer_sort" class="form-control form-control-sm" value="0">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small">Background Cover Image</label>
                            <input type="file" name="bg_image" id="offer_img_input" class="form-control form-control-sm" accept="image/*" onchange="previewOfferImage(this)">
                            <small class="text-muted d-block mt-1" style="font-size:0.72rem;">High-resolution banner background image recommended</small>
                            
                            <!-- Instant Cover Image Live Preview -->
                            <div class="mt-2 d-flex align-items-center gap-2">
                                <span class="small text-muted" style="font-size:0.75rem;">Preview:</span>
                                <img id="offerImagePreview" src="https://via.placeholder.com/120x60?text=PREVIEW" class="preview-img-box">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Slide Status</label>
                            <select name="status" id="offer_status" class="form-select form-select-sm">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Offer Subtext Description *</label>
                            <textarea name="description" id="offer_desc" class="form-control form-control-sm" rows="3" placeholder="Promo details..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="save_offer" class="btn btn-danger fw-semibold btn-sm px-4" style="background-color: #b03030; border: none;">Save Banner Slide</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Interactive Image Preview & Form JavaScript -->
<script>
function previewOfferImage(input) {
    const previewImg = document.getElementById('offerImagePreview');
    if (input.files && input.files[0]) {
        previewImg.src = URL.createObjectURL(input.files[0]);
    }
}

function resetOfferForm() {
    document.getElementById('offerModalTitle').innerHTML = '<i class="fas fa-plus-circle text-danger me-2"></i>Add New Banner Slide';
    document.getElementById('offer_id').value = '';
    document.getElementById('existing_img').value = '';
    document.getElementById('offer_title').value = '';
    document.getElementById('offer_price').value = '';
    document.getElementById('offer_link').value = 'products.php';
    document.getElementById('offer_sort').value = '0';
    document.getElementById('offer_status').value = 'active';
    document.getElementById('offer_desc').value = '';
    document.getElementById('offer_img_input').value = '';
    document.getElementById('offerImagePreview').src = 'https://via.placeholder.com/120x60?text=PREVIEW';
}

function editOffer(off) {
    document.getElementById('offerModalTitle').innerHTML = '<i class="fas fa-edit text-danger me-2"></i>Edit Banner Slide: ' + off.title;
    document.getElementById('offer_id').value = off.id;
    document.getElementById('existing_img').value = off.bg_image;
    document.getElementById('offer_title').value = off.title;
    document.getElementById('offer_price').value = off.highlight_price;
    document.getElementById('offer_link').value = off.btn_link;
    document.getElementById('offer_sort').value = off.sort_order;
    document.getElementById('offer_status').value = off.status;
    document.getElementById('offer_desc').value = off.description;
    document.getElementById('offer_img_input').value = '';
    
    var previewImg = document.getElementById('offerImagePreview');
    if (off.bg_image) {
        previewImg.src = '../' + off.bg_image;
    } else {
        previewImg.src = 'https://via.placeholder.com/120x60?text=NO+IMAGE';
    }
    
    var modal = new bootstrap.Modal(document.getElementById('offerModal'));
    modal.show();
}
</script>

<?php include 'includes/footer.php'; ?>