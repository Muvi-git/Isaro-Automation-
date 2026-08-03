<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isaro Automation Systems (Pvt) Ltd</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="isaro-navbar navbar navbar-expand-lg sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/images/industrial_automation_logo 1.png" alt="Isaro Automation Logo" class="img-fluid">
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#isaroNavbarContent" aria-controls="isaroNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Items -->
        <div class="collapse navbar-collapse" id="isaroNavbarContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link isaro-nav-link <?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : ''; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link isaro-nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link isaro-nav-link <?php echo ($current_page == 'products.php' || $current_page == 'product-detail.php') ? 'active' : ''; ?>" href="products.php">Our Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link isaro-nav-link <?php echo ($current_page == 'projects.php') ? 'active' : ''; ?>" href="projects.php">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link isaro-nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="contact.php">Contact Us</a>
                </li>
            </ul>

            <!-- Search Form -->
            <form class="d-flex isaro-search-box mt-2 mt-lg-0" action="products.php" method="GET">
                <input class="form-control isaro-search-input w-100" type="search" name="query" placeholder="Search..." aria-label="Search" required>
                <button class="isaro-search-btn" type="submit" title="Search">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</header>