<?php
require_once('../../controllers/adminAuth.php');

include '../../../config/db.php';

// Fetch Data from Database
$totalUsers = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS count FROM users"))['count'];
$activeUsers = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS count FROM users WHERE account_status = 0"))['count'];
$inactiveUsers = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS count FROM users WHERE account_status = 1"))['count'];
$suspendedUsers = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS count FROM users WHERE account_status = 2"))['count'];
$pendingUsers = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS count FROM users WHERE account_status = 3"))['count'];

// // Uncomment these when ready to use:
// $totalTransactions = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS count FROM transactions"))['count'];
// $totalIncome = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount) AS total FROM transactions WHERE type = 'income'"))['total'] ?? 0;
// $totalExpenses = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount) AS total FROM transactions WHERE type = 'expense'"))['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Data Oversight</title>
    <link rel="stylesheet" href="../../styles/admin/data-oversight.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/admin-header.php'; ?>

    <h2>Data Oversight Dashboard</h2>

    <div class="overview-container">
        <div class="card">
            <h3>Total Users</h3>
            <p><?= $totalUsers ?></p>
        </div>
        <div class="card">
            <h3>Active Users</h3>
            <p><?= $activeUsers ?></p>
        </div>
        <div class="card">
            <h3>Inactive Users</h3>
            <p><?= $inactiveUsers ?></p>
        </div>
        <div class="card">
            <h3>Suspended Users</h3>
            <p><?= $suspendedUsers ?></p>
        </div>
        <div class="card">
            <h3>Pending Users</h3>
            <p><?= $pendingUsers ?></p>
        </div>
        <div class="card">
            <h3>Total Transactions</h3>
            <!-- <p><?= $totalTransactions ?></p> -->
        </div>
        <div class="card">
            <h3>Total Income</h3>
            <!-- <p>$<?= number_format($totalIncome, 2) ?></p> -->
        </div>
        <div class="card">
            <h3>Total Expenses</h3>
            <!-- <p>$<?= number_format($totalExpenses, 2) ?></p> -->
        </div>
    </div>

    <div class="custom-search">
        <h3>Custom Data Search</h3>
        <form id="custom-search-form" method="POST" action="">
            <div class="form-group">
                <label for="status">Select to view:</label>
                <select name="status" id="status">
                    <option value="all">All Users</option>
                    <option value="0">Active Users</option>
                    <option value="1">Inactive Users</option>
                    <option value="2">Suspended Users</option>
                    <option value="3">Pending Users</option>
                    <!-- <option value="totalTransactions">Total Transactions</option>
                    <option value="totalIncome">Total Income</option>
                    <option value="totalExpenses">Total Expenses</option> -->
                </select>
            </div>

            <div class="form-group">
                <label for="from_date">From Date:</label>
                <input type="date" name="from_date" id="from_date" />
            </div>

            <div class="form-group">
                <label for="to_date">To Date:</label>
                <input type="date" name="to_date" id="to_date" />
            </div>

            <button type="submit">Search</button>
        </form>

        <div id="graphContainer"></div>
    </div>

    <?php include '../header-footer/admin-footer.php'; ?>
</body>

<!--chart.txt-->

<script src="../../validation/admin/data-oversight.js"></script>

</html>