<?php
session_start();

if (!isset($_COOKIE['status']) || $_COOKIE['role'] !== 'admin') {
    header('Location: ../../views/auth/login.php');
    exit();
}

// Dummy data (replace with real DB values as needed)
$adminData = [
    'photo' => '../../../public/assets/admin-default.png',
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'phone' => '01234567890',
    'address' => 'Admin Office, Headquarters',
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Profile - MoneyMap</title>
    <link rel="stylesheet" href="../../styles/admin/admin-profile.css" />
    <link rel="icon" href="../../../public/assets/logo.png" />
</head>

<body>
    <?php include '../header-footer/admin-header.php'; ?>

    <main class="profile-container">
        <h1>Admin Profile</h1>

        <form action="../../controllers/admin/updateProfile.php" method="POST" enctype="multipart/form-data" class="profile-form">
            <div class="profile-photo">
                <img id="admin-photo" src="<?= $adminData['photo'] ?>" alt="Admin Photo" />
                <input type="file" name="photo" id="photo" accept="image/*" />
            </div>

            <div class="profile-info">
                <label for="name"><strong>Full Name:</strong></label>
                <input type="text" id="name" name="name" value="<?= $adminData['name'] ?>" />
                <div id="error-name" class="error"></div>

                <label for="email"><strong>Email:</strong></label>
                <input type="email" id="email" name="email" value="<?= $adminData['email'] ?>" />
                <div id="error-email" class="error"></div>

                <label for="phone"><strong>Phone Number:</strong></label>
                <input type="text" id="phone" name="phone" value="<?= $adminData['phone'] ?>" />
                <div id="error-phone" class="error"></div>

                <label for="address"><strong>Address:</strong></label>
                <textarea id="address" name="address" rows="3"><?= $adminData['address'] ?></textarea>

                <label for="password"><strong>New Password:</strong></label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep current" />
                <div id="error-password" class="error"></div>

                <label for="confirm-password"><strong>Confirm Password:</strong></label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Leave blank to keep current" />
                <div id="error-confirm-password" class="error"></div>

                <div id="errorMSG" class="error"></div>

                <div class="form-buttons">
                    <button type="submit" class="save-btn">Save Changes</button>
                    <button type="reset" class="reset-btn">Reset</button>
                </div>
            </div>
        </form>
    </main>

    <?php include '../header-footer/admin-footer.php'; ?>
    <script src="../../validation/admin/admin-profile.js"></script>
</body>
</html>
