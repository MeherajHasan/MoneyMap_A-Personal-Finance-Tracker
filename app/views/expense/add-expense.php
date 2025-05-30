<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/expenseCategoryModel.php');
require_once('../../models/expenseModel.php');
require_once('../../models/billModel.php');

$categoryNames = getExpenseCategoryName($_SESSION['user']['id']);

function isValidNameString($str)
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

$category = $name = $amount = $date = $notes = "";
$categoryError = $nameError = $amountError = $dateError = "";
$hasError = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST['expenseCategory'])) {
        $categoryError = "Please select a category.";
        $hasError = true;
    } else {
        $category = $_POST['expenseCategory'];
        if (!in_array($category, $categoryNames)) {
            $categoryError = "Invalid category selected.";
            $hasError = true;
        }
    }

    if (empty(trim($_POST['expenseName'] ?? ''))) {
        $nameError = "Name is required.";
        $hasError = true;
    } else {
        $name = trim($_POST['expenseName']);
        if (!isValidNameString($name)) {
            $nameError = "Name contains invalid characters.";
            $hasError = true;
        }
    }

    if (empty(trim($_POST['expenseAmount'] ?? ''))) {
        $amountError = "Amount is required.";
        $hasError = true;
    } else {
        $amount = trim($_POST['expenseAmount']);
        if (!is_numeric($amount) || floatval($amount) <= 0) {
            $amountError = "Amount must be a positive number.";
            $hasError = true;
        }
    }

    if (empty($_POST['expenseDate'])) {
        $dateError = "Date is required.";
        $hasError = true;
    }

    $notes = trim($_POST['expenseNotes'] ?? '');

    if (!$hasError) {
        $categoryID = getExpenseCategoryIdByName($_SESSION['user']['id'], $category);
        if ($categoryID === null) {
            $categoryError = "Invalid category.";
            $hasError = true;
        } elseif ($categoryID === '3') {
            $expenseId = addExpenseReturnId($_SESSION['user']['id'], $categoryID, $name, $amount, $_POST['expenseDate']);

            $addBillStatus = addBillViaExpense($_SESSION['user']['id'], $expenseId, $name, $amount, $_POST['expenseDate'], $notes);
            if ($addBillStatus) {
                header("Location: expense-dashboard.php");
                exit();
            } else {
                $categoryError = "Failed to add bill. Please try again.";
            }
        } else {
            $addExpense = addExpense($_SESSION['user']['id'], $categoryID, $name, $amount, $notes);
            if ($addExpense) {
                header("Location: expense-dashboard.php");
                exit();
            } else {
                $categoryError = "Failed to add expense. Please try again.";
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
    <title>MoneyMap || Add Expense</title>
    <link rel="stylesheet" href="../../styles/expense/add-expense.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Add Expense</h2>
        </div>

        <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="POST" class="expense-form"
            novalidate>
            <div class="form-group">
                <label for="expenseCategory">Category:</label>
                <select id="expenseCategory" name="expenseCategory">
                    <option value="" disabled <?php if ($category === '') echo 'selected'; ?>>Select Category</option>
                    <?php
                    foreach ($categoryNames as $cat) {
                        $selected = ($cat === $category) ? "selected" : "";
                        echo "<option value=\"$cat\" $selected>$cat</option>";
                    }
                    ?>
                </select>

                <p id="categoryError" class="error-message"><?= $categoryError; ?></p>
            </div>

            <div class="form-group">
                <label for="expenseName">Name</label>
                <input type="text" id="expenseName" name="expenseName" placeholder="e.g., Rent, Groceries"
                    value="<?= $name; ?>" />
                <p id="nameError" class="error-message"><?= $nameError; ?></p>
            </div>

            <div class="form-group">
                <label for="expenseAmount">Amount</label>
                <input type="number" id="expenseAmount" name="expenseAmount" placeholder="Amount in $"
                    value="<?= $amount; ?>" step="0.01" />
                <p id="amountError" class="error-message"><?= $amountError; ?></p>
            </div>

            <div class="form-group">
                <label for="expenseDate">Date</label>
                <input type="date" id="expenseDate" name="expenseDate" value="<?= $date; ?>" />
                <p id="dateError" class="error-message"><?= $dateError; ?></p>
            </div>

            <div class="form-group">
                <label for="expenseNotes">Notes (Optional)</label>
                <textarea id="expenseNotes" name="expenseNotes"
                    placeholder="Optional details about the expense"><?= $notes; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Expense</button>

            <div class="navigation-buttons">
                <a href="expense-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="edit-expense.php" class="btn btn-secondary">Edit Expense</a>
                <a href="expense-report.php" class="btn btn-secondary">View Expense Report</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/expense/add-expense.js"></script>
</body>

</html>