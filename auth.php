<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Basic check: is user logged in?
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Optional: if page requires admin role
if (isset($require_admin) && $require_admin === true) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        // Redirect non-admins
        header("Location: ../auth/login.php");
        exit();
    }
}
