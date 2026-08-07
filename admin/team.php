<?php
include 'includes/header.php';

// Handle Delete Team Member
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM team_members WHERE id = ?");
    $stmt->execute([$del_id]);
    echo "<script>alert('Team member deleted successfully!'); window.location.href='team.php';</script>";
    exit();
}

// Handle Add / Edit Team Member
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_member'])) {
    $name = trim($_POST['name']);
    $designation = trim($_POST['designation']);
    $description = trim($_POST['description']);
    $sort_order = intval($_POST['sort_order']);
    $mem_id = !empty($_POST['mem_id']) ? intval($_POST['mem_id']) : null;

    $image = $_POST['existing_img'] ?? 'assets/images/5872a08cd669c3cadda08e29a9ba3eff4d6a5c52.png';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $file_name)) {
            $image = "assets/images/uploads/" . $file_name;
        }
    }

    if ($mem_id) {
        $stmt = $pdo->prepare("UPDATE team_members SET name=?, designation=?, description=?, image=?, sort_order=? WHERE id=?");
        $stmt->execute([$name, $designation, $description, $image, $sort_order, $mem_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO team_members (name, designation, description, image, sort_order) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $designation, $description, $image, $sort_order]);
    }
    echo "<script>alert('Team member details saved successfully!'); window.location.href='team.php';</script>";
    exit();
}

// --- PAGINATION LOGIC (10 Team Members Per Page) ---
$items_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

$total_members = $pdo->query("SELECT COUNT(*) FROM team_members")->fetchColumn();
$total_pages = ceil($total_members / $items_per_page);

