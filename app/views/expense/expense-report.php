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
    <title>MoneyMap || Expense Report</title>
    <link rel="stylesheet" href="../../styles/expense/expense-report.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header class="header">
        <div class="container">
            <img src="../../../public/assets/fullLogo.png" alt="MoneyMap Logo" class="logo" />
            <nav class="nav">
                <a href="../dashboard/dashboard.html">Dashboard</a>
                <a href="expenses.html">Expenses</a>
                <a href="budget-dashboard.html">Budget</a>
                <a href="bills-dashboard.html">Bills</a>
                <a href="debt-dashboard.html">Debt</a>
                <a href="savings-dashboard.html">Savings</a>
                <a href="reports.html">Reports</a>
                <a href="../../../public/index.html">Logout</a>
            </nav>
        </div>
    </header>

    <main class="main container">
        <div class="section-header">
            <h2>Expense Report</h2>
        </div>

        <!-- Filter Panel -->
        <section class="filters">
            <div class="filter-group">
                <label>Report Type:</label>
                <label><input type="radio" name="reportType" value="yearly" checked> Yearly</label>
                <label><input type="radio" name="reportType" value="monthly"> Monthly</label>
            </div>

            <div class="filter-group">
                <label>Expense Categories:</label>
                <label><input type="checkbox" name="expenseCategory" value="House Rent" checked> House Rent</label>
                <label><input type="checkbox" name="expenseCategory" value="Transportation" checked> Transportation</label>
                <label><input type="checkbox" name="expenseCategory" value="Shopping" checked> Shopping</label>
                <label><input type="checkbox" name="expenseCategory" value="Food" checked> Food</label>
                <label><input type="checkbox" name="expenseCategory" value="Cosmetics" checked> Cosmetics</label>
                <label><input type="checkbox" name="expenseCategory" value="Pet" checked> Pet</label>
                <label><input type="checkbox" name="expenseCategory" value="Medical" checked> Medical</label>
                <label><input type="checkbox" name="expenseCategory" value="Education" checked> Education</label>
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

        <!-- Chart Section -->
        <div class="chart-container">
            <canvas id="expenseChart"></canvas>
        </div>

        <!-- Expense Table -->
        <table id="expenseTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Amount ($)</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamically populated rows -->
            </tbody>
        </table>

        <!-- Download Button -->
        <div class="navigation-buttons">
            <a href="#" id="downloadBtn" class="btn btn-secondary">Download Report</a>
            <a href="expense-dashboard.html" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 <a href="../../views/landing/about.html">MoneyMap.</a> All rights reserved.</p>
    </footer>

    <script src="../../validation/expense/expense-report.js"></script>
</body>

</html>
