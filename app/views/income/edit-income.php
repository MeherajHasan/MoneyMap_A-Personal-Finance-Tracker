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

$incomeID = $_GET['id'] ?? null;

$previousIncome = getSpecificIncome($incomeID);
// if (!$previousIncome) {
//     header("Location: income-dashboard.php");
//     exit;
// }

$typeMap = [
    0 => 'main',
    1 => 'side',
    2 => 'irregular'
];
$typeLabelMap = [
    0 => 'Regular Main Income',
    1 => 'Regular Side Income',
    2 => 'Irregular Income'
];

$prevTypeText = $typeLabelMap[$previousIncome['income_type']];
$prevTypeValue = $typeMap[$previousIncome['income_type']];
$prevSource = $previousIncome['source'];
$prevAmount = number_format($previousIncome['amount'], 2);
$prevDate = $previousIncome['income_date'];
$prevNotes = $previousIncome['note'] ?? "";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $incomeType = $typeMap[$previousIncome['income_type']];
    $incomeSource = $prevSource;
    $incomeAmount = $previousIncome['amount'];  
    $incomeDate = $prevDate;
    $incomeNotes = $prevNotes;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $incomeType = $_POST['incomeType'] ?? "";
    $incomeSource = trim($_POST['incomeSource'] ?? "");
    $incomeAmount = trim($_POST['incomeAmount'] ?? "");
    $incomeDate = trim($_POST['incomeDate'] ?? "");
    $incomeNotes = trim($_POST['incomeNotes'] ?? "");

    $hasError = false;

    $validTypes = ["main", "side", "irregular"];
    if ($incomeType !== "" && !in_array($incomeType, $validTypes)) {
        $emptyError = "Please select a valid Income Type.";
        $hasError = true;
    }

    if ($incomeSource !== "") {
        for ($i = 0; $i < strlen($incomeSource); $i++) {
            $c = $incomeSource[$i];
            if (!(($c >= 'a' && $c <= 'z') || ($c >= 'A' && $c <= 'Z') || ($c >= '0' && $c <= '9') || $c === ' ' || $c === '.' || $c === ',' || $c === '-')) {
                $sourceError = "Source contains invalid characters.";
                $hasError = true;
                break;
            }
        }
    }

    if ($incomeAmount === "") {
        $amountError = "Amount is required.";
        $hasError = true;
    } elseif (!is_numeric($incomeAmount) || floatval($incomeAmount) <= 0) {
        $amountError = "Amount must be a positive number.";
        $hasError = true;
    }

    if ($incomeDate === "") {
        $dateError = "Date is required.";
        $hasError = true;
    }

    if (!$hasError) {
        $incomeType = array_search($incomeType, $typeMap);
        $updateSuccess = updateIncome($incomeID, $incomeType, $incomeSource, $incomeAmount, $incomeDate, $incomeNotes);
        if ($updateSuccess) {
            header("Location: income-dashboard.php");
            exit;
        } else {
            $emptyError = "Failed to update income. Please try again.";
        }
    } else {
        if ($emptyError === "") {
            $emptyError = "Please fix the errors above and resubmit.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Edit Income</title>
    <link rel="stylesheet" href="../../styles/income/edit-income.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Edit Income</h2>
        </div>

        <form action="<?= $_SERVER['PHP_SELF'] . '?id=' . urlencode($incomeID) ?>" method="POST" class="income-form two-column-form">

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Income Type</label>
                    <input type="text" value="<?= $prevTypeText ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="incomeType">New Income Type</label>
                    <select id="incomeType" name="incomeType">
                        <option value="" <?= $incomeType === "" ? "selected" : "" ?>>Select</option>
                        <option value="main" <?= $incomeType === "main" ? "selected" : "" ?>>Regular Main Income</option>
                        <option value="side" <?= $incomeType === "side" ? "selected" : "" ?>>Regular Side Income</option>
                        <option value="irregular" <?= $incomeType === "irregular" ? "selected" : "" ?>>Irregular Income</option>
                    </select>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Source</label>
                    <input type="text" value="<?= $prevSource ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="incomeSource">New Source</label>
                    <input type="text" id="incomeSource" name="incomeSource" placeholder="e.g., Freelancing" value="<?= $incomeSource ?>" />
                    <p id="sourceError" class="error-message"><?= $sourceError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Amount</label>
                    <input type="text" value="$<?= $prevAmount ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="incomeAmount">New Amount</label>
                    <input type="number" id="incomeAmount" name="incomeAmount" placeholder="Amount in $" value="<?= $incomeAmount ?>" />
                    <p id="amountError" class="error-message"><?= $amountError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Date</label>
                    <input type="text" value="<?= $prevDate ?>" readonly />
                </div>
                <div class="form-column">
                    <label for="incomeDate">New Date</label>
                    <input type="date" id="incomeDate" name="incomeDate" value="<?= $incomeDate ?>" />
                    <p id="dateError" class="error-message"><?= $dateError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Notes</label>
                    <textarea readonly><?= $prevNotes ?></textarea>
                </div>
                <div class="form-column">
                    <label for="incomeNotes">New Notes</label>
                    <textarea id="incomeNotes" name="incomeNotes" placeholder="Optional details about the income"><?= $incomeNotes ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Income</button>
            <p id="emptyError" class="error-message"><?= $emptyError ?></p>

            <div class="navigation-buttons">
                <a href="income-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="add-income.php" class="btn btn-secondary">Add New Income</a>
                <a href="income-report.php" class="btn btn-secondary">View Income Report</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/income/edit-income.js"></script>
</body>

</html>
