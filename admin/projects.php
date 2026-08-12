<?php
include 'includes/header.php';

// Handle Delete Project
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$del_id]);
    echo "<script>alert('Project deleted successfully!'); window.location.href='projects.php';</script>";
    exit();
}

// Handle Add / Edit Project
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_project'])) {
    $title = trim($_POST['title']);
    $client_industry = trim($_POST['client_industry']);
    $location = trim($_POST['location']);
    $short_desc = trim($_POST['short_desc']);
    $full_details = trim($_POST['full_details']);
    $is_recent = isset($_POST['is_recent']) ? 1 : 0;
    $proj_id = !empty($_POST['proj_id']) ? intval($_POST['proj_id']) : null;

    $main_img = $_POST['existing_img'] ?? 'assets/images/2f9058cda797988dc0788f626d5eb70c856ef2bb.png';
    if (isset($_FILES['main_img']) && $_FILES['main_img']['error'] == 0) {
        $target_dir = "../assets/images/uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $file_name = time() . '_' . basename($_FILES["main_img"]["name"]);
        if (move_uploaded_file($_FILES["main_img"]["tmp_name"], $target_dir . $file_name)) {
            $main_img = "assets/images/uploads/" . $file_name;
        }
    }

    if ($proj_id) {
        $stmt = $pdo->prepare("UPDATE projects SET title=?, client_industry=?, location=?, short_desc=?, full_details=?, main_img=?, is_recent=? WHERE id=?");
        $stmt->execute([$title, $client_industry, $location, $short_desc, $full_details, $main_img, $is_recent, $proj_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO projects (title, client_industry, location, short_desc, full_details, main_img, is_recent) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $client_industry, $location, $short_desc, $full_details, $main_img, $is_recent]);
    }
    echo "<script>alert('Project saved successfully!'); window.location.href='projects.php';</script>";
    exit();
}

// --- PAGINATION LOGIC (10 Projects Per Page) ---
$items_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

$total_projects = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$total_pages = ceil($total_projects / $items_per_page);

$stmt = $pdo->prepare("SELECT * FROM projects ORDER BY id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$projects = $stmt->fetchAll();
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
    width: 65px;
    height: 45px;
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
        width: 50px !important;
        height: 35px !important;
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
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-industry text-danger me-2"></i>Case Projects Management</h4>
        <p class="text-muted x-small mb-0" style="font-size: 0.83rem;">Manage engineering projects and case studies displayed on the user portfolio.</p>
    </div>
    <div>
        <button class="btn btn-danger fw-semibold px-3 py-2 rounded-2 d-inline-flex align-items-center gap-2" style="background-color: #b03030; border: none;" data-bs-toggle="modal" data-bs-target="#projectModal" onclick="resetProjectForm()">
            <i class="fas fa-plus-circle"></i> Add New Project
        </button>
    </div>
</div>

<!-- Projects Table -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4 admin-card-container">
    <div class="table-responsive">
        <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold" style="width: 80px;">Cover Photo</th>
                    <th class="fw-bold">Project Title</th>
                    <th class="fw-bold">Client Industry</th>
                    <th class="fw-bold">Location</th>
                    <th class="fw-bold">Highlight Status</th>
                    <th class="fw-bold text-end" style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($projects)): ?>
                    <?php foreach($projects as $proj): ?>
                    <tr>
                        <td>
                            <img src="../<?php echo htmlspecialchars($proj['main_img']); ?>" class="table-banner-thumb" onerror="this.src='https://via.placeholder.com/65x45?text=NO+IMG';">
                        </td>
                        <td>
                            <strong class="text-dark d-block"><?php echo htmlspecialchars($proj['title']); ?></strong>
                            <small class="text-muted"><?php echo substr(htmlspecialchars($proj['short_desc']), 0, 55) . '...'; ?></small>
                        </td>
                        <td><span class="badge bg-light text-dark border px-2 py-1"><?php echo htmlspecialchars($proj['client_industry'] ?? 'General Industry'); ?></span></td>
                        <td><small class="text-secondary"><i class="fas fa-map-marker-alt text-danger me-1"></i> <?php echo htmlspecialchars($proj['location'] ?? 'Sri Lanka'); ?></small></td>
                        <td>
                            <?php if($proj['is_recent']): ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="fas fa-star me-1"></i> Recent Featured</span>
                            <?php else: ?>
                                <span class="badge bg-light text-muted border px-2 py-1">Standard Grid</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary me-1" onclick='editProject(<?php echo json_encode($proj); ?>)' title="Edit Project">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="projects.php?delete=<?php echo $proj['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this project?')" title="Delete Project">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No projects found in database. Click "Add New Project" to get started.</td>
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
                <i class="fas fa-list me-1 text-danger"></i> Showing <strong class="text-danger"><?php echo $offset + 1; ?> - <?php echo min($offset + $items_per_page, $total_projects); ?></strong> of <strong><?php echo $total_projects; ?></strong> Projects
            </span>
        </div>
        <nav aria-label="Project Pagination">
            <ul class="pagination pagination-sm mb-0 gap-1">
                <!-- Previous Button -->
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="projects.php?page=<?php echo $page - 1; ?>">
                        <i class="fas fa-chevron-left me-1"></i> Prev
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link custom-page-btn rounded-2 shadow-sm fw-bold border" href="projects.php?page=<?php echo $i; ?>" style="<?php echo ($page == $i) ? 'background-color: #b03030 !important; border-color: #b03030 !important; color: #fff !important;' : 'background-color: #ffffff; color: #333;'; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link custom-page-btn rounded-2 shadow-sm border fw-semibold text-dark bg-white" href="projects.php?page=<?php echo $page + 1; ?>">
                        Next <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<!-- Project Add/Edit Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <form action="projects.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-dark text-white py-3">
                    <h5 class="modal-title fw-bold fs-6" id="projModalTitle"><i class="fas fa-industry text-danger me-2"></i>Add New Case Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="proj_id" id="proj_id">
                    <input type="hidden" name="existing_img" id="existing_img">

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Project Title *</label>
                            <input type="text" name="title" id="proj_title" class="form-control form-control-sm" placeholder="e.g. Smart Factory PLC Integration" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Client Industry</label>
                            <input type="text" name="client_industry" id="proj_industry" class="form-control form-control-sm" placeholder="e.g. Industrial Manufacturing">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Location Zone</label>
                            <input type="text" name="location" id="proj_location" class="form-control form-control-sm" placeholder="e.g. Biyagama EPZ">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Main Cover Image *</label>
                            <input type="file" name="main_img" id="proj_img_input" class="form-control form-control-sm" accept="image/*" onchange="previewProjImage(this)">
                            <small class="text-muted d-block mt-1" style="font-size:0.72rem;">High quality industrial photo recommended</small>
                            
                            <!-- Instant Cover Image Live Preview -->
                            <div class="mt-2 d-flex align-items-center gap-2">
                                <span class="small text-muted" style="font-size:0.75rem;">Preview:</span>
                                <img id="projImagePreview" src="https://via.placeholder.com/90x60?text=PREVIEW" class="preview-img-box">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Short Summary *</label>
                            <textarea name="short_desc" id="proj_short_desc" class="form-control form-control-sm" rows="2" placeholder="Brief 1-2 sentence overview for cards..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Full Technical Case Study Details</label>
                            <textarea name="full_details" id="proj_full_details" class="form-control form-control-sm" rows="4" placeholder="Detailed scope, components integrated, engineering results..."></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_recent" id="proj_is_recent">
                                <label class="form-check-label fw-semibold small" for="proj_is_recent">Display in Top "Recent Projects" Showcase Section</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="save_project" class="btn btn-danger fw-semibold btn-sm px-4" style="background-color: #b03030; border: none;">Save Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Interactive Image Preview & Form JavaScript -->
