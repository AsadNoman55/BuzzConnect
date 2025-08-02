<?php
session_start();
require_once "../includes/auth.php";
require_once "../includes/db.php";
file_put_contents("log.txt", "Hit follow_toggle.php\n", FILE_APPEND);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['followed_id'])) {
    $follower_id = $_SESSION['user_id'] ?? null;
    $followed_id = (int) $_POST['followed_id'];

    if (!$follower_id || $follower_id === $followed_id) {
        echo json_encode(["status" => "error", "message" => "Invalid operation"]);
        exit;
    }

    // Check if already following
    $stmt = $conn->prepare("SELECT * FROM follows WHERE follower_id = ? AND followed_id = ?");
    $stmt->execute([$follower_id, $followed_id]);

    if ($stmt->rowCount() > 0) {
        // Unfollow
        $delete = $conn->prepare("DELETE FROM follows WHERE follower_id = ? AND followed_id = ?");
        $delete->execute([$follower_id, $followed_id]);

        // Optional: delete follow notification
        $clearNotif = $conn->prepare("DELETE FROM notifications WHERE type = 'follow' AND user_id = ? AND from_user_id = ?");
        $clearNotif->execute([$followed_id, $follower_id]);

        echo json_encode(["status" => "unfollowed"]);
    } else {
        // Follow
        $insert = $conn->prepare("INSERT INTO follows (follower_id, followed_id) VALUES (?, ?)");
        $insert->execute([$follower_id, $followed_id]);

        // Create notification
        $notif = $conn->prepare("INSERT INTO notifications (user_id, from_user_id, type, is_read, created_at) VALUES (?, ?, 'follow', 0, NOW())");
        $notif->execute([$followed_id, $follower_id]);

        echo json_encode(["status" => "followed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
