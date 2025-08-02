<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/auth.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'];

    // Check if user already liked the post
    $check = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
    $check->execute([$user_id, $post_id]);

    if ($check->rowCount() > 0) {
        // Unlike
        $delete = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
        $delete->execute([$user_id, $post_id]);
    } else {
        // Like
        $insert = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
        $insert->execute([$user_id, $post_id]);

        // Get post owner to notify them
        $stmt = $conn->prepare("SELECT user_id FROM posts WHERE id = ?");
        $stmt->execute([$post_id]);
        $post_owner_id = $stmt->fetchColumn();

        // Send notification only if user liked someone else's post
        if ($post_owner_id && $post_owner_id != $user_id) {
            $notify = $conn->prepare("INSERT INTO notifications (user_id, type, from_user_id, post_id) VALUES (?, 'like', ?, ?)");
            $notify->execute([$post_owner_id, $user_id, $post_id]);
        }
    }

    // Redirect back
    header("Location: ../users/dashboard.php");
    exit();
} else {
    echo "Invalid request.";
}

