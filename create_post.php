<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/auth.php";
require_once "../includes/functions.php";

// Handle POST (form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $content = trim($_POST['content']);

    // Image handling
    $imageName = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../uploads/posts/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $imageTmp = $_FILES['image']['tmp_name'];
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        move_uploaded_file($imageTmp, $imagePath);
    }

    // Save to DB
    $stmt = $conn->prepare("INSERT INTO posts (user_id, content, image, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$userId, $content, $imageName]);

    set_flash('success', 'Your buzz is live! 🐝');
    header("Location: ../users/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post – BuzzConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Isolated styles for the create post page */
        .create-post-body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f3460;
            color: #fff;
        }
        .post-container {
            max-width: 700px;
            margin: 100px auto 30px; /* Adjusted to account for header */
        }
        .post-box {
            background-color: #16213e;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
        }
        .create-post-form .form-control, 
        .create-post-form .form-control:focus {
            background-color: #1a1a2e;
            border: 1px solid #00adb5;
            color: #fff;
            box-shadow: none;
        }
        .btn-post.w-100 {
            background-color: #00adb5;
            color: #fff;
            font-weight: 600;
            border-radius: 30px;
            border: none;
            transition: 0.3s;
        }
        .btn-post:hover {
            background-color: #008891;
            color: #fff;
        }
        .img-preview {
            max-width: 100%;
            max-height: 250px;
            margin-top: 1rem;
            border-radius: 12px;
            display: none;
        }
    </style>
    <script>
        function previewImage(event) {
            const preview = document.getElementById('img-preview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</head>
<body class="create-post-body">

<?php include "../includes/header.php"; ?>

<div class="post-container">
    <div class="post-box">
        <h3 class="mb-4 text-center">Create a Buzz 🐝</h3>
        <form action="create_post.php" method="POST" enctype="multipart/form-data" class="create-post-form">
            <div class="mb-3">
                <label class="form-label">What's on your mind?</label>
                <?php if (isset($_GET['content'])): ?>
                    <textarea name="content" rows="4" class="form-control" placeholder="Type something awesome..." required><?= htmlspecialchars($_GET['content']) ?></textarea>
                <?php else: ?>
                    <textarea name="content" rows="4" class="form-control" placeholder="Type something awesome..." required></textarea>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Add an Image (optional)</label>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                <img id="img-preview" class="img-preview" alt="Image Preview">
            </div>
            <button type="submit" class="btn btn-post w-100">Post It 🚀</button>
        </form>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>