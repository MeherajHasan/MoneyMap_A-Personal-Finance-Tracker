<?php
    require_once('../../controllers/userAuth.php');
    require_once('../../models/debtModel.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMap || Debt Report</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/debt/debt-report.css">
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="debt-report-container">
            <h2>Debt Report</h2>

            <div class="report-options">
                <div class="filter-group">
                    <label for="reportType">Report Type:</label>
                    <select id="reportType">
                        <option value="summary">Debt Summary</option>
                        <option value="details">Detailed Debt List</option>
                        <option value="payment-schedule">Payment Schedules</option>
                        </select>
                </div>

                <div class="filter-group">
                    <label for="sortBy">Sort By:</label>
                    <select id="sortBy">
                        <option value="name">Debt Name</option>
                        <option value="principal">Principal Amount</option>
                        <option value="interestRate">Interest Rate</option>
                        <option value="minimumPayment">Minimum Payment</option>
                        <option value="debtDate">Debt Date</option>
                        </select>
                </div>

                <div class="filter-group">
                    <label for="sortOrder">Sort Order:</label>
                    <select id="sortOrder">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>

                <button id="generateReportBtn" class="btn btn-primary">Generate Report</button>
            </div>

            <div id="reportOutput" class="report-output-section">
                </div>

            <p id="noReportGenerated" style="display:none; text-align: center; font-style: italic; color: #888;">Click "Generate Report" to view debt information.</p>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/debt/debt-report.js"></script>
</body>

</html>