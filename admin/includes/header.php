<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';

if (!isset($_SESSION['admin_id']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header('Location: login.php');
    exit();
}

$admin_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isaro Admin Dashboard</title>

    <!-- Ultra-HD Crisp Vector Circular Favicon (Lossless Upscaled SVG) from User Header -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Cdefs%3E%3ClinearGradient id='isaroGlow' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%23900c3f'/%3E%3Cstop offset='50%25' stop-color='%23c71585'/%3E%3Cstop offset='100%25' stop-color='%23e65c9c'/%3E%3C/linearGradient%3E%3C/defs%3E%3Ccircle cx='50' cy='50' r='48' fill='url(%23isaroGlow)' stroke='%23ffffff' stroke-width='2'/%3E%3Ccircle cx='50' cy='22' r='7' fill='%23ffd700' stroke='%23333333' stroke-width='0.8'/%3E%3Ccircle cx='50' cy='22' r='3.2' fill='%23000000'/%3E%3Cpolyline points='12,47 40,47 50,28 62,75 72,54 88,47' fill='none' stroke='%23ffd700' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3Cpolyline points='12,54 38,54 50,35 62,82 72,61 88,54' fill='none' stroke='%23ffd700' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E">

    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* 1. SCROLLBAR LOCK (PREVENTS 100% OF HORIZONTAL SHIFTING/JITTER ACROSS PAGES) */
        html {
            scrollbar-gutter: stable;
            overflow-y: scroll !important;
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            color: #333333;
        }

        /* Custom Scrollbar for Sidebar */
        .admin-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .admin-sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .admin-sidebar::-webkit-scrollbar-thumb {
            background: #d0d0d0;
            border-radius: 4px;
        }
        .admin-sidebar::-webkit-scrollbar-thumb:hover {
            background: #b03030;
        }

        /* Fixed Sidebar */
        .admin-sidebar {
            width: 260px;
            background: #ffffff;
            height: 100vh;
            border-right: 1px solid #e5e9f2;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 10px rgba(0,0,0,0.02);
            transition: transform 0.3s ease-in-out;
        }

        /* Sidebar Navigation Links */
        .admin-sidebar .nav-link {
            color: #555555;
            font-size: 0.88rem;
            font-weight: 500;
            padding: 11px 18px;
            border-radius: 8px;
            margin: 2px 14px;
            transition: all 0.25s ease-in-out;
            display: flex;
            align-items: center;
        }
        .admin-sidebar .nav-link:hover {
            background-color: #fdf2f2;
            color: #b03030;
            transform: translateX(3px);
        }
        .admin-sidebar .nav-link.active {
            background-color: #fff0f1;
            color: #b03030;
            font-weight: 600;
            border-left: 4px solid #b03030;
            border-radius: 4px 8px 8px 4px;
        }
        .admin-sidebar .nav-link i {
            width: 26px;
            font-size: 1rem;
        }

        /* Main Right Column Wrapper */
        .admin-main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease-in-out;
        }

        /* Top Header Bar */
        .top-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e9f2;
            padding: 14px 30px;
            position: sticky;
            top: 0;
            z-index: 900;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        /* Page Content Area */
        .admin-content {
            padding: 28px 30px 80px 30px;
            flex: 1 0 auto;
        }

        /* Fixed Bottom Footer */
        .admin-footer {
            position: fixed;
            bottom: 0;
            right: 0;
            left: 260px;
            z-index: 990;
            background: #ffffff;
            border-top: 1px solid #e5e9f2;
            padding: 12px 30px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.02);
            transition: left 0.3s ease-in-out;
        }

        /* Sidebar Backdrop Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1040;
        }

        /* Responsive Breakpoints */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .sidebar-overlay.show {
                display: block;
            }
            .admin-main-wrapper {
                margin-left: 0 !important;
            }
            .admin-footer {
                left: 0 !important;
            }
            .top-navbar {
                padding: 12px 16px !important;
            }
            .admin-content {
                padding: 16px 16px 80px 16px !important;
            }
        }
    </style>
</head>
<body>

<!-- MOBILE OVERLAY BACKDROP -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleAdminSidebar()"></div>

