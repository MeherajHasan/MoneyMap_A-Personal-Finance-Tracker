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
    <title>MoneyMap || Add New Debt</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/debt/add-debt.css">
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="add-debt-container">
            <h2>Add New Debt</h2>
            <form action="" id="addDebtForm" method="POST">
                <div class="form-group">
                    <label for="debtName">Debt Name:</label>
                    <input type="text" id="debtName" name="debtName">
                    <p class="error-message" id="debtNameError"></p>
                </div>

                <div class="form-group">
                    <label for="payeeName">Payee Name:</label>
                    <input type="text" id="payeeName" name="payeeName">
                    <p class="error-message" id="payeeNameError"></p>
                </div>

                <div class="form-group">
                    <label for="debtDate">Debt Date:</label>
                    <input type="date" id="debtDate" name="debtDate">
                    <p class="error-message" id="debtDateError"></p>
                </div>

                <div class="form-group">
                    <label for="maxPaymentDate">Maximum Payment Date (Optional):</label>
                    <input type="date" id="maxPaymentDate" name="maxPaymentDate">
                    <p class="error-message" id="maxPaymentDateError"></p>
                </div>

                <div class="form-group">
                    <label for="principalAmount">Principal Amount:</label>
                    <input type="number" id="principalAmount" name="principalAmount" step="0.01">
                    <p class="error-message" id="principalAmountError"></p>
                </div>

                <div class="form-group">
                    <label for="interestRate">Interest Rate (%):</label>
                    <input type="number" id="interestRate" name="interestRate" step="0.01">
                    <p class="error-message" id="interestRateError"></p>
                </div>

                <div class="form-group">
                    <label for="minimumPayment">Minimum Payment:</label>
                    <input type="number" id="minimumPayment" name="minimumPayment" step="0.01">
                    <p class="error-message" id="minimumPaymentError"></p>
                </div>

                <div class="form-group">
                    <label for="notes">Notes (Optional):</label>
                    <textarea id="notes" name="notes"></textarea>
                    <p class="error-message" id="notesError"></p>
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