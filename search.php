<?php
session_start();
require_once "../includes/auth.php";
require_once "../includes/db.php";
require_once "../includes/functions.php";

$searchResults = [];
$query = '';

if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    if ($query !== '') {
        $stmt = $conn->prepare("SELECT id, name, username, bio, profile_pic FROM users WHERE (name LIKE ? OR username LIKE ?) AND id != ? LIMIT 20");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm, $_SESSION['user_id']]);
        $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BuzzConnect – Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f3460;
            color: #fff;
        }

        .search-container {
            max-width: 700px;
            margin: 40px auto;
        }

        .search-box {
            background-color: #16213e;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
        }

        .search-box input {
            background-color: #0f3460;
            border: none;
            color: #fff;
        }

        .search-box input:focus {
            border: 1px solid #00adb5;
            box-shadow: none;
        }

        .user-result {
            display: flex;
            align-items: center;
            background-color: #1a1a2e;
            padding: 1rem;
            border-radius: 15px;
            margin-top: 1rem;
            transition: all 0.2s ease;
        }

        .user-result:hover {
            background-color: #212529;
        }

        .user-result img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
            border: 2px solid #00adb5;
        }

        .user-info h6 {
            margin: 0;
            font-weight: 600;
        }

        .user-info p {
            font-size: 0.85rem;
            color: #aaa;
        }
    </style>
</head>
<body>
<?php include "../includes/header.php"; ?>

<!-- SEARCH BOX -->
<div class="search-container">
    <div class="search-box">
        <form action="search.php" method="GET">
            <input type="text" name="query" class="form-control form-control-lg mb-3" placeholder="Search users by name or username..." value="<?= htmlspecialchars($query) ?>" required>
            <button class="btn btn-info w-100">Search</button>
        </form>

        <?php if ($query && empty($searchResults)): ?>
            <p class="text-center mt-4 text-light">No users found for "<?= htmlspecialchars($query) ?>"</p>
        <?php endif; ?>

       <?php foreach ($searchResults as $user): ?>
    <!-- <a href="profile.php?id=<?= $user['id'] ?>" class="text-decoration-none text-white"> -->
       <a href="profile.php?id=<?= $user['id'] ?>" class="text-decoration-none">
    <div class="user-result">
        <img src="../uploads/<?= $user['profile_pic'] ?: 'default.png' ?>" alt="User">
        <div class="user-info">
            <h6><?= htmlspecialchars($user['name']) ?></h6>
            <p>@<?= htmlspecialchars($user['username']) ?> – <?= htmlspecialchars($user['bio']) ?></p>
        </div>
    </div>
</a>

    </a>
<?php endforeach; ?>


    </div>
</div>
<?php include "../includes/footer.php"; ?>
</body>
<script src="../assets/js/follow.js"></script>
</html>
