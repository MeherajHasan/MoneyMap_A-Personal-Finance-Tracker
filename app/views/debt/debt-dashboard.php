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
    <title>MoneyMap || Debt Dashboard</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/debt/debt-dashboard.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <a href="../dashboard/dashboard.php" class="logo-link">
                <img src="../../../public/assets/fullLogo.png" alt="MoneyMap Logo" class="logo" />
            </a>
            <nav class="nav">
                <a href="../dashboard/dashboard.php">Dashboard</a>
                <a href="../expense/expense-dashboard.php">Expenses</a>
                <a href="../budget/budget-dashboard.php">Budget</a>
                <a href="#" onclick="alert('This feature is under development.'); return false;">Bills</a>
                <a href="../debt/debt-dashboard.php">Debt</a>
                <a href="../savings/savings-dashboard.php">Savings</a>
                <a href="#" onclick="alert('This feature is under development.'); return false;">Reports</a>
                <a href="../../controllers/auth/logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="main container">
        <div class="debt-dashboard-container">
            <h2>Debt Overview</h2>

            <section class="debt-summary">
                <h3>Summary</h3>
                <div class="summary-metrics">
                    <div class="metric-card">
                        <h4>Total Debt</h4>
                        <p id="totalDebt">$0.00</p>
                    </div>
                    <div class="metric-card">
                        <h4>Total Minimum Payment</h4>
                        <p id="totalMinimumPayment">$0.00</p>
                    </div>
                    <div class="metric-card">
                        <h4>Total Interest Rate</h4>
                        <p id="totalInterestRate">-</p>
                    </div>
                </div>
            </section>

            <section class="current-debts">
                <h3>Current Debts</h3>
                <ul id="debtList">
                    <li>
                        <div class="debt-info">
                            <span class="debt-name">Credit Card</span>
                            <span class="debt-amount">$1,200.00</span>
                        </div>
                        <div class="debt-actions">
                            <a href="edit-debt.php" class="btn-edit">Edit</a>
                            <a href="debt-details.php" class="btn-details">Details</a>
                            <a href="debt-pay.php" class="btn-pay">Pay</a>
                        </div>
                    </li>
                    <li>
                        <div class="debt-info">
                            <span class="debt-name">Student Loan</span>
                            <span class="debt-amount">$15,500.00</span>
                        </div>
                        <div class="debt-actions">
                            <a href="edit-debt.php" class="btn-edit">Edit</a>
                            <a href="debt-details.php" class="btn-details">Details</a>
                            <a href="debt-pay.php" class="btn-pay">Pay</a>
                        </div>
                    </li>
                    </ul>
                <p id="noDebts" style="display:none;">No debts recorded yet.</p>
            </section>

            <div class="actions">
                <a href="add-debt.php" class="btn btn-primary">Add New Debt</a>
                <a href="debt-report.php" class="btn btn-info">Debt Report</a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 <a href="../../views/landing/about.html">MoneyMap.</a> All rights reserved.</p>
    </footer>

    <script src="../../validation/debt/debt-dashboard.js"></script>
</body>

</html>