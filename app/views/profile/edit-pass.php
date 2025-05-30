<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/userModel.php');

$errorMSG = '';
$successMSG = '';

$actualCurrentPassword = $_SESSION['user']['password'];  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $errorMSG = "All fields are required.";
    } elseif (!password_verify($currentPassword, $actualCurrentPassword)) {
        $errorMSG = "Current password is incorrect.";
    } elseif (strlen($newPassword) < 8) {
        $errorMSG = "New password must be at least 8 characters long.";
    } elseif ($newPassword !== $confirmPassword) {
        $errorMSG = "New password and confirm password do not match.";
    } else {
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $passwordUpdate = updateUserPassword($_SESSION['user'], $hashedNewPassword);
        if ($passwordUpdate) { 
            $successMSG = "Password changed successfully."; 
            $_POST = [];
            $_SESSION['user']['password'] = $hashedNewPassword;
            header("Location: profile.php");
            exit();
        } else {
            $errorMSG = "Failed to change password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Password</title>
    <link rel="stylesheet" href="../../styles/profile/edit-pass.css" />
    <link rel="icon" href="../../../public/assets/logo.png" />
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo" />
    </header>

    <main>
        <h1>Edit Password</h1>
        <form id="edit-password" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="current-password"><strong>Current Password:</strong></label>
            <input type="password" id="current-password" name="current-password" class="password" value="" />
            <br />

            <label for="new-password"><strong>New Password:</strong></label>
            <input type="password" id="new-password" name="new-password" class="password" value="" />
            <br />

            <label for="confirm-password"><strong>Confirm New Password:</strong></label>
            <input type="password" id="confirm-password" name="confirm-password" class="password" value="" />
            <br />

            <p id="errorMSG" style="color:red;"><?= $errorMSG; ?></p>
            <p id="successMSG" style="color:green;"><?= $successMSG; ?></p>

            <div class="btn-container">
                <button type="submit" class="btn" id="save-btn">Save</button>
                <button type="button" class="btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php'; ?>

    <script src="../../validation/profile/edit-pass.js"></script>
</body>

</html>
