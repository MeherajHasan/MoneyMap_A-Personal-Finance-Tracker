<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/expenseCategoryModel.php');

$categoryNames = getExpenseCategoryName($_SESSION['user']['id']);
$categories = getExpenseCategories($_SESSION['user']['id']);

function isValidCategoryName($str)
{
    for ($i = 0; $i < strlen($str); $i++) {
        $c = $str[$i];
        if (!(($c >= 'a' && $c <= 'z') ||
            ($c >= 'A' && $c <= 'Z') ||
            ($c >= '0' && $c <= '9') ||
            $c === ' ' || $c === '.' || $c === ',' || $c === '-')) {
            return false;
        }
    }
    return true;
}

$newCategory = "";
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $newCategory = trim($_POST['newCategory'] ?? '');

        if ($newCategory === '') {
            $error = "Category name cannot be empty.";
        } elseif (!isValidCategoryName($newCategory)) {
            $error = "Category name contains invalid characters.";
        } elseif (in_array($newCategory, $categoryNames)) {
            $error = "Category already exists.";
        } else {
            if (addExpenseCategory($_SESSION['user']['id'], $newCategory)) {
                $success = "Category added successfully.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $error = "Failed to add category.";
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $categoryToDelete = $_POST['category'];
        foreach ($categories as $cat) {
            if ($cat['name'] === $categoryToDelete) {
                if ($cat['status'] == 0) {
                    $error = "Default categories cannot be deleted.";
                } else {
                    if (deleteExpenseCategory($cat['category_id'], $_SESSION['user']['id'])) {
                        $success = "Category deleted successfully.";
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        $error = "Failed to delete category.";
                    }
                }
                break;
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $oldCategory = $_POST['oldCategory'];
        $newCategory = trim($_POST['newCategory'] ?? '');

        if ($newCategory === '') {
            $error = "Category name cannot be empty.";
        } elseif (!isValidCategoryName($newCategory)) {
            $error = "Category name contains invalid characters.";
        } elseif (in_array($newCategory, $categories)) {
            $error = "Category already exists.";
        } else {
            if (($key = array_search($oldCategory, $categories)) !== false) {
                $categories[$key] = $newCategory; // Simulate updating in DB
                $success = "Category updated successfully.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MoneyMap || Expense Categories</title>
    <link rel="stylesheet" href="../../styles/expense/expense-category.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Existing Expense Categories</h2>
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
                    <td><?= $cat['name'] ?></td>
                    <td>
                        <button class="btn btn-edit" data-category="<?= $cat['name'] ?>">Edit</button>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="category" value="<?= $cat['name'] ?>">
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="section-header">
            <h2>Add New Category</h2>
        </div>

        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>" class="add-category">
            <input type="hidden" name="action" value="add">
            <input type="text" id="newCategory" name="newCategory" placeholder="Enter new category name"
                value="<?= $newCategory ?>" autocomplete="off" />
            <button type="submit" id="addCategoryBtn" class="btn btn-primary">Add Category</button>
        </form>

        <?php if ($error): ?>
        <p id="emptyError" style="color: red;"><?= $error ?></p>
        <?php elseif ($success): ?>
        <p style="color: green;"><?= $success ?></p>
        <?php endif; ?>

        <div class="navigation-buttons">
            <a href="expense-dashboard.php" class="btn btn-secondary">Back to Expense Dashboard</a>
            <a href="add-expense.php" class="btn btn-secondary">Add New Expense</a>
            <a href="expense-report.php" class="btn btn-secondary">View Expense Report</a>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/expense/expense-category.js"></script>
</body>

</html>