<?php
    require_once('../../controllers/userAuth.php');

    $category = $amount = $startDate = $endDate = $notes = "";
    $categoryError = $amountError = $startDateError = $endDateError = $emptyError = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $isValid = true;

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
            // db
            header("Location: budget-dashboard.php");
            exit();
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

        <form action="" method="POST" class="budget-form two-column-form">
            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Category</label>
                    <input type="text" value="Groceries" readonly />
                </div>
                <div class="form-column">
                    <label for="budgetCategory">New Category</label>
                    <select id="budgetCategory" name="budgetCategory">
                        <option value="">Select</option>
                        <option value="Groceries" <?= $category === 'Groceries' ? 'selected' : '' ?>>Groceries</option>
                        <option value="Utilities" <?= $category === 'Utilities' ? 'selected' : '' ?>>Utilities</option>
                        <option value="Transportation" <?= $category === 'Transportation' ? 'selected' : '' ?>>Transportation</option>
                        <option value="Entertainment" <?= $category === 'Entertainment' ? 'selected' : '' ?>>Entertainment</option>
                        <option value="Healthcare" <?= $category === 'Healthcare' ? 'selected' : '' ?>>Healthcare</option>
                        <option value="Education" <?= $category === 'Education' ? 'selected' : '' ?>>Education</option>
                        <option value="Emergency Fund" <?= $category === 'Emergency Fund' ? 'selected' : '' ?>>Emergency Fund</option>
                    </select>
                    <p id="categoryError" class="error-message"><?= $categoryError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Budget Amount</label>
                    <input type="text" value="$300" readonly />
                </div>
                <div class="form-column">
                    <label for="budgetAmount">New Budget Amount</label>
                    <input type="number" id="budgetAmount" name="budgetAmount" value="<?= htmlspecialchars($amount) ?>" placeholder="Amount in $" />
                    <p id="amountError" class="error-message"><?= $amountError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Start Date</label>
                    <input type="text" value="2025-05-01" readonly />
                </div>
                <div class="form-column">
                    <label for="budgetStartDate">New Start Date</label>
                    <input type="date" id="budgetStartDate" name="budgetStartDate" value="<?= htmlspecialchars($startDate) ?>" />
                    <p id="startDateError" class="error-message"><?= $startDateError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous End Date</label>
                    <input type="text" value="2025-05-31" readonly />
                </div>
                <div class="form-column">
                    <label for="budgetEndDate">New End Date</label>
                    <input type="date" id="budgetEndDate" name="budgetEndDate" value="<?= htmlspecialchars($endDate) ?>" />
                    <p id="endDateError" class="error-message"><?= $endDateError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Notes</label>
                    <textarea readonly>Monthly grocery budget for May</textarea>
                </div>
                <div class="form-column">
                    <label for="budgetNotes">New Notes</label>
                    <textarea id="budgetNotes" name="budgetNotes" placeholder="Optional notes about this budget"><?= htmlspecialchars($notes) ?></textarea>
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
