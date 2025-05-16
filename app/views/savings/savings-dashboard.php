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
                <p id="total-saved">$0.00</p>
            </div>
            <div class="overview-card">
                <h3>Total Goals</h3>
                <p id="total-goals">0</p>
            </div>
            <div class="overview-card">
                <h3>Goals Achieved</h3>
                <p id="goals-achieved">0</p>
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
                    <tr>
                        <td>Vacation Fund</td>
                        <td>$5,000.00</td>
                        <td>$1,200.00</td>
                        <td><progress value="24" max="100"></progress></td>
                        <td>Dec 2025</td>
                        <td>
                            <div class="actions">
                                <a href="edit-savings.php" class="btn btn-secondary">Edit</a>
                                <a href="add-money.php" class="btn btn-success">Add Money</a>
                                <a href="#" class="btn btn-danger">Delete</a>
                            </div>
                        </td>
                    </tr>
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