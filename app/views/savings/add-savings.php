<?php
require_once('../../controllers/userAuth.php');

$goalName = $targetAmount = $targetDate = $description = "";
$nameError = $amountError = $dateError = "";
$successMessage = "";

function isValidBillName($name) {
    for ($i = 0; $i < strlen($name); $i++) {
        $char = $name[$i];
        if (!(($char >= 'a' && $char <= 'z') ||
              ($char >= 'A' && $char <= 'Z') ||
              ($char >= '0' && $char <= '9') ||
              $char === ' ' || $char === '.' || $char === ',' || $char === '-')) {
            return false;
        }
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $goalName = trim($_POST['goal-name']);
    $targetAmount = $_POST['target-amount'];
    $targetDate = $_POST['target-date'];
    $description = trim($_POST['description']);

    $hasError = false;

    if ($goalName === "") {
        $nameError = "Goal name is required.";
        $hasError = true;
    } elseif (!isValidBillName($goalName)) {
        $nameError = "Only letters, digits, spaces, ., , and - are allowed.";
        $hasError = true;
    }

    if ($targetAmount === "" || !is_numeric($targetAmount)) {
        $amountError = "Valid amount is required.";
        $hasError = true;
    } elseif ((float)$targetAmount <= 0) {
        $amountError = "Amount must be greater than 0.";
        $hasError = true;
    }

    if ($targetDate === "") {
        $dateError = "Target date is required.";
        $hasError = true;
    }

    if (!$hasError) {
        // db
        $successMessage = "Savings goal added successfully!";
        $goalName = $targetAmount = $targetDate = $description = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Add New Savings Goal</title>
    <link rel="stylesheet" href="../../styles/savings/add-savings.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php'; ?>

    <main class="main container">
        <div class="form-container">
            <h2>Add New Savings Goal</h2>

            <?php if ($successMessage): ?>
                <p class="successMSG"><?= $successMessage ?></p>
            <?php endif; ?>

            <form id="add-savings-form" method="POST" action="">
                <div class="form-group">
                    <label for="goal-name">Goal Name</label>
                    <input type="text" id="goal-name" name="goal-name" placeholder="Enter goal name" value="<?= htmlspecialchars($goalName) ?>">
                    <p id="nameError" class="errorMSG"><?= $nameError ?></p>
                </div>
                <div class="form-group">
                    <label for="target-amount">Target Amount</label>
                    <input type="number" id="target-amount" name="target-amount" placeholder="Enter target amount" value="<?= htmlspecialchars($targetAmount) ?>">
                    <p id="amountError" class="errorMSG"><?= $amountError ?></p>
                </div>
                <div class="form-group">
                    <label for="target-date">Target Date</label>
                    <input type="date" id="target-date" name="target-date" value="<?= htmlspecialchars($targetDate) ?>">
                    <p id="dateError" class="errorMSG"><?= $dateError ?></p>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Enter a description (optional)"><?= htmlspecialchars($description) ?></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Goal</button>
                </div>
            </form>
        </div>
    </main>

    <?php include '../header-footer/footer.php'; ?>
    <script src="../../scripts/savings/add-savings.js"></script>
</body>

</html>
