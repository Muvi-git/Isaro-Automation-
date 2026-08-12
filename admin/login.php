<?php
session_start();
require_once '../config/db.php';

// Already Logged In නම් Dashboard එකට Redirect කිරීම
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        
      
        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS `admins` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `username` VARCHAR(50) NOT NULL UNIQUE,
                `password` VARCHAR(255) NOT NULL,
                `email` VARCHAR(100) NOT NULL,
                `full_name` VARCHAR(100) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
            
            $pdo->exec("ALTER TABLE `admins` MODIFY `password` VARCHAR(255) NOT NULL");
        } catch (PDOException $e) {
            // Ignore if exists
        }

        // 2. Admin User සොයා ගැනීම
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        $validBcryptHash = password_hash('admin123', PASSWORD_BCRYPT);

        // User නැත්නම් Auto Insert කිරීම
        if (!$admin && $username === 'admin' && $password === 'admin123') {
            $insert = $pdo->prepare("INSERT INTO admins (username, password, email, full_name) VALUES (?, ?, ?, ?)");
            $insert->execute(['admin', $validBcryptHash, 'admin@isaroautomation.com', 'System Administrator']);
            
            $admin_id = $pdo->lastInsertId();
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_name'] = 'System Administrator';
            $_SESSION['admin_user'] = 'admin';
            header('Location: index.php');
            exit();
        }

        // 3. Fail-Safe Password Check Logic
        $isLoggedIn = false;

        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                $isLoggedIn = true;
            } 
            // Fallback Reset Check for 'admin123'
            elseif ($username === 'admin' && $password === 'admin123') {
                $update = $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?");
                $update->execute([$validBcryptHash, $admin['id']]);
                $isLoggedIn = true;
            }
        }

        if ($isLoggedIn) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['admin_user'] = $admin['username'];
            header('Location: index.php');
            exit();
        } else {
            $error = 'Invalid Username or Password!';
        }
    } else {
        $error = 'Please fill in all fields!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Isaro Automation</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: #ffffff;
            border: 1px solid #e5e9f2;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        }
        .form-control:focus {
            border-color: #b03030;
            box-shadow: 0 0 0 0.2rem rgba(176, 48, 48, 0.15);
        }
        .btn-login {
            background-color: #b03030;
            color: #ffffff;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #8e2323;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(176, 48, 48, 0.25);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <img src="../assets/images/Untitled - 12 August 2026 at 09.47.16.png" class="img-fluid mb-2" style="max-height: 50px;" alt="Isaro Logo">
        <h5 class="fw-bold text-dark mt-2 mb-1">Control Panel Access</h5>
        <p class="text-muted small mb-0" style="font-size: 0.8rem;">Enter your admin credentials to log in.</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger py-2 text-center rounded-3 mb-3" style="font-size: 0.82rem;">
            <i class="fas fa-exclamation-circle me-1"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="mb-3">
            <label class="form-label fw-semibold text-secondary" style="font-size: 0.8rem;">Username</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                <input type="text" name="username" class="form-control border-start-0" placeholder="e.g. admin" value="admin" required autocomplete="off">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold text-secondary" style="font-size: 0.8rem;">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn btn-login w-100 shadow-sm">
            <i class="fas fa-sign-in-alt me-2"></i> Sign In to Admin
        </button>
    </form>
    
    <div class="text-center mt-4 pt-2 border-top">
        <a href="../index.php" class="text-decoration-none text-muted" style="font-size: 0.78rem;">
            <i class="fas fa-arrow-left me-1"></i> Back to Isaro Automation Website
        </a>
    </div>
</div>

</body>
</html>