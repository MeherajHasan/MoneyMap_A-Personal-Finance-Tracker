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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Add Expense</title>
    <link rel="stylesheet" href="../../styles/expense/add-expense.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <header class="header">
        <div class="container">
            <img src="../../../public/assets/fullLogo.png" alt="MoneyMap Logo" class="logo" />
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
        <div class="section-header">
            <h2>Add Expense</h2>
        </div>

        <form action="" method="POST" class="expense-form">
            <div class="form-group">
                <label for="expenseCategory">Category:</label>
                <select id="expenseCategory" name="expenseCategory">
                    <option value="" disabled selected>Select Category</option>
                    <option value="House Rent">House Rent</option>
                    <option value="Transportation">Transportation</option>
                    <option value="Shopping">Shopping</option>
                    <option value="Food">Food</option>
                    <option value="Cosmetics">Cosmetics</option>
                    <option value="Pet">Pet</option>
                    <option value="Medical">Medical</option>
                    <option value="Education">Education</option>
                </select>

            </div>

            <div class="form-group">
                <label for="expenseName">Name</label>
                <input type="text" id="expenseName" name="expenseName" placeholder="e.g., Rent, Groceries" />
                <p id="nameError" class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="expenseAmount">Amount</label>
                <input type="number" id="expenseAmount" name="expenseAmount" placeholder="Amount in $" />
                <p id="amountError" class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="expenseDate">Date</label>
                <input type="date" id="expenseDate" name="expenseDate" />
                <p id="dateError" class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="expenseNotes">Notes (Optional)</label>
                <textarea id="expenseNotes" name="expenseNotes"
                    placeholder="Optional details about the expense"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Expense</button>
            <p id="emptyError" class="error-message"></p>

            <!-- Additional navigation buttons -->
            <div class="navigation-buttons">
                <a href="expense-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="edit-expense.php" class="btn btn-secondary">Edit Expense</a>
                <a href="expense-report.php" class="btn btn-secondary">View Expense Report</a>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 <a href="../../views/landing/about.html">MoneyMap.</a> All rights reserved.</p>
    </footer>

    <script src="../../validation/expense/add-expense.js"></script>
</body>

</html>