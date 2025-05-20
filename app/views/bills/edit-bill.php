<?php
require_once('../../controllers/userAuth.php');

$bills = [
    1 => ['name' => 'Electricity Bill - April', 'amount' => 1200, 'dueDate' => '2025-04-10', 'status' => 'Paid'],
    2 => ['name' => 'Internet Bill - April', 'amount' => 800, 'dueDate' => '2025-04-15', 'status' => 'Due'],
    3 => ['name' => 'Water Bill - April', 'amount' => 400, 'dueDate' => '2025-04-05', 'status' => 'Paid'],
    4 => ['name' => 'Gas Bill - April', 'amount' => 600, 'dueDate' => '2025-04-20', 'status' => 'Due'],
];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id === 0 || !isset($bills[$id])) {
    echo "Invalid Bill ID.";
    exit();
}

$currentBill = $bills[$id];

$errors = [
    'name' => '',
    'amount' => '',
    'due_date' => '',
    'status' => '',
    'no_change' => '',
];

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

$bill_name = $currentBill['name'];
$amount = $currentBill['amount'];
$due_date = $currentBill['dueDate'];
$status = $currentBill['status'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bill_name = isset($_POST['bill_name']) ? trim($_POST['bill_name']) : '';
    $amount = isset($_POST['amount']) ? trim($_POST['amount']) : '';
    $due_date = isset($_POST['due_date']) ? trim($_POST['due_date']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';

    $isValid = true;

    if ($bill_name === '') {
        $errors['name'] = 'Bill name cannot be empty.';
        $isValid = false;
    } elseif (!isValidBillName($bill_name)) {
        $errors['name'] = 'Bill name contains invalid characters.';
        $isValid = false;
    }

    if ($amount === '' || !is_numeric($amount) || floatval($amount) <= 0) {
        $errors['amount'] = 'Amount must be a positive number.';
        $isValid = false;
    }

    if ($due_date === '') {
        $errors['due_date'] = 'Due date must be selected.';
        $isValid = false;
    }

    if ($status !== 'Paid' && $status !== 'Due') {
        $errors['status'] = 'Status must be either Paid or Due.';
        $isValid = false;
    }

    if ($bill_name === $currentBill['name'] &&
        floatval($amount) == $currentBill['amount'] &&
        $due_date === $currentBill['dueDate'] &&
        $status === $currentBill['status']) {
        $errors['no_change'] = 'Please change at least one field before submitting.';
        $isValid = false;
    }

    if ($isValid) {
        // db
        header('Location: bill-dashboard.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Bill - MoneyMap</title>
    <link rel="stylesheet" href="../../styles/bills/edit-bill.css" />
    <link rel="icon" href="../../../public/assets/logo.png" />
</head>
<body>
    <?php include '../header-footer/header.php'; ?>

    <main class="edit-bill-container">
        <section class="current-bill">
            <h2>Current Bill Info</h2>
            <p><strong>Bill Name:</strong> <?= htmlspecialchars($currentBill['name']) ?></p>
            <p><strong>Amount ($):</strong> <?= htmlspecialchars($currentBill['amount']) ?></p>
            <p><strong>Due Date:</strong> <?= htmlspecialchars($currentBill['dueDate']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($currentBill['status']) ?></p>
        </section>

        <section class="edit-bill-form">
            <h2>Edit Bill</h2>
            <form action="" method="POST" id="edit-bill-form" novalidate>
                <label for="bill-name">Bill Name:</label>
                <input type="text" id="bill-name" name="bill_name" value="<?= htmlspecialchars($bill_name) ?>" />
                <div class="error" id="error-name"><?= $errors['name'] ?></div>

                <label for="amount">Amount ($):</label>
                <input type="number" id="amount" name="amount" step="0.01" value="<?= htmlspecialchars($amount) ?>" />
                <div class="error" id="error-amount"><?= $errors['amount'] ?></div>

                <label for="due-date">Due Date:</label>
                <input type="date" id="due-date" name="due_date" value="<?= htmlspecialchars($due_date) ?>" />
                <div class="error" id="error-date"><?= $errors['due_date'] ?></div>

                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="">-- Select Status --</option>
                    <option value="Paid" <?= $status === 'Paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="Due" <?= $status === 'Due' ? 'selected' : '' ?>>Due</option>
                </select>
                <div class="error" id="error-status"><?= $errors['status'] ?></div>

                <div class="error" id="error-no-change" style="color:red; margin-top:10px;"><?= $errors['no_change'] ?></div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="bill-dashboard.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </section>
    </main>

    <?php include '../header-footer/footer.php'; ?>
    <script src="../../validation/bills/edit-bill.js"></script>
</body>
</html>
