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
    <title>MoneyMap || Edit Savings</title>
    <link rel="stylesheet" href="../../styles/savings/edit-savings.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Edit Savings Goal</h2>
        </div>

        <form action="" method="POST" class="savings-form two-column-form">
            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Goal Name</label>
                    <input type="text" value="Emergency Fund" readonly />
                </div>
                <div class="form-column">
                    <label for="savingsGoalName">New Goal Name</label>
                    <input type="text" id="savingsGoalName" name="savingsGoalName" placeholder="e.g., Emergency Fund, Vacation" />
                    <p id="nameError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Amount</label>
                    <input type="text" value="$5000" readonly />
                </div>
                <div class="form-column">
                    <label for="savingsAmount">New Amount</label>
                    <input type="number" id="savingsAmount" name="savingsAmount" placeholder="Amount in $" />
                    <p id="amountError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Target Date</label>
                    <input type="text" value="2025-12-31" readonly />
                </div>
                <div class="form-column">
                    <label for="savingsTargetDate">New Target Date</label>
                    <input type="date" id="savingsTargetDate" name="savingsTargetDate" />
                    <p id="dateError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Current Savings</label>
                    <input type="text" value="$1500" readonly />
                </div>
                <div class="form-column">
                    <label for="savingsCurrentAmount">New Current Savings</label>
                    <input type="number" id="savingsCurrentAmount" name="savingsCurrentAmount" placeholder="Current Savings Amount" />
                    <p id="currentAmountError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Notes</label>
                    <textarea readonly>Saving for unexpected emergencies</textarea>
                </div>
                <div class="form-column">
                    <label for="savingsNotes">New Notes</label>
                    <textarea id="savingsNotes" name="savingsNotes" placeholder="Optional details about the savings goal"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Savings Goal</button>
            <p id="emptyError" class="error-message"></p>

            <div class="navigation-buttons">
                <a href="savings-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="add-savings.php" class="btn btn-secondary">Add New Savings Goal</a>
                <a href="savings-report.php" class="btn btn-secondary">View Savings Report</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/savings/edit-savings.js"></script>
</body>

</html>