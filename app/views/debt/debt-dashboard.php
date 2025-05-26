<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/debtModel.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMap || Debt Dashboard</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/debt/debt-dashboard.css">
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="debt-dashboard-container">
            <h2>Debt Overview</h2>

            <section class="debt-summary">
                <h3>Summary</h3>
                <div class="summary-metrics">
                    <div class="metric-card">
                        <h4>Total Active Debts</h4>
                        <p id="totalDebt"><?= countTotalActiveDebts($_SESSION['user']['id']) ?? '0' ?></p>
                    </div>
                    <div class="metric-card">
                        <h4>Total Active Debt Amount</h4>
                        <p id="totalMinimumPayment">$<?= sumActiveDebtAmounts($_SESSION['user']['id']) ?? '$0.00' ?></p>
                    </div>
                    <div class="metric-card">
                        <h4>Total Payable Amount</h4>
                        <p id="totalInterestRate">
                            $<?= sumActiveDebtAmounts($_SESSION['user']['id']) - sumPaidAmounts($_SESSION['user']['id']) ?? '0.00' ?>
                        </p>
                    </div>
                </div>
            </section>

            <section class="current-debts">
                <h3>Current Debts</h3>
                <ul id="debtList">
                    <?php
                    $debts = getAllActiveDebts($_SESSION['user']['id']);
                    if (!empty($debts)) {
                        foreach ($debts as $debt) {
                            $formattedAmount = number_format($debt['total_amount'], 2);
                            echo "<li>
                                <div class='debt-info'>
                                    <span class='debt-name'>" . htmlspecialchars($debt['debt_name']) . "</span>
                                    <span class='debt-amount'>\${$formattedAmount}</span>
                                </div>
                                <div class='debt-actions'>
                                    <a href='edit-debt.php?id={$debt['debt_id']}' class='btn-edit'>Edit</a>
                                    <a href='debt-details.php?id={$debt['debt_id']}' class='btn-details'>Details</a>
                                    <a href='debt-pay.php?id={$debt['debt_id']}' class='btn-pay'>Pay</a>
                                </div>
                            </li>";
                        }
                    } else {
                        echo "<p id='noDebts'>No debts recorded yet.</p>";
                    }
                    ?>
                </ul>

                <p id="noDebts" style="display:none;">No debts recorded yet.</p>
            </section>

            <div class="actions">
                <a href="add-debt.php" class="btn btn-primary">Add New Debt</a>
                <a href="debt-report.php" class="btn btn-info">Debt Report</a>
            </div>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <!-- <script src="../../validation/debt/debt-dashboard.js"></script> -->
</body>

</html>