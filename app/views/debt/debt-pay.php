<?php
require_once('../../controllers/userAuth.php');

$paymentAmount = "";
$paymentError = "";
$isValid = true;

// Demo value - this would come from DB in real application
$remainingPayableAmount = 5000.00;

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
        }
    }

    if ($isValid) {
        // Example: Handle DB update logic here

        header("Location: debt-dashboard.php");
        exit();
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

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="debt-form">
                <div class="debt-info-section">
                    <h3>Debt Information</h3>
                    <div class="detail-item">
                        <span class="label">Debt Name:</span>
                        <span class="value">Home Loan</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Payee Name:</span>
                        <span class="value">Bank of MoneyMap</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Remaining Payable Amount:</span>
                        <span class="value">$<?php echo number_format($remainingPayableAmount, 2); ?></span>
                    </div>

                    <div class="payment-form">
                        <label for="paymentAmount">Payment Amount:</label>
                        <input type="number" id="paymentAmount" name="paymentAmount" placeholder="Enter payment amount"
                            value="<?php echo htmlspecialchars($paymentAmount); ?>"/>
                        <span class="error-message" style="color: red;"><?php echo $paymentError; ?></span>

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

    <script src="../../scripts/debt/debt-pay.js"></script>
</body>
</html>
