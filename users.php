<?php
session_start();
$require_admin = true; // 🔒 Only admins allowed here
require_once "../includes/auth.php";
require_once "../includes/functions.php";
require_once "../includes/db.php";

// Fetch all users
$stmt = $conn->prepare("SELECT id, fullname, username, email, role, created_at FROM users ORDER BY created_at DESC");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BuzzConnect – Manage Users</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #0f3460;
      color: #fff;
    }

    .table-dark th, .table-dark td {
      vertical-align: middle;
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
  <h2 class="mb-4 text-center">Manage Users 👥</h2>

  <table class="table table-dark table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Registered</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= $user['id'] ?></td>
          <td><?= htmlspecialchars($user['fullname']) ?></td>
          <td>@<?= htmlspecialchars($user['username']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><span class="badge bg-<?= $user['role'] === 'admin' ? 'info' : 'secondary' ?>"><?= $user['role'] ?></span></td>
          <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
          <td>
            <form action="delete_user.php" method="POST" onsubmit="return confirm('Are you sure to delete this user?');">
              <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
              <button type="submit" class="btn btn-sm btn-delete">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>
