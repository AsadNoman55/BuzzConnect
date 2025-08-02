<?php
session_start();
require_once "../includes/auth.php";
require_once "../includes/functions.php";
require_once "../includes/db.php";

if (!isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
    die("Invalid post ID.");
}

$post_id = (int) $_GET['post_id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT content FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("Post not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Report Post – BuzzConnect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f3460;
            color: #fff;
        }
  </style>
</head>
<body>

<?php include "../includes/header.php"; ?>

<div class="container mt-5 mb-5" style="max-width: 600px;">
  <h4 class="mb-3 text-light">🚨 Report Post</h4>
  <div class="bg-dark text-light p-4 rounded shadow-sm">
    <p><strong>Post:</strong> <?= htmlspecialchars($post['content']) ?></p>

    <form action="report_submit.php" method="POST">
      <input type="hidden" name="post_id" value="<?= $post_id ?>">

      <div class="mb-3">
        <label for="reason" class="form-label">Reason</label>
        <select name="reason" id="reason" class="form-select" required>
          <option value="">Select a reason</option>
          <option value="Spam">Spam</option>
          <option value="Harassment">Harassment</option>
          <option value="Hate Speech">Hate Speech</option>
          <option value="Sexual Content">Sexual Content</option>
          <option value="Violence or Gore">Violence or Gore</option>
          <option value="Self-Harm or Suicide">Self-Harm or Suicide</option>
          <option value="Misinformation">Misinformation</option>
          <option value="Impersonation">Impersonation</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="details" class="form-label">Details (optional)</label>
        <textarea name="details" id="details" class="form-control" rows="3" placeholder="Add more context..."></textarea>
      </div>

      <button type="submit" class="btn btn-danger">Submit Report</button>
    </form>
  </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
