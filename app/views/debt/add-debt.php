<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/debtModel.php');

$isValid = true;
$debtName = $payeeName = $debtDate = $maxPaymentDate = "";
$principalAmount = $interestRate = $minimumPayment = $notes = "";

$debtNameError = $payeeNameError = $debtDateError = $maxPaymentDateError = "";
$principalAmountError = $interestRateError = $minimumPaymentError = $notesError = "";

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
        if ($debtDate !== "" && $maxPaymentDate < $debtDate) {
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
        $addDebt = addNewDebt($_SESSION['user']['id'], $debtName, $payeeName, $debtDate, $maxPaymentDate, $principalAmount, $interestRate, $minimumPayment, $notes);
        if ($addDebt) {
            header("Location: debt-dashboard.php?success=Debt added successfully.");
            exit();
        } else {
            $notesError = "Failed to add debt. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MoneyMap || Add New Debt</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/debt/add-debt.css" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="add-debt-container">
            <h2>Add New Debt</h2>
            <form action="" id="addDebtForm" method="POST" novalidate>
                <div class="form-group">
                    <label for="debtName">Debt Name:</label>
                    <input type="text" id="debtName" name="debtName" value="<?php echo htmlspecialchars($debtName); ?>" />
                    <p class="error-message"><?php echo $debtNameError; ?></p>
                </div>

                <div class="form-group">
                    <label for="payeeName">Payee Name:</label>
                    <input type="text" id="payeeName" name="payeeName" value="<?php echo htmlspecialchars($payeeName); ?>" />
                    <p class="error-message"><?php echo $payeeNameError; ?></p>
                </div>

                <div class="form-group">
                    <label for="debtDate">Debt Date:</label>
                    <input type="date" id="debtDate" name="debtDate" value="<?php echo htmlspecialchars($debtDate); ?>" />
                    <p class="error-message"><?php echo $debtDateError; ?></p>
                </div>

                <div class="form-group">
                    <label for="maxPaymentDate">Maximum Payment Date (Optional):</label>
                    <input type="date" id="maxPaymentDate" name="maxPaymentDate" value="<?php echo htmlspecialchars($maxPaymentDate); ?>" />
                    <p class="error-message"><?php echo $maxPaymentDateError; ?></p>
                </div>

                <div class="form-group">
                    <label for="principalAmount">Principal Amount:</label>
                    <input type="number" id="principalAmount" name="principalAmount" step="0.01" value="<?php echo htmlspecialchars($principalAmount); ?>" />
                    <p class="error-message"><?php echo $principalAmountError; ?></p>
                </div>

                <div class="form-group">
                    <label for="interestRate">Interest Rate (%):</label>
                    <input type="number" id="interestRate" name="interestRate" step="0.01" value="<?php echo htmlspecialchars($interestRate); ?>" />
                    <p class="error-message"><?php echo $interestRateError; ?></p>
                </div>

                <div class="form-group">
                    <label for="minimumPayment">Minimum Payment:</label>
                    <input type="number" id="minimumPayment" name="minimumPayment" step="0.01" value="<?php echo htmlspecialchars($minimumPayment); ?>" />
                    <p class="error-message"><?php echo $minimumPaymentError; ?></p>
                </div>

                <div class="form-group">
                    <label for="notes">Notes (Optional):</label>
                    <textarea id="notes" name="notes"><?php echo htmlspecialchars($notes); ?></textarea>
                    <p class="error-message"><?php echo $notesError; ?></p>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Add Debt</button>
                    <a href="debt-dashboard.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/debt/add-debt.js"></script>
</body>

</html>
