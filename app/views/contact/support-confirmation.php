<?php
require_once('../../controllers/userAuth.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link rel="stylesheet" href="../../styles/contact/confirmation.css" type="text/css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/png">
</head>

<body>
    <header>
        <div id="moneyMap-logo"><img src="../../../public/assets/logo.png" alt="MoneyMap-logo"></div>
    </header>

    <main class="confirmation">
        <h1>Thank You!</h1>
        <p>Your message has been successfully submitted.</p>
        <img id="check-icon" src="../../../public/assets/check.png" alt="check-icon">
        <div>
            <button id="backToIndex">Back to Main Menu</button>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/contact/support-confirmation.js"></script>

</body>
</html>