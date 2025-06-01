<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/budgetModel.php');
require_once('../../models/expenseCategoryModel.php');

$category = $amount = $startDate = $endDate = $notes = "";
$prevCategory = $prevAmount = $prevStartDate = $prevEndDate = $prevNotes = "";
$categoryError = $amountError = $startDateError = $endDateError = $emptyError = "";

$categoryId = $_GET['category_id'] ?? ''; 
$budgetId = $_GET['id'] ?? '';
$categories = getExpenseCategoryName($_SESSION['user']['id']);
//var_dump($categoryId, $budgetId);

if (!empty($budgetId)) {
    $budgetInfo = getBudgetInfoById($budgetId);
    if ($budgetInfo) {
        $prevCategory = getExpenseCategoryNameById($categoryId);
        $prevAmount = $budgetInfo['amount'];
        $prevStartDate = $budgetInfo['start_date'];
        $prevEndDate = $budgetInfo['target_date'];
        $prevNotes = $budgetInfo['note'];
    }

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        $category = $prevCategory;
        $amount = $prevAmount;
        $startDate = $prevStartDate;
        $endDate = $prevEndDate;
        $notes = $prevNotes;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;
    $budgetId = $_POST['budgetId'] ?? '';
    $categoryId = $_POST['categoryId'] ?? '';

    if (empty($_POST["budgetCategory"])) {
        $categoryError = "Please select a new category.";
        $isValid = false;
    } else {
        $category = $_POST["budgetCategory"];
    }

    if (empty($_POST["budgetAmount"])) {
        $amountError = "Please enter a new amount.";
        $isValid = false;
    } else {
        $amount = $_POST["budgetAmount"];
        if ($amount < 0) {
            $amountError = "Amount cannot be negative.";
            $isValid = false;
        }
    }

    if (empty($_POST["budgetStartDate"])) {
        $startDateError = "Start date is required.";
        $isValid = false;
    } else {
        $startDate = $_POST["budgetStartDate"];
    }

    if (empty($_POST["budgetEndDate"])) {
        $endDateError = "End date is required.";
        $isValid = false;
    } else {
        $endDate = $_POST["budgetEndDate"];
    }

    if (!empty($_POST["budgetNotes"])) {
        $notes = trim($_POST["budgetNotes"]);
    }

    if (!$isValid) {
        $emptyError = "Please correct the errors above.";
    } else {
        $newCategoryId = getExpenseCategoryIdByName($_SESSION['user']['id'], $category);
        var_dump($newCategoryId, $budgetId);

        $updateStatus = updateBudget($budgetId, $newCategoryId, $amount, $startDate, $endDate, $notes);
        if ($updateStatus) {
            header("Location: budget-dashboard.php?success=Budget updated successfully.");
            exit();
        } else {
            $emptyError = "Failed to update the budget. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Edit Budget</title>
    <link rel="stylesheet" href="../../styles/budget/edit-budget.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Edit Budget</h2>
        </div>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="budget-form two-column-form">
            <input type="hidden" name="budgetId" value="<?= $budgetId ?>" />
            <input type="hidden" name="categoryId" value="<?= $categoryId ?>" />
            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Category</label>
                    <input type="text" value="<?= $prevCategory ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="budgetCategory">New Category</label>
                    <select id="budgetCategory" name="budgetCategory">
                        <option value="">Select</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat ?>" <?= $category === $cat ? 'selected' : '' ?>>
                                <?= $cat ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p id="categoryError" class="error-message"><?= $categoryError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Budget Amount</label>
                    <input type="text" value="<?= $prevAmount ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="budgetAmount">New Budget Amount</label>
                    <input type="number" id="budgetAmount" name="budgetAmount" value="<?= $amount ?>" placeholder="Amount in $" />
                    <p id="amountError" class="error-message"><?= $amountError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Start Date</label>
                    <input type="text" value="<?= $prevStartDate ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="budgetStartDate">New Start Date</label>
                    <input type="date" id="budgetStartDate" name="budgetStartDate" value="<?= $startDate ?>" />
                    <p id="startDateError" class="error-message"><?= $startDateError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous End Date</label>
                    <input type="text" value="<?= $prevEndDate ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="budgetEndDate">New End Date</label>
                    <input type="date" id="budgetEndDate" name="budgetEndDate" value="<?= $endDate ?>" />
                    <p id="endDateError" class="error-message"><?= $endDateError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Notes</label>
                    <textarea readonly><?= $prevNotes ?></textarea>
                </div>
                <div class="form-column">
                    <label for="budgetNotes">New Notes</label>
                    <textarea id="budgetNotes" name="budgetNotes" placeholder="Optional notes about this budget"><?= $notes ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Budget</button>
            <p id="emptyError" class="error-message"><?= $emptyError ?></p>

            <div class="navigation-buttons">
                <a href="budget-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="add-budget.php" class="btn btn-secondary">Add New Budget</a>
                <a href="budget-report.php" class="btn btn-secondary">View Budget Report</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/budget/edit-budget.js"></script>
</body>

</html>