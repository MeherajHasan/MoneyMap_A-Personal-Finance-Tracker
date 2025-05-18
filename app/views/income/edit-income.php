<?php
    require_once('../../controllers/userAuth.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Edit Income</title>
    <link rel="stylesheet" href="../../styles/income/edit-income.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Edit Income</h2>
        </div>

        <form action="" method="POST" class="income-form two-column-form">
            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Income Type</label>
                    <input type="text" value="Regular Main Income" readonly />
                </div>
                <div class="form-column">
                    <label for="incomeType">New Income Type</label>
                    <select id="incomeType" name="incomeType">
                        <option value="">Select</option>
                        <option value="main">Regular Main Income</option>
                        <option value="side">Regular Side Income</option>
                        <option value="irregular">Irregular Income</option>
                    </select>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Source</label>
                    <input type="text" value="Job Salary" readonly />
                </div>
                <div class="form-column">
                    <label for="incomeSource">New Source</label>
                    <input type="text" id="incomeSource" name="incomeSource" placeholder="e.g., Freelancing" />
                    <p id="sourceError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Amount</label>
                    <input type="text" value="$2000" readonly />
                </div>
                <div class="form-column">
                    <label for="incomeAmount">New Amount</label>
                    <input type="number" id="incomeAmount" name="incomeAmount" placeholder="Amount in $" />
                    <p id="amountError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Date</label>
                    <input type="text" value="2025-04-01" readonly />
                </div>
                <div class="form-column">
                    <label for="incomeDate">New Date</label>
                    <input type="date" id="incomeDate" name="incomeDate" />
                    <p id="dateError" class="error-message"></p>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-column">
                    <label>Previous Notes</label>
                    <textarea readonly>Monthly paycheck</textarea>
                </div>
                <div class="form-column">
                    <label for="incomeNotes">New Notes</label>
                    <textarea id="incomeNotes" name="incomeNotes" placeholder="Optional details about the income"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Income</button>
            <p id="emptyError" class="error-message"></p>

            <div class="navigation-buttons">
                <a href="income-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                <a href="add-income.php" class="btn btn-secondary">Add New Income</a>
                <a href="income-report.php" class="btn btn-secondary">View Income Report</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/income/edit-income.js"></script>
</body>

</html>
