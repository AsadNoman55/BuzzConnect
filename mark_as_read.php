<?php
session_start();
require_once "../includes/auth.php";
require_once "../includes/db.php";

$user_id = $_SESSION['user_id'];

// Mark all notifications as read
$stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0");
$stmt->execute([$user_id]);

// Redirect back to notifications page
header("Location: index.php");
exit();
