<?php
require_once('../../controllers/adminAuth.php');
require_once('../../models/expenseCategoryModel.php');
require_once('../../models/userModel.php');

$searchExpense = $searchBudget = "";
$expenseError = $budgetError = "";
$user = $userID = $specificExpenseResult = $generalizedExpenseResult = $budgetResult = "";
$specificExpenseCategoryNames = $generalizedExpenseCategoryNames
    = $budgetCategoryNames = [];

$generalizedExpenseCategoryNames = getGeneralizedExpenseCategoryName();
if (count($generalizedExpenseCategoryNames) > 0) {
    $generalizedExpenseResult = "<ul>";
    foreach ($generalizedExpenseCategoryNames as $category) {
        $generalizedExpenseResult .= "<li>" . $category . "</li>";
    }
    $generalizedExpenseResult .= "</ul>";
} else {
    $generalizedExpenseResult = "<p>No expense categories found.</p>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['searchExpenseBtn'])) {
        if (empty(trim($_POST['searchExpense']))) {
            $expenseError = "Please enter an email to search.";
        } else if (!filter_var($_POST['searchExpense'], FILTER_VALIDATE_EMAIL)) {
            $expenseError = "Please enter a valid email address.";
        } else {
            $searchExpense = trim($_POST['searchExpense']);

            $user = searchByMail($searchExpense);
            if ($user) {
                $userID = $user['id'];
                $expenseCategoryNames = getSpecificExpenseCategoryName($userID);

                if (count($expenseCategoryNames) > 0) {
                    $specificExpenseResult = "<ul>";
                    foreach ($expenseCategoryNames as $category) {
                        $specificExpenseResult .= "<li>" . $category . "</li>";
                    }
                    $specificExpenseResult .= "</ul>";
                } else {
                    $specificExpenseResult = "<p>No expense categories found for this user.</p>";
                }
            } else {
                $expenseError = "No user found with this email.";
            }
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

    <h3>Default Expense Categories</h3>
    <?= $generalizedExpenseResult; ?>

    <h3>Individual Expense Categories:</h3>
    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
        <input type="text" name="searchExpense" placeholder="Search by User Email" value="<?= $searchExpense; ?>" />
        <button type="submit" name="searchExpenseBtn">Search</button>
    </form>
    <div style="color:red;"><?= $expenseError; ?></div>
    <div>
        <?= $specificExpenseResult; ?>
    </div>

    <h3>Budget Categories:</h3>
    <form method="post" action="<?= $_SERVER["PHP_SELF"]; ?>">
        <input type="text" name="searchBudget" placeholder="Search by User Email" value="<?= $searchBudget; ?>" />
        <button type="submit" name="searchBudgetBtn">Search</button>
    </form>
    <div style="color:red;"><?= $budgetError; ?></div>
    <div>
        <?= $budgetResult; ?>
    </div>

    <?php include '../header-footer/admin-footer.php'; ?>

    <script src="../../validation/admin/category-management.js"></script>
</body>
</html>