<!-- FIXED LEFT SIDEBAR -->
<div class="admin-sidebar" id="adminSidebar">
    <div>
        <!-- Logo Section -->
        <div class="p-3 text-center border-bottom mb-3 bg-white d-flex align-items-center justify-content-between justify-content-lg-center">
            <a href="index.php" class="text-decoration-none">
                <img src="../assets/images/Untitled - 12 August 2026 at 09.47.16.png" class="img-fluid" style="max-height: 45px;" onerror="this.src='https://via.placeholder.com/150x45?text=ISARO+AUTOMATION'">
            </a>
            <button type="button" class="btn-close d-lg-none" onclick="toggleAdminSidebar()"></button>
        </div>
        
        <div class="px-3 mb-3 text-center">
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle d-block mx-auto fw-bold" style="width: max-content; font-size: 0.68rem; letter-spacing: 0.5px;">
                CONTROL PANEL v2.0
            </span>
        </div>

        <!-- Navigation Links -->
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo ($admin_page == 'index.php') ? 'active' : ''; ?>" href="index.php">
                    <i class="fas fa-chart-pie me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($admin_page == 'products.php') ? 'active' : ''; ?>" href="products.php">
                    <i class="fas fa-box me-2"></i> Products Catalog
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($admin_page == 'categories.php') ? 'active' : ''; ?>" href="categories.php">
                    <i class="fas fa-tags me-2"></i> Categories
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($admin_page == 'projects.php') ? 'active' : ''; ?>" href="projects.php">
                    <i class="fas fa-industry me-2"></i> Case Projects
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($admin_page == 'offers.php') ? 'active' : ''; ?>" href="offers.php">
                    <i class="fas fa-sliders-h me-2"></i> Banner Carousel
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($admin_page == 'inquiries.php') ? 'active' : ''; ?>" href="inquiries.php">
                    <i class="fas fa-envelope-open-text me-2"></i> Quote Inquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($admin_page == 'reviews.php') ? 'active' : ''; ?>" href="reviews.php">
                    <i class="fas fa-star me-2"></i> Customer Reviews
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($admin_page == 'team.php') ? 'active' : ''; ?>" href="team.php">
                    <i class="fas fa-users me-2"></i> Team Members
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($admin_page == 'faqs.php') ? 'active' : ''; ?>" href="faqs.php">
                    <i class="fas fa-question-circle me-2"></i> FAQs
                </a>
            </li>
        </ul>
    </div>

    <!-- Bottom Logout -->
    <div class="p-3 border-top bg-light">
        <a class="nav-link text-danger fw-semibold m-0 px-2 py-1 rounded-2 d-flex align-items-center justify-content-between" href="logout.php">
            <span><i class="fas fa-sign-out-alt me-2"></i> Logout</span>
            <i class="fas fa-angle-right small"></i>
        </a>
    </div>
</div>

<!-- MAIN RIGHT SIDE WRAPPER -->
<div class="admin-main-wrapper">

    <!-- TOP NAVBAR -->
    <div class="top-navbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm d-lg-none me-2" onclick="toggleAdminSidebar()" title="Toggle Menu">
                <i class="fas fa-bars"></i>
            </button>
            <span class="text-secondary fw-semibold fs-6 d-none d-sm-inline">Isaro Management Hub</span>
        </div>
        <div class="d-flex align-items-center gap-2 gap-sm-3">
            <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-secondary rounded-2 px-2 px-sm-3 fw-medium" style="font-size: 0.8rem;">
                <i class="fas fa-external-link-alt me-1 fs-7"></i> <span class="d-none d-sm-inline">Visit </span>Site
            </a>
            <div class="vr bg-secondary opacity-25" style="height: 20px;"></div>
            <span class="fw-semibold fs-7 text-dark d-flex align-items-center gap-2">
                <i class="fas fa-user-circle fs-5 text-danger"></i> 
                <span class="d-none d-sm-inline"><?php echo htmlspecialchars($_SESSION['admin_name'] ?? $_SESSION['admin_username'] ?? 'System Admin'); ?></span>
            </span>
        </div>
    </div>

    <script>
    function toggleAdminSidebar() {
        var sidebar = document.getElementById('adminSidebar');
        var overlay = document.getElementById('sidebarOverlay');
        if (sidebar && overlay) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    }
    </script>

    <!-- PAGE CONTENT CONTAINER -->
    <div class="admin-content">