<?php
    require_once('../../controllers/userAuth.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Edit Expense</title>
    <link rel="stylesheet" href="../../styles/expense/edit-expense.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Edit Expense</h2>
        </div>

        <form action="" method="POST" class="expense-form two-column-form">
            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Category</label>
                    <input type="text" value="House Rent" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseCategory">New Category</label>
                    <select id="expenseCategory" name="expenseCategory">
                        <option value="">Select</option>
                        <option value="House Rent">House Rent</option>
                        <option value="Transportation">Transportation</option>
                        <option value="Shopping">Shopping</option>
                        <option value="Food">Food</option>
                        <option value="Cosmetics">Cosmetics</option>
                        <option value="Pet">Pet</option>
                        <option value="Medical">Medical</option>
                        <option value="Education">Education</option>
                    </select>
                    <p id="categoryError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Name</label>
                    <input type="text" value="Monthly Rent" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseName">New Name</label>
                    <input type="text" id="expenseName" name="expenseName" placeholder="e.g., Rent, Groceries" />
                    <p id="nameError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Amount</label>
                    <input type="text" value="$1200" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseAmount">New Amount</label>
                    <input type="number" id="expenseAmount" name="expenseAmount" placeholder="Amount in $" />
                    <p id="amountError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Date</label>
                    <input type="text" value="2025-05-01" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseDate">New Date</label>
                    <input type="date" id="expenseDate" name="expenseDate" />
                    <p id="dateError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Notes</label>
                    <textarea readonly>Rent for May 2025</textarea>
                </div>
                <div class="form-column">
                    <label for="expenseNotes">New Notes</label>
                    <textarea id="expenseNotes" name="expenseNotes" placeholder="Optional details about the expense"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Expense</button>
            <p id="emptyError" class="error-message"></p>

            <div class="navigation-buttons">
                <a href="expense-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="add-expense.php" class="btn btn-secondary">Add New Expense</a>
                <a href="expense-report.php" class="btn btn-secondary">View Expense Report</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/expense/edit-expense.js"></script>
</body>

</html>
