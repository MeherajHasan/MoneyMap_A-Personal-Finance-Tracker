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
    <title>Edit Address</title>
    <link rel="stylesheet" href="../../styles/profile/edit-address.css">
    <link rel="icon" href="../../../public/assets/logo.png">
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>

    <main>
        <h1>Edit Address</h1>
        <form id="edit-address" action="" method="post" onsubmit="return false;">
            <p><strong>Current Address: </strong> <span id="current-address"></span></p>

            <label for="address"><strong>New Address: </strong></label>
            <textarea id="address" name="address" class="address" rows="4"></textarea>

            <p id="errorMSG"></p>

            <div class="btn-container">
                <button type="button" class="btn" id="save-btn">Save</button>
                <button type="button" class="btn" id="cancel-btn">Cancel</button>
            </div>

        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/profile/edit-address.js"></script>
</body>

</html>