<script>
function previewProjImage(input) {
    const previewImg = document.getElementById('projImagePreview');
    if (input.files && input.files[0]) {
        previewImg.src = URL.createObjectURL(input.files[0]);
    }
}

function resetProjectForm() {
    document.getElementById('projModalTitle').innerHTML = '<i class="fas fa-plus-circle text-danger me-2"></i>Add New Case Project';
    document.getElementById('proj_id').value = '';
    document.getElementById('existing_img').value = '';
    document.getElementById('proj_title').value = '';
    document.getElementById('proj_industry').value = '';
    document.getElementById('proj_location').value = '';
    document.getElementById('proj_short_desc').value = '';
    document.getElementById('proj_full_details').value = '';
    document.getElementById('proj_is_recent').checked = false;
    document.getElementById('proj_img_input').value = '';
    document.getElementById('projImagePreview').src = 'https://via.placeholder.com/90x60?text=PREVIEW';
}

function editProject(proj) {
    document.getElementById('projModalTitle').innerHTML = '<i class="fas fa-edit text-danger me-2"></i>Edit Case Project: ' + proj.title;
    document.getElementById('proj_id').value = proj.id;
    document.getElementById('existing_img').value = proj.main_img;
    document.getElementById('proj_title').value = proj.title;
    document.getElementById('proj_industry').value = proj.client_industry || '';
    document.getElementById('proj_location').value = proj.location || '';
    document.getElementById('proj_short_desc').value = proj.short_desc;
    document.getElementById('proj_full_details').value = proj.full_details || '';
    document.getElementById('proj_is_recent').checked = (proj.is_recent == 1);
    document.getElementById('proj_img_input').value = '';
    
    var previewImg = document.getElementById('projImagePreview');
    if (proj.main_img) {
        previewImg.src = '../' + proj.main_img;
    } else {
        previewImg.src = 'https://via.placeholder.com/90x60?text=NO+IMAGE';
    }
    
    var modal = new bootstrap.Modal(document.getElementById('projectModal'));
    modal.show();
}
</script>

<?php include 'includes/footer.php'; ?>