<?php
    session_start();

    if (!isset($_COOKIE['status'])) {
        header('Location: ../../views/auth/login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Password</title>
    <link rel="stylesheet" href="../../styles/profile/edit-pass.css">
    <link rel="icon" href="../../../public/assets/logo.png">
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>

    <main>
        <h1>Edit Password</h1>
        <form id="edit-password" action="" method="post" onsubmit="return false;">
            <label for="current-password"><strong>Current Password:</strong></label>
            <input type="password" id="current-password" name="current-password" class="password">
            <br>

            <label for="new-password"><strong>New Password:</strong></label>
            <input type="password" id="new-password" name="new-password" class="password">
            <br>

            <label for="confirm-password"><strong>Confirm New Password:</strong></label>
            <input type="password" id="confirm-password" name="confirm-password" class="password">

            <p id="errorMSG"></p>

            <div class="btn-container">
                <button type="button" class="btn" id="save-btn">Save</button>
                <button type="button" class="btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/profile/edit-pass.js"></script>
</body>

</html>
