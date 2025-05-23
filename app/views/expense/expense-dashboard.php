<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/expenseCategoryModel.php');
require_once('../../models/expenseModel.php');

$expenseCategoryNames = getExpenseCategoryName($_SESSION['user']['id']);
$expenses = getAllExpenses($_SESSION['user']['id']);

$categoryTotals = getExpenseTotalsByCategory($_SESSION['user']['id']);
$totalExpense = array_sum($categoryTotals);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['expenseID'])) {
    $expenseID = $_POST['expenseID'];
    if (deleteExpense($expenseID)) {
        echo 'success';
        header('Location: expense-dashboard.php');
        exit();
    } 
}
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
            <?php foreach ($expenseCategoryNames as $category):
                $amount = isset($categoryTotals[$category]) ? $categoryTotals[$category] : 0;
            ?>
                <div class="card">
                    <h3><?= $category ?></h3>
                    <p>$<?= number_format($amount, 2) ?></p>
                </div>
            <?php endforeach; ?>

            <div class="card expense-total">
                <h3>Total Expense</h3>
                <p>$<?= number_format($totalExpense, 2) ?></p>
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
                <?php if (!empty($expenses)): ?>
                    <?php foreach ($expenses as $expense): ?>
                        <tr>
                            <td><?= $expense['category_name'] ?></td>
                            <td><?= $expense['name'] ?></td>
                            <td>$<?= $expense['amount'] ?></td>
                            <td><?= $expense['expense_date'] ?></td>
                            <td><?= $expense['note'] ?></td>
                            <td>
                                <a href="edit-expense.php?id=<?= $expense['expenseID'] ?>" class="btn-small edit">Edit</a>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this expense record?');">
                                    <input type="hidden" name="expenseID" value="<?= $expense['expenseID'] ?>">
                                    <button type="submit" class="btn-small delete">Delete</button>
                                </form>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No expenses found.</td>
                    </tr>
                <?php endif; ?>
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