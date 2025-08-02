<?php
session_start();
require_once "../includes/auth.php";
require_once "../includes/db.php";
require_once "../includes/functions.php";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $userId = $_SESSION['user_id'];
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $bio = trim($_POST['bio']);

    // Profile picture handling
    $profilePic = '';
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $imageTmp = $_FILES['profile_pic']['tmp_name'];
        $profilePic = uniqid() . '_' . basename($_FILES['profile_pic']['name']);
        $imagePath = $uploadDir . $profilePic;

        move_uploaded_file($imageTmp, $imagePath);

        // Update with profile pic
        $stmt = $conn->prepare("UPDATE users SET name = ?, username = ?, bio = ?, profile_pic = ? WHERE id = ?");
        $stmt->execute([$fullname, $username, $bio, $profilePic, $userId]);
    } else {
        // Update without changing profile pic
        $stmt = $conn->prepare("UPDATE users SET name = ?, username = ?, bio = ? WHERE id = ?");
        $stmt->execute([$fullname, $username, $bio, $userId]);
    }

    set_flash('success', 'Profile updated successfully!');
    header("Location: profile.php");
    exit();
}

// Fetch current user data
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$profilePic = $user['profile_pic'] ? '../uploads/' . $user['profile_pic'] : '../uploads/default.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BuzzConnect – Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f3460;
            color: #fff;
        }

        .edit-container {
            max-width: 700px;
            margin: 40px auto;
        }

        .edit-box {
            background-color: #16213e;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
        }

        .form-control, .form-control:focus {
            background-color: #1a1a2e;
            border: none;
            color: #fff;
            border: 1px solid #00adb5;
            box-shadow: none;
        }

        .form-label {
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        .btn-save {
            background-color: #00adb5;
            color: #fff;
            font-weight: 600;
            border-radius: 30px;
        }

        .btn-save:hover {
            background-color: #008891;
        }

        .profile-img-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #00adb5;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<?php include "../includes/header.php"; ?>

<div class="edit-container">
    <div class="edit-box">
        <h3 class="text-center mb-4">Edit Profile</h3>

        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div class="text-center">
                <img src="<?= htmlspecialchars($profilePic) ?>" class="profile-img-preview" alt="Profile Picture">
            </div>
            <div class="mb-3">
                <label class="form-label">Change Profile Picture</label>
                <input type="file" name="profile_pic" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Bio</label>
                <textarea name="bio" rows="3" class="form-control" required><?= htmlspecialchars($user['bio']) ?></textarea>
            </div>

            <button type="submit" name="update" class="btn btn-save w-100">Save Changes</button>
        </form>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
