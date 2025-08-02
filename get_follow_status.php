<?php
session_start();
require_once "../includes/auth.php";
require_once "../includes/db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['followed_id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

$follower_id = $_SESSION['user_id'] ?? null;
$followed_id = (int) $_GET['followed_id'];

if (!$follower_id || $follower_id === $followed_id) {
    echo json_encode(["status" => "unfollowed"]);
    exit;
}

$stmt = $conn->prepare("SELECT 1 FROM follows WHERE follower_id = ? AND followed_id = ?");
$stmt->execute([$follower_id, $followed_id]);

$status = $stmt->rowCount() > 0 ? "followed" : "unfollowed";

echo json_encode(["status" => $status]);
