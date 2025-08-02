<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/functions.php";
$is_logged_in = isset($_SESSION['user_id']);
$is_admin = ($is_logged_in && isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
?>

<nav class="navbar navbar-expand-lg shadow-sm border-bottom border-info rounded-bottom sticky-top" style="background-color: #1a1a2e;">
    <div class="container">
        <a class="navbar-brand text-light fw-bold" href="<?= $is_admin ? '../admin/dashboard.php' : '../users/dashboard.php' ?>">
            BuzzConnect 🐝
        </a>
        <?php if ($is_logged_in): ?>
            <div class="ms-auto d-flex align-items-center">
                <ul class="navbar-nav me-3">
                    <?php if ($is_admin): ?>
                        <li class="nav-item"><a class="nav-link text-light" href="../admin/dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="../admin/users.php">Users</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="../admin/posts.php">Posts</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="../admin/reports.php">Reports</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link text-light" href="../users/dashboard.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="../users/profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="../users/search.php">Search</a></li>

                        <!-- 🔔 Notification Icon -->
                        <li class="nav-item position-relative">
                            <a class="nav-link text-light" href="javascript:void(0);" id="notifIcon">
                                <i class="fa-solid fa-bell"></i>
                                <span id="notifCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                                    !
                                </span>
                            </a>
                            <div id="notifDropdown"
                                 class="d-none position-absolute end-0 bg-dark text-light rounded p-3 shadow"
                                 style="width: 320px; max-height: 400px; overflow-y: auto; z-index: 1000;">
                                <!-- Notifications will be loaded here -->
                            </div>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link text-light" href="../auth/logout.php">Logout</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</nav>
