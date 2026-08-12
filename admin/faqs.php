<?php 
include 'includes/header.php';

// Handle Delete FAQ
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM faqs WHERE id = ?");
    $stmt->execute([$del_id]);
    echo "<script>alert('FAQ deleted successfully!'); window.location.href='faqs.php';</script>";
    exit();
}

// Handle Add / Edit FAQ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_faq'])) {
    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);
    $sort_order = intval($_POST['sort_order']);
    $faq_id = !empty($_POST['faq_id']) ? intval($_POST['faq_id']) : null;

    if ($faq_id) {
        $stmt = $pdo->prepare("UPDATE faqs SET question=?, answer=?, sort_order=? WHERE id=?");
        $stmt->execute([$question, $answer, $sort_order, $faq_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO faqs (question, answer, sort_order) VALUES (?, ?, ?)");
        $stmt->execute([$question, $answer, $sort_order]);
    }
    echo "<script>alert('FAQ saved successfully!'); window.location.href='faqs.php';</script>";
    exit();
}

// --- PAGINATION LOGIC (10 FAQs Per Page) ---
$items_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

$total_faqs = $pdo->query("SELECT COUNT(*) FROM faqs")->fetchColumn();
$total_pages = ceil($total_faqs / $items_per_page);

$stmt = $pdo->prepare("SELECT * FROM faqs ORDER BY sort_order ASC, id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$faqs = $stmt->fetchAll();
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
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-question-circle text-danger me-2"></i>FAQs Management</h4>
        <p class="text-muted x-small mb-0" style="font-size: 0.83rem;">Manage frequently asked questions and answers displayed on the user FAQ page.</p>
    </div>
    <div>
        <button class="btn btn-danger fw-semibold px-3 py-2 rounded-2 d-inline-flex align-items-center gap-2" style="background-color: #b03030; border: none;" data-bs-toggle="modal" data-bs-target="#faqModal" onclick="resetFaqForm()">
            <i class="fas fa-plus-circle"></i> Add New FAQ
        </button>
    </div>
</div>

<!-- FAQs Table -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4 admin-card-container">
    <div class="table-responsive">
        <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold" style="width: 80px;">Order</th>
                    <th class="fw-bold" style="width: 30%;">Question</th>
                    <th class="fw-bold">Answer Details</th>
                    <th class="fw-bold text-end" style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($faqs)): ?>
                    <?php foreach($faqs as $faq): ?>
                    <tr>
                        <td><span class="badge bg-light text-dark border fw-bold px-2 py-1"><?php echo $faq['sort_order']; ?></span></td>
                        <td><strong class="text-dark"><?php echo htmlspecialchars($faq['question']); ?></strong></td>
                        <td><span class="text-secondary" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars($faq['answer']); ?></span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary me-1" onclick='editFaq(<?php echo json_encode($faq); ?>)' title="Edit FAQ">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="faqs.php?delete=<?php echo $faq['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this FAQ permanently?')" title="Delete FAQ">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No FAQs added yet. Click "Add New FAQ" to create one.</td>
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
                <i class="fas fa-list me-1 text-danger"></i> Showing <strong class="text-danger"><?php echo $offset + 1; ?> - <?php echo min($offset + $items_per_page, $total_faqs); ?></strong> of <strong><?php echo $total_faqs; ?></strong> FAQs
            </span>
        </div>
        <nav aria-label="FAQ Pagination">
            <ul class="pagination pagination-sm mb-0 gap-1">
                <!-- Previous Button -->
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="faqs.php?page=<?php echo $page - 1; ?>">
                        <i class="fas fa-chevron-left me-1"></i> Prev
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link custom-page-btn rounded-2 shadow-sm fw-bold border" href="faqs.php?page=<?php echo $i; ?>" style="<?php echo ($page == $i) ? 'background-color: #b03030 !important; border-color: #b03030 !important; color: #fff !important;' : 'background-color: #ffffff; color: #333;'; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="faqs.php?page=<?php echo $page + 1; ?>">
                        Next <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<!-- FAQ Add/Edit Modal -->
<div class="modal fade" id="faqModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <form action="faqs.php" method="POST">
                <div class="modal-header bg-dark text-white py-3">
                    <h5 class="modal-title fw-bold fs-6" id="faqModalTitle"><i class="fas fa-question-circle text-danger me-2"></i>Add New FAQ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="faq_id" id="faq_id">

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Question *</label>
                        <input type="text" name="question" id="faq_question" class="form-control form-control-sm" placeholder="e.g. What warranty periods do you offer?" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Answer *</label>
                        <textarea name="answer" id="faq_answer" class="form-control form-control-sm" rows="4" placeholder="Detailed answer..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Sort Order</label>
                        <input type="number" name="sort_order" id="faq_sort" class="form-control form-control-sm" value="0">
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="save_faq" class="btn btn-danger fw-semibold btn-sm px-4" style="background-color: #b03030; border: none;">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetFaqForm() {
    document.getElementById('faqModalTitle').innerHTML = '<i class="fas fa-plus-circle text-danger me-2"></i>Add New FAQ';
    document.getElementById('faq_id').value = '';
    document.getElementById('faq_question').value = '';
    document.getElementById('faq_answer').value = '';
    document.getElementById('faq_sort').value = '0';
}

function editFaq(faq) {
    document.getElementById('faqModalTitle').innerHTML = '<i class="fas fa-edit text-danger me-2"></i>Edit FAQ';
    document.getElementById('faq_id').value = faq.id;
    document.getElementById('faq_question').value = faq.question;
    document.getElementById('faq_answer').value = faq.answer;
    document.getElementById('faq_sort').value = faq.sort_order;
    
    var modal = new bootstrap.Modal(document.getElementById('faqModal'));
    modal.show();
}
</script>

<?php include 'includes/footer.php'; ?>