<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/expenseCategoryModel.php');
require_once('../../models/expenseModel.php');
require_once('../../models/billModel.php');

$prevCategory = $prevName = $prevAmount = $prevDate = $prevNotes = $expenseID = "";
$category = $name = $amount = $date = $notes = "";
$categoryError = $nameError = $amountError = $dateError = $emptyError = "";
$hasError = false;

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

if (isset($_GET['id'])) {
    $expenseID = (int)$_GET['id'];
    //var_dump($expenseID);

    $expense = getExpenseById($expenseID);
    if (!$expense) {
        header("Location: expense-dashboard.php");
        exit();
    }

    $prevCategory = $expense['category_name'];
    $prevName = $expense['name'];
    $prevAmount = $expense['amount'];
    $prevDate = $expense['expense_date'];
    $prevNotes = $expense['note'];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $category = $prevCategory;
        $name = $prevName;
        $amount = $prevAmount;
        $date = $prevDate;
        $notes = $prevNotes;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $expenseID = (int)$_POST['expenseID'];
    $expense = getExpenseById($expenseID);
    if ($expense) {
        $prevCategory = $expense['category_name'];
        //var_dump($prevCategory);
        $prevName = $expense['name'];
        $prevAmount = $expense['amount'];
        $prevDate = $expense['expense_date'];
        $prevNotes = $expense['note'];
    } else { 
        header("Location: expense-dashboard.php");
        exit();
    }

    if (empty($_POST['expenseCategory'])) {
        $categoryError = "Please select a category.";
        $hasError = true;
    } else {
        $category = trim($_POST['expenseCategory']);    // selected ta paisi -> str

        $allowedRows = getExpenseCategories($_SESSION['user']['id']);
        $allowedCategories = array_column(($allowedRows), 'name');

        if (!in_array($category, $allowedCategories)) {
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
        } else {
            $amount = floatval($amount);
        }
    }

    if (empty($_POST['expenseDate'])) {
        $dateError = "Date is required.";
        $hasError = true;
    } else {
        $date = $_POST['expenseDate'];
    }


    $notes = $_POST['expenseNotes'] ?? '';

    if (!$hasError) {
        if (
            $category === $prevCategory && $name === $prevName && floatval($amount) === floatval($prevAmount) &&
            $date === $prevDate && $notes === $prevNotes
        ) {
            $emptyError = "No changes detected. Please update at least one field.";
            $hasError = true;
        }
    }

    if (!$hasError) {
        $category_id = (int)getExpenseCategoryIdByName($_SESSION['user']['id'], $category);
        // OK -> category_id
        //var_dump($expenseID, $category_id, $name, $amount, $notes, $date);
        var_dump($prevCategory);
        $prevCategoryId = getExpenseCategoryIdByName($_SESSION['user']['id'], $prevCategory);

        $updateExpense = updateExpense($expenseID, $category_id, $name, $amount, $notes, $date);

        if ($updateExpense) {
            if ($prevCategoryId != 3 && $category_id == 3) {
                addBillViaExpense($_SESSION['user']['id'], $expenseID, $name, $amount, $date, 0);
                header("Location: expense-dashboard.php?msg=update_success");
                exit; 
            } 

            //var_dump($prevCategoryId, $category_id);

            elseif ($prevCategoryId == 3 && $category_id != 3) {
                deleteBillByExpenseId($expenseID);
                header("Location: expense-dashboard.php?msg=update_success");
                exit;
            } 

            else {
                $updateBill = updateBillViaExpense($expenseID, $name, $amount, $date);
                if ($updateBill) {
                    header("Location: expense-dashboard.php?msg=update_success");
                    exit; 
                } else {
                    $emptyError = "Failed to update bill.";
                }
            }
        } else {
            $emptyError = "Failed to update expense. Please try again.";
        }
    }
}
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

        <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="POST" class="expense-form two-column-form">
            <input type="hidden" name="expenseID" value="<?= $expenseID; ?>">
            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Category</label>
                    <input type="text" value="<?= $prevCategory; ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseCategory">New Category</label>
                    <select id="expenseCategory" name="expenseCategory">
                        <option value="" <?php if ($category === '') echo 'selected'; ?>>Select</option>
                        <?php
                        $categories = getExpenseCategoryName($_SESSION['user']['id']);
                        foreach ($categories as $cat) {
                            $selected = ($cat === $category) ? "selected" : "";
                            echo "<option value=\"$cat\" $selected>$cat</option>";
                        }
                        ?>
                    </select>
                    <p id="categoryError" class="error-message"><?= $categoryError; ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Name</label>
                    <input type="text" value="<?= $prevName; ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseName">New Name</label>
                    <input type="text" id="expenseName" name="expenseName" placeholder="e.g., Rent, Groceries"
                        value="<?= $name; ?>" />
                    <p id="nameError" class="error-message"><?= $nameError; ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Amount</label>
                    <input type="text" value="$<?= $prevAmount; ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseAmount">New Amount</label>
                    <input type="number" id="expenseAmount" name="expenseAmount" placeholder="Amount in $"
                        value="<?= $amount; ?>" step="0.01" />
                    <p id="amountError" class="error-message"><?= $amountError; ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Date</label>
                    <input type="text" value="<?= $prevDate; ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseDate">New Date</label>
                    <input type="date" id="expenseDate" name="expenseDate" value="<?= $date; ?>" />
                    <p id="dateError" class="error-message"><?= $dateError; ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Notes</label>
                    <textarea readonly><?= $prevNotes; ?></textarea>
                </div>
                <div class="form-column">
                    <label for="expenseNotes">New Notes</label>
                    <textarea id="expenseNotes" name="expenseNotes"
                        placeholder="Optional details about the expense"><?= $notes; ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Expense</button>
            <p id="emptyError" class="error-message"><?= $emptyError; ?></p>

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