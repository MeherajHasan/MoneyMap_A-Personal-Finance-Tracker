<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/budgetModel.php');
require_once('../../models/expenseCategoryModel.php');

$budgetCategory = $budgetAmount = $budgetStartDate = $budgetEndDate = $budgetNotes = "";
$categoryError = $amountError = $startDateError = $endDateError = "";
$successMessage = "";
$selectedCategory = $_GET['category'] ?? 'all';
$categoryNames = getExpenseCategoryName($_SESSION['user']['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $budgetCategory = $_POST["budgetCategory"] ?? "";
    $budgetAmount = $_POST["budgetAmount"] ?? "";
    $budgetStartDate = $_POST["budgetStartDate"] ?? "";
    $budgetEndDate = $_POST["budgetEndDate"] ?? "";
    $budgetNotes = $_POST["budgetNotes"] ?? "";

    $hasError = false;

    if ($budgetCategory === "") {
        $categoryError = "Select a category.";
        $hasError = true;
    }

    if ($budgetAmount === "" || $budgetAmount <= 0) {
        $amountError = "Enter valid amount.";
        $hasError = true;
    }

    if ($budgetStartDate === "") {
        $startDateError = "Select start date.";
        $hasError = true;
    }

    if ($budgetEndDate === "") {
        $endDateError = "Select end date.";
        $hasError = true;
    }

    if (!$hasError) {
        $categoryId = getExpenseCategoryIdByName($_SESSION['user']['id'], $budgetCategory);
        $addStatus = addNewBudget($categoryId, $_SESSION['user']['id'], $budgetAmount, $budgetStartDate, $budgetEndDate, $budgetNotes);
        if ($addStatus) {
            $successMessage = "Budget added successfully!";
            $budgetCategory = $budgetAmount = $budgetStartDate = $budgetEndDate = $budgetNotes = "";
            header("Location: budget-dashboard.php");
            exit();
        } else {
            $successMessage = "Failed to add budget. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Add Budget</title>
    <link rel="stylesheet" href="../../styles/budget/add-budget.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Add Budget</h2>
            <?php if ($successMessage): ?>
                <p class="success-message"><?= $successMessage ?></p>
            <?php endif; ?>
        </div>

        <form action="<?= $_SERVER["PHP_SELF"]; ?>" method="POST" class="budget-form">
            <div class="form-group">
                <label for="budgetCategory">Category:</label>
                <select id="budgetCategory" name="budgetCategory">
                    <option value="" disabled <?= $budgetCategory === "" ? "selected" : "" ?>>Select Category</option>
                    <?php foreach ($categoryNames as $cat): ?>
                        <option value="<?= strtolower($cat) ?>" <?= strtolower($selectedCategory) == strtolower($cat) ? 'selected' : '' ?>>
                            <?= $cat ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="error-message"><?= $categoryError ?></p>
            </div>

            <div class="form-group">
                <label for="budgetAmount">Budget Amount</label>
                <input type="number" id="budgetAmount" name="budgetAmount" placeholder="Amount in $" value="<?= $budgetAmount ?>" />
                <p class="error-message"><?= $amountError ?></p>
            </div>

            <div class="form-group">
                <label for="budgetStartDate">Start Date</label>
                <input type="date" id="budgetStartDate" name="budgetStartDate" value="<?= $budgetStartDate ?>" />
                <p class="error-message"><?= $startDateError ?></p>
            </div>

            <div class="form-group">
                <label for="budgetEndDate">End Date</label>
                <input type="date" id="budgetEndDate" name="budgetEndDate" value="<?= $budgetEndDate ?>" />
                <p class="error-message"><?= $endDateError ?></p>
            </div>

            <div class="form-group">
                <label for="budgetNotes">Notes (Optional)</label>
                <textarea id="budgetNotes" name="budgetNotes" placeholder="Optional details about the budget"><?= $budgetNotes ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Budget</button>

            <div class="navigation-buttons">
                <a href="budget-dashboard.php" class="btn btn-secondary">Back to Budget Dashboard</a>
                <a href="edit-budget.php" class="btn btn-secondary">Edit Budget</a>
                <a href="budget-report.php" class="btn btn-secondary">View Budget Report</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/budget/add-budget.js"></script>
</body>

</html> 