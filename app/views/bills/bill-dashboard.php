<?php
require_once('../../controllers/userAuth.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bill Dashboard - MoneyMap</title>
    <link rel="stylesheet" href="../../styles/bills/bill-dashboard.css" />
    <link rel="icon" href="../../../public/assets/logo.png" />
</head>
<body>
    <?php include '../header-footer/header.php'; ?>

    <main class="bill-dashboard-container">
        <h1>Bill Dashboard</h1>

        <section class="bill-summary">
            <div class="summary-card due-bills">
                <h2>Due Bills</h2>
                <p id="due-count">0</p>
            </div>
            <div class="summary-card paid-bills">
                <h2>Paid Bills</h2>
                <p id="paid-count">0</p>
            </div>
        </section>

        <section class="bill-actions">
            <a href="add-bill.php" class="btn btn-primary">Add New Bill</a>
        </section>

        <section class="bill-list">
            <table>
                <thead>
                    <tr>
                        <th>Bill Name</th>
                        <th>Amount ($)</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="bill-table-body">
                    </tbody>
            </table>
        </section>
    </main>

    <?php include '../header-footer/footer.php'; ?>
    <script src="../../validation/bills/bill-dashboard.js"></script>
</body>
</html>