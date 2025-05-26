<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/savingsModel.php');
require_once('../../models/savings_transactionsModel.php');

$savingsID = $_POST['savingsID'] ?? ($_GET['id'] ?? null);
// var_dump($savingsID);

$goalName = $transactionDate = $notes = $amount = "";
$targetAmount = $savedAmount = $maxToSave = 0;
$amountError = $dateError = "";
$hasError = false;

if ($savingsID !== null) {
    $saving = getSavingsById((int)$savingsID);

    //var_dump($savingsID,$saving);

    if ($saving) {
        $goalName = $saving['goal_name'];
        $targetAmount = $saving['target_amount'];
        $savedAmount = $saving['saved_amount'];
        $maxToSave = $targetAmount - $savedAmount;
    } 
}
else {
    echo "<script>alert('No savings ID provided.'); </script>";
    header("Location: savings-dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $savingsID = $_POST['savingsID'] ?? null;

    //var_dump($savingsID);

    if (empty($_POST["amount"])) {
        $amountError = "Please enter an amount.";
        $hasError = true;
    } elseif ($_POST["amount"] <= 0) {
        $amountError = "Amount must be greater than zero.";
        $hasError = true;
    } else {
        $amount = $_POST["amount"];
        if ($amount > $maxToSave) {
            $amountError = "Amount exceeds the maximum allowed to save.";
            $hasError = true;
        }
    }

    if (empty($_POST["transactionDate"])) {
        $dateError = "Please select a date.";
        $hasError = true;
    } else {
        $transactionDate = $_POST["transactionDate"];
    }

    if (!$hasError) {
        $notes = $_POST["notes"] ?? "";

        $success = addSavingsTransaction($savingsID, $amount, $transactionDate, $notes);

        if ($success) {
            $statusUpdate = updateCompleteStatus($savingsID);
            if ($statusUpdate) {
                header("Location: savings-dashboard.php?success=1");
                exit();
            } else {
                echo "<script>alert('Failed to update savings status. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Failed to add transaction. Please try again.');</script>";
        }
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
            <form id="addMoneyForm" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                <input type="hidden" name="savingsID" value="<?= $savingsID; ?>">

                <div class="form-group">
                    <label for="goalNameDisplay">Selected Goal:</label>
                    <input type="text" id="goalNameDisplay" class="form-control" value="<?= $goalName ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="targetAmount">Target Amount:</label>
                    <input type="number" id="targetAmount" class="form-control" value="<?= number_format($targetAmount, 2, '.', '') ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="savedAmount">Saved Amount:</label>
                    <input type="number" id="savedAmount" class="form-control" value="<?= number_format($savedAmount, 2, '.', '') ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="amountToSave">Maximum Amount to Save:</label>
                    <input type="number" id="amountToSave" class="form-control" value="<?= number_format($maxToSave, 2, '.', '') ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="amount">Amount to Add:</label>
                    <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount" value="<?= $amount ?>" <?= $maxToSave == 0 ? 'readonly' : '' ?>>
                    <p class="errorMSG"><?= $amountError ?></p>
                </div>

                <div class="form-group">
                    <label for="transactionDate">Transaction Date:</label>
                    <input type="date" id="transactionDate" name="transactionDate" class="form-control" value="<?= $transactionDate ?>">
                    <p class="errorMSG"><?= $dateError ?></p>
                </div>

                <div class="form-group">
                    <label for="notes">Notes (Optional):</label>
                    <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Add any notes about this transaction"><?= $notes ?></textarea>
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