<?php
require_once('../../controllers/userAuth.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Reports - MoneyMap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../../styles/reports/report.css" />
    <link rel="icon" href="../../../public/assets/logo.png" />
</head>

<body>
    <?php include '../header-footer/header.php'; ?>

    <main class="report-container">
        <section class="report-header">
            <h2>Financial Summary Report</h2>
            <p>Track your income, expenses, and savings over time.</p>
        </section>

        <section class="report-summary">
            <div class="summary-card" id="total-income">
                <h3>Total Income</h3>
                <p>$<span id="income-amount">0.00</span></p>
            </div>
            <div class="summary-card" id="total-expenses">
                <h3>Total Expenses</h3>
                <p>$<span id="expense-amount">0.00</span></p>
            </div>
            <div class="summary-card" id="net-balance">
                <h3>Net Balance</h3>
                <p>$<span id="balance-amount">0.00</span></p>
            </div>
        </section>

        <section class="report-analysis">
            <h2>Transaction Analysis and Report</h2>

            <!-- Date-wise custom table and graph generation option and button -->
            <div class="custom-range">
                <label for="custom-start-date">From:</label>
                <input type="date" id="custom-start-date" />
                <label for="custom-end-date">To:</label>
                <input type="date" id="custom-end-date" />
                <button class="btn btn-primary" id="generate-custom-report">Generate Custom Report</button>
                <div class="error"></div>
            </div>

            <h3>Detailed Transaction</h3>
            <div class="report-table">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Amount ($)</th>
                        </tr>
                    </thead>
                    <tbody id="transaction-table-body">
                        <!-- JS will populate rows -->
                    </tbody>
                </table>
            </div>

        </section>

        <section class="report-graph">
            <h3>Income vs Expense Overview</h3>
            <canvas id="income-expense-chart" width="800" height="400"></canvas>
        </section>
    </main>

    <?php include '../header-footer/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../validation/reports/report.js"></script>
</body>

</html>