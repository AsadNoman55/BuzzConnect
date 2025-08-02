<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/auth.php";
require_once "../includes/functions.php";

if (!isset($_GET['post_id'])) {
    header("Location: ../users/dashboard.php");
    exit();
}

$post_id = $_GET['post_id'];
$user_id = $_SESSION['user_id'];

// ✅ Fetch post info
$stmt = $conn->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ Fetch comments with users
$stmt = $conn->prepare("SELECT comments.*, users.username 
                        FROM comments 
                        JOIN users ON comments.user_id = users.id 
                        WHERE comments.post_id = ?
                        ORDER BY comments.created_at ASC");
$stmt->execute([$post_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Group comments by parent_id
$grouped_comments = [];
foreach ($comments as $comment) {
    $grouped_comments[$comment['parent_id']][] = $comment;
}

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BuzzConnect – Comments</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #0f3460;
        color: #fff;
    }
    .container { max-width: 800px; }
    .post-box, .comment-box {
        background-color: #16213e;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 0 25px rgba(0,0,0,0.4);
        margin-bottom: 1.5rem;
    }
    .form-control, .form-control:focus {
        background-color: #1a1a2e;
        color: #fff;
        border: 1px solid #00adb5;
        box-shadow: none;
    }
    .btn-post {
        background-color: #00adb5;
        color: #fff;
        font-weight: 600;
        border-radius: 30px;
    }
    .btn-post:hover { background-color: #008891; }
    .comment {
        background-color: #1a1a2e;
        border-radius: 15px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .comment h6 { font-weight: 600; margin-bottom: 0.3rem; }
    .comment .time { color: #aaa; font-size: 0.8rem; }
  </style>
</head>
<body>
<?php include "../includes/header.php"; ?>
<div class="container pt-3">
    <div class="post-box">
        <h5>@<?= htmlspecialchars($post['username']) ?></h5>
        <p><?= htmlspecialchars($post['content']) ?></p>
        <?php if (!empty($post['image'])): ?>
            <img src="../uploads/posts/<?= htmlspecialchars($post['image']) ?>" alt="Post Image" class="img-fluid rounded mt-2">
        <?php endif; ?>
    </div>

    <div class="comment-box">
        <form id="new-comment-form">
            <input type="hidden" name="parent_id" value="">
            <input type="hidden" name="post_id" value="<?= $post_id ?>">
            <div class="mb-3">
                <textarea name="content" class="form-control" rows="3" placeholder="Add your comment..." required></textarea>
            </div>
            <button type="submit" class="btn btn-post w-100">💬 Post Comment</button>
        </form>
    </div>

    <div id="comments-section">
        <?php display_comments($grouped_comments); ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("new-comment-form");
        form.addEventListener("submit", async function (e) {
            e.preventDefault();
            const formData = new FormData(form);
            const res = await fetch("ajax_add_comment.php", {
                method: "POST",
                body: formData
            });
            const data = await res.text();
            document.getElementById("comments-section").innerHTML = data;
            form.reset();
        });

        document.querySelectorAll(".reply-btn").forEach(btn => {
            btn.addEventListener("click", function () {
                const parentId = this.dataset.commentId;
                const form = this.nextElementSibling;
                form.classList.toggle("d-none");
            });
        });

        document.querySelectorAll(".reply-form").forEach(replyForm => {
            replyForm.addEventListener("submit", async function (e) {
                e.preventDefault();
                const parentId = this.dataset.parentId;
                const content = this.querySelector("textarea").value;
                const formData = new FormData();
                formData.append("parent_id", parentId);
                formData.append("post_id", "<?= $post_id ?>");
                formData.append("content", content);
                const res = await fetch("ajax_add_comment.php", {
                    method: "POST",
                    body: formData
                });
                const data = await res.text();
                document.getElementById("comments-section").innerHTML = data;
            });
        });
    });
</script>

<?php include "../includes/footer.php"; ?>
</body>
</html>
