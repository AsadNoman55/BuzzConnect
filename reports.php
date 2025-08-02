<?php
session_start();
$require_admin = true;
require_once "../includes/auth.php"; // ✅ Admin-only access
require_once "../includes/functions.php";
require_once "../includes/db.php";

// ✅ Fetch all reports with post + user info
$sql = "SELECT reports.*, users.username AS reporter_name, posts.content AS post_content
        FROM reports
        JOIN users ON reports.reported_by = users.id
        JOIN posts ON reports.post_id = posts.id
        ORDER BY reports.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BuzzConnect Admin – Reports</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #0f3460;
      color: #fff;
    }
    .report-container {
      max-width: 1000px;
      margin: 30px auto;
    }
    .report-card {
      background-color: #16213e;
      padding: 1.5rem;
      border-radius: 15px;
      margin-bottom: 1rem;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
    .report-card h6 {
      font-weight: 600;
    }
    .report-card p {
      font-size: 0.9rem;
    }
    .text-muted {
      color: #aaa !important;
    }
  </style>
</head>
<body>
<?php include "../includes/header.php"; ?>

<div class="report-container">
  <h2 class="mb-4 text-center">Reported Posts 🛑</h2>

  <?php if (empty($reports)): ?>
    <p class="text-center text-muted">No reports yet 🚫</p>
  <?php else: ?>
    <?php foreach ($reports as $report): ?>
      <div class="report-card">
        <h6>Reported by: @<?= htmlspecialchars($report['reporter_name']) ?> <span class="text-muted">on <?= date("M d, Y h:i A", strtotime($report['created_at'])) ?></span></h6>
        <p><strong>Post Content:</strong> <?= htmlspecialchars($report['post_content']) ?></p>
        <p><strong>Reason:</strong> <?= htmlspecialchars($report['reason']) ?: '<em>No reason provided</em>' ?></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
