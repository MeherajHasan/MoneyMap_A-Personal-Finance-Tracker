<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/savingsModel.php');

$savingsId = $name = $amount = $targetDate = $currentAmount = $notes = "";
$nameError = $amountError = $dateError = $currentAmountError = $emptyError = "";

$savingsId = $_GET['id'] ?? null;
//var_dump($savingsId);
$currentData = null;

function isValidBillName($name)
{
    for ($i = 0; $i < strlen($name); $i++) {
        $char = $name[$i];
        if (!(($char >= 'a' && $char <= 'z') ||
            ($char >= 'A' && $char <= 'Z') ||
            ($char >= '0' && $char <= '9') ||
            $char === ' ' || $char === '.' || $char === ',' || $char === '-')) {
            return false;
        }
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    if ($savingsId) {
        $currentData = getSavingsById($savingsId);
        if ($currentData) {
            $name = $currentData['goal_name'];
            $amount = $currentData['target_amount'];
            $targetDate = $currentData['target_date'];
            $currentAmount = $currentData['saved_amount'];
            $notes = $currentData['note'] ?? '';
        } else {
            echo "Invalid savings ID.";
            exit;
        }
    } else {
        echo "No savings ID specified.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $savingsId = $_POST["savingsId"] ?? null;
    $name = trim($_POST["savingsGoalName"]);
    $amount = trim($_POST["savingsAmount"]);
    $targetDate = $_POST["savingsTargetDate"];
    $currentAmount = trim($_POST["savingsCurrentAmount"]);
    $notes = trim($_POST["savingsNotes"]);

    $isValid = true;

    if ($name === "") {
        $nameError = "Goal name is required.";
        $isValid = false;
    } elseif (!isValidBillName($name)) {
        $nameError = "Only letters, digits, spaces, ., , and - are allowed.";
        $isValid = false;
    }

    if ($amount === "") {
        $amountError = "Amount is required.";
        $isValid = false;
    } elseif (!is_numeric($amount) || floatval($amount) <= 0) {
        $amountError = "Enter a valid amount greater than 0.";
        $isValid = false;
    }

    if ($targetDate === "") {
        $dateError = "Target date is required.";
        $isValid = false;
    }

    if ($currentAmount === "") {
        $currentAmountError = "Current amount is required.";
        $isValid = false;
    } elseif (!is_numeric($currentAmount) || floatval($currentAmount) < 0) {
        $currentAmountError = "Enter a valid non-negative amount.";
        $isValid = false;
    }

    if (!$isValid) {
        $emptyError = "Please fix the errors above.";
    } else {
        $userId = $_SESSION['user']['id'] ?? null;
        //var_dump($userId, $savingsId, $name, $amount, $targetDate, $currentAmount, $notes);

        if ($savingsId && $userId) {
            $updateSuccess = updateSavings($savingsId, $userId, $name, $amount, $targetDate, $currentAmount, $notes);

            if ($updateSuccess) {
                
                if ($currentAmount >= $amount) {
                    $updateStatus = updateCompleteStatus($savingsId);
                    if ($updateStatus) {
                        header("Location: savings-dashboard.php");
                        exit; 
                    } else {
                        $emptyError = "Failed to update savings status. Please try again.";
                    }
                } else {
                    $reverseStatus = reverseCompleteStatus($savingsId);
                    if ($reverseStatus) {
                        header("Location: savings-dashboard.php");
                        exit;
                    } else {
                        $emptyError = "Failed to update savings status. Please try again.";
                    }
                }
            } else {
                $emptyError = "Failed to update savings. Please try again.";
            }
        } else {
            $emptyError = "Invalid request. Missing savings ID or user session.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Edit Savings</title>
    <link rel="stylesheet" href="../../styles/savings/edit-savings.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Edit Savings Goal</h2>
        </div>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="savings-form two-column-form">
            <input type="hidden" name="savingsId" value="<?= $savingsId; ?>"> 
            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Goal Name</label>
                    <input type="text" value="<?= $currentData['goal_name'] ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="savingsGoalName">New Goal Name</label>
                    <input type="text" id="savingsGoalName" name="savingsGoalName" value="<?= $name ?>" />
                    <p id="nameError" class="error-message"><?= $nameError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Amount</label>
                    <input type="text" value="<?= $currentData['target_amount'] ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="savingsAmount">New Amount</label>
                    <input type="number" id="savingsAmount" name="savingsAmount" value="<?= $amount ?>" placeholder="Amount in $" />
                    <p id="amountError" class="error-message"><?= $amountError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Target Date</label>
                    <input type="text" value="<?= $currentData['target_date'] ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="savingsTargetDate">New Target Date</label>
                    <input type="date" id="savingsTargetDate" name="savingsTargetDate" value="<?= $targetDate ?>" />
                    <p id="dateError" class="error-message"><?= $dateError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Current Savings</label>
                    <input type="text" value="<?= $currentData['saved_amount'] ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="savingsCurrentAmount">New Current Savings</label>
                    <input type="number" id="savingsCurrentAmount" name="savingsCurrentAmount" value="<?= $currentAmount ?>" />
                    <p id="currentAmountError" class="error-message"><?= $currentAmountError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Notes</label>
                    <textarea readonly><?= $currentData['note'] ?? 'No notes provided.' ?></textarea>
                </div>
                <div class="form-column">
                    <label for="savingsNotes">New Notes</label>
                    <textarea id="savingsNotes" name="savingsNotes"><?= $notes ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Savings Goal</button>
            <p id="emptyError" class="error-message"><?= $emptyError ?></p>

            <div class="navigation-buttons">
                <a href="savings-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="add-savings.php" class="btn btn-secondary">Add New Savings Goal</a>
                <a href="savings-report.php" class="btn btn-secondary">View Savings Report</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>
    <script src="../../scripts/savings/edit-savings.js"></script>
</body>

</html>