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
    <title>MoneyMap || Add Money</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/savings/add-money.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <a href="../dashboard/dashboard.html" class="logo-link">
                <img src="../../../public/assets/fullLogo.png" alt="MoneyMap Logo" class="logo" />
            </a>
            <nav class="nav">
                <a href="../dashboard/dashboard.html">Dashboard</a>
                <a href="../expenses/expenses.html">Expenses</a>
                <a href="budget-dashboard.html">Budget</a>
                <a href="../bills/bills-dashboard.html">Bills</a>
                <a href="../debt/debt-dashboard.html">Debt</a>
                <a href="../savings/savings-dashboard.html" class="active">Savings</a>
                <a href="../reports/reports.html">Reports</a>
                <a href="../../../public/index.html">Logout</a>
            </nav>
        </div>
    </header>

    <main class="main container">
        <div class="add-money-form-container">
            <h2>Add Money to Savings Goal</h2>
            <form id="addMoneyForm" method="POST">
                <div class="form-group">
                    <label for="goalName">Select Goal:</label>
                    <select id="goalName" name="goalName" class="form-control">
                        <option value="" disabled selected>Select a Savings Goal</option>
                    </select>
                    <small class="form-text text-muted">Choose the savings goal you want to add money to.</small>
                    <p id="nameError" class="errorMSG"></p>
                </div>
                <div class="form-group">
                    <label for="amount">Amount to Add:</label>
                    <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount">
                    <p id="amountError" class="errorMSG"></p>
                </div>
                <div class="form-group">
                    <label for="transactionDate">Transaction Date:</label>
                    <input type="date" id="transactionDate" name="transactionDate" class="form-control">
                    <p id="dateError" class="errorMSG"></p>
                </div>
                <div class="form-group">
                    <label for="notes">Notes (Optional):</label>
                    <textarea id="notes" name="notes" class="form-control" rows="3"
                        placeholder="Add any notes about this transaction"></textarea>
                    <p id="emptyError" class="errorMSG"></p>
                </div>
                <button type="submit" class="btn btn-success">Add Money</button>
                <a href="savings-dashboard.html" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 <a href="../../views/landing/about.html">MoneyMap.</a> All rights reserved.</p>
    </footer>
    
    <script src="../../validation/savings/add-money.js"></script>
</body>

</html>