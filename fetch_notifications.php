<?php
session_start();
require_once "../includes/auth.php";
require_once "../includes/db.php";

$user_id = $_SESSION['user_id'];

// Fetch latest 10 notifications
$stmt = $conn->prepare("SELECT n.*, u.username AS from_username, u.profile_pic 
                        FROM notifications n
                        JOIN users u ON n.from_user_id = u.id
                        WHERE n.user_id = ?
                        ORDER BY n.created_at DESC
                        LIMIT 10");
$stmt->execute([$user_id]);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if ($notifications): ?>
    <?php foreach ($notifications as $n): ?>
        <div class="notification-card p-3 mb-2 rounded bg-dark text-light d-flex align-items-center">
            <img src="../uploads/<?= $n['profile_pic'] ?? 'default.png' ?>" width="40" height="40" class="rounded-circle me-3" style="object-fit: cover;">
            
            <div>
                <?php if ($n['type'] == 'follow'): ?>
                    <strong>@<?= htmlspecialchars($n['from_username']) ?></strong> started following you.
                <?php elseif ($n['type'] == 'like'): ?>
                    <strong>@<?= htmlspecialchars($n['from_username']) ?></strong> liked your <a href="../posts/comments.php?post_id=<?= $n['post_id'] ?>" class="text-info">post</a>.
                <?php elseif ($n['type'] == 'comment'): ?>
                    <strong>@<?= htmlspecialchars($n['from_username']) ?></strong> commented on your <a href="../posts/comments.php?post_id=<?= $n['post_id'] ?>" class="text-info">post</a>.
                <?php endif; ?>
                <br>
                <small class="text-muted"><?= date('F j, Y • g:i A', strtotime($n['created_at'])) ?></small>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-center text-light">🔕 No notifications yet.</div>
<?php endif; ?>
