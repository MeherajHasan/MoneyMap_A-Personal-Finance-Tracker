<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/budgetModel.php');
require_once('../../models/expenseCategoryModel.php');

$selectedMonth = $_GET['month'] ?? date('Y-m');
$selectedCategory = $_GET['category'] ?? 'all';
$monthlyBudgets = getSelectedMonthBudgets($_SESSION['user']['id'], $selectedMonth);
$categoryNames = getExpenseCategoryName($_SESSION['user']['id']);

function getSelectedBudgetMonth($monthStr)
{
    if (!$monthStr) {
        return date('F Y');
    }
    $date = date_create($monthStr . '-01');
    return date_format($date, "F Y");
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Budget Dashboard</title>
    <link rel="stylesheet" href="../../styles/budget/budget-dashboard.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <section class="summary-cards">
            <div class="card budget-total">
                <h3>Total Budget <br><i>(<?= getSelectedBudgetMonth($selectedMonth) ?>)</i></h3>
                <p>$<?= getTotalBudgetMonthly($_SESSION['user']['id'], $selectedMonth) ?? '0.00' ?></p>
            </div>
            <div class="card budget-used">
                <h3>Used Budget <br><i>(<?= getSelectedBudgetMonth($selectedMonth) ?>)</i></h3>
                <p>$<?= getUsedBudgetMonthly($_SESSION['user']['id'], $selectedMonth) ?? '0.00' ?></p>
            </div>
            <div class="card budget-remaining">
                <h3>Remaining Budget <br><i>(<?= getSelectedBudgetMonth($selectedMonth) ?>)</i></h3>
                <p>$<?= number_format(getTotalBudgetMonthly($_SESSION['user']['id'], $selectedMonth) -
                        getUsedBudgetMonthly($_SESSION['user']['id'], $selectedMonth), 2) ?? '0.00' ?></p>
            </div>
        </section>

        <div class="section-header">
            <h2>Budget Allocations</h2>
            <a href="add-budget.php" class="btn btn-primary">+ Add Budget</a>
        </div>

        <form method="GET" action="<?= $_SERVER['PHP_SELF'] ?>" class="filters">
            <label for="categoryFilter">Category:</label>
            <select id="categoryFilter" name="category">
                <option value="all" <?= $selectedCategory == 'all' ? 'selected' : '' ?>>All</option>
                <?php foreach ($categoryNames as $cat): ?>
                    <option value="<?= strtolower($cat) ?>" <?= strtolower($selectedCategory) == strtolower($cat) ? 'selected' : '' ?>>
                        <?= $cat ?>
                    </option>
                <?php endforeach; ?>

            </select>

            <label for="monthFilter">Month:</label>
            <input type="month" id="monthFilter" name="month" value="<?= $selectedMonth ?: date('Y-m') ?>" onchange="this.form.submit()" />

        </form>

        <table class="budget-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Used</th>
                    <th>Remaining</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="budgetTableBody">
                <?php foreach ($monthlyBudgets as $budget): ?>
                    <?php
                    $usedAmount = getUsedBudgetByCategory($_SESSION['user']['id'], $budget['category_id'], $selectedMonth);
                    $remaining = $budget['amount'] - $usedAmount;

                    $categoryName = getCategoryNameById($budget['category_id']);
                    ?>
                    <?php if ($selectedCategory == 'all' || strtolower($categoryName) == strtolower($selectedCategory)): ?>
                        <tr>
                            <td><?= $categoryName ?></td>
                            <td>$<?= number_format($budget['amount'], 2) ?></td>
                            <td>$<?= number_format($usedAmount, 2) ?></td>
                            <td>$<?= number_format($remaining, 2) ?></td>
                            <td><?= $budget['start_date'] ?></td>
                            <td><?= $budget['target_date'] ?></td>
                            <td><?= $budget['note'] ?></td>
                            <td>
                                <a href="edit-budget.php?id=<?= $budget['budget_id'] ?>&category_id=<?= $budget['category_id'] ?>" class="btn-small edit">Edit</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if (empty($monthlyBudgets)): ?>
                    <tr>
                        <td colspan="8">No budget entries found for this month.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="action-buttons">
            <a href="budget-category.php" class="btn">Manage Categories</a>
            <a href="budget-report.php" class="btn">View Budget Report</a>
            <a href="overspend-notify.php" class="btn">Overspend Notification</a>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/budget/budget-dashboard.js"></script>
</body>

</html>