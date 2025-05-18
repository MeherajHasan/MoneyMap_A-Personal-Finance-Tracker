<?php
    require_once('../../controllers/userAuth.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Add Income</title>
    <link rel="stylesheet" href="../../styles/income/add-income.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Add Income</h2>
        </div>

        <form action="" method="POST" class="income-form">
            <div class="form-group">
                <label for="incomeType">Income Type</label>
                <select id="incomeType" name="incomeType" required>
                    <option value="main">Regular Main Income</option>
                    <option value="side">Regular Side Income</option>
                    <option value="irregular">Irregular Income</option>
                </select>
            </div>

            <div class="form-group">
                <label for="incomeSource">Source</label>
                <input type="text" id="incomeSource" name="incomeSource" placeholder="e.g., Job Salary, Freelancing" />
                <p id="sourceError" class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="incomeAmount">Amount</label>
                <input type="number" id="incomeAmount" name="incomeAmount" placeholder="Amount in $" />
                <p id="amountError" class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="incomeDate">Date</label>
                <input type="date" id="incomeDate" name="incomeDate" />
                <p id="dateError" class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="incomeNotes">Notes (Optional)</label>
                <textarea id="incomeNotes" name="incomeNotes" placeholder="Optional details about the income"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Income</button>
            <p id="emptyError" class="error-message"></p>

            <div class="navigation-buttons">
                <a href="income-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="edit-income.php" class="btn btn-secondary">Edit Income</a>
                <a href="income-report.php" class="btn btn-secondary">View Income Report</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/income/add-income.js"></script>
</body>

</html>
