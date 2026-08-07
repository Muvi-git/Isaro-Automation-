<?php
include 'includes/header.php';

// Fetch Quick Stats
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalInquiries = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status='pending'")->fetchColumn();
$totalProjects = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$pendingReviews = $pdo->query("SELECT COUNT(*) FROM product_reviews WHERE is_approved=0")->fetchColumn();

// Fetch Recent Pending Inquiries
$recentInquiries = $pdo->query("SELECT * FROM inquiries ORDER BY id DESC LIMIT 5")->fetchAll();
?>

<!-- Premium Dashboard Styles -->
<style>
.dashboard-stat-card {
    background: #ffffff;
    border: 1px solid #e5e9f2;
    border-radius: 14px;
    padding: 22px;
    transition: all 0.25s ease-in-out;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    display: block;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}
.dashboard-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    border-color: rgba(176, 48, 48, 0.3);
}
.stat-icon-wrapper {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
}
.stat-arrow-link {
    font-size: 0.78rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 14px;
    transition: gap 0.2s ease;
}
.dashboard-stat-card:hover .stat-arrow-link {
    gap: 8px;
}
.welcome-banner {
    background: linear-gradient(135deg, #1e2125 0%, #343a40 100%);
    color: #ffffff;
    border-radius: 16px;
    padding: 26px 30px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
}
</style>

<!-- Welcome Banner / Quick Shortcuts Header -->
<div class="welcome-banner mb-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div>
        <h4 class="fw-bold mb-1"><i class="fas fa-grip-horizontal text-danger me-2"></i>Isaro Control Center</h4>
        <p class="text-white-50 x-small mb-0" style="font-size: 0.85rem;">Manage your catalog, customer quote inquiries, projects, and reviews in real-time.</p>
    </div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="products.php" class="btn btn-sm btn-danger px-3 py-2 fw-semibold rounded-2 d-inline-flex align-items-center gap-2" style="background-color: #b03030; border: none;">
            <i class="fas fa-plus-circle"></i> Manage Products
        </a>
        <a href="projects.php" class="btn btn-sm btn-light px-3 py-2 fw-semibold rounded-2 d-inline-flex align-items-center gap-2 border">
            <i class="fas fa-folder-plus"></i> View Projects
        </a>
    </div>
</div>

<!-- Stat Cards Row (Fully Clickable Cards) -->
<div class="row g-4 mb-4">
    <!-- 1. Total Products Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="products.php" class="dashboard-stat-card border-start border-danger border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small fw-semibold text-uppercase tracking-wider" style="font-size: 0.72rem;">Total Products</span>
                    <h2 class="fw-bold text-dark mt-2 mb-0"><?php echo number_format($totalProducts); ?></h2>
                </div>
                <div class="stat-icon-wrapper bg-danger-subtle text-danger border border-danger-subtle">
                    <i class="fas fa-box"></i>
                </div>
            </div>
            <div class="stat-arrow-link text-danger">
                <span>Browse Products</span> <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </div>

    <!-- 2. Pending Quote Inquiries Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="inquiries.php" class="dashboard-stat-card border-start border-warning border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small fw-semibold text-uppercase tracking-wider" style="font-size: 0.72rem;">Pending Quotes</span>
                    <h2 class="fw-bold text-dark mt-2 mb-0"><?php echo number_format($totalInquiries); ?></h2>
                </div>
                <div class="stat-icon-wrapper bg-warning-subtle text-warning border border-warning-subtle">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
            </div>
            <div class="stat-arrow-link text-warning">
                <span>View Inquiries</span> <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </div>

    <!-- 3. Completed Projects Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="projects.php" class="dashboard-stat-card border-start border-success border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small fw-semibold text-uppercase tracking-wider" style="font-size: 0.72rem;">Completed Projects</span>
                    <h2 class="fw-bold text-dark mt-2 mb-0"><?php echo number_format($totalProjects); ?></h2>
                </div>
                <div class="stat-icon-wrapper bg-success-subtle text-success border border-success-subtle">
                    <i class="fas fa-industry"></i>
                </div>
            </div>
            <div class="stat-arrow-link text-success">
                <span>Manage Projects</span> <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </div>

    <!-- 4. Pending Reviews Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="reviews.php" class="dashboard-stat-card border-start border-info border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small fw-semibold text-uppercase tracking-wider" style="font-size: 0.72rem;">Pending Reviews</span>
                    <h2 class="fw-bold text-dark mt-2 mb-0"><?php echo number_format($pendingReviews); ?></h2>
                </div>
                <div class="stat-icon-wrapper bg-info-subtle text-info border border-info-subtle">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="stat-arrow-link text-info">
                <span>Moderate Reviews</span> <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </div>
</div>

<!-- Recent Inquiries Table -->
<div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <div>
            <h6 class="fw-bold text-dark mb-1"><i class="fas fa-inbox me-2 text-danger"></i> Recent Customer Quotations & Messages</h6>
            <p class="text-muted x-small mb-0" style="font-size: 0.78rem;">Recent inquiries submitted via website quote requests and contact forms.</p>
        </div>
        <a href="inquiries.php" class="btn btn-sm btn-outline-danger fw-semibold px-3 py-1 fs-7">View All Inquiries</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle fs-7 mb-0">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold">Type</th>
                    <th class="fw-bold">Customer Name</th>
                    <th class="fw-bold">Contact Info</th>
                    <th class="fw-bold">Date & Time</th>
                    <th class="fw-bold">Status</th>
                    <th class="fw-bold text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($recentInquiries)): ?>
                    <?php foreach($recentInquiries as $inq): ?>
                    <tr>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary border px-2 py-1" style="font-size: 0.7rem;">
                                <i class="fas fa-tag me-1"></i><?php echo strtoupper(str_replace('_', ' ', $inq['type'])); ?>
                            </span>
                        </td>
                        <td class="fw-semibold text-dark">
                            <?php echo htmlspecialchars($inq['full_name']); ?>
                            <?php if(!empty($inq['company'])): ?>
                                <br><span class="text-muted x-small fw-normal" style="font-size: 0.75rem;"><i class="fas fa-building me-1"></i><?php echo htmlspecialchars($inq['company']); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="mailto:<?php echo htmlspecialchars($inq['email']); ?>" class="text-decoration-none text-dark"><?php echo htmlspecialchars($inq['email']); ?></a>
                            <?php if(!empty($inq['phone'])): ?>
                                <br><small class="text-muted"><i class="fas fa-phone me-1"></i><?php echo htmlspecialchars($inq['phone']); ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted"><?php echo date('Y-m-d | h:i A', strtotime($inq['created_at'])); ?></td>
                        <td>
                            <?php if($inq['status'] == 'pending'): ?>
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1"><i class="fas fa-clock me-1"></i>Pending</span>
                            <?php else: ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="fas fa-check-circle me-1"></i>Replied</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="inquiries.php?id=<?php echo $inq['id']; ?>" class="btn btn-sm btn-light border fw-semibold px-3" style="font-size: 0.78rem;">
                                <i class="fas fa-eye me-1 text-danger"></i> Manage
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4 fs-7">
                            <i class="fas fa-inbox fa-2x mb-2 text-secondary d-block"></i>
                            No customer inquiries received yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>