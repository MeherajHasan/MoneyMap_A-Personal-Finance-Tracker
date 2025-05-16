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
    <title>MoneyMap || Income Report</title>
    <link rel="stylesheet" href="../../styles/income/income-report.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Income Report</h2>
        </div>

        <!-- Filter Panel -->
        <section class="filters">
            <div class="filter-group">
                <label>Report Type:</label>
                <label><input type="radio" name="reportType" value="yearly" checked> Yearly</label>
                <label><input type="radio" name="reportType" value="monthly"> Monthly</label>
            </div>

            <div class="filter-group">
                <label>Income Types:</label>
                <label><input type="checkbox" name="incomeType" value="main" checked> Main Income</label>
                <label><input type="checkbox" name="incomeType" value="side" checked> Side Income</label>
                <label><input type="checkbox" name="incomeType" value="irregular" checked> Irregular Income</label>
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
            <canvas id="incomeChart"></canvas>
        </div>

        <!-- Income Table -->
        <table id="incomeTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Income Type</th>
                    <th>Amount ($)</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dummy rows to be filled dynamically -->
            </tbody>
        </table>

        <!-- Download Button -->
        <div class="navigation-buttons">
            <a href="#" id="downloadBtn" class="btn btn-secondary">Download Report</a>
            <a href="income-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/income/income-report.js"></script>
</body>

</html>
