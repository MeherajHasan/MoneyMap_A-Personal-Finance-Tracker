<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/incomeModel.php');

$incomeType = "";
$incomeSource = "";
$incomeAmount = "";
$incomeDate = "";
$incomeNotes = "";

$sourceError = "";
$amountError = "";
$dateError = "";
$emptyError = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $incomeType = $_POST['incomeType'];
    if ($incomeType === "main") {
        $incomeType = 0;
    } elseif ($incomeType === "side") {
        $incomeType = 1;
    } elseif ($incomeType === "irregular") {
        $incomeType = 2;
    }

    $incomeSource = trim($_POST['incomeSource']);
    $incomeAmount = $_POST['incomeAmount'];
    $incomeDate = $_POST['incomeDate'];
    $incomeNotes = trim($_POST['incomeNotes'] ?? '');

    $hasError = false;

    if ($incomeSource !== "") {
        for ($i = 0; $i < strlen($incomeSource); $i++) {
            $c = $incomeSource[$i];
            if (!(($c >= 'a' && $c <= 'z') ||
                  ($c >= 'A' && $c <= 'Z') ||
                  ($c >= '0' && $c <= '9') ||
                  $c === ' ' || $c === '.' || $c === ',' || $c === '-')) {
                $sourceError = "Source contains invalid characters.";
                $hasError = true;
                break;
            }
        }
    }

    if ($incomeAmount === '') {
        $amountError = "Amount is required.";
        $hasError = true;
    } elseif (!is_numeric($incomeAmount) || floatval($incomeAmount) <= 0) {
        $amountError = "Amount must be a positive number.";
        $hasError = true;
    }

    if ($incomeDate === '') {
        $dateError = "Date is required.";
        $hasError = true;
    }

    if (!$hasError) {
        $user_id = $_SESSION['user']['id'];

        addIncome($user_id, $incomeType, $incomeSource, $incomeAmount, $incomeDate, $incomeNotes);

        header("Location: income-dashboard.php");
        exit;
    } else {
        $emptyError = "Please fix the errors above and resubmit.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Add Income</title>
    <link rel="stylesheet" href="../../styles/income/add-income.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Add Income</h2>
        </div>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="income-form" novalidate>
            <div class="form-group">
                <label for="incomeType">Income Type</label>
                <select id="incomeType" name="incomeType" required>
                    <option value="main" <?= $incomeType === "main" ? 'selected' : '' ?>>Regular Main Income</option>
                    <option value="side" <?= $incomeType === "side" ? 'selected' : '' ?>>Regular Side Income</option>
                    <option value="irregular" <?= $incomeType === "irregular" ? 'selected' : '' ?>>Irregular Income</option>
                </select>
            </div>

            <div class="form-group">
                <label for="incomeSource">Source</label>
                <input type="text" id="incomeSource" name="incomeSource" placeholder="e.g., Job Salary, Freelancing" value="<?= htmlspecialchars($incomeSource) ?>" />
                <p id="sourceError" class="error-message" style="color: red;"><?= htmlspecialchars($sourceError) ?></p>
            </div>

            <div class="form-group">
                <label for="incomeAmount">Amount</label>
                <input type="number" step="0.01" id="incomeAmount" name="incomeAmount" placeholder="Amount in $" value="<?= htmlspecialchars($incomeAmount) ?>" />
                <p id="amountError" class="error-message" style="color: red;"><?= htmlspecialchars($amountError) ?></p>
            </div>

            <div class="form-group">
                <label for="incomeDate">Date</label>
                <input type="date" id="incomeDate" name="incomeDate" value="<?= htmlspecialchars($incomeDate) ?>" />
                <p id="dateError" class="error-message" style="color: red;"><?= htmlspecialchars($dateError) ?></p>
            </div>

            <div class="form-group">
                <label for="incomeNotes">Notes (Optional)</label>
                <textarea id="incomeNotes" name="incomeNotes" placeholder="Optional details about the income"><?= htmlspecialchars($incomeNotes) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Income</button>
            <p id="emptyError" class="error-message" style="color: red;"><?= htmlspecialchars($emptyError) ?></p>

            <div class="navigation-buttons">
                <a href="income-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="edit-income.php" class="btn btn-secondary">Edit Income</a>
                <a href="income-report.php" class="btn btn-secondary">View Income Report</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/income/add-income.js"></script>
</body>

</html>
