<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/incomeModel.php');

$typeFilter = isset($_GET['type']) ? $_GET['type'] : 'all';
$dateFilter = isset($_GET['date']) ? $_GET['date'] : '';
$incomeId = '';

if ($typeFilter == 'all') {
    $incomeRecords = getAllIncome($_SESSION['user']['id'], $dateFilter);
} elseif ($typeFilter == 'main') {
    $incomeRecords = getRegularMainIncome($_SESSION['user']['id'], $dateFilter);
} elseif ($typeFilter == 'side') {
    $incomeRecords = getRegularSideIncome($_SESSION['user']['id'], $dateFilter);
} elseif ($typeFilter == 'irregular') {
    $incomeRecords = getIrregularIncome($_SESSION['user']['id'], $dateFilter);
} else {
    $incomeRecords = getAllIncome($_SESSION['user']['id'], $dateFilter);
}

$typeMap = [
    0 => 'Regular Main',
    1 => 'Regular Side',
    2 => 'Irregular'
];

if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    deleteIncome($deleteId); 
    header("Location: income-dashboard.php?deleted=1&type=$typeFilter&date=$dateFilter");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Income Dashboard</title>
    <link rel="stylesheet" href="../../styles/income/income-dashboard.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <section class="summary-cards">
            <div class="card income-main">
                <h3>Total Regular Main Income</h3>
                <p><?= totalRegularMainIncome($_SESSION['user']['id']) ?? "0.00"; ?></p>
            </div>
            <div class="card income-side">
                <h3>Total Regular Side Income</h3>
                <p><?= totalRegularSideIncome($_SESSION['user']['id']) ?? "0.00"; ?></p>
            </div>
            <div class="card income-irregular">
                <h3>Total Irregular Income</h3>
                <p><?= totalIrregularIncome($_SESSION['user']['id']) ?? "0.00"; ?></p>
            </div>
            <div class="card income-total">
                <h3>Total Income</h3>
                <p><?= totalIncome($_SESSION['user']['id']) ?? "0.00"; ?></p>
            </div>
        </section>

        <div class="section-header">
            <h2>Income Records</h2>
            <a href="add-income.php" class="btn btn-primary">+ Add Income</a>
        </div>

        <div class="filters">
            <label for="typeFilter">Type:</label>
            <select id="typeFilter">
                <option value="all">All</option>
                <option value="main">Regular Main</option>
                <option value="side">Regular Side</option>
                <option value="irregular">Irregular</option>
            </select>

            <label for="dateFilter">Date:</label>
            <input type="month" id="dateFilter" />
        </div>

        <table class="income-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Source</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="incomeTableBody">
                <?php if ($incomeRecords && mysqli_num_rows($incomeRecords) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($incomeRecords)): ?>
                <tr>
                    <td><?= $typeMap[$row['income_type']]; ?></td>
                    <td><?= $row['source']; ?></td>
                    <td>$<?= number_format($row['amount'], 2); ?></td>
                    <td><?= $row['income_date']; ?></td>
                    <td><?= $row['note']; ?></td>
                    <td>
                        <?php $incomeId = $row['income_id']; ?>
                        <a class="btn-small edit" href="edit-income.php?id=<?= $incomeId; ?>">Edit</a>
                        <button class="btn-small delete"
                            onclick="deleteIncome(<?= $incomeId; ?>)">Delete</button>
                    </td>

                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6">No income records found.</td>
                </tr>
                <?php endif; ?>
            </tbody>

        </table>

        <div class="action-buttons">
            <a href="income-report.php" class="btn">View Income Report</a>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/income/income-dashboard.js"></script>
</body>

</html>