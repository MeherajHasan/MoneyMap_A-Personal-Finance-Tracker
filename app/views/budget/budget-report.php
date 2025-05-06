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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Budget Report</title>
    <link rel="stylesheet" href="../../styles/budget/budget-report.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header class="header">
        <div class="container">
            <a href="../dashboard/dashboard.html" class="logo-link">
                <img src="../../../public/assets/fullLogo.png" alt="MoneyMap Logo" class="logo" />
            </a>
            <nav class="nav">
                <a href="../dashboard/dashboard.html">Dashboard</a>
                <a href="expenses.html">Expenses</a>
                <a href="budget-dashboard.html">Budget</a>
                <a href="../bills/bills-dashboard.html">Bills</a>
                <a href="../debt/debt-dashboard.html">Debt</a>
                <a href="../savings/savings-dashboard.html">Savings</a>
                <a href="../reports/reports.html">Reports</a>
                <a href="../../../public/index.html">Logout</a>
            </nav>
        </div>
    </header>

    <main class="main container">
        <div class="section-header">
            <h2>Budget Report</h2>
            <p id="reportPeriod"></p> </div>

        <section class="filters">
            <div class="filter-group">
                <label>Report Type:</label>
                <label><input type="radio" name="reportType" value="yearly" checked> Yearly</label>
                <label><input type="radio" name="reportType" value="monthly"> Monthly</label>
            </div>

            <div class="filter-group">
                <label>Budget Categories:</label>
                <div class="checkbox-grid">
                    <label><input type="checkbox" name="budgetCategory" value="Housing" checked> Housing</label>
                    <label><input type="checkbox" name="budgetCategory" value="Transportation" checked> Transportation</label>
                    <label><input type="checkbox" name="budgetCategory" value="Groceries" checked> Groceries</label>
                    <label><input type="checkbox" name="budgetCategory" value="Entertainment" checked> Entertainment</label>
                    <label><input type="checkbox" name="budgetCategory" value="Utilities" checked> Utilities</label>
                    <label><input type="checkbox" name="budgetCategory" value="Healthcare" checked> Healthcare</label>
                    <label><input type="checkbox" name="budgetCategory" value="Savings" checked> Savings</label>
                    </div>
            </div>

            <div class="filter-group">
                <label for="yearSelect">Select Year:</label>
                <select id="yearSelect">
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    </select>
            </div>

            <div class="filter-group">
                <label for="monthSelect">Select Month (optional):</label>
                <select id="monthSelect">
                    <option value="">-- All Months --</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
            </div>

            <div class="filter-group">
                <button id="generateBtn" class="btn btn-primary">Generate Report</button>
            </div>
        </section>

        <section class="budget-overview">
            <h3>Budget Overview</h3>
            <div class="overview-details">
                <p><strong>Total Planned Budget:</strong> <span id="totalPlanned">$0.00</span></p>
                <p><strong>Total Actual Spending:</strong> <span id="totalActual">$0.00</span></p>
                <p><strong>Overall Status:</strong> <span id="budgetStatus"></span></p>
                <p><strong>Difference:</strong> <span id="budgetDifference"></span></p>
                <p><strong>Percentage of Budget Used:</strong> <span id="budgetUtilized">0%</span></p>
            </div>
        </section>

        <section class="chart-section">
            <h3>Budget Breakdown</h3>
            <div class="chart-container">
                <canvas id="budgetChart"></canvas>
            </div>
        </section>

        <section class="budget-table">
            <h3>Spending by Category</h3>
            <table id="budgetTable">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Planned Budget ($)</th>
                        <th>Actual Spending ($)</th>
                        <th>Difference ($)</th>
                        <th>% of Budget Used</th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
                <tfoot>
                    <tr class="total-row">
                        <th>Total</th>
                        <td id="totalPlannedTable">$0.00</td>
                        <td id="totalActualTable">$0.00</td>
                        <td id="totalDifferenceTable"></td>
                        <td id="totalUtilizedTable"></td>
                    </tr>
                </tfoot>
            </table>
        </section>

        <section class="applied-filters">
            <h3>Filters Applied</h3>
            <p id="appliedFiltersText">No filters applied.</p>
        </section>

        <div class="navigation-buttons">
            <a href="#" id="downloadBtn" class="btn btn-secondary">Download Report</a>
            <a href="budget-dashboard.html" class="btn btn-secondary">Back to Budget Dashboard</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 <a href="../../views/landing/about.html">MoneyMap.</a> All rights reserved.</p>
    </footer>

    <script src="../../validation/budget/budget-report.js"></script>
</body>

</html>