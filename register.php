<?php
session_start();
require_once "../includes/functions.php"; // flash + clean_input
require_once "../includes/db.php"; // include DB once only

if (isset($_SESSION['user_id'])) {
    header("Location: ../users/dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $fullname = clean_input($_POST['fullname']);
    $username = clean_input($_POST['username']);
    $email = clean_input($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert user into DB (include fullname too)
    $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$fullname, $username, $email, $password]);

    set_flash('success', 'Account created successfully! 🎉');
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BuzzConnect – Register</title>
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

        .register-box {
            background-color: #0f3460;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 480px;
        }

        .register-box h2 {
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

        .btn-register {
            background-color: #00adb5;
            color: #fff;
            font-weight: 600;
            border-radius: 30px;
        }

        .btn-register:hover {
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
    <div class="register-box">
        <h2>Create Your BuzzConnect Account 🐝</h2>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control" placeholder="John Doe" required>
            </div>
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="johndoe123" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" name="register" class="btn btn-register w-100">Register</button>
            
        </form>
        <div class="small-text mt-3">
            Already have an account? <a href="login.php">Login</a>
        </div>
    </div>
</body>
</html>
