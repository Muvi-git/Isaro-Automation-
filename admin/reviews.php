<?php
include 'includes/header.php';

// Handle Delete Review
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM product_reviews WHERE id = ?");
    $stmt->execute([$del_id]);
    echo "<script>alert('Review deleted successfully!'); window.location.href='reviews.php';</script>";
    exit();
}

// Handle Approve / Reject Toggle
if (isset($_GET['toggle_approval']) && isset($_GET['id'])) {
    $rev_id = intval($_GET['id']);
    $new_status = (intval($_GET['toggle_approval']) === 1) ? 1 : 0;
    $stmt = $pdo->prepare("UPDATE product_reviews SET is_approved = ? WHERE id = ?");
    $stmt->execute([$new_status, $rev_id]);
    echo "<script>window.location.href='reviews.php';</script>";
    exit();
}

// --- PAGINATION LOGIC (10 Reviews Per Page) ---
$items_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

$total_reviews = $pdo->query("SELECT COUNT(*) FROM product_reviews")->fetchColumn();
$total_pages = ceil($total_reviews / $items_per_page);

$stmt = $pdo->prepare("
    SELECT r.*, p.title as product_title, p.sku as product_sku, p.main_img as product_img 
    FROM product_reviews r 
    JOIN products p ON r.product_id = p.id 
    ORDER BY r.id DESC 
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$reviews = $stmt->fetchAll();
?>

<!-- Custom Premium Styles -->
<style>
.table-img-thumb {
    width: 44px;
    height: 44px;
    object-fit: contain;
    border-radius: 6px;
    border: 1px solid #e9ecef;
    background-color: #ffffff;
    padding: 2px;
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
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-star text-danger me-2"></i>Customer Reviews Approval Manager</h4>
        <p class="text-muted x-small mb-0" style="font-size: 0.83rem;">Approve or reject customer product reviews before they appear publicly on the website.</p>
    </div>
    <div>
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fw-semibold fs-7">
            <i class="fas fa-comments me-1"></i> Total: <?php echo $total_reviews; ?> Reviews
        </span>
    </div>
</div>

<!-- Reviews Table -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold">Product Details</th>
                    <th class="fw-bold">Reviewer Name</th>
                    <th class="fw-bold">Rating</th>
                    <th class="fw-bold">Comment Text</th>
                    <th class="fw-bold">Date</th>
                    <th class="fw-bold">Status</th>
                    <th class="fw-bold text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($reviews)): ?>
                    <?php foreach($reviews as $rev): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="../<?php echo htmlspecialchars($rev['product_img']); ?>" class="table-img-thumb" onerror="this.src='https://via.placeholder.com/44?text=NO+IMG';">
                                <div>
                                    <strong class="text-dark d-block fs-7" style="line-height: 1.2;"><?php echo htmlspecialchars($rev['product_title']); ?></strong>
                                    <small class="text-muted" style="font-size: 0.72rem;"><i class="fas fa-barcode me-1"></i><?php echo htmlspecialchars($rev['product_sku']); ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong class="text-dark d-block"><?php echo htmlspecialchars($rev['reviewer_name']); ?></strong>
                            <a href="mailto:<?php echo htmlspecialchars($rev['reviewer_email']); ?>" class="text-muted small text-decoration-none"><?php echo htmlspecialchars($rev['reviewer_email']); ?></a>
                        </td>
                        <td>
                            <div class="text-warning fs-7" style="font-size: 0.78rem;">
                                <?php 
                                for($i=1; $i<=5; $i++) {
                                    echo ($i <= $rev['rating']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star text-muted"></i>';
                                }
                                ?>
                                <span class="fw-bold text-dark ms-1">(<?php echo $rev['rating']; ?>.0)</span>
                            </div>
                        </td>
                        <td style="max-width: 240px;">
                            <span class="text-secondary d-block text-truncate" title="<?php echo htmlspecialchars($rev['comment']); ?>">
                                <?php echo htmlspecialchars($rev['comment']); ?>
                            </span>
                        </td>
                        <td><small class="text-muted"><?php echo date('Y-m-d', strtotime($rev['created_at'])); ?></small></td>
                        <td>
                            <?php if($rev['is_approved'] == 1): ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                    <i class="fas fa-check-circle me-1"></i> Approved
                                </span>
                            <?php else: ?>
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                    <i class="fas fa-clock me-1"></i> Pending
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <!-- View Modal Trigger -->
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="modal" data-bs-target="#revModal<?php echo $rev['id']; ?>" title="View Review Details">
                                <i class="fas fa-eye"></i>
                            </button>

                            <?php if($rev['is_approved'] == 0): ?>
                                <a href="reviews.php?id=<?php echo $rev['id']; ?>&toggle_approval=1" class="btn btn-sm btn-outline-success me-1" title="Approve Review">
                                    <i class="fas fa-check"></i>
                                </a>
                            <?php else: ?>
                                <a href="reviews.php?id=<?php echo $rev['id']; ?>&toggle_approval=0" class="btn btn-sm btn-outline-warning me-1" title="Unapprove Review">
                                    <i class="fas fa-eye-slash"></i>
                                </a>
                            <?php endif; ?>
                            
                            <a href="reviews.php?delete=<?php echo $rev['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this review permanently?')" title="Delete Review">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- REVIEW DETAILS MODAL -->
                    <div class="modal fade" id="revModal<?php echo $rev['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg text-start" style="border-radius: 14px;">
                                <div class="modal-header bg-dark text-white py-3">
                                    <h5 class="modal-title fw-bold fs-6">
                                        <i class="fas fa-star text-danger me-2"></i>Review Details #REV-<?php echo $rev['id']; ?>
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded border mb-3">
                                        <img src="../<?php echo htmlspecialchars($rev['product_img']); ?>" class="preview-img-box" style="width: 55px; height: 55px; object-fit: contain;" onerror="this.src='https://via.placeholder.com/55?text=NO+IMG';">
                                        <div>
                                            <span class="text-muted small d-block" style="font-size: 0.75rem;">Product Item</span>
                                            <strong class="text-dark d-block"><?php echo htmlspecialchars($rev['product_title']); ?></strong>
                                            <small class="text-secondary">SKU: <?php echo htmlspecialchars($rev['product_sku']); ?></small>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-6">
                                            <label class="text-muted small d-block">Reviewer Name</label>
                                            <strong class="text-dark"><?php echo htmlspecialchars($rev['reviewer_name']); ?></strong>
                                        </div>
                                        <div class="col-6">
                                            <label class="text-muted small d-block">Email Address</label>
                                            <a href="mailto:<?php echo htmlspecialchars($rev['reviewer_email']); ?>" class="text-danger fw-semibold small"><?php echo htmlspecialchars($rev['reviewer_email']); ?></a>
                                        </div>
                                        <div class="col-6">
                                            <label class="text-muted small d-block">Rating Stars</label>
                                            <div class="text-warning">
                                                <?php 
                                                for($i=1; $i<=5; $i++) {
                                                    echo ($i <= $rev['rating']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star text-muted"></i>';
                                                }
                                                ?>
                                                <strong class="text-dark ms-1">(<?php echo $rev['rating']; ?>/5)</strong>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="text-muted small d-block">Submitted Date</label>
                                            <span class="text-secondary small"><?php echo date('F j, Y', strtotime($rev['created_at'])); ?></span>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label fw-bold small text-dark"><i class="fas fa-comment text-danger me-1"></i> Customer Comment:</label>
                                        <div class="p-3 bg-light rounded border text-dark fs-7" style="white-space: pre-line;">
                                            <?php echo htmlspecialchars($rev['comment']); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer bg-light py-2 justify-content-between">
                                    <?php if($rev['is_approved'] == 0): ?>
                                        <a href="reviews.php?id=<?php echo $rev['id']; ?>&toggle_approval=1" class="btn btn-sm btn-success fw-semibold px-3">
                                            <i class="fas fa-check me-1"></i> Approve Review
                                        </a>
                                    <?php else: ?>
                                        <a href="reviews.php?id=<?php echo $rev['id']; ?>&toggle_approval=0" class="btn btn-sm btn-warning fw-semibold px-3">
                                            <i class="fas fa-eye-slash me-1"></i> Unapprove Review
                                        </a>
                                    <?php endif; ?>
                                    
                                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-star fa-2x mb-2 text-secondary d-block"></i>
                            No product reviews submitted yet.
                        </td>
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
                <i class="fas fa-list me-1 text-danger"></i> Showing <strong class="text-danger"><?php echo $offset + 1; ?> - <?php echo min($offset + $items_per_page, $total_reviews); ?></strong> of <strong><?php echo $total_reviews; ?></strong> Reviews
            </span>
        </div>
        <nav aria-label="Review Pagination">
            <ul class="pagination pagination-sm mb-0 gap-1">
                <!-- Previous Button -->
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="reviews.php?page=<?php echo $page - 1; ?>">
                        <i class="fas fa-chevron-left me-1"></i> Prev
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link custom-page-btn rounded-2 shadow-sm fw-bold border" href="reviews.php?page=<?php echo $i; ?>" style="<?php echo ($page == $i) ? 'background-color: #b03030 !important; border-color: #b03030 !important; color: #fff !important;' : 'background-color: #ffffff; color: #333;'; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="reviews.php?page=<?php echo $page + 1; ?>">
                        Next <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>