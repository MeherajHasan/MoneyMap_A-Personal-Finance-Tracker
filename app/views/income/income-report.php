<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/incomeModel.php');

$userId = $_SESSION['user']['id'];
$reportType = $_GET['reportType'] ?? 'yearly';

$selectedYear = $_GET['year'] ?? date('Y');
$selectedMonth = $_GET['month'] ?? '';

$incomeTypes = $_GET['incomeType'] ?? ['main', 'side', 'irregular'];

$months = [
    '' => '-- All Months --',
    'January' => 'January',
    'February' => 'February',
    'March' => 'March',
    'April' => 'April',
    'May' => 'May',
    'June' => 'June',
    'July' => 'July',
    'August' => 'August',
    'September' => 'September',
    'October' => 'October',
    'November' => 'November',
    'December' => 'December'
];

$dateFilter = '';
if ($reportType === 'monthly' && $selectedMonth !== '') {
    $monthNum = date('m', strtotime($selectedMonth));
    $dateFilter = "$selectedYear-$monthNum";
} elseif ($reportType === 'yearly') {
    // leave empty to fetch all months
}

$incomes = [];
$chartData = [];

function processIncome($res, $label, &$incomes, &$chartData, $reportType)
{
    while ($row = mysqli_fetch_assoc($res)) {
        $row['type'] = $label;
        $incomes[] = $row;
        $date = date($reportType === 'monthly' ? 'd' : 'M', strtotime($row['income_date']));
        if (!isset($chartData[$label][$date])) $chartData[$label][$date] = 0;
        $chartData[$label][$date] += $row['amount'];
    }
}

if (in_array('main', $incomeTypes)) {
    $res = getRegularMainIncome($userId, $dateFilter);
    processIncome($res, 'Main Income', $incomes, $chartData, $reportType);
}
if (in_array('side', $incomeTypes)) {
    $res = getRegularSideIncome($userId, $dateFilter);
    processIncome($res, 'Side Income', $incomes, $chartData, $reportType);
}
if (in_array('irregular', $incomeTypes)) {
    $res = getIrregularIncome($userId, $dateFilter);
    processIncome($res, 'Irregular Income', $incomes, $chartData, $reportType);
}

usort($incomes, fn($a, $b) => strtotime($b['income_date']) - strtotime($a['income_date']));

$tableRowsHtml = '';
if (count($incomes) > 0) {
    foreach ($incomes as $income) {
        $formattedDate = date('Y-m-d', strtotime($income['income_date']));
        $formattedAmount = number_format($income['amount'], 2);
        $type = htmlspecialchars($income['type']);
        $note = htmlspecialchars($income['note']);
        $tableRowsHtml .= "<tr><td>{$formattedDate}</td><td>{$type}</td><td>\${$formattedAmount}</td><td>{$note}</td></tr>";
    }
} else {
    $tableRowsHtml = "<tr><td colspan='4'>No income records found for the selected filters.</td></tr>";
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
        <form method="GET" action="">
            <section class="filters">
                <div class="filter-group">
                    <label>Report Type:</label>
                    <label><input type="radio" name="reportType" value="yearly"
                            <?= $reportType === 'yearly' ? 'checked' : '' ?>> Default</label>
                    <label><input type="radio" name="reportType" value="monthly"
                            <?= $reportType === 'monthly' ? 'checked' : '' ?>> Custom</label>
                </div>

                <div class="filter-group">
                    <label>Income Types:</label>
                    <label><input type="checkbox" name="incomeType[]" value="main"
                            <?= in_array('main', $incomeTypes) ? 'checked' : '' ?>>
                        Main Income</label>
                    <label><input type="checkbox" name="incomeType[]" value="side"
                            <?= in_array('side', $incomeTypes) ? 'checked' : '' ?>>
                        Side Income</label>
                    <label><input type="checkbox" name="incomeType[]" value="irregular"
                            <?= in_array('irregular', $incomeTypes) ? 'checked' : '' ?>>
                        Irregular Income</label>
                </div>

                <div class="filter-group">
                    <label for="yearSelect">Select Year <i>(*select custom)</i>:</label>
                    <select id="yearSelect" name="year">
                        <?php
                        foreach (['2025', '2024', '2023'] as $year) {
                            echo "<option value=\"$year\" " . ($year == $selectedYear ? 'selected' : '') . ">$year</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="monthSelect">Select Month <i>(*select custom)</i>:</label>
                    <select id="monthSelect" name="month">
                        <?php
                        foreach ($months as $value => $label) {
                            echo "<option value=\"$value\" " . ($value == $selectedMonth ? 'selected' : '') . ">$label</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="filter-group">
                    <button id="generateBtn" class="btn btn-primary" type="submit">Generate Report</button>
                </div>
            </section>
        </form>

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
                <?= $tableRowsHtml ?>
            </tbody>
        </table>

        <!-- Download Button -->
        <div class="navigation-buttons">
            <a href="#" id="downloadBtn" class="btn btn-secondary">Download Report</a>
            <a href="income-dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script>
    const chartCtx = document.getElementById('incomeChart').getContext('2d');
    const rawChartData = <?= json_encode($chartData) ?>;

    // Extract unique labels (dates/days/months)
    const labels = [...new Set(Object.values(rawChartData).flatMap(obj => Object.keys(obj)))].sort((a, b) => {
        // Sort by month names or numeric day
        if (<?= json_encode($reportType) ?> === 'monthly') {
            return Number(a) - Number(b);
        } else {
            // Month name sorting (convert month abbrev to date to compare)
            return new Date('1970-' + a + '-01') - new Date('1970-' + b + '-01');
        }
    });

    const datasets = Object.entries(rawChartData).map(([label, data], idx) => {
        const colorList = ['#E53935', '#0D1B2A', '#81C784']; // red, dark blue, light green
        return {
            label,
            data: labels.map(l => data[l] || 0),
            backgroundColor: colorList[idx % colorList.length]
        };
    });

    new Chart(chartCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Income Breakdown by ' + (<?= json_encode($reportType === 'monthly') ?> ? 'Day' : 'Month')
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount ($)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: <?= json_encode($reportType === 'monthly' ? 'Day' : 'Month') ?>
                    }
                }
            }
        }
    });
    </script>
</body>

</html>
