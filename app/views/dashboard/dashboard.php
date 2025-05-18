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
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../styles/dashboard/dashboard.css" type="text/css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon">
</head>
<body>
    <div class="dashboard-container">

        <nav class="sidebar">
            <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
            <ul class="nav-menu">
                <li><a href="../../views/income/income-dashboard.php"><img class="menu-icon" id="income-icon" src="../../../public/assets/income.png" alt="income-icon">Income</a></li>
                <li><a href="../../views/expense/expense-dashboard.php"><img class="menu-icon" id="expense-icon" src="../../../public/assets/expense.png" alt="expense-icon">Expenses</a></li>
                <li><a href="../../views/budget/budget-dashboard.php"><img class="menu-icon" id="budget-goal-icon" src="../../../public/assets/budget.png" alt="budget-goal-icon">Budget Goals</a></li>
                <li><a href="../../views/debt/debt-dashboard.php"><img class="menu-icon" id="debt-icon" src="../../../public/assets/debt.png" alt="debt-icon">Debt Tracking</a></li>
                <li><a href="../../views/savings/savings-dashboard.php"><img class="menu-icon" id="goals-icon" src="../../../public/assets/savings.png" alt="goals-icon">Saving Goals</a></li>
                <li><a href="../../views/bills/bill-dashboard.php"><img class="menu-icon" id="bill-icon" src="../../../public/assets/bill.png" alt="bill-icon">Bills</a></li>
                <li><a href="../../views/reports/report.php"><img class="menu-icon" id="report-icon" src="../../../public/assets/report.png" alt="report-icon">Analysis & Reports</a></li>
                <li><a href="../../views/contact/contact.php"><img class="menu-icon" id="support-icon" src="../../../public/assets/support.png" alt="support-icon">Feedback & Support</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="dashboard-header">
                <div class="header-right">
                    <span class="navigation-btn" id="sync-status"></span>
                    <button class="navigation-btn" id="syncBtn"><img id="sync-icon" src="../../../public/assets/sync.png" alt="sync-icon"></button>
                    <button class="navigation-btn" id="profileBtn"><img id="profile-img" src="../../../public/assets/profile.png" alt="profile-img"></button>
                    <button class="navigation-btn" id="notificationBtn"><img id="notification-icon" src="../../../public/assets/notification-white.png" alt="notification-icon"></button>
                    <a href="../../controllers/auth/logout.php" class="navigation-btn" id="logoutBtn"><img id="logout-icon" src="../../../public/assets/logout.png" alt="logout-icon"></a>
                </div>
            </header>

            <section class="dashboard-widgets">
                <h1>Welcome to Your Dashboard!</h1>
                <p>Select a feature from the sidebar to get started.</p>
                 
                <div class="widget" id="income-widget">
                    <h2 class="widget-title">Income</h2>
                    <p id="widget-amount" class="widget-amount"></p>
                    <button class="widget-action-btn">View Details</button>
                </div> 
                <div class="widget" id="expense-widget">
                    <h2 class="widget-title">Expenses</h2>
                    <p id="widget-amount" class="widget-amount"></p>
                    <button class="widget-action-btn">View Details</button>
                </div> 
                <div class="widget" id="budget-widget">
                    <h2 class="widget-title">Budget Goals</h2>
                    <p id="widget-amount" class="widget-amount"></p>
                    <button class="widget-action-btn">View Details</button>
                </div> 
                <div class="widget" id="savings-widget">
                    <h2 class="widget-title">Savings</h2>
                    <p id="widget-amount" class="widget-amount"></p>
                    <button class="widget-action-btn">View Details</button>
                </div> 
                <div class="widget" id="debt-widget">
                    <h2 class="widget-title">Debt</h2>
                    <p id="widget-amount" class="widget-amount"></p>
                    <button class="widget-action-btn">View Details</button>
                </div> 
                <div class="widget" id="bills-widget">
                    <h2 class="widget-title">Bills</h2>
                    <p id="widget-amount" class="widget-amount"></p>
                    <button class="widget-action-btn">View Details</button>
                </div>
                <div class="widget" id="reports-widget">
                    <h2 class="widget-title">Analysis & Reports</h2>
                    <p id="widget-amount" class="widget-amount"></p>
                    <button class="widget-action-btn">View Details</button>
                </div>
            </section>
        </main>
    </div>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/dashboard/dashboard.js"></script>
</body>
</html>
