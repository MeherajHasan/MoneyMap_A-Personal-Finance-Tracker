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

function isValidNotesString($str) {
    for ($i = 0; $i < strlen($str); $i++) {
        $c = $str[$i];
        if (!(($c >= 'a' && $c <= 'z') ||
              ($c >= 'A' && $c <= 'Z') ||
              ($c >= '0' && $c <= '9') ||
              $c === ' ' || $c === '.' || $c === ',' || $c === '-' ||
              $c === '!' || $c === '?' || $c === ':' || $c === ';' ||
              $c === "\n" || $c === "\r")) {
            return false;
        }
    }
    return true;
}

$debtName = $payeeName = $debtDate = $maxPaymentDate = $principalAmount = $interestRate = $minimumPayment = $notes = "";
$debtNameError = $payeeNameError = $debtDateError = $maxPaymentDateError = $principalAmountError = $interestRateError = $minimumPaymentError = $notesError = $emptyError = "";
$isValid = true;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["debtName"])) {
        $debtNameError = "Debt name is required.";
        $isValid = false;
    } else {
        $debtName = trim($_POST["debtName"]);
        if (!isValidNameString($debtName)) {
            $debtNameError = "Debt name contains invalid characters.";
            $isValid = false;
        }
    }

    if (empty($_POST["payeeName"])) {
        $payeeNameError = "Payee name is required.";
        $isValid = false;
    } else {
        $payeeName = trim($_POST["payeeName"]);
        if (!isValidNameString($payeeName)) {
            $payeeNameError = "Payee name contains invalid characters.";
            $isValid = false;
        }
    }

    if (empty($_POST["debtDate"])) {
        $debtDateError = "Debt date is required.";
        $isValid = false;
    } else {
        $debtDate = $_POST["debtDate"];
    }

    if (!empty($_POST["maxPaymentDate"])) {
        $maxPaymentDate = $_POST["maxPaymentDate"];
        if (!empty($debtDate) && $maxPaymentDate < $debtDate) {
            $maxPaymentDateError = "Maximum payment date cannot be before debt date.";
            $isValid = false;
        }
    }

    if (empty($_POST["principalAmount"])) {
        $principalAmountError = "Principal amount is required.";
        $isValid = false;
    } else {
        $principalAmount = $_POST["principalAmount"];
        if (!is_numeric($principalAmount) || $principalAmount <= 0) {
            $principalAmountError = "Principal amount must be a positive number.";
            $isValid = false;
        }
    }

    if (empty($_POST["interestRate"])) {
        $interestRateError = "Interest rate is required.";
        $isValid = false;
    } else {
        $interestRate = $_POST["interestRate"];
        if (!is_numeric($interestRate) || $interestRate < 0) {
            $interestRateError = "Interest rate must be a non-negative number.";
            $isValid = false;
        }
    }

    if (empty($_POST["minimumPayment"])) {
        $minimumPaymentError = "Minimum payment is required.";
        $isValid = false;
    } else {
        $minimumPayment = $_POST["minimumPayment"];
        if (!is_numeric($minimumPayment) || $minimumPayment < 0) {
            $minimumPaymentError = "Minimum payment must be a non-negative number.";
            $isValid = false;
        }
    }

    if (!empty($_POST["notes"])) {
        $notes = trim($_POST["notes"]);
        if (!isValidNotesString($notes)) {
            $notesError = "Notes contain invalid characters.";
            $isValid = false;
        }
    }

    if ($isValid) {
        // DB 
        header("Location: debt-dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Edit Debt</title>
    <link rel="stylesheet" href="../../styles/debt/edit-debt.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>
<body>
    <?php include '../header-footer/header.php' ?>
    <main class="main container">
        <div class="section-header">
            <h2>Edit Debt</h2>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="debt-form two-column-form">
            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Debt Name</label>
                    <input type="text" value="Existing Debt Name" readonly />
                </div>
                <div class="form-column">
                    <label for="debtName">New Debt Name</label>
                    <input type="text" id="debtName" name="debtName" value="<?= htmlspecialchars($debtName) ?>" placeholder="e.g., Personal Loan, Car Loan" />
                    <p class="error-message"><?= $debtNameError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Payee Name</label>
                    <input type="text" value="Existing Payee Name" readonly />
                </div>
                <div class="form-column">
                    <label for="payeeName">New Payee Name</label>
                    <input type="text" id="payeeName" name="payeeName" value="<?= htmlspecialchars($payeeName) ?>" placeholder="e.g., Bank, Lender" />
                    <p class="error-message"><?= $payeeNameError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Debt Date</label>
                    <input type="text" value="2025-01-01" readonly />
                </div>
                <div class="form-column">
                    <label for="debtDate">New Debt Date</label>
                    <input type="date" id="debtDate" name="debtDate" value="<?= htmlspecialchars($debtDate) ?>" />
                    <p class="error-message"><?= $debtDateError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Max Payment Date</label>
                    <input type="text" value="2025-12-31" readonly />
                </div>
                <div class="form-column">
                    <label for="maxPaymentDate">New Max Payment Date (Optional)</label>
                    <input type="date" id="maxPaymentDate" name="maxPaymentDate" value="<?= htmlspecialchars($maxPaymentDate) ?>" />
                    <p class="error-message"><?= $maxPaymentDateError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Principal Amount</label>
                    <input type="text" value="$5000" readonly />
                </div>
                <div class="form-column">
                    <label for="principalAmount">New Principal Amount</label>
                    <input type="number" id="principalAmount" name="principalAmount" value="<?= htmlspecialchars($principalAmount) ?>" placeholder="Amount in $" />
                    <p class="error-message"><?= $principalAmountError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Interest Rate</label>
                    <input type="text" value="5%" readonly />
                </div>
                <div class="form-column">
                    <label for="interestRate">New Interest Rate (%)</label>
                    <input type="number" id="interestRate" name="interestRate" step="0.01" value="<?= htmlspecialchars($interestRate) ?>" placeholder="Interest rate" />
                    <p class="error-message"><?= $interestRateError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Minimum Payment</label>
                    <input type="text" value="$200" readonly />
                </div>
                <div class="form-column">
                    <label for="minimumPayment">New Minimum Payment</label>
                    <input type="number" id="minimumPayment" name="minimumPayment" step="0.01" value="<?= htmlspecialchars($minimumPayment) ?>" placeholder="Amount in $" />
                    <p class="error-message"><?= $minimumPaymentError ?></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Notes</label>
                    <textarea readonly>Existing notes about the debt...</textarea>
                </div>
                <div class="form-column">
                    <label for="notes">New Notes</label>
                    <textarea id="notes" name="notes" placeholder="Optional details about the debt"><?= htmlspecialchars($notes) ?></textarea>
                    <p class="error-message"><?= $notesError ?></p>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Debt</button>
            <p class="error-message"><?= $emptyError ?></p>

            <div class="navigation-buttons">
                <a href="debt-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="add-debt.php" class="btn btn-secondary">Add New Debt</a>
                <a href="debt-report.php" class="btn btn-secondary">View Debt Report</a>
            </div>
        </form>
    </main>
    <?php include '../header-footer/footer.php' ?>
</body>
</html>
