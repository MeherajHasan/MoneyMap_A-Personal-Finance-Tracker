<?php
    require_once('../../controllers/userAuth.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Budget Dashboard</title>
    <link rel="stylesheet" href="../../styles/budget/budget-dashboard.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <section class="summary-cards">
            <div class="card budget-total">
                <h3>Total Budget</h3>
                <p>$4,500</p>
            </div>
            <div class="card budget-used">
                <h3>Used Budget</h3>
                <p>$3,000</p>
            </div>
            <div class="card budget-remaining">
                <h3>Remaining Budget</h3>
                <p>$1,500</p>
            </div>
        </section>

        <div class="section-header">
            <h2>Budget Allocations</h2>
            <a href="add-budget.php" class="btn btn-primary">+ Add Budget</a>
        </div>

        <div class="filters">
            <label for="categoryFilter">Category:</label>
            <select id="categoryFilter">
                <option value="all">All</option>
                <option value="housing">Housing</option>
                <option value="food">Food</option>
                <option value="transport">Transport</option>
                <option value="utilities">Utilities</option>
                <option value="entertainment">Entertainment</option>
                <option value="others">Others</option>
            </select>

            <label for="monthFilter">Month:</label>
            <input type="month" id="monthFilter" />
        </div>

        <table class="budget-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Used</th>
                    <th>Remaining</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="budgetTableBody">
                <tr>
                    <td>Housing</td>
                    <td>$1,200</td>
                    <td>$1,000</td>
                    <td>$200</td>
                    <td>2025-05-01</td>
                    <td>2025-05-31</td>
                    <td>Rent and utilities</td>
                    <td>
                        <a href="edit-budget.php?id=1" class="btn-small edit">Edit</a>
                        <button class="btn-small delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Food</td>
                    <td>$800</td>
                    <td>$600</td>
                    <td>$200</td>
                    <td>2025-05-01</td>
                    <td>2025-05-31</td>
                    <td>Groceries and dining out</td>
                    <td>
                        <a href="edit-budget.php?id=2" class="btn-small edit">Edit</a>
                        <button class="btn-small delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Transport</td>
                    <td>$400</td>
                    <td>$250</td>
                    <td>$150</td>
                    <td>2025-05-01</td>
                    <td>2025-05-31</td>
                    <td>Gas and public transit</td>
                    <td>
                        <a href="edit-budget.php?id=3" class="btn-small edit">Edit</a>
                        <button class="btn-small delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Entertainment</td>
                    <td>$300</td>
                    <td>$200</td>
                    <td>$100</td>
                    <td>2025-05-01</td>
                    <td>2025-05-31</td>
                    <td>Movies, games</td>
                    <td>
                        <a href="edit-budget.php?id=4" class="btn-small edit">Edit</a>
                        <button class="btn-small delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="action-buttons">
            <a href="budget-report.php" class="btn">View Budget Report</a>
            <a href="budget-category.php" class="btn">View Budget Categories</a>
            <a href="overspend-notify.php" class="btn">Overspend Notification</a>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/budget/budget-dashboard.js"></script>
</body>

</html>
