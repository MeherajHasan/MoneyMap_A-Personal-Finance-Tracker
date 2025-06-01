<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/debtModel.php');

$allDebts = getAllDebts($_SESSION['user']['id']);
$debtID = $_POST['debt_id'] ?? $_GET['id'] ??  null;
$totalWithInterest = 0.00;

$selectedDebt = null;
if ($debtID !== null) {
    foreach ($allDebts as $debt) {
        if ($debt['debt_id'] == $debtID) {
            $selectedDebt = $debt;
            break;
        }
    }
}

if ($selectedDebt !== null) {
    $debtDate = new DateTime($selectedDebt['debt_date']);
    $maxPayDate = new DateTime($selectedDebt['max_pay_date']);
    $interval = $debtDate->diff($maxPayDate);
    $years = $interval->days / 365; 

    $P = (float) $selectedDebt['total_amount'];
    $R = (float) $selectedDebt['interest_rate'] / 100;
    $T = $years;

    $estimatedTotal = $P + ($P * $R * $T);
    $totalWithInterest =  number_format($estimatedTotal, 2);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MoneyMap || Debt Details</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/debt/debt-details.css" />
</head>

<body>
<?php include '../header-footer/header.php' ?>

<main class="main container">
    <div class="debt-details-container">
        <h2>Debt Details</h2>

        <?php if ($selectedDebt !== null): ?>
            <div id="debtInformation" class="debt-info-section">
                <h3>Debt Information</h3>
                <div class="detail-item">
                    <span class="label">Debt Name:</span>
                    <span class="value"><?= $selectedDebt['debt_name'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Payee Name:</span>
                    <span class="value"><?= $selectedDebt['payee_name'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Debt Date:</span>
                    <span class="value"><?= $selectedDebt['debt_date'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Maximum Payment Date:</span>
                    <span class="value"><?= $selectedDebt['max_pay_date'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Principal Amount:</span>
                    <span class="value"><?= $selectedDebt['total_amount'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Interest Rate:</span>
                    <span class="value"><?= $selectedDebt['interest_rate'] ?>%</span>
                </div>
                <div class="detail-item">
                    <span class="label">Minimum Payment:</span>
                    <span class="value"><?= $selectedDebt['min_payment'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Notes:</span>
                    <span class="value"><?= $selectedDebt['notes'] ?></span>
                </div>

                <h3>Payment Details</h3>
                <div class="detail-item">
                    <span class="label">Total Paid Amount:</span>
                    <span class="value"><?= $selectedDebt['paid_amount'] ?? '-' ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Remaining Payable Amount:</span>
                    <span class="value"><?= $selectedDebt['total_amount'] - $selectedDebt['paid_amount'] ?? '-' ?>.00</span>
                </div>
                <div class="detail-item"> 
                    <span class="label">Estimated Total with Interest:</span>
                    <span class="value"><?= $totalWithInterest ?? '-' ?></span>
                </div>

                <div class="actions">
                    <a href="debt-pay.php?id=<?= urlencode($selectedDebt['debt_id']) ?>" class="btn btn-primary">Make a Payment</a>
                    <a href="edit-debt.php?id=<?= urlencode($selectedDebt['debt_id']) ?>" class="btn btn-edit">Edit Debt</a>
                    <a href="debt-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        <?php else: ?>
            <p style="text-align: center; font-style: italic; color: #888;">
                Please select a debt to view its details.
            </p>
        <?php endif; ?>
    </div>
</main>

<?php include '../header-footer/footer.php' ?>

<script src="../../validation/debt/debt-details.js"></script>

</body>
</html>
