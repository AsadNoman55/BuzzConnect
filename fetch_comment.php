<?php
require_once "../includes/db.php";
require_once "../includes/functions.php";

// Enable error reporting (debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['post_id'])) {
    echo "<p>❌ No post ID provided.</p>";
    exit;
}

$post_id = intval($_GET['post_id']);

// Fetch main comments (no parent)
$stmt = $conn->prepare("
    SELECT c.*, u.username 
    FROM comments c 
    JOIN users u ON c.user_id = u.id 
    WHERE c.post_id = ? AND (c.parent_id IS NULL OR c.parent_id = 0)
    ORDER BY c.created_at DESC
");
$stmt->execute([$post_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to get replies
function getReplies($parent_id, $conn) {
    $stmt = $conn->prepare("
        SELECT c.*, u.username 
        FROM comments c 
        JOIN users u ON c.user_id = u.id 
        WHERE c.parent_id = ? 
        ORDER BY c.created_at ASC
    ");
    $stmt->execute([$parent_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Output comments
if ($comments) {
    foreach ($comments as $comment) {
        echo "<div class='comment-box mb-3'>";
        echo "<div class='comment-author'>@".htmlspecialchars($comment['username'])."</div>";
        echo "<div class='comment-date'>Posted on: {$comment['created_at']}</div>";
        echo "<div class='comment-content'>".nl2br(htmlspecialchars($comment['content']))."</div>";

        // Reply button + hidden form
        echo "<div class='mt-2'>";
        echo "<button class='btn btn-sm btn-outline-primary reply-btn' data-comment-id='{$comment['id']}'>Reply</button>";
        echo "<form class='reply-form d-none mt-2' data-parent-id='{$comment['id']}'>
                <textarea class='form-control mb-2' placeholder='Write a reply...'></textarea>
                <button type='submit' class='btn btn-sm btn-primary'>Submit Reply</button>
              </form>";
        echo "</div>";

        // Replies
        $replies = getReplies($comment['id'], $conn);
        if ($replies) {
            echo "<div class='ms-4 mt-3'>";
            foreach ($replies as $reply) {
                echo "<div class='comment-box reply-box mb-2'>";
                echo "<div class='comment-author'>@".htmlspecialchars($reply['username'])."</div>";
                echo "<div class='comment-date'>Posted on: {$reply['created_at']}</div>";
                echo "<div class='comment-content'>".nl2br(htmlspecialchars($reply['content']))."</div>";
                echo "</div>";
            }
            echo "</div>";
        }

        echo "</div>"; // End of comment-box
    }
} else {
    echo "<p>No comments yet. Be the first to comment!</p>";
}
