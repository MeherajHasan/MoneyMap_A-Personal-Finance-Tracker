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
    <title>MoneyMap || Add New Savings Goal</title>
    <link rel="stylesheet" href="../../styles/savings/add-savings.css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="form-container">
            <h2>Add New Savings Goal</h2>
            <form id="add-savings-form">
                <div class="form-group">
                    <label for="goal-name">Goal Name</label>
                    <input type="text" id="goal-name" name="goal-name" placeholder="Enter goal name">
                    <p id="nameError" class="errorMSG"></p>
                </div>
                <div class="form-group">
                    <label for="target-amount">Target Amount</label>
                    <input type="number" id="target-amount" name="target-amount" placeholder="Enter target amount">
                    <p id="amountError" class="errorMSG"></p>
                </div>
                <div class="form-group">
                    <label for="target-date">Target Date</label>
                    <input type="date" id="target-date" name="target-date">
                    <p id="dateError" class="errorMSG"></p>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Enter a description (optional)"></textarea>
                    <p id="emptyError" class="errorMSG"></p>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Goal</button>
                </div>
            </form>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/savings/add-savings.js"></script>
</body>

</html>
