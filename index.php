<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // If user is already logged in, redirect to dashboard
    header("Location: users/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BuzzConnect – Connect, Share, Vibe</title>
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
            flex-direction: column;
            text-align: center;
            padding: 2rem;
        }

        h1 {
            font-size: 3rem;
            font-weight: 600;
            color: #00adb5;
            margin-bottom: 0.5rem;
        }

        p {
            font-size: 1.2rem;
            color: #ccc;
            margin-bottom: 2rem;
        }

        .btn-start {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 30px;
            margin: 0 0.5rem;
        }

        .btn-login {
            background-color: transparent;
            border: 2px solid #00adb5;
            color: #00adb5;
        }

        .btn-login:hover {
            background-color: #00adb5;
            color: #fff;
        }

        .btn-register {
            background-color: #00adb5;
            color: #fff;
        }

        .btn-register:hover {
            background-color: #008891;
        }

        .logo {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.2rem;
            }

            .logo {
                font-size: 3rem;
            }

            .btn-start {
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>
</head>
<body>

    <div class="logo">🐝</div>
    <h1>Welcome to BuzzConnect</h1>
    <p>Where people share, connect, and vibe ⚡</p>

    <div>
        <a href="auth/login.php" class="btn btn-start btn-login">Login</a>
        <a href="auth/register.php" class="btn btn-start btn-register">Register</a>
    </div>

</body>
</html>
