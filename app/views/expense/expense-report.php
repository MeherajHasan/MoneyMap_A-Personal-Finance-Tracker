<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Expense Bar Chart</title>
    <link rel="stylesheet" href="../../styles/expense/expense-report.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>
<body>
    <?php include '../header-footer/header.php' ?>
    <h1>Monthly Expense by Category</h1>
    <canvas id="expenseBarChart"></canvas>
    <?php include '../header-footer/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../validation/expense/expense-report.js"></script>
</body>
</html>
