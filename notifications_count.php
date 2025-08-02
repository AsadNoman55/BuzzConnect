<?php
session_start();
require_once "../includes/auth.php";
require_once "../includes/db.php";

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
$stmt->execute([$user_id]);
$count = $stmt->fetchColumn();

echo json_encode(['unread' => $count]);
