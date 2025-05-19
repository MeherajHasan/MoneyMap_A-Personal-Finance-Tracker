<?php
require_once('../../controllers/userAuth.php');

$goalName = $amount = $transactionDate = $notes = "";
$nameError = $amountError = $dateError = "";
$hasError = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["goalName"])) {
        $nameError = "Please select a savings goal.";
        $hasError = true;
    } else {
        $goalName = $_POST["goalName"];
    }

    if (empty($_POST["amount"])) {
        $amountError = "Please enter an amount.";
        $hasError = true;
    } elseif ($_POST["amount"] <= 0) {
        $amountError = "Amount must be greater than zero.";
        $hasError = true;
    } else {
        $amount = $_POST["amount"];
    }

    if (empty($_POST["transactionDate"])) {
        $dateError = "Please select a date.";
        $hasError = true;
    } else {
        $transactionDate = $_POST["transactionDate"];
    }

    if (!$hasError) {
        // db
        header("Location: savings-dashboard.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMap || Add Money</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/savings/add-money.css">
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="add-money-form-container">
            <h2>Add Money to Savings Goal</h2>
            <form id="addMoneyForm" method="POST" action="">
                <div class="form-group">
                    <label for="goalName">Select Goal:</label>
                    <select id="goalName" name="goalName" class="form-control">
                        <option value="" disabled <?= $goalName === "" ? "selected" : "" ?>>Select a Savings Goal</option>
                        <option value="Emergency Fund" <?= $goalName === "Emergency Fund" ? "selected" : "" ?>>Emergency Fund</option>
                        <option value="Vacation" <?= $goalName === "Vacation" ? "selected" : "" ?>>Vacation</option>
                        <option value="Car Savings" <?= $goalName === "Car Savings" ? "selected" : "" ?>>Car Savings</option>
                    </select>
                    <small class="form-text text-muted">Choose the savings goal you want to add money to.</small>
                    <p class="errorMSG"><?= $nameError ?></p>
                </div>

                <div class="form-group">
                    <label for="amount">Amount to Add:</label>
                    <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount" value="<?= htmlspecialchars($amount) ?>">
                    <p class="errorMSG"><?= $amountError ?></p>
                </div>

                <div class="form-group">
                    <label for="transactionDate">Transaction Date:</label>
                    <input type="date" id="transactionDate" name="transactionDate" class="form-control" value="<?= htmlspecialchars($transactionDate) ?>">
                    <p class="errorMSG"><?= $dateError ?></p>
                </div>

                <div class="form-group">
                    <label for="notes">Notes (Optional):</label>
                    <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Add any notes about this transaction"><?= htmlspecialchars($notes) ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">Add Money</button>
                <a href="savings-dashboard.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/savings/add-money.js"></script>
</body>

</html>
