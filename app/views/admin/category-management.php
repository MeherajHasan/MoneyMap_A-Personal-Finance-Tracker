<?php
require_once('../../controllers/adminAuth.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <link rel="stylesheet" href="../../styles/admin/category-management.css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon">
</head>
<body>
    <?php include '../header-footer/admin-header.php' ?>
    <h2>Category Management</h2>

    <!-- Income Categories -->
    <h3>Income Categories:</h3>
    <ul>
        <li>Regular Main Income</li>
        <li>Regular Side Income</li>
        <li>Irregular Income</li>
    </ul>

    <!-- Expense Categories Search -->
    <h3>Expense Categories:</h3>
    <form method="post">
        <input type="text" name="searchExpense" placeholder="Search by User Email">
        <button type="submit" name="searchExpenseBtn">Search</button>
    </form>

    <!-- Display Area for Expense Categories -->
    <div id="expense-category-list">
        <!-- Expense categories will be shown here after search -->
    </div>

    <!-- Budget Categories Search -->
    <h3>Budget Categories:</h3>
    <form method="post">
        <input type="text" name="searchBudget" placeholder="Search by User Email">
        <button type="submit" name="searchBudgetBtn">Search</button>
    </form>

    <!-- Display Area for Budget Categories -->
    <div id="budget-category-list">
        <!-- Budget categories will be shown here after search -->
    </div>

    <?php include '../header-footer/admin-footer.php' ?>

    <script src="../../validation/admin/category-management.js"></script>

</body>
</html>
