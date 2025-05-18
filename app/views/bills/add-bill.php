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

        <form id="add-bill-form" action="" method="POST" class="bill-form">
            <label for="bill-name"><strong>Bill Name:</strong></label>
            <input type="text" id="bill-name" name="bill_name" />
            <div class="error" id="error-name"></div>

            <label for="amount"><strong>Amount ($):</strong></label>
            <input type="number" id="amount" name="amount" step="0.01" />
            <div class="error" id="error-amount"></div>

            <label for="due-date"><strong>Due Date:</strong></label>
            <input type="date" id="due-date" name="due_date" />
            <div class="error" id="error-date"></div>

            <label for="status"><strong>Status:</strong></label>
            <select id="status" name="status">
                <option value="">-- Select Status --</option>
                <option value="Paid">Paid</option>
                <option value="Due">Due</option>
            </select>
            <div class="error" id="error-status"></div>

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
