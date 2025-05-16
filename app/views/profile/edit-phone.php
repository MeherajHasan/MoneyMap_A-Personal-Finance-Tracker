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
    <title>Edit Phone Number</title>
    <link rel="stylesheet" href="../../styles/profile/edit-phone.css">
    <link rel="icon" href="../../../public/assets/logo.png">
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>

    <main>
        <h1>Edit Phone Number</h1>
        <form id="edit-phone" action="" method="post" onsubmit="return false;">
            <p><strong>Current Phone Number: </strong> <span id="current-phone"></span></p>

            <label for="phone"><strong>New Phone Number: </strong></label>
            <input type="tel" id="phone" name="phone" class="phone">

            <p id="errorMSG"></p>

            <div class="btn-container">
                <button type="button" class="btn" id="save-btn">Save</button>
                <button type="button" class="btn" id="cancel-btn">Cancel</button>
            </div>

        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/profile/edit-phone.js"></script>
</body>

</html>