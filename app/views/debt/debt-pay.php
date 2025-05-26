<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/debtModel.php');

$paymentAmount = "";
$paymentError = "";
$isValid = true;

$debtID = $_GET['id'] ?? null;
//var_dump($debtID); 
if (!$debtID) {
    header("Location: debt-dashboard.php");
    exit();
}

$debt = getDebtByID($debtID, $_SESSION['user']['id']);

if (!$debt) {
    echo "<p>Invalid debt ID or access denied.</p>";
    exit();
}

$min_payment = $debt['min_payment'];
$remainingPayableAmount = $debt['total_amount'] - $debt['paid_amount'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["paymentAmount"])) {
        $paymentError = "Payment amount is required.";
        $isValid = false;
    } else {
        $paymentAmount = trim($_POST["paymentAmount"]);
        if (!is_numeric($paymentAmount) || $paymentAmount <= 0) {
            $paymentError = "Payment amount must be a positive number.";
            $isValid = false;
        } elseif ($paymentAmount > $remainingPayableAmount) {
            $paymentError = "Payment amount cannot exceed remaining payable amount ($" . number_format($remainingPayableAmount, 2) . ").";
            $isValid = false;
        } elseif ($paymentAmount < $min_payment) {
            $paymentError = "Payment amount must be at least the minimum payment amount ($" . number_format($min_payment, 2) . ").";
            $isValid = false;
        } 
    }

    if ($isValid) {
        $payStatus = paymentDebt($debtID, $paymentAmount);
        if ($payStatus) {
            header("Location: debt-dashboard.php?message=Payment successful");
            exit();
        } else {
            $paymentError = "Failed to process payment. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MoneyMap || Pay Debt</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/debt/debt-pay.css" />
</head>
<body>
    <?php include '../header-footer/header.php'; ?>

    <main class="main container">
        <div class="debt-pay-container">
            <h2>Pay Debt</h2>

            <form method="POST" action="debt-pay.php?id=<?= $debtID ?>" class="debt-form">
                <div class="debt-info-section">
                    <h3>Debt Information</h3>
                    <div class="detail-item">
                        <span class="label">Debt Name:</span>
                        <span class="value"><?= $debt['debt_name'] ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Payee Name:</span>
                        <span class="value"><?= $debt['payee_name'] ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Remaining Payable Amount:</span>
                        <span class="value">$<?= number_format($remainingPayableAmount, 2) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Minimum Payment Amount:</span>
                        <span class="value">$<?= number_format($min_payment, 2) ?></span>
                    </div>
                    <div class="payment-form">
                        <label for="paymentAmount">Payment Amount:</label>
                        <input type="number" id="paymentAmount" name="paymentAmount" placeholder="Enter payment amount"
                            value="<?= $paymentAmount ?>"/>
                        <span class="error-message" style="color: red;"><?= $paymentError ?></span>

                        <div class="actions">
                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                            <a href="debt-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <?php include '../header-footer/footer.php'; ?>

    <!-- <script src="../../scripts/debt/debt-pay.js"></script> -->
</body>
</html>
