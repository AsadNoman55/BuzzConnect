<?php
session_start();
require_once "../includes/auth.php"; // protect access
require_once "../includes/db.php";

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    // Get the post and check ownership
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
    $stmt->execute([$post_id, $user_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        // Delete image if it exists
        if (!empty($post['image']) && file_exists("../uploads/posts/" . $post['image'])) {
            unlink("../uploads/posts/" . $post['image']);
        }

        // Delete post from DB
        $delete = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $delete->execute([$post_id]);

        $_SESSION['success'] = "Post deleted successfully.";
    } else {
        $_SESSION['error'] = "Post not found or not yours.";
    }

    header("Location: ../users/dashboard.php");
    exit();
} else {
    echo "Invalid request.";
}
