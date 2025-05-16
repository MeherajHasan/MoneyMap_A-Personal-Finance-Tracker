<?php
    session_start();

    if (!isset($_COOKIE['status'])) {
        header('Location: ../../views/auth/login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMap || Savings Report</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/savings/savings-report.css">
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="savings-report-container">
            <h2>Savings Report</h2>

            <section class="report-overview">
                <h3>Overview</h3>
                <div class="overview-metrics">
                    <div class="metric-card">
                        <h4>Total Saved</h4>
                        <p id="totalSaved">$0.00</p>
                    </div>
                    <div class="metric-card">
                        <h4>Total Goals</h4>
                        <p id="totalGoals">0</p>
                    </div>
                    <div class="metric-card">
                        <h4>Goals Achieved</h4>
                        <p id="goalsAchieved">0</p>
                    </div>
                    <div class="metric-card">
                        <h4>Average Savings per Goal</h4>
                        <p id="averageSavings">$0.00</p>
                    </div>
                </div>
            </section>

            <section class="goal-progress-summary">
                <h3>Goal Progress Summary</h3>
                <ul id="goalProgressList">
                    <li>
                        <span>Vacation</span>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 30%;"></div>
                            <span>30%</span>
                        </div>
                    </li>
                    <li>
                        <span>Emergency Fund</span>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 60%;"></div>
                            <span>60%</span>
                        </div>
                    </li>
                    </ul>
            </section>

            <section class="recent-transactions">
                <h3>Recent Savings Transactions</h3>
                <table class="transactions-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Goal</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody id="transactionsBody">
                        <tr>
                            <td>2025-05-05</td>
                            <td>Vacation</td>
                            <td>Deposit</td>
                            <td>+$200.00</td>
                            <td>Monthly contribution</td>
                        </tr>
                        <tr>
                            <td>2025-04-28</td>
                            <td>Emergency Fund</td>
                            <td>Deposit</td>
                            <td>+$500.00</td>
                            <td>Extra savings</td>
                        </tr>
                        </tbody>
                </table>
                <p id="noTransactions" style="display:none;">No recent transactions found.</p>
            </section>

            <div class="actions">
                <a href="savings-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/savings/savings-report.js"></script>
</body>

</html>