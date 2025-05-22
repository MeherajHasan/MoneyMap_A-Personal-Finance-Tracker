<?php
require_once('../../controllers/adminAuth.php');
include '../../models/userModel.php';

// Fetch Data from Database
$totalUsers = getTotalUsers() ?? 0;
$activeUsers = countUsersByStatus(0) ?? 0;
$inactiveUsers = countUsersByStatus(1) ?? 0;
$suspendedUsers = countUsersByStatus(2) ?? 0;
$pendingUsers = countUsersByStatus(3) ?? 0;

// $totalTransactions = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS count FROM transactions"))['count'];
// $totalIncome = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount) AS total FROM transactions WHERE type = 'income'"))['total'] ?? 0;
// $totalExpenses = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(amount) AS total FROM transactions WHERE type = 'expense'"))['total'] ?? 0;

$errors = [];
$status = '';
$from_date = '';
$to_date = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate status
    $allowed_status = ['all', '0', '1', '2', '3'];
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    if (!in_array($status, $allowed_status, true)) {
        $errors[] = 'Invalid status selected.';
    }

    // Validate dates
    $from_date = isset($_POST['from_date']) ? trim($_POST['from_date']) : '';
    $to_date = isset($_POST['to_date']) ? trim($_POST['to_date']) : '';

    if ($from_date !== '' && $to_date !== '') {
        if (strtotime($from_date) > strtotime($to_date)) {
            $errors[] = 'From Date cannot be later than To Date.';
        }
    }
}
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

        <?php if (!empty($errors)) : ?>
            <div style="color: red;">
                <ul>
                    <?php foreach ($errors as $e) {
                        echo '<li>' . htmlspecialchars($e) . '</li>';
                    } ?>
                </ul>
            </div>
        <?php endif; ?>

        <form id="custom-search-form" method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <div class="form-group">
                <label for="status">Select to view:</label>
                <select name="status" id="status">
                    <option value="all" <?= ($status === 'all') ? 'selected' : '' ?>>All Users</option>
                    <option value="0" <?= ($status === '0') ? 'selected' : '' ?>>Active Users</option>
                    <option value="1" <?= ($status === '1') ? 'selected' : '' ?>>Inactive Users</option>
                    <option value="2" <?= ($status === '2') ? 'selected' : '' ?>>Suspended Users</option>
                    <option value="3" <?= ($status === '3') ? 'selected' : '' ?>>Pending Users</option>
                    <!-- <option value="totalTransactions">Total Transactions</option>
                    <option value="totalIncome">Total Income</option>
                    <option value="totalExpenses">Total Expenses</option> -->
                </select>
            </div>

            <div class="form-group">
                <label for="from_date">From Date:</label>
                <input type="date" name="from_date" id="from_date" value="<?= htmlspecialchars($from_date) ?>" />
            </div>

            <div class="form-group">
                <label for="to_date">To Date:</label>
                <input type="date" name="to_date" id="to_date" value="<?= htmlspecialchars($to_date) ?>" />
            </div>

            <button type="submit">Search</button>
        </form>

        <div id="graphContainer"></div>
    </div>

    <?php include '../header-footer/admin-footer.php'; ?>
</body>

<script src="../../validation/admin/data-oversight.js"></script>

</html>
