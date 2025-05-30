<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/savingsModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['savingsID'])) {
    $savingsID = $_POST['savingsID'];
    if (deleteSavings($savingsID)) {
        header('Location: savings-dashboard.php');
        exit();
    } else {
        echo "<script>alert('Error deleting savings goal. Please try again.');</script>";
    }
}
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMap || Savings Dashboard</title>
    <link rel="stylesheet" href="../../styles/savings/savings-dashboard.css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="overview-cards">
            <div class="overview-card">
                <h3>Total Saved</h3>
                <p id="total-saved">$<?= getTotalSavings($_SESSION['user']['id']) ?? '0.00' ?></p>
            </div>
            <div class="overview-card">
                <h3>Total Goals</h3>
                <p id="total-goals"><?= getTotalGoals($_SESSION['user']['id']) ?? '0' ?></p>
            </div>
            <div class="overview-card">
                <h3>Goals Achieved</h3>
                <p id="goals-achieved"><?= getAchievedGoals($_SESSION['user']['id']) ?? '0' ?></p>
            </div>
        </div>

        <div class="savings-table">
            <h2>My Savings Goals</h2>
            <table>
                <thead>
                    <tr>
                        <th>Goal Name</th>
                        <th>Target Amount</th>
                        <th>Amount Saved</th>
                        <th>Progress</th>
                        <th>Target Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $savingsList = getAllSavingsDetails($_SESSION['user']['id']);
                    if (count($savingsList) === 0) {
                        echo '<tr><td colspan="6">No savings goals found.</td></tr>';
                    } else {
                        foreach ($savingsList as $saving) {
                            $progress = 0;
                            if ($saving['target_amount'] > 0) {
                                $progress = ($saving['saved_amount'] / $saving['target_amount']) * 100;
                                if ($progress > 100) $progress = 100;
                            }

                            $targetAmount = number_format($saving['target_amount'], 2);
                            $savedAmount = number_format($saving['saved_amount'], 2);
                            $targetDate = date("M Y", strtotime($saving['target_date']));

                            $editUrl = "edit-savings.php?id=" . $saving['savings_id'];
                            $addMoneyUrl = "add-money.php?id=" . $saving['savings_id'];
                            $deleteUrl = "delete-savings.php?id=" . $saving['savings_id'];

                            echo "<tr>
                                    <td>" . $saving['goal_name'] . "</td>
                                    <td>\$$targetAmount</td>
                                    <td>\$$savedAmount</td>
                                    <td><progress value=\"$progress\" max=\"100\"></progress> " . round($progress) . "%</td>
                                    <td>$targetDate</td>
                                    <td> 
                                        <div class=\"actions\">
                                            <a href=\"$editUrl\" class=\"btn btn-secondary\">Edit</a>
                                            <a href=\"$addMoneyUrl\" class=\"btn btn-success\">Add Money</a>
                                            <form method=\"POST\" action=\"savings-dashboard.php\" style=\"display:inline;\" onsubmit=\"return confirm('Are you sure you want to delete this goal?');\">
                                                <input type=\"hidden\" name=\"savingsID\" value=\"" . $saving['savings_id'] . "\">
                                                <button type=\"submit\" class=\"btn btn-danger\">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>";
                        }
                    }
                    ?>
                </tbody>

            </table>
        </div>

        <div class="additional-actions">
            <a href="add-savings.php" class="btn btn-primary">Add New Goal</a>
            <a href="savings-report.php" class="btn btn-info">Savings Report</a>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/savings/savings-dashboard.js"></script>
</body>

</html>