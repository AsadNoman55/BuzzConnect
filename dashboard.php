<?php
session_start();
require_once "../includes/auth.php";
require_once "../includes/functions.php";
require_once "../includes/db.php";

$user_id = $_SESSION['user_id'];

// Fetch posts with like & comment count
$posts = [];
try {
    $stmt = $conn->query("SELECT posts.*, users.username,
        (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) AS like_count,
        (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comment_count
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY posts.created_at DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle error
}

function fetch_and_group_comments($conn, $post_id) {
    $stmt = $conn->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = ? ORDER BY comments.created_at ASC");
    $stmt->execute([$post_id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $grouped_comments = [];
    foreach ($comments as $comment) {
        $grouped_comments[$comment['parent_id']][] = $comment;
    }
    return $grouped_comments;
}

function display_comments($grouped, $parent_id = null) {
    if (!isset($grouped[$parent_id])) return;

    foreach ($grouped[$parent_id] as $c): ?>
        <div class="comment ms-<?= $parent_id ? '5' : '0' ?>">
            <h6>@<?= htmlspecialchars($c['username']) ?></h6>
            <p><?= htmlspecialchars($c['content']) ?></p>
            <div class="time">Posted <?= timeAgo($c['created_at']) ?></div>
        </div>
    <?php endforeach;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BuzzConnect – Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f3460;
            color: #fff;
        }
        .feed-container {
            max-width: 700px;
            margin: 100px auto 30px;
        }
        .post-box, .post-card {
            background-color: #1a1a2e;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
            position: relative;
        }
        .post-box textarea, .form-control, .form-control:focus {
            background-color: #0f3460;
            border: none;
            color: #fff;
        }
        .btn-post {
            background-color: #00fff5;
            color: #0f3460;
            font-weight: 600;
            border-radius: 30px;
            border: none;
        }
        .like-count { color: #aaa; font-size: 0.9rem; }
        .delete-btn i { font-size: 1rem; color: #ff4b5c; }
        .comment { background-color: #0f3a5c; padding: 1rem; border-radius: 12px; margin-top: 0.5rem; }
        .notification-indicator { position: relative; }
        .notification-indicator .dot {
            position: absolute;
            top: -3px;
            right: -3px;
            height: 10px;
            width: 10px;
            background-color: red;
            border-radius: 50%;
        }
        
      .interaction-bar {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
}
.interaction-bar .left-actions {
    display: flex;
    gap: 10px;
}
.interaction-bar .right-actions {
    display: flex;
    gap: 10px;
}

.interaction-bar i {
    font-size: 1.3rem;
}

.btn-like i.fa-heart {
    transition: color 0.2s ease;
}

.btn-like i.fa-heart.liked {
    color: #ff2e63; /* Hard red for liked post */
}

.btn-comment-toggle {
    margin-left: 8px; /* move comment icon a bit to right */
}

.delete-btn {
    background: none;
    border: none;
    padding: 0;
}

.delete-btn i {
    font-size: 1rem;
    color: #ff4b5c;
}

    </style>
</head>
<body>
<?php include "../includes/header.php"; ?>
<div class="feed-container">
    <?php if ($msg = get_flash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $msg ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="post-box mb-4">
        <form action="../posts/create_post.php" method="GET">
            <textarea class="form-control mb-3" rows="3" placeholder="Write something amazing..." name="content"></textarea>
            <button type="submit" class="btn btn-post w-100">Create a Post 🐝</button>
        </form>
    </div>

    <?php foreach ($posts as $post):
        $liked = false;
        $likeCheck = $conn->prepare("SELECT 1 FROM likes WHERE post_id = ? AND user_id = ?");
        $likeCheck->execute([$post['id'], $user_id]);
        $liked = $likeCheck->fetchColumn();
    ?>
        <div class="post-card">
            <?php if ($post['user_id'] == $user_id): ?>
                <form action="../posts/delete_post.php" method="POST" class="position-absolute top-0 end-0 mt-2 me-2">
                    <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                    <button type="submit" class="delete-btn">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            <?php endif; ?>

            <h6>@<?= htmlspecialchars($post['username']) ?> <span class="time-ago">&bull; <?= timeAgo($post['created_at']) ?></span></h6>
            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

            <?php if (!empty($post['image'])): ?>
                <img src="../uploads/posts/<?= htmlspecialchars($post['image']) ?>" alt="Post Image" class="img-fluid rounded mb-2">
            <?php endif; ?>

            <div class="interaction-bar">
                <form action="../posts/like_post.php" method="POST" class="d-inline">
                    <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                    <button type="submit" class="btn btn-sm btn-outline-light">
                        <i class="<?= $liked ? 'fa-solid text-danger' : 'fa-regular' ?> fa-heart"></i> <?= $post['like_count'] ?>
                    </button>
                </form>

                <button class="comment-toggle btn btn-sm btn-outline-info" data-post-id="<?= $post['id'] ?>">
                    <i class="fa-regular fa-comment"></i> <?= $post['comment_count'] ?>
                </button>

                <a href="../posts/comments.php?post_id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-info">Comment</a>
<form action="../posts/report_post.php" method="GET" class="d-inline">
    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
    <button type="submit" class="btn btn-sm btn-outline-warning">
        <i class="fa-solid fa-flag"></i> Report
    </button>
</form>

            </div>

            <div class="comments-section mt-3 d-none" id="comments-<?= $post['id'] ?>">
                <?php $grouped_comments = fetch_and_group_comments($conn, $post['id']); ?>
                <?php display_comments($grouped_comments); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".comment-toggle").forEach(btn => {
        btn.addEventListener("click", async function () {
            const postId = this.dataset.postId;
            const section = document.getElementById("comments-" + postId);

            if (!section.classList.contains("d-none")) {
                section.classList.add("d-none");
                return;
            }

            try {
                const res = await fetch(`../posts/fetch_comment.php?post_id=${postId}&_=${Date.now()}`);
                const html = await res.text();
                section.innerHTML = html;
                section.classList.remove("d-none");
            } catch (err) {
                section.innerHTML = "<p class='text-danger'>Failed to load comments.</p>";
                section.classList.remove("d-none");
            }
        });
    });
});


// document.querySelectorAll(".comment-toggle").forEach(btn => {
//     btn.addEventListener("click", async () => {
//         const postId = btn.dataset.postId;
//         const section = document.getElementById("comments-" + postId);
//         section.classList.toggle("d-none");

//         if (!section.classList.contains("d-none")) {
//             const res = await fetch("../posts/fetch_comment.php?post_id=" + postId);
//             const html = await res.text();
//             section.innerHTML = html;
//         }
//     });
// });

</script>

<?php include "../includes/footer.php"; ?>
</body>
</html>
