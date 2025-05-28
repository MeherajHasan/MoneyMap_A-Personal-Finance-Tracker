<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Budget Report</title>
    <link rel="stylesheet" href="../../styles/budget/budget-report.css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>
<body>
    <?php include '../header-footer/header.php' ?>
    
    <h2>Budget Report</h2>
    <div class="chart-container">
        <canvas id="budgetChart"></canvas>
    </div>

    <?php include '../header-footer/footer.php' ?>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../validation/budget/budget-report.js"></script>
</body>
</html>
