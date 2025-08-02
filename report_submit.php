<?php
session_start();
require_once "../includes/auth.php";
require_once "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'], $_POST['reason'])) {
    $post_id = (int) $_POST['post_id'];
    $reported_by = $_SESSION['user_id'];
    $reason = trim($_POST['reason']);
    $details = trim($_POST['details'] ?? '');

    // Combine reason + details if both provided
    $full_reason = $details ? "$reason - $details" : $reason;

    $stmt = $conn->prepare("INSERT INTO reports (post_id, reported_by, reason) VALUES (?, ?, ?)");
    $stmt->execute([$post_id, $reported_by, $full_reason]);

    $_SESSION['success'] = "Your report has been submitted.";
    header("Location: ../users/dashboard.php");
    exit;
}

header("Location: ../users/dashboard.php");
exit;
