<?php
    require_once('../../controllers/userAuth.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMap || Pay Debt</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/debt/debt-pay.css">
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="debt-pay-container">
            <h2>Pay Debt</h2>

            <form class="debt-form">
                <div class="debt-info-section">
                    <h3>Debt Information</h3>
                    <div class="detail-item">
                        <span class="label">Debt Name:</span>
                        <span id="debtNameDisplay" class="value">Home Loan</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Payee Name:</span>
                        <span id="payeeNameDisplay" class="value">Bank of MoneyMap</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Remaining Payable Amount:</span>
                        <span id="payableAmountDisplay" class="value">$5,000</span>
                    </div>

                    <div class="payment-form">
                        <label for="paymentAmount">Payment Amount:</label>
                        <input type="number" id="paymentAmount" placeholder="Enter payment amount" />
                        <span id="paymentError" class="error-message" style="color: red;"></span>

                        <div class="actions">
                            <button type="submit" id="submitPayment" class="btn btn-primary">Submit Payment</button>
                            <a href="debt-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/debt/debt-pay.js"></script>
</body>

</html>
