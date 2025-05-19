<?php
require_once('../../controllers/userAuth.php');

$billName = $amount = $dueDate = $status = '';
$errors = ['bill_name' => '', 'amount' => '', 'due_date' => '', 'status' => ''];

function isValidBillName($name) {
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $billName = trim($_POST['bill_name']);
    $amount = trim($_POST['amount']);
    $dueDate = trim($_POST['due_date']);
    $status = trim($_POST['status']);

    if ($billName === '') {
        $errors['bill_name'] = 'Bill name is required.';
    } elseif (!isValidBillName($billName)) {
        $errors['bill_name'] = 'Bill name contains invalid characters.';
    }

    if ($amount === '') {
        $errors['amount'] = 'Amount is required.';
    } elseif (!is_numeric($amount) || $amount <= 0) {
        $errors['amount'] = 'Amount must be a positive number.';
    }

    if ($dueDate === '') {
        $errors['due_date'] = 'Due date is required.';
    }

    if ($status === '') {
        $errors['status'] = 'Status is required.';
    }

    if (!array_filter($errors)) {
        // saveBillToDB($billName, $amount, $dueDate, $status);
        header("Location: bill-dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Bill - MoneyMap</title>
    <link rel="stylesheet" href="../../styles/bills/add-bill.css" />
    <link rel="icon" href="../../../public/assets/logo.png" />
</head>
<body>
    <?php include '../header-footer/header.php'; ?>

    <main class="add-bill-container">
        <h1>Add New Bill</h1>

        <form id="add-bill-form" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="bill-form">
            <label for="bill-name"><strong>Bill Name:</strong></label>
            <input type="text" id="bill-name" name="bill_name" value="<?= htmlspecialchars($billName) ?>" />
            <div class="error"><?= $errors['bill_name'] ?></div>

            <label for="amount"><strong>Amount ($):</strong></label>
            <input type="number" id="amount" name="amount" step="0.01" value="<?= htmlspecialchars($amount) ?>" />
            <div class="error"><?= $errors['amount'] ?></div>

            <label for="due-date"><strong>Due Date:</strong></label>
            <input type="date" id="due-date" name="due_date" value="<?= htmlspecialchars($dueDate) ?>" />
            <div class="error"><?= $errors['due_date'] ?></div>

            <label for="status"><strong>Status:</strong></label>
            <select id="status" name="status">
                <option value="">-- Select Status --</option>
                <option value="Paid" <?= $status === 'Paid' ? 'selected' : '' ?>>Paid</option>
                <option value="Due" <?= $status === 'Due' ? 'selected' : '' ?>>Due</option>
            </select>
            <div class="error"><?= $errors['status'] ?></div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">Add Bill</button>
                <a href="bill-dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php'; ?>
    <script src="../../validation/bills/add-bill.js"></script>
</body>
</html>
