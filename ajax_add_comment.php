<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo "Invalid request";
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
$post_id = $_POST['post_id'] ?? null;
$content = trim($_POST['content'] ?? '');
$parent_id = $_POST['parent_id'] ?? null;

if (!$user_id || !$post_id || $content === '') {
    http_response_code(400);
    echo "Missing required data";
    exit;
}

// ✅ Insert the comment
$stmt = $conn->prepare("INSERT INTO comments (user_id, post_id, content, parent_id, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->execute([$user_id, $post_id, $content, $parent_id]);

// ✅ Get post owner ID
$stmt = $conn->prepare("SELECT user_id FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post_owner_id = $stmt->fetchColumn();

// ✅ Create notification for post owner (if commenter isn't the owner)
if ($post_owner_id && $post_owner_id != $user_id) {
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, from_user_id, post_id, type, created_at) VALUES (?, ?, ?, 'comment', NOW())");
    $stmt->execute([$post_owner_id, $user_id, $post_id]);
}

// ✅ Fetch all comments for the post
$stmt = $conn->prepare("SELECT comments.*, users.username 
                        FROM comments 
                        JOIN users ON comments.user_id = users.id 
                        WHERE comments.post_id = ?
                        ORDER BY comments.created_at ASC");
$stmt->execute([$post_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Group by parent_id
$grouped_comments = [];
foreach ($comments as $comment) {
    $grouped_comments[$comment['parent_id']][] = $comment;
}

// ✅ Display comments
function display_comments($grouped, $parent_id = null) {
    if (!isset($grouped[$parent_id])) return;

    foreach ($grouped[$parent_id] as $c): ?>
        <div class="comment ms-<?= $parent_id ? '5' : '0' ?>">
            <h6>@<?= htmlspecialchars($c['username']) ?></h6>
            <p><?= htmlspecialchars($c['content']) ?></p>
            <div class="time">Posted <?= timeAgo($c['created_at']) ?></div>
            <button class="btn btn-sm btn-outline-info reply-btn mt-2" data-comment-id="<?= $c['id'] ?>">↩️ Reply</button>
            <form method="POST" class="reply-form mt-2 d-none" data-parent-id="<?= $c['id'] ?>">
                <textarea name="content" class="form-control mt-1 mb-2" rows="2" placeholder="Reply..." required></textarea>
                <button class="btn btn-sm btn-outline-info">Reply</button>
            </form>
            <?php display_comments($grouped, $c['id']); ?>
        </div>
    <?php endforeach;
}

// ✅ Output the updated comments section
ob_start();
display_comments($grouped_comments);
echo ob_get_clean();
