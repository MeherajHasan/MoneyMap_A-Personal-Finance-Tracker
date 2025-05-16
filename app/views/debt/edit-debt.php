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

        <form action="" method="POST" class="debt-form two-column-form">
            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Debt Name</label>
                    <input type="text" value="Existing Debt Name" readonly />
                </div>
                <div class="form-column">
                    <label for="debtName">New Debt Name</label>
                    <input type="text" id="debtName" name="debtName" placeholder="e.g., Personal Loan, Car Loan" />
                    <p id="debtNameError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Payee Name</label>
                    <input type="text" value="Existing Payee Name" readonly />
                </div>
                <div class="form-column">
                    <label for="payeeName">New Payee Name</label>
                    <input type="text" id="payeeName" name="payeeName" placeholder="e.g., Bank, Lender" />
                    <p id="payeeNameError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Debt Date</label>
                    <input type="text" value="2025-01-01" readonly />
                </div>
                <div class="form-column">
                    <label for="debtDate">New Debt Date</label>
                    <input type="date" id="debtDate" name="debtDate" />
                    <p id="debtDateError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Max Payment Date</label>
                    <input type="text" value="2025-12-31" readonly />
                </div>
                <div class="form-column">
                    <label for="maxPaymentDate">New Max Payment Date (Optional)</label>
                    <input type="date" id="maxPaymentDate" name="maxPaymentDate" />
                    <p id="maxPaymentDateError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Principal Amount</label>
                    <input type="text" value="$5000" readonly />
                </div>
                <div class="form-column">
                    <label for="principalAmount">New Principal Amount</label>
                    <input type="number" id="principalAmount" name="principalAmount" placeholder="Amount in $" />
                    <p id="principalAmountError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Interest Rate</label>
                    <input type="text" value="5%" readonly />
                </div>
                <div class="form-column">
                    <label for="interestRate">New Interest Rate (%)</label>
                    <input type="number" id="interestRate" name="interestRate" step="0.01" placeholder="Interest rate" />
                    <p id="interestRateError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Minimum Payment</label>
                    <input type="text" value="$200" readonly />
                </div>
                <div class="form-column">
                    <label for="minimumPayment">New Minimum Payment</label>
                    <input type="number" id="minimumPayment" name="minimumPayment" step="0.01" placeholder="Amount in $" />
                    <p id="minimumPaymentError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Notes</label>
                    <textarea readonly>Existing notes about the debt...</textarea>
                </div>
                <div class="form-column">
                    <label for="notes">New Notes</label>
                    <textarea id="notes" name="notes" placeholder="Optional details about the debt"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Debt</button>
            <p id="emptyError" class="error-message"></p>

            <div class="navigation-buttons">
                <a href="debt-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="add-debt.php" class="btn btn-secondary">Add New Debt</a>
                <a href="debt-report.php" class="btn btn-secondary">View Debt Report</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/debt/edit-debt.js"></script>
</body>

</html>
