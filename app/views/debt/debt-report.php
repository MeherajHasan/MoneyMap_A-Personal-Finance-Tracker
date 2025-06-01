<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Debt Report</title>
    <link rel="stylesheet" href="../../styles/debt/debt-report.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>
<body>
    <?php include '../header-footer/header.php' ?>
    <h1>Debt Report</h1>

    <div id="debtChartContainer" style="display: flex; flex-wrap: wrap; gap: 40px; padding: 20px;"></div>

    <?php include '../header-footer/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../validation/debt/debt-report.js"></script>
</body>
</html>
 