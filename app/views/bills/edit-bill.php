<?php
session_start();

if (!isset($_COOKIE['status'])) {
    header('Location: ../../views/auth/login.php');
    exit();
}

// Dummy bill data (replace with DB fetch)
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO: Process update, then redirect
    header('Location: bill-dashboard.php');
    exit();
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
            <form action="" method="POST" id="edit-bill-form">
                <label for="bill-name">Bill Name:</label>
                <input type="text" id="bill-name" name="bill_name" value="<?= htmlspecialchars($currentBill['name']) ?>" />
                <div class="error" id="error-name"></div>

                <label for="amount">Amount ($):</label>
                <input type="number" id="amount" name="amount" step="0.01" value="<?= htmlspecialchars($currentBill['amount']) ?>" />
                <div class="error" id="error-amount"></div>

                <label for="due-date">Due Date:</label>
                <input type="date" id="due-date" name="due_date" value="<?= htmlspecialchars($currentBill['dueDate']) ?>" />
                <div class="error" id="error-date"></div>

                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="">-- Select Status --</option>
                    <option value="Paid" <?= $currentBill['status'] === 'Paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="Due" <?= $currentBill['status'] === 'Due' ? 'selected' : '' ?>>Due</option>
                </select>
                <div class="error" id="error-status"></div>

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

