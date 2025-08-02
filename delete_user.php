<?php
session_start();
$require_admin = true;
require_once "../includes/auth.php";
require_once "../includes/db.php";
require_once "../includes/functions.php";

// Check if user_id is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    // Optional: Don't allow deleting yourself or other admins
    if ($user_id == $_SESSION['user_id']) {
        set_flash('error', 'You cannot delete your own account 🤨');
        header("Location: users.php");
        exit();
    }

    // Fetch user to check role (prevent admin deleting other admins)
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $targetUser = $stmt->fetch();

    if ($targetUser && $targetUser['role'] === 'admin') {
        set_flash('error', 'You cannot delete another admin 🚫');
        header("Location: users.php");
        exit();
    }

    // Delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);

    set_flash('success', 'User deleted successfully ✅');
} else {
    set_flash('error', 'Invalid request ❌');
}

header("Location: users.php");
exit();
