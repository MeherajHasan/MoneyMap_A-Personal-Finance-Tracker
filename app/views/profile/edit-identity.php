<?php
require_once('../../controllers/userAuth.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Identity</title>
    <link rel="stylesheet" href="../../styles/profile/edit-identity.css">
    <link rel="icon" href="../../../public/assets/logo.png">
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>

    <main>
        <h1>Edit Identity</h1>
        <form id="edit-identity" action="" method="post" onsubmit="return false;">
            <p><strong>Current Identity Type: </strong> <span id="current-idType"></span></p>
            <p><strong>Current ID Number: </strong> <span id="current-idNumber"></span></p>

            <label for="id-type"><strong>New Identity Type: </strong></label>
            <select id="id-type" name="id-type" class="id-type">
                <option value="" selected disabled>--Select A Type--</option>
                <option value="NID">NID</option>
                <option value="Passport">Passport</option>
            </select>
            <br><br>

            <label for="id-number"><strong>New ID Number: </strong></label>
            <input type="text" id="id-number" name="id-number" class="id-number">

            <div id="passport-expiry" style="display: none;">
                <label for="passport-expiry-date"><strong>Passport Expiry Date: </strong></label>
                <input type="date" id="passport-expiry-date" name="passport-expiry-date">
            </div>

            <p id="errorMSG"></p>

            <div class="btn-container">
                <button type="button" class="btn" id="save-btn">Save</button>
                <button type="button" class="btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/profile/edit-identity.js"></script>
</body>

</html>