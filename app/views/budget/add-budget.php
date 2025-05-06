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
    <title>MoneyMap || Add Budget</title>
    <link rel="stylesheet" href="../../styles/budget/add-budget.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <header class="header">
        <div class="container">
            <img src="../../../public/assets/fullLogo.png" alt="MoneyMap Logo" class="logo" />
            <nav class="nav">
                <a href="../dashboard/dashboard.html">Dashboard</a>
                <a href="expenses.html">Expenses</a>
                <a href="budget-dashboard.html">Budget</a>
                <a href="bills-dashboard.html">Bills</a>
                <a href="debt-dashboard.html">Debt</a>
                <a href="savings-dashboard.html">Savings</a>
                <a href="reports.html">Reports</a>
                <a href="../../../public/index.html">Logout</a>
            </nav>
        </div>
    </header>

    <main class="main container">
        <div class="section-header">
            <h2>Add Budget</h2>
        </div>

        <form action="" method="POST" class="budget-form">
            <div class="form-group">
                <label for="budgetCategory">Category:</label>
                <select id="budgetCategory" name="budgetCategory">
                    <option value="" disabled selected>Select Category</option>
                    <option value="Housing">Housing</option>
                    <option value="Food">Food</option>
                    <option value="Transport">Transport</option>
                    <option value="Utilities">Utilities</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Savings">Savings</option>
                    <option value="Healthcare">Healthcare</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            <div class="form-group">
                <label for="budgetAmount">Amount</label>
                <input type="number" id="budgetAmount" name="budgetAmount" placeholder="Amount in $" />
                <p id="amountError" class="error-message"></p>
            </div>      
            
            <div class="form-group">
                <label for="spentAmount">Amount Spent</label>
                <input type="number" id="spentAmount" name="spentAmount" placeholder="Amount Spent" />
                <p id="spentError" class="error-message"></p>
            </div>            

            <div class="form-group">
                <label for="budgetStartDate">Start Date</label>
                <input type="date" id="budgetStartDate" name="budgetStartDate" />
                <p id="startDateError" class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="budgetEndDate">End Date</label>
                <input type="date" id="budgetEndDate" name="budgetEndDate" />
                <p id="endDateError" class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="budgetNotes">Notes (Optional)</label>
                <textarea id="budgetNotes" name="budgetNotes" placeholder="Optional details about the budget"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Budget</button>
            <p id="emptyError" class="error-message"></p>

            <!-- Additional navigation buttons -->
            <div class="navigation-buttons">
                <a href="budget-dashboard.html" class="btn btn-secondary">Back to Budget Dashboard</a>
                <a href="edit-budget.html" class="btn btn-secondary">Edit Budget</a>
                <a href="budget-report.html" class="btn btn-secondary">View Budget Report</a>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 <a href="../../views/landing/about.html">MoneyMap.</a> All rights reserved.</p>
    </footer>

    <script src="../../validation/budget/add-budget.js"></script>
</body>

</html>
