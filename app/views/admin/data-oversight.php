<?php
require_once('../../controllers/adminAuth.php');
include '../../models/userModel.php';
include '../../models/incomeModel.php';
include '../../models/expenseModel.php';
include '../../models/savingsModel.php';
include '../../models/budgetModel.php';
include '../../models/debtModel.php';
include '../../models/billModel.php';
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
            <p><?= getTotalUsers() ?></p>
        </div>
        <div class="card">
            <h3>Active Users</h3>
            <p><?= countUsersByStatus(0) ?></p>
        </div>
        <div class="card">
            <h3>Inactive Users</h3>
            <p><?= countUsersByStatus(1) ?></p>
        </div>
        <div class="card">
            <h3>Suspended Users</h3>
            <p><?= countUsersByStatus(2) ?></p>
        </div>
        <div class="card">
            <h3>Pending Users</h3>
            <p><?= countUsersByStatus(3) ?></p>
        </div>
        <div class="card">
            <h3>Total Income</h3>
            <p>$<?= getAllUserTotalIncome() ?></p>
        </div>
        <div class="card">
            <h3>Total Expenses</h3>
            <p>$<?= getAllUserTotalExpense() ?></p>
        </div>
        <div class="card">
            <h3>Total Savings</h3>
            <p>$<?= getAllUserTotalSavings() ?></p>
        </div>
        <div class="card">
            <h3>Total Budget</h3>
            <p>$<?= getAllUserTotalBudget() ?></p>
        </div>
        <div class="card">
            <h3>Total Debt</h3>
            <p>$<?= getAllUserTotalDebt() ?></p>
        </div>
        <div class="card">
            <h3>Total Bills</h3>
            <p>$<?= getAllUserTotalBills() ?></p>
        </div>
    </div>
        </form>
    </div>

    <?php include '../header-footer/admin-footer.php'; ?>
</body>

<script src="../../validation/admin/data-oversight.js"></script>

</html>
