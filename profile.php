<?php
session_start();
require_once "../includes/auth.php";
require_once "../includes/functions.php";
require_once "../includes/db.php";

$loggedInUserId = $_SESSION['user_id'];
$profileId = isset($_GET['id']) ? (int) $_GET['id'] : $loggedInUserId;
$isOwnProfile = ($loggedInUserId === $profileId);

// Fetch user info
$stmt = $conn->prepare("SELECT username, name, profile_pic, bio FROM users WHERE id = ?");
$stmt->execute([$profileId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    set_flash('error', 'User not found.');
    header("Location: dashboard.php");
    exit;
}

// Defaults
$user['name'] = $user['name'] ?? 'No Name Yet';
$user['bio'] = $user['bio'] ?? 'No bio provided';
$user['profile_pic'] = $user['profile_pic'] ?? 'default.png';

// Count followers, following, posts
$followers = $conn->prepare("SELECT COUNT(*) FROM follows WHERE followed_id = ?");
$followers->execute([$profileId]);
$followerCount = $followers->fetchColumn();

$following = $conn->prepare("SELECT COUNT(*) FROM follows WHERE follower_id = ?");
$following->execute([$profileId]);
$followingCount = $following->fetchColumn();

$posts = $conn->prepare("SELECT COUNT(*) FROM posts WHERE user_id = ?");
$posts->execute([$profileId]);
$postCount = $posts->fetchColumn();

// Fetch posts for gallery
$stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$profileId]);
$userPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BuzzConnect – Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f3460;
            color: #fff;
        }
        .profile-container {
            max-width: 700px;
            margin: 30px auto;
        }
        .profile-card {
            background-color: #16213e;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
        }
        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #00adb5;
            margin-bottom: 1rem;
        }
        .profile-card h4 {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }
        .profile-card p {
            color: #aaa;
            font-size: 0.9rem;
        }
        .edit-btn {
            margin-top: 1rem;
            border-radius: 30px;
            font-weight: 600;
        }
        .gallery img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<?php include "../includes/header.php"; ?>

<div class="profile-container">

    <!-- Flash messages -->
    <?php if ($msg = get_flash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $msg ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($msg = get_flash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $msg ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Profile Card -->
    <div class="profile-card">
        <img src="../uploads/<?= htmlspecialchars($user['profile_pic']) ?>" alt="Profile Picture" class="profile-img">
        <h4><?= htmlspecialchars($user['name']) ?></h4>
        <p>@<?= htmlspecialchars($user['username']) ?></p>
        <p><?= htmlspecialchars($user['bio']) ?></p>

        <!-- Stats -->
        <div class="d-flex justify-content-around text-center mt-3">
            <div>
                <h5><?= $postCount ?></h5>
                <p>Posts</p>
            </div>
            <div>
                <h5><?= $followerCount ?></h5>
                <p>Followers</p>
            </div>
            <div>
                <h5><?= $followingCount ?></h5>
                <p>Following</p>
            </div>
        </div>

        <!-- Buttons -->
        <?php if ($isOwnProfile): ?>
            <a href="edit_profile.php" class="btn btn-outline-info edit-btn">Edit Profile</a>
        <?php else: ?>
            <button type="button" class="btn btn-outline-success edit-btn follow-btn" data-user="<?= $profileId ?>">➕ Follow</button>
        <?php endif; ?>
    </div>

    <!-- Post Gallery -->
    <?php if (count($userPosts) > 0): ?>
        <div class="gallery container mt-4">
            <div class="row">
                <?php foreach ($userPosts as $post): ?>
                    <div class="col-4 mb-3">
                        <?php if (!empty($post['image'])): ?>
                            <img src="../uploads/posts/<?= htmlspecialchars($post['image']) ?>" class="img-fluid rounded shadow" />
                        <?php else: ?>
                            <div class="bg-dark text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                <small>No Image</small>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center mt-4">
            <p class="text-muted">No posts yet.</p>
        </div>
    <?php endif; ?>

</div>

<?php include "../includes/footer.php"; ?>
<script src="./assets/js/follow.js"></script>
</body>
</html>
