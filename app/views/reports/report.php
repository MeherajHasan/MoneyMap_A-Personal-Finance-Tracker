<!DOCTYPE html>
<html>

<head>
    <title>Analysis & Reports</title>
    <link rel="stylesheet" href="../../styles/reports/report.css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>
    <div class="widgets">
        <div class="widget" id="income">Total Income: </div>
        <div class="widget" id="expense">Total Expenses: </div>
        <div class="widget" id="balance">Net Balance: </div>
    </div>
    
    <h2 class="chartTitle">Income vs Expense</h2>
    <canvas id="lineChart"></canvas>

    <div class="charts">
        <div class="chart-container">
            <h2 class="chartTitle">Budget Analysis</h2>
            <canvas id="budgetPie"></canvas>
        </div>

        <div class="chart-container">
            <h2 class="chartTitle">Debt Analysis</h2>
            <canvas id="debtPie"></canvas>
        </div>

        <div class="chart-container">
            <h2 class="chartTitle">Savings Analysis</h2>
            <canvas id="savingsPie"></canvas>
        </div>
    </div>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/reports/report.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>