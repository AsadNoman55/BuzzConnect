<?php
session_start();
$require_admin = true;
require_once "../includes/auth.php";
require_once "../includes/functions.php";
require_once "../includes/db.php";

// Fetch all posts with user info
$stmt = $conn->prepare("
    SELECT posts.id, posts.content, posts.created_at, posts.image, users.username 
    FROM posts 
    JOIN users ON posts.user_id = users.id 
    ORDER BY posts.created_at DESC
");
$stmt->execute();
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BuzzConnect – Manage Posts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #0f3460;
      color: #fff;
    }

    .post-card {
      background-color: #1a1a2e;
      padding: 1rem 1.5rem;
      border-radius: 15px;
      margin-bottom: 1.5rem;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    }

    .post-card h6 {
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .post-card p {
      margin-bottom: 0.4rem;
    }

    .btn-delete {
      background-color: #ff4b5c;
      color: #fff;
      font-weight: 600;
    }

    .btn-delete:hover {
      background-color: #d63447;
    }
  </style>
</head>
<body>

<?php include "../includes/header.php"; ?>

<!-- MAIN CONTENT -->
<div class="container mt-5">
  <h2 class="mb-4 text-center">Manage Posts 📝</h2>

  <?php foreach ($posts as $post): ?>
    <div class="post-card">
      <h6>@<?= htmlspecialchars($post['username']) ?> 
        <span class="text-muted" style="font-size: 0.8rem;">• <?= timeAgo($post['created_at']) ?></span>
      </h6>
      <p><?= htmlspecialchars($post['content']) ?></p>

      <?php if (!empty($post['image'])): ?>
        <img src="../uploads/posts/<?= htmlspecialchars($post['image']) ?>" alt="Post Image" class="img-fluid mt-2 rounded">
      <?php endif; ?>

      <form action="delete_post.php" method="POST" class="mt-3" onsubmit="return confirm('Are you sure you want to delete this post?');">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <button type="submit" class="btn btn-sm btn-delete">Delete</button>
      </form>
    </div>
  <?php endforeach; ?>

</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
