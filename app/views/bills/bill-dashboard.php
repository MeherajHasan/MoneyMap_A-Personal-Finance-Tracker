<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/billModel.php');

if (isset($_GET['delete'], $_GET['expense']) && is_numeric($_GET['delete']) && is_numeric($_GET['expense'])) {
    $billIdToDelete = (int)$_GET['delete'];
    $expenseIdToUpdate = (int)$_GET['expense'];

    $deleteStatus = deleteBill($billIdToDelete, $expenseIdToUpdate);

    if ($deleteStatus) {
        header("Location: bill-dashboard.php?message=Bill deleted successfully");
        exit();
    } else {
        header("Location: bill-dashboard.php?error=Failed to delete bill");
        exit();
    }
}

$bills = getAllBills($_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bill Dashboard - MoneyMap</title>
    <link rel="stylesheet" href="../../styles/bills/bill-dashboard.css" />
    <link rel="icon" href="../../../public/assets/logo.png" />
</head>

<body>
    <?php include '../header-footer/header.php'; ?>

    <main class="bill-dashboard-container">
        <h1>Bill Dashboard</h1>

        <section class="bill-summary">
            <div class="summary-card paid-bills">
                <h2>Paid Bills</h2>
                <p id="paid-count"><?= countPaidBills($_SESSION['user']['id']) ?></p>
            </div>

            <div class="summary-card due-bills">
                <h2>Due Bills</h2>
                <p id="due-count"><?= countDueBills($_SESSION['user']['id']) ?></p>
            </div>
        </section>

        <section class="bill-actions">
            <a href="add-bill.php" class="btn btn-primary">+ Add New Bill</a>
        </section>

        <section class="bill-list">
            <table>
                <thead>
                    <tr>
                        <th>Bill Name</th>
                        <th>Amount ($)</th>
                        <th>Payment Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="bill-table-body">
                    <?php foreach ($bills as $bill): ?>
                        <tr>
                            <td><?= $bill['bill_name'] ?></td>
                            <td><?= number_format($bill['amount'], 2) ?></td>
                            <td><?= $bill['payment_date'] ?></td>
                            <td class="<?= $bill['status'] == 0 ? 'paid' : 'due' ?>">
                                <?= $bill['status'] == 0 ? 'Paid' : 'Due' ?>
                            </td>
                            <td>
                                <a href="edit-bill.php?id=<?= $bill['bill_id'] ?>" class="btn btn-edit">Edit</a>
                                <a href="bill-dashboard.php?delete=<?= $bill['bill_id'] ?>&expense=<?= $bill['expense_id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this bill?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </section>
    </main>

    <?php include '../header-footer/footer.php'; ?>
    <script src="../../validation/bills/bill-dashboard.js"></script>
</body>

</html>