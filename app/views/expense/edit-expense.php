<?php
require_once('../../controllers/userAuth.php');

function isValidNameString($str) {
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

// demo value
$prevCategory = "House Rent";
$prevName = "Monthly Rent";
$prevAmount = 1200;
$prevDate = "2025-05-01";
$prevNotes = "Rent for May 2025";

$category = $name = $amount = $date = $notes = "";
$categoryError = $nameError = $amountError = $dateError = $emptyError = "";
$hasError = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST['expenseCategory'])) {
        $categoryError = "Please select a category.";
        $hasError = true;
    } else {
        $category = $_POST['expenseCategory'];
        $allowedCategories = ["House Rent", "Transportation", "Shopping", "Food", "Cosmetics", "Pet", "Medical", "Education"];
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

    if (!$hasError) {
        if (
            $category === $prevCategory &&
            $name === $prevName &&
            floatval($amount) === floatval($prevAmount) &&
            $date === $prevDate &&
            $notes === $prevNotes
        ) {
            $emptyError = "No changes detected. Please update at least one field.";
            $hasError = true;
        }
    }

    if (!$hasError) {
        // db
        header("Location: expense-dashboard.php");
        exit;
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

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="expense-form two-column-form">
            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Category</label>
                    <input type="text" value="<?php echo htmlspecialchars($prevCategory); ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseCategory">New Category</label>
                    <select id="expenseCategory" name="expenseCategory">
                        <option value="" <?php if ($category === '') echo 'selected'; ?>>Select</option>
                        <?php
                        $categories = ["House Rent", "Transportation", "Shopping", "Food", "Cosmetics", "Pet", "Medical", "Education"];
                        foreach ($categories as $cat) {
                            $selected = ($cat === $category) ? "selected" : "";
                            echo "<option value=\"$cat\" $selected>$cat</option>";
                        }
                        ?>
                    </select>
                    <p id="categoryError" class="error-message"><?php echo $categoryError; ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Name</label>
                    <input type="text" value="<?php echo htmlspecialchars($prevName); ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseName">New Name</label>
                    <input type="text" id="expenseName" name="expenseName" placeholder="e.g., Rent, Groceries"
                        value="<?php echo htmlspecialchars($name); ?>" />
                    <p id="nameError" class="error-message"><?php echo $nameError; ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Amount</label>
                    <input type="text" value="$<?php echo htmlspecialchars($prevAmount); ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseAmount">New Amount</label>
                    <input type="number" id="expenseAmount" name="expenseAmount" placeholder="Amount in $"
                        value="<?php echo htmlspecialchars($amount); ?>" step="0.01" />
                    <p id="amountError" class="error-message"><?php echo $amountError; ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Date</label>
                    <input type="text" value="<?php echo htmlspecialchars($prevDate); ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="expenseDate">New Date</label>
                    <input type="date" id="expenseDate" name="expenseDate" value="<?php echo htmlspecialchars($date); ?>" />
                    <p id="dateError" class="error-message"><?php echo $dateError; ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Notes</label>
                    <textarea readonly><?php echo htmlspecialchars($prevNotes); ?></textarea>
                </div>
                <div class="form-column">
                    <label for="expenseNotes">New Notes</label>
                    <textarea id="expenseNotes" name="expenseNotes"
                        placeholder="Optional details about the expense"><?php echo htmlspecialchars($notes); ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Expense</button>
            <p id="emptyError" class="error-message"><?php echo $emptyError; ?></p>

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
