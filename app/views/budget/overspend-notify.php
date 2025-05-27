<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/budgetModel.php')
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMap || Budget Overspent!</title>
    <link rel="stylesheet" href="../../styles/budget/overspend-notify.css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="notification-container">
            <div class="notification warning">
                <h2>Budget Overspent!</h2>
                <p id="overspent-message">You have exceeded your budget this month in the following categories:</p>
                <ul id="overspent-categories">
                    <?php
                    $overspentCategories = getOverspentCategoriesByUser($_SESSION['user']['id']);
                    foreach ($overspentCategories as $cat) {
                        echo '<li>' . $cat . '</li>';
                    }
                    ?>
                </ul>

                <p><a href="budget-report.php">Review your Budget Report for details.</a></p>
                <button id="acknowledge-btn">Okay</button>
            </div>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/budget/overspend-notify.js"></script>
</body>

</html>