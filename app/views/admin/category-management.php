<?php
require_once('../../controllers/adminAuth.php');

$searchExpense = $searchBudget = "";
$expenseError = $budgetError = "";
$expenseResult = $budgetResult = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['searchExpenseBtn'])) {
        if (empty(trim($_POST['searchExpense']))) {
            $expenseError = "Please enter an email to search.";
        } else if (!filter_var($_POST['searchExpense'], FILTER_VALIDATE_EMAIL)) {
            $expenseError = "Please enter a valid email address.";
        } else {
            $searchExpense = trim($_POST['searchExpense']);
            // db
        }
    }

    if (isset($_POST['searchBudgetBtn'])) {
        if (empty(trim($_POST['searchBudget']))) {
            $budgetError = "Please enter an email to search.";
        } else if (!filter_var($_POST['searchBudget'], FILTER_VALIDATE_EMAIL)) {
            $budgetError = "Please enter a valid email address.";
        } else {
            $searchBudget = trim($_POST['searchBudget']);
            // db
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Category Management</title>
    <link rel="stylesheet" href="../../styles/admin/category-management.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>
<body>
    <?php include '../header-footer/admin-header.php'; ?>

    <h2>Category Management</h2>

    <h3>Income Categories:</h3>
    <ul>
        <li>Regular Main Income</li>
        <li>Regular Side Income</li>
        <li>Irregular Income</li>
    </ul>

    <h3>Expense Categories:</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="searchExpense" placeholder="Search by User Email" value="<?php echo htmlspecialchars($searchExpense); ?>" />
        <button type="submit" name="searchExpenseBtn">Search</button>
    </form>
    <div style="color:red;"><?php echo $expenseError; ?></div>
    <div id="expense-category-list">
        <?php echo $expenseResult; ?>
    </div>

    <h3>Budget Categories:</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="searchBudget" placeholder="Search by User Email" value="<?php echo htmlspecialchars($searchBudget); ?>" />
        <button type="submit" name="searchBudgetBtn">Search</button>
    </form>
    <div style="color:red;"><?php echo $budgetError; ?></div>
    <div id="budget-category-list">
        <?php echo $budgetResult; ?>
    </div>

    <?php include '../header-footer/admin-footer.php'; ?>

    <script src="../../validation/admin/category-management.js"></script>
</body>
</html>
