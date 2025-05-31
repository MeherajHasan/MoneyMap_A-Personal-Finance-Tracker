<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/budgetModel.php');
require_once('../../models/expenseCategoryModel.php');

$newCategory = '';
$emptyError = '';

$categories = getExpenseCategories($_SESSION['user']['id']);
$categoryNames = getExpenseCategoryName($_SESSION['user']['id']);

function isValidCategoryName($name)
{
    for ($i = 0; $i < strlen($name); $i++) {
        $char = $name[$i];
        if (!(($char >= 'a' && $char <= 'z') ||
            ($char >= 'A' && $char <= 'Z') ||
            ($char >= '0' && $char <= '9') ||
            $char === ' ' || $char === '.' || $char === ',' || $char === '-')) {
            return false;
        }
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['deleteCategoryID'])) {
        $categoryID = $_POST['deleteCategoryID'];
        $deleteCategoryStatus = deleteExpenseCategory($categoryID, $_SESSION['user']['id']);

        if ($deleteCategoryStatus) {
            $deleteBudgetStatus = deleteBudgetByCategory($categoryID, $_SESSION['user']['id']);
            if ($deleteBudgetStatus) {
                header("Location: budget-category.php");
                exit();
            } else {
                $emptyError = 'Failed to delete budget associated with this category.';
            }
        } else {
            $emptyError = 'Failed to delete category. Please try again.';
        }
    }

    $newCategory = trim($_POST['newCategory'] ?? '');

    if ($newCategory === '') {
        $emptyError = 'Category name is required.';
    } elseif (!isValidCategoryName($newCategory)) {
        $emptyError = 'Category name contains invalid characters.';
    } elseif (in_array($newCategory, $categoryNames)) { 
        $emptyError = 'Category already exists.';
    } else {
        $addStatus = addExpenseCategory($_SESSION['user']['id'], $newCategory);
        if ($addStatus) {
            header("Location: budget-category.php");
            exit();
        } else {
            $emptyError = 'Failed to add category. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Budget Categories</title>
    <link rel="stylesheet" href="../../styles/budget/budget-category.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Existing Budget Categories</h2>
            <h3><i>For editing your personal category names, <a href="../expense/expense-category.php"><u>click here!</u></a></i></h3>
        </div>

        <table class="category-table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="categoryTableBody">
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= $cat['name']; ?></td>
                        <td>
                            <?php if ($cat['status'] == 1): ?>
                                <?php if ($cat['status'] == 1): ?>
                                    <form method="POST" action="<?= $_SERVER["PHP_SELF"]; ?>" class="delete-category-form" onclick="return confirm('Are you sure you want to delete this category?');">
                                        <input type="hidden" name="deleteCategoryID" value="<?= $cat['category_id']; ?>">
                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                                <?php else: ?>
                                    <span><i>Default categories cannot be edited or deleted</i></span>
                                <?php endif; ?>

                            <?php else: ?>
                                <span><i>Default categories cannot be edited or deleted</i></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <div class="section-header">
            <h2>Add New Category</h2>
        </div>

        <form method="POST" action="<?= $_SERVER["PHP_SELF"]; ?>" class="add-category">
            <input type="text" id="newCategory" name="newCategory" placeholder="Enter new category name" value="<?= $newCategory; ?>" />
            <button id="addCategoryBtn" class="btn btn-primary" type="submit">+ Add Category</button>
        </form>
        <p id="emptyError"><?= $emptyError; ?></p>

        <div class="navigation-buttons">
            <a href="budget-dashboard.php" class="btn btn-secondary">Back to Budget Dashboard</a>
            <a href="add-budget.php" class="btn btn-secondary">Add New Budget</a>
            <a href="budget-report.php" class="btn btn-secondary">View Budget Report</a>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/budget/budget-category.js"></script>
</body>

</html>