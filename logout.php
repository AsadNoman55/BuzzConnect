<?php
session_start();
require_once "../includes/functions.php"; // ✅ Load flash message functions

// Clear session
$_SESSION = [];
session_destroy();

// Kill session cookie (optional)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Set logout flash
set_flash('success', 'You have been logged out successfully. 👋');

// Redirect
header("Location: login.php");
exit();
