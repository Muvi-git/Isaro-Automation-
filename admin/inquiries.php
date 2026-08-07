<?php
include 'includes/header.php';

// Handle Status Change
if (isset($_GET['status']) && isset($_GET['id'])) {
    $inq_id = intval($_GET['id']);
    $status = $_GET['status'];
    $stmt = $pdo->prepare("UPDATE inquiries SET status=? WHERE id=?");
    $stmt->execute([$status, $inq_id]);
    echo "<script>window.location.href='inquiries.php';</script>";
    exit();
}

// --- PAGINATION LOGIC (10 Inquiries Per Page) ---
$items_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

$total_inquiries = $pdo->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();
$total_pages = ceil($total_inquiries / $items_per_page);

$stmt = $pdo->prepare("SELECT * FROM inquiries ORDER BY id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$inquiries = $stmt->fetchAll();
?>

<!-- Custom Premium Styles -->
<style>
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
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-envelope-open-text text-danger me-2"></i>Customer Inquiries & Quote Requests</h4>
        <p class="text-muted x-small mb-0" style="font-size: 0.83rem;">Manage customer RFQ price inquiries, messages, and wishlisted item requests submitted via website forms.</p>
    </div>
    <div>
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fw-semibold fs-7">
            <i class="fas fa-inbox me-1"></i> Total: <?php echo $total_inquiries; ?> Submissions
        </span>
    </div>
</div>

<!-- Inquiries Table -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold" style="width: 90px;">Ref #</th>
                    <th class="fw-bold">Type</th>
                    <th class="fw-bold">Customer Name</th>
                    <th class="fw-bold">Contact Info</th>
                    <th class="fw-bold">Company</th>
                    <th class="fw-bold">Message / Items</th>
                    <th class="fw-bold">Status</th>
                    <th class="fw-bold text-end" style="width: 130px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($inquiries)): ?>
                    <?php foreach($inquiries as $inq): 
                        $items_list = !empty($inq['items_json']) ? json_decode($inq['items_json'], true) : [];
                    ?>
                    <tr>
                        <td class="fw-bold text-secondary">#INQ-<?php echo $inq['id']; ?></td>
                        <td>
                            <span class="badge bg-secondary-subtle text-dark border px-2 py-1" style="font-size: 0.78rem;">
                                <i class="fas fa-tag me-1"></i><?php echo strtoupper(str_replace('_', ' ', $inq['type'])); ?>
                            </span>
                        </td>
                        <td class="fw-semibold text-dark"><?php echo htmlspecialchars($inq['full_name']); ?></td>
                        <td>
                            <a href="mailto:<?php echo htmlspecialchars($inq['email']); ?>" class="text-decoration-none text-dark fw-medium"><?php echo htmlspecialchars($inq['email']); ?></a>
                            <?php if(!empty($inq['phone'])): ?>
                                <br><small class="text-muted"><i class="fas fa-phone me-1"></i><?php echo htmlspecialchars($inq['phone']); ?></small>
                            <?php endif; ?>
                        </td>
                        <td><span class="text-secondary"><?php echo htmlspecialchars($inq['company'] ?? 'N/A'); ?></span></td>
                        <td style="max-width: 240px;">
                            <small class="text-dark d-block text-truncate"><?php echo htmlspecialchars($inq['message']); ?></small>
                            <?php if(!empty($items_list)): ?>
                                <span class="badge bg-info-subtle text-info border mt-1 px-2 py-1" style="font-size:0.7rem;">
                                    <i class="fas fa-list-check me-1"></i><?php echo count($items_list); ?> Requested Item(s)
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($inq['status'] == 'pending'): ?>
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1"><i class="fas fa-clock me-1"></i>Pending</span>
                            <?php elseif($inq['status'] == 'replied'): ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="fas fa-check-circle me-1"></i>Replied</span>
                            <?php else: ?>
                                <span class="badge bg-light text-muted border px-2 py-1"><i class="fas fa-archive me-1"></i>Archived</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <!-- View Modal Trigger -->
                            <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#inqModal<?php echo $inq['id']; ?>" title="View Inquiry Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <!-- Mark as Replied -->
                            <a href="inquiries.php?id=<?php echo $inq['id']; ?>&status=replied" class="btn btn-sm btn-outline-success me-1" title="Mark as Replied">
                                <i class="fas fa-check"></i>
                            </a>
                            <!-- Archive -->
                            <a href="inquiries.php?id=<?php echo $inq['id']; ?>&status=archived" class="btn btn-sm btn-outline-secondary" title="Archive Inquiry">
                                <i class="fas fa-archive"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- INQUIRY DETAILS MODAL -->
                    <div class="modal fade" id="inqModal<?php echo $inq['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg text-start" style="border-radius: 14px;">
                                <div class="modal-header bg-dark text-white py-3">
                                    <h5 class="modal-title fw-bold fs-6">
                                        <i class="fas fa-envelope-open-text text-danger me-2"></i>Inquiry Details #INQ-<?php echo $inq['id']; ?>
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="text-muted small d-block">Customer Name</label>
                                            <strong class="fs-6 text-dark"><?php echo htmlspecialchars($inq['full_name']); ?></strong>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted small d-block">Inquiry Type</label>
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                <?php echo strtoupper(str_replace('_', ' ', $inq['type'])); ?>
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted small d-block">Email Address</label>
                                            <a href="mailto:<?php echo htmlspecialchars($inq['email']); ?>" class="fw-semibold text-danger"><?php echo htmlspecialchars($inq['email']); ?></a>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted small d-block">Phone Number</label>
                                            <span class="fw-semibold text-dark"><?php echo htmlspecialchars($inq['phone'] ?? 'N/A'); ?></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted small d-block">Company / Organization</label>
                                            <span class="fw-semibold text-dark"><?php echo htmlspecialchars($inq['company'] ?? 'N/A'); ?></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted small d-block">Date Submitted</label>
                                            <span class="text-secondary"><?php echo date('F j, Y | h:i A', strtotime($inq['created_at'])); ?></span>
                                        </div>
                                    </div>

                                    <hr class="my-3 opacity-25">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-dark"><i class="fas fa-comment-alt text-danger me-1"></i> Customer Message / Requirement:</label>
                                        <div class="p-3 bg-light rounded border text-dark fs-7" style="white-space: pre-line;">
                                            <?php echo htmlspecialchars($inq['message']); ?>
                                        </div>
                                    </div>

                                    <!-- Requested Wishlist Items List (if present) -->
                                    <?php if(!empty($items_list)): ?>
                                        <div class="mt-3">
                                            <label class="form-label fw-bold small text-dark"><i class="fas fa-boxes-stacked text-danger me-1"></i> Attached Quote Request Items List:</label>
                                            <div class="table-responsive rounded border">
                                                <table class="table table-sm table-striped align-middle mb-0 fs-7">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Item Title</th>
                                                            <th>SKU / Model</th>
                                                            <th class="text-end">Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($items_list as $item): ?>
                                                            <tr>
                                                                <td class="fw-semibold text-dark"><?php echo htmlspecialchars($item['title'] ?? 'Product Item'); ?></td>
                                                                <td class="text-muted"><?php echo htmlspecialchars($item['code'] ?? $item['sku'] ?? 'N/A'); ?></td>
                                                                <td class="text-end fw-bold text-danger"><?php echo htmlspecialchars($item['price'] ?? 'N/A'); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="modal-footer bg-light py-2 justify-content-between">
                                    <a href="mailto:<?php echo htmlspecialchars($inq['email']); ?>?subject=RE: Quote Inquiry #INQ-<?php echo $inq['id']; ?> - Isaro Automation" class="btn btn-sm btn-danger fw-semibold px-3" style="background-color: #b03030; border: none;">
                                        <i class="fas fa-paper-plane me-1"></i> Reply via Email
                                    </a>
                                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 text-secondary d-block"></i>
                            No customer inquiries received yet.
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
                <i class="fas fa-list me-1 text-danger"></i> Showing <strong class="text-danger"><?php echo $offset + 1; ?> - <?php echo min($offset + $items_per_page, $total_inquiries); ?></strong> of <strong><?php echo $total_inquiries; ?></strong> Inquiries
            </span>
        </div>
        <nav aria-label="Inquiry Pagination">
            <ul class="pagination pagination-sm mb-0 gap-1">
                <!-- Previous Button -->
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="inquiries.php?page=<?php echo $page - 1; ?>">
                        <i class="fas fa-chevron-left me-1"></i> Prev
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link custom-page-btn rounded-2 shadow-sm fw-bold border" href="inquiries.php?page=<?php echo $i; ?>" style="<?php echo ($page == $i) ? 'background-color: #b03030 !important; border-color: #b03030 !important; color: #fff !important;' : 'background-color: #ffffff; color: #333;'; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="inquiries.php?page=<?php echo $page + 1; ?>">
                        Next <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>