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
    <title>MoneyMap || Budget Overspent!</title>
    <link rel="stylesheet" href="../../styles/budget/overspend-notify.css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <header class="header">
        <div class="container">
            <a href="../dashboard/dashboard.html" class="logo-link">
                <img src="../../../public/assets/fullLogo.png" alt="MoneyMap Logo" class="logo" />
            </a>
            <nav class="nav">
                <a href="../dashboard/dashboard.html">Dashboard</a>
                <a href="expenses.html">Expenses</a>
                <a href="budget-dashboard.html">Budget</a>
                <a href="../bills/bills-dashboard.html">Bills</a>
                <a href="../debt/debt-dashboard.html">Debt</a>
                <a href="../savings/savings-dashboard.html">Savings</a>
                <a href="../reports/reports.html">Reports</a>
                <a href="../../../public/index.html">Logout</a>
            </nav>
        </div>
    </header>

    <main class="main container">
        <div class="notification-container">
            <div class="notification warning">
                <h2>Budget Overspent!</h2>
                <p id="overspent-message">You have exceeded your budget in the following categories:</p>
                <ul id="overspent-categories">
                    </ul>
                <p><a href="budget-report.html">Review your Budget Report for details.</a></p>
                <button id="acknowledge-btn">Okay</button>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 <a href="../../views/landing/about.html">MoneyMap.</a> All rights reserved.</p>
    </footer>

    <script src="../../validation/budget/overspend-notify.js"></script>
</body>

</html>