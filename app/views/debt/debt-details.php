<?php
    session_start();

    if (!isset($_COOKIE['status'])) {
        header('Location: ../../views/auth/login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMap || Debt Details</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/debt/debt-details.css">
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="debt-details-container">
            <h2>Debt Details</h2>

            <div class="debt-selector">
                <label for="selectDebt">Select Debt:</label>
                <select id="selectDebt">
                    <option value="">-- Select a Debt --</option>
                    </select>
            </div>

            <div id="debtInformation" class="debt-info-section" style="display:none;">
                <h3>Debt Information</h3>
                <div class="detail-item">
                    <span class="label">Debt Name:</span>
                    <span id="debtNameDisplay" class="value">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Payee Name:</span>
                    <span id="payeeNameDisplay" class="value">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Debt Date:</span>
                    <span id="debtDateDisplay" class="value">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Maximum Payment Date:</span>
                    <span id="maxPaymentDateDisplay" class="value">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Principal Amount:</span>
                    <span id="principalAmountDisplay" class="value">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Interest Rate:</span>
                    <span id="interestRateDisplay" class="value">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Minimum Payment:</span>
                    <span id="minimumPaymentDisplay" class="value">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Notes:</span>
                    <span id="notesDisplay" class="value">-</span>
                </div>

                <h3>Payment Details</h3>
                <div class="detail-item">
                    <span class="label">Total Paid Amount:</span>
                    <span id="paidAmountDisplay" class="value">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Remaining Payable Amount:</span>
                    <span id="payableAmountDisplay" class="value">-</span>
                </div>
                <div class="detail-item">
                    <span class="label">Estimated Total with Interest:</span>
                    <span id="totalWithInterestDisplay" class="value">-</span>
                </div>

                <div class="actions">
                    <a href="debt-pay.php" class="btn btn-primary">Make a Payment</a>
                    <a href="edit-debt.php" class="btn btn-edit">Edit Debt</a>
                    <a href="debt-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>

            <p id="noDebtSelected" style="display:none; text-align: center; font-style: italic; color: #888;">Please select a debt to view its details.</p>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/debt/debt-details.js"></script>
</body>

</html>