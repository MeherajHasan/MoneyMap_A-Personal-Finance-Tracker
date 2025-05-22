<?php
    require_once('../../controllers/userAuth.php');
    require_once('../../models/expenseCategoryModel.php');
    require_once('../../models/expenseModel.php');

    $expenseCategoryNames = getExpenseCategoryName($_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Expense Dashboard</title>
    <link rel="stylesheet" href="../../styles/expense/expense-dashboard.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <section class="summary-cards">
            <div class="card expense-house-rent">
                <h3>House Rent</h3>
                <p>$1,200</p>
            </div>
            <div class="card expense-transportation">
                <h3>Transportation</h3>
                <p>$300</p>
            </div>
            <div class="card expense-shopping">
                <h3>Shopping</h3>
                <p>$450</p>
            </div>
            <div class="card expense-food">
                <h3>Food</h3>
                <p>$600</p>
            </div>
            <div class="card expense-cosmetics">
                <h3>Cosmetics</h3>
                <p>$100</p>
            </div>
            <div class="card expense-pet">
                <h3>Pet</h3>
                <p>$80</p>
            </div>
            <div class="card expense-medical">
                <h3>Medical</h3>
                <p>$200</p>
            </div>
            <div class="card expense-education">
                <h3>Education</h3>
                <p>$400</p>
            </div>
            <div class="card expense-total">
                <h3>Total Expense</h3>
                <p>$3,930</p>
            </div>
        </section>

        <div class="section-header">
            <h2>Expense Records</h2>
            <a href="add-expense.php" class="btn btn-primary">+ Add Expense</a>
        </div>

        <div class="filters">
            <label for="categoryFilter">Category:</label>
            <select id="categoryFilter">
                <option value="all">All</option>
                <?php foreach ($expenseCategoryNames as $category): ?>
                    <option value="<?= $category; ?>"><?= $category; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="dateFilter">Date:</label>
            <input type="month" id="dateFilter" />
        </div>

        <table class="expense-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Details</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="expenseTableBody">
                <tr>
                    <td>House Rent</td>
                    <td>Monthly Rent</td>
                    <td>$1,200</td>
                    <td>2025-05-01</td>
                    <td>May Rent</td>
                    <td>
                        <a href="edit-expense.php?id=1" class="btn-small edit">Edit</a>
                        <button class="btn-small delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Transportation</td>
                    <td>Taxi Fare</td>
                    <td>$50</td>
                    <td>2025-05-03</td>
                    <td>Daily commute</td>
                    <td>
                        <a href="edit-expense.php?id=2" class="btn-small edit">Edit</a>
                        <button class="btn-small delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Shopping</td>
                    <td>Clothing</td>
                    <td>$200</td>
                    <td>2025-04-28</td>
                    <td>Spring collection</td>
                    <td>
                        <a href="edit-expense.php?id=3" class="btn-small edit">Edit</a>
                        <button class="btn-small delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Food</td>
                    <td>Groceries</td>
                    <td>$120</td>
                    <td>2025-05-02</td>
                    <td>Weekly shopping</td>
                    <td>
                        <a href="edit-expense.php?id=4" class="btn-small edit">Edit</a>
                        <button class="btn-small delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Medical</td>
                    <td>Doctor Visit</td>
                    <td>$80</td>
                    <td>2025-04-30</td>
                    <td>Regular checkup</td>
                    <td>
                        <a href="edit-expense.php?id=5" class="btn-small edit">Edit</a>
                        <button class="btn-small delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="action-buttons">
            <a href="expense-category.php" class="btn">Manage Categories</a>
            <a href="expense-report.php" class="btn">View Expense Report</a>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/expense/expense-dashboard.js"></script>
</body>

</html>
