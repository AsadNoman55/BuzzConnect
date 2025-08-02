<?php
session_start();

require_once "../includes/functions.php";
require_once "../includes/db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: ../users/dashboard.php");
    exit();
}

// 🔒 Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];

    // Find user by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // ✅ Save role to session

        // ✅ Redirect based on role
        $redirect = ($_SESSION['role'] === 'admin') ? 'admin/dashboard.php' : 'users/dashboard.php';
        header("Location: ../$redirect");
        exit();
    } else {
        set_flash('error', 'Invalid email or password ❌');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BuzzConnect – Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background-color: #0f3460;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 420px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .form-control {
            background-color: #1a1a2e;
            border: none;
            color: #fff;
        }

        .form-control:focus {
            box-shadow: none;
            background-color: #1a1a2e;
            color: #fff;
            border: 1px solid #00adb5;
        }

        .btn-login {
            background-color: #00adb5;
            color: #fff;
            font-weight: 600;
            border-radius: 30px;
        }

        .btn-login:hover {
            background-color: #008891;
        }

        .small-text {
            color: #aaa;
            text-align: center;
            margin-top: 1rem;
        }

        a {
            color: #00adb5;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="login-box">
        <h2>Welcome to BuzzConnect 🐝</h2>

        <!-- ✅ Success message (e.g. after registration) -->
        <?php if ($msg = get_flash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $msg ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- ❌ Error message (e.g. invalid login) -->
        <?php if ($msg = get_flash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $msg ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" name="login" class="btn btn-login w-100">Login</button>
        </form>
        <div class="small-text mt-3">
            Don’t have an account? <a href="register.php">Sign up</a>
        </div>
    </div>
</body>

</html>