$stmt = $pdo->prepare("SELECT * FROM team_members ORDER BY sort_order ASC, id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$team_members = $stmt->fetchAll();
?>

<!-- Custom Premium Styles -->
<style>
.preview-img-box {
    width: 65px;
    height: 65px;
    object-fit: cover;
    border-radius: 50%;
    border: 1px solid #dee2e6;
    background-color: #f8f9fa;
}
.table-avatar-thumb {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 50%;
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
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-users text-danger me-2"></i>Team Members Management</h4>
        <p class="text-muted x-small mb-0" style="font-size: 0.83rem;">Manage key company personnel and leadership displayed on the About Us page.</p>
    </div>
    <div>
        <button class="btn btn-danger fw-semibold px-3 py-2 rounded-2 d-inline-flex align-items-center gap-2" style="background-color: #b03030; border: none;" data-bs-toggle="modal" data-bs-target="#teamModal" onclick="resetTeamForm()">
            <i class="fas fa-plus-circle"></i> Add Team Member
        </button>
    </div>
</div>

<!-- Team Members Table -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold" style="width: 80px;">Order</th>
                    <th class="fw-bold" style="width: 70px;">Photo</th>
                    <th class="fw-bold">Full Name</th>
                    <th class="fw-bold">Designation / Role</th>
                    <th class="fw-bold">Short Bio</th>
                    <th class="fw-bold text-end" style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($team_members)): ?>
                    <?php foreach($team_members as $mem): ?>
                    <tr>
                        <td><span class="badge bg-light text-dark border fw-bold px-2 py-1"><?php echo $mem['sort_order']; ?></span></td>
                        <td>
                            <img src="../<?php echo htmlspecialchars($mem['image']); ?>" class="table-avatar-thumb" onerror="this.src='https://via.placeholder.com/48?text=NO+IMG';">
                        </td>
                        <td><strong class="text-dark"><?php echo htmlspecialchars($mem['name']); ?></strong></td>
                        <td><span class="badge bg-light text-danger border px-2 py-1"><?php echo htmlspecialchars($mem['designation']); ?></span></td>
                        <td><span class="text-secondary" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars($mem['description'] ?? 'N/A'); ?></span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary me-1" onclick='editMember(<?php echo json_encode($mem); ?>)' title="Edit Member">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="team.php?delete=<?php echo $mem['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this team member permanently?')" title="Delete Member">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No team members added yet. Click "Add Team Member" to get started.</td>
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
                <i class="fas fa-list me-1 text-danger"></i> Showing <strong class="text-danger"><?php echo $offset + 1; ?> - <?php echo min($offset + $items_per_page, $total_members); ?></strong> of <strong><?php echo $total_members; ?></strong> Team Members
            </span>
        </div>
        <nav aria-label="Team Pagination">
            <ul class="pagination pagination-sm mb-0 gap-1">
                <!-- Previous Button -->
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="team.php?page=<?php echo $page - 1; ?>">
                        <i class="fas fa-chevron-left me-1"></i> Prev
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link custom-page-btn rounded-2 shadow-sm fw-bold border" href="team.php?page=<?php echo $i; ?>" style="<?php echo ($page == $i) ? 'background-color: #b03030 !important; border-color: #b03030 !important; color: #fff !important;' : 'background-color: #ffffff; color: #333;'; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="team.php?page=<?php echo $page + 1; ?>">
                        Next <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<!-- Team Member Add/Edit Modal -->
<div class="modal fade" id="teamModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <form action="team.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-dark text-white py-3">
                    <h5 class="modal-title fw-bold fs-6" id="teamModalTitle"><i class="fas fa-users text-danger me-2"></i>Add New Team Member</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="mem_id" id="mem_id">
                    <input type="hidden" name="existing_img" id="existing_img">

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Full Name *</label>
                        <input type="text" name="name" id="mem_name" class="form-control form-control-sm" placeholder="e.g. Arun Perera" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Designation / Role *</label>
                        <input type="text" name="designation" id="mem_designation" class="form-control form-control-sm" placeholder="e.g. Senior Automation Engineer" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Profile Photo</label>
                        <input type="file" name="image" id="team_img_input" class="form-control form-control-sm" accept="image/*" onchange="previewTeamImage(this)">
                        <small class="text-muted d-block mt-1" style="font-size:0.72rem;">Square ratio photo recommended</small>
                        
                        <!-- Instant Profile Photo Live Preview -->
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <span class="small text-muted" style="font-size:0.75rem;">Preview:</span>
                            <img id="teamImagePreview" src="https://via.placeholder.com/65?text=PREVIEW" class="preview-img-box">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Sort Order</label>
                        <input type="number" name="sort_order" id="mem_sort" class="form-control form-control-sm" value="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Short Bio / Description</label>
                        <textarea name="description" id="mem_desc" class="form-control form-control-sm" rows="3" placeholder="Brief technical background..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="save_member" class="btn btn-danger fw-semibold btn-sm px-4" style="background-color: #b03030; border: none;">Save Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Interactive Image Preview & Form JavaScript -->
<script>
function previewTeamImage(input) {
    const previewImg = document.getElementById('teamImagePreview');
    if (input.files && input.files[0]) {
        previewImg.src = URL.createObjectURL(input.files[0]);
    }
}

function resetTeamForm() {
    document.getElementById('teamModalTitle').innerHTML = '<i class="fas fa-plus-circle text-danger me-2"></i>Add New Team Member';
    document.getElementById('mem_id').value = '';
    document.getElementById('existing_img').value = '';
    document.getElementById('mem_name').value = '';
    document.getElementById('mem_designation').value = '';
    document.getElementById('mem_sort').value = '0';
    document.getElementById('mem_desc').value = '';
    document.getElementById('team_img_input').value = '';
    document.getElementById('teamImagePreview').src = 'https://via.placeholder.com/65?text=PREVIEW';
}

function editMember(mem) {
    document.getElementById('teamModalTitle').innerHTML = '<i class="fas fa-edit text-danger me-2"></i>Edit Team Member: ' + mem.name;
    document.getElementById('mem_id').value = mem.id;
    document.getElementById('existing_img').value = mem.image;
    document.getElementById('mem_name').value = mem.name;
    document.getElementById('mem_designation').value = mem.designation;
    document.getElementById('mem_sort').value = mem.sort_order;
    document.getElementById('mem_desc').value = mem.description || '';
    document.getElementById('team_img_input').value = '';
    
    var previewImg = document.getElementById('teamImagePreview');
    if (mem.image) {
        previewImg.src = '../' + mem.image;
    } else {
        previewImg.src = 'https://via.placeholder.com/65?text=NO+IMAGE';
    }
    
    var modal = new bootstrap.Modal(document.getElementById('teamModal'));
    modal.show();
}
</script>

<?php include 'includes/footer.php'; ?>