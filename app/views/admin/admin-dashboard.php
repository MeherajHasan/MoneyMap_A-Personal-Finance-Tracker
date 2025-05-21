<?php
require_once('../../controllers/adminAuth.php');
require_once('../../models/userModel.php');

$photoPath = $_SESSION['user']['photo_path'];
$profileImage = (!empty($photoPath) && file_exists("../{$photoPath}")) 
    ? "../{$photoPath}" : "../../../public/assets/profile.png";

$fname = strtoupper($_SESSION['user']['fname']);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../styles/admin/admin-dashboard.css" type="text/css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon">
</head>
<body>
    <div class="dashboard-container">

        <nav class="sidebar">
            <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
            <ul class="nav-menu">
                <li><a href="user-management.php"><img class="menu-icon" src="../../../public/assets/users.png" alt="users-icon">User Management</a></li>
                <li><a href="category-management.php"><img class="menu-icon" src="../../../public/assets/category.png" alt="category-icon">Category Management</a></li>
                <li><a href="data-oversight.php"><img class="menu-icon" src="../../../public/assets/data-oversight.png" alt="data-icon">Data Oversight</a></li>
                <li><a href="contact-response.php"><img class="menu-icon" src="../../../public/assets/contact.png" alt="contact-icon">Contact Responses</a></li>
                <li><a href="backup.php"><img class="menu-icon" src="../../../public/assets/export.png" alt="backup-icon">Data Export</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="dashboard-header">
                <div class="header-right">
                    <button class="navigation-btn" id="profileBtn"><img id="profile-img" src="<?= $profileImage ?>" alt="admin-profile-img"></button>
                    <button class="navigation-btn" id="notificationBtn"><img id="notification-icon" src="../../../public/assets/notification-white.png" alt="notification-icon"></button>
                    <a href="../../controllers/logout.php" class="navigation-btn" id="logoutBtn"><img id="logout-icon" src="../../../public/assets/logout.png" alt="logout-icon"></a>
                </div>
            </header>

            <section class="dashboard-widgets">
                <h1>Welcome, <?= $fname ?>!</h1>
                <p>Manage the Money Map platform using the controls below.</p>

                <div class="widget" id="total-users-widget">
                    <h2 class="widget-title">Total Users</h2>
                    <p class="widget-amount" id="user-count"><?= getTotalUsers() ?></p>
                    <button class="widget-action-btn" onclick="window.location.href='user-management.php'">View Users</button>
                </div>

                <div class="widget" id="categories-widget">
                    <h2 class="widget-title">Categories</h2>
                    <p class="widget-amount" id="category-count">--</p>
                    <button class="widget-action-btn" onclick="window.location.href='category-management.php'">Manage Categories</button>
                </div>

                <div class="widget" id="transactions-widget">
                    <h2 class="widget-title">Data Oversight</h2>
                    <p class="widget-amount" id="transaction-count">--</p>
                    <button class="widget-action-btn" onclick="window.location.href='data-oversight.php'">View Data</button>
                </div>

                <div class="widget" id="backup-widget">
                    <h2 class="widget-title">Backup & Export</h2>
                    <p class="widget-amount">Ready</p>
                    <button class="widget-action-btn" onclick="window.location.href='backup.php'">Go to Backup</button>
                </div>

                <div class="widget" id="feedback-widget">
                    <h2 class="widget-title">Contact Responses</h2>
                    <p class="widget-amount" id="message-count">--</p>
                    <button class="widget-action-btn" onclick="window.location.href='contact-response.php'">Respond Now</button>
                </div>

            </section>
        </main>
    </div>

    <?php include '../header-footer/admin-footer.php' ?>

    <script src="../../validation/admin/admin-dashboard.js"></script>
</body>
</html>
