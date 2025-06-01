<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/billModel.php');

$billID = $_GET['id'] ?? null;

$currentBill = getBillById($billID);

if (!$currentBill || $currentBill['user_id'] != $_SESSION['user']['id']) {
    echo "Invalid Bill ID or unauthorized access.";
    exit();
}

$billName = $currentBill['bill_name'];
$billAmount = $currentBill['amount'];
$billDueDate = $currentBill['payment_date'];
$billStatus = $currentBill['status'] === 0 ? 'Paid' : 'Due';
$billStatusInput = "";
$nameError = "";
$amountError = "";
$dateError = "";
$statusError = "";
$noChangeError = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $billName = trim($_POST['bill_name'] ?? '');
    $billAmount = trim($_POST['amount'] ?? '');
    $billDueDate = trim($_POST['due_date'] ?? '');
    $billStatusInput = trim($_POST['status'] ?? '');
    if ($billStatusInput === 'Paid' || $billStatusInput === 'Due') {
        $billStatus = $billStatusInput;
    } else {
        $billStatus = $currentBill['status'] === 0 ? 'Paid' : 'Due';
    }

    $hasError = false;

    if ($billName === "") {
        $nameError = "Bill name cannot be empty.";
        $hasError = true;
    } else {
        for ($i = 0; $i < strlen($billName); $i++) {
            $c = $billName[$i];
            if (!(($c >= 'a' && $c <= 'z') || ($c >= 'A' && $c <= 'Z') || ($c >= '0' && $c <= '9') || $c === ' ' || $c === '.' || $c === ',' || $c === '-')) {
                $nameError = "Bill name contains invalid characters.";
                $hasError = true;
                break;
            }
        }
    }

    if ($billAmount === "") {
        $amountError = "Amount is required.";
        $hasError = true;
    } elseif (!is_numeric($billAmount) || floatval($billAmount) <= 0) {
        $amountError = "Amount must be a positive number.";
        $hasError = true;
    }

    if ($billDueDate === "") {
        $dateError = "Due date is required.";
        $hasError = true;
    }

    if (!in_array($billStatus, ['Paid', 'Due'])) {
        $statusError = "Status must be either Paid or Due.";
        $hasError = true;
    }

    if (
        !$hasError &&
        $billName === $currentBill['bill_name'] &&
        floatval($billAmount) == $currentBill['amount'] &&
        $billDueDate === $currentBill['payment_date'] &&
        $billStatus === ($currentBill['status'] == 0 ? 'Paid' : 'Due')
    ) { 
        $noChangeError = "Please change at least one field before submitting.";
        $hasError = true;
    }

    if (!$hasError) {
        $statusValue = $billStatus === 'Paid' ? 0 : 1;

        $expenseID = $currentBill['expense_id']; 
        $note = "Updated via Bill Edit";  

        $updated = updateBill($billID, $_SESSION['user']['id'], $billName, floatval($billAmount), $billDueDate, $statusValue, $expenseID, $note);
        if ($updated) {
            header("Location: bill-dashboard.php");
            exit;
        } else {
            $noChangeError = "Failed to update bill. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Edit Bill</title>
    <link rel="stylesheet" href="../../styles/bills/edit-bill.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Edit Bill</h2>
        </div>

        <section class="current-bill-info">
            <h3>Current Bill Info</h3>
            <p><strong>Name:</strong> <?= $currentBill['bill_name'] ?></p>
            <p><strong>Amount:</strong> $<?= number_format($currentBill['amount'], 2) ?></p>
            <p><strong>Due Date:</strong> <?= $currentBill['payment_date'] ?></p>
            <p><strong>Status:</strong> <?= $currentBill['status'] == 0 ? 'Paid' : 'Due' ?></p>
        </section>

        <form action="<?= $_SERVER['PHP_SELF'] . '?id=' . urlencode($billID) ?>" method="POST">
            <label for="bill-name">Bill Name:</label>
            <input type="text" id="bill-name" name="bill_name" value="<?= $billName ?>" />
            <div class="error"><?= $nameError ?></div>

            <label for="amount">Amount ($):</label>
            <input type="number" id="amount" name="amount" step="0.01" value="<?= $billAmount ?>" />
            <div class="error"><?= $amountError ?></div>

            <label for="due-date">Due Date:</label>
            <input type="date" id="due-date" name="due_date" value="<?= $billDueDate ?>" />
            <div class="error"><?= $dateError ?></div>

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="" disabled>-- Select Status --</option>
                <?php
                $selectedStatus = $_SERVER["REQUEST_METHOD"] === "POST" ? $billStatusInput : ($currentBill['status'] == 0 ? 'Paid' : 'Due');
                ?>
                <option value="Paid" <?= $selectedStatus === 'Paid' ? 'selected' : '' ?>>Paid</option>
                <option value="Due" <?= $selectedStatus === 'Due' ? 'selected' : '' ?>>Due</option>

            </select>


            <div class="error"><?= $statusError ?></div>

            <div class="error" style="margin-top: 10px; color: red;"><?= $noChangeError ?></div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="bill-dashboard.php" class="btn btn-secondary">Cancel</a>
            </div> 
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>
    <script src="../../validation/bills/edit-bill.js"></script>
</body>

</html>