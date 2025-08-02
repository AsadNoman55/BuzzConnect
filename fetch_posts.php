<?php
require_once "../includes/db.php";
require_once "../includes/functions.php";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) session_start();

// ✅ Fetch posts with user info
$stmt = $conn->prepare("SELECT posts.*, users.username, users.profile_pic 
                        FROM posts 
                        JOIN users ON posts.user_id = users.id 
                        ORDER BY posts.created_at DESC");
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach ($posts as $post): ?>
    <div class="post-card">
        <h6>@<?= htmlspecialchars($post['username']) ?> 
            <span class="text-muted" style="font-size: 0.8rem;"> ?></span>
        </h6>
        <p><?= htmlspecialchars($post['content']) ?></p>

        <?php if (!empty($post['image'])): ?>
            <img src="../uploads/posts/<?= htmlspecialchars($post['image']) ?>" alt="Post Image" class="img-fluid mt-2 rounded">
        <?php endif; ?>

        <div class="like-comment-bar mt-2">
            <form action="../posts/like_post.php" method="POST" class="d-inline">
                <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                <button type="submit" class="btn btn-sm btn-outline-info">
                    ❤️ Like
                </button>
            </form>

            <a href="../posts/comments.php?post_id=<?= $post['id']; ?>" class="btn btn-sm btn-outline-light">💬 Comment</a>

            <!-- Delete button only if current user owns the post -->
            <?php if ($_SESSION['user_id'] === $post['user_id']): ?>
                <form action="../posts/delete_post.php" method="POST" class="d-inline float-end">
                    <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this post?')">
                        🗑️ Delete
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
