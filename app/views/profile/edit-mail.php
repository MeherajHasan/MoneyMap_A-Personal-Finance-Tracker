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
    <title>Edit Email</title>
    <link rel="stylesheet" href="../../styles/profile/edit-mail.css">
    <link rel="icon" href="../../../public/assets/logo.png">
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>

    <main>
        <h1>Edit Email</h1>
        <form id="edit-mail" action="" method="post" onsubmit="return false;">
            <p><strong>Current Email: </strong> <span id="current-email"></span></p>

            <label for="email"><strong>New Email: </strong></label>
            <input type="email" id="email" name="email" class="email">
            
            <p id="errorMSG"></p>
            
            <button type="button" class="btn" id="save-btn">Save</button>
            <button type="button" class="btn" id="cancel-btn">Cancel</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 <a id="about" href="../../views/landing/about.html">MoneyMap.</a> All rights reserved.</p>
    </footer>

    <script src="../../validation/profile/edit-mail.js"></script>
</body>

</html>
