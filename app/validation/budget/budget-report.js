document.addEventListener('DOMContentLoaded', () => {
    const generateBtn = document.getElementById('generateBtn');
    const budgetTableBody = document.querySelector('#budgetTable tbody');
    const totalPlannedElement = document.getElementById('totalPlanned');
    const totalActualElement = document.getElementById('totalActual');
    const budgetStatusElement = document.getElementById('budgetStatus');
    const budgetDifferenceElement = document.getElementById('budgetDifference');
    const budgetUtilizedElement = document.getElementById('budgetUtilized');
    const chartCanvas = document.getElementById('budgetChart');
    const downloadBtn = document.getElementById('downloadBtn');
    const reportPeriodElement = document.getElementById('reportPeriod');
    const appliedFiltersTextElement = document.getElementById('appliedFiltersText');
    const totalPlannedTableElement = document.getElementById('totalPlannedTable');
    const totalActualTableElement = document.getElementById('totalActualTable');
    const totalDifferenceTableElement = document.getElementById('totalDifferenceTable');
    const totalUtilizedTableElement = document.getElementById('totalUtilizedTable');

    let budgetChart;

    generateBtn.addEventListener('click', () => {
        const year = document.getElementById('yearSelect').value;
        const month = document.getElementById('monthSelect').value;
        const reportType = document.querySelector('input[name="reportType"]:checked').value;
        const selectedCategories = Array.from(document.querySelectorAll('input[name="budgetCategory"]:checked'))
            .map(input => input.value);

        const filtersApplied = [];
        filtersApplied.push(`Report Type: ${reportType}`);
        filtersApplied.push(`Year: ${year}`);
        if (month) {
            filtersApplied.push(`Month: ${month}`);
        }
        filtersApplied.push(`Categories: ${selectedCategories.join(', ')}`);
        appliedFiltersTextElement.textContent = filtersApplied.join(' | ');

        const reportPeriodText = reportType === 'yearly' ? `Year: ${year}` : `Month: ${month}, ${year}`;
        reportPeriodElement.textContent = reportPeriodText;

        // In a real application, you would fetch data based on these filters
        const budgetData = generateDummyBudgetReport(reportType, year, month, selectedCategories);
        updateBudgetOverview(budgetData);
        updateBudgetTable(budgetData);
        updateChart(budgetData, reportType, month, selectedCategories);
    });

    downloadBtn.addEventListener('click', () => {
        const reportType = document.querySelector('input[name="reportType"]:checked').value;
        const year = document.getElementById('yearSelect').value;
        const month = document.getElementById('monthSelect').value;
        const selectedCategories = Array.from(document.querySelectorAll('input[name="budgetCategory"]:checked'))
            .map(input => input.value);

        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "Budget Report\n";
        csvContent += `Report Type: ${reportType}, Year: ${year}${month ? `, Month: ${month}` : ''}, Categories: ${selectedCategories.join(', ')}\n\n`;
        csvContent += "Category,Planned Budget ($),Actual Spending ($),Difference ($),% of Budget Used\n";

        const tableRows = budgetTableBody.querySelectorAll('tr');
        tableRows.forEach(row => {
            const rowData = Array.from(row.cells).map(cell => cell.innerText);
            csvContent += rowData.join(',') + "\n";
        });

        csvContent += "\nTotal Planned Budget," + totalPlannedTableElement.innerText + "\n";
        csvContent += "Total Actual Spending," + totalActualTableElement.innerText + "\n";
        csvContent += "Overall Difference," + totalDifferenceTableElement.innerText + "\n";
        csvContent += "Overall % Used," + totalUtilizedTableElement.innerText + "\n";

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'budget_report.csv');
        document.body.appendChild(link); // Required for Firefox
        link.click();
        document.body.removeChild(link);
    });

    function generateDummyBudgetReport(reportType, year, month, categories) {
        const report = {};
        const plannedVsActual = [];
        let totalPlanned = 0;
        let totalActual = 0;

        const dummyPlanned = {
            Housing: 1500,
            Transportation: 500,
            Groceries: 400,
            Entertainment: 200,
            Utilities: 300,
            Healthcare: 150,
            Savings: 200
        };

        const months = month ? [month] : ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        categories.forEach(category => {
            const planned = dummyPlanned[category] || 0;
            let actual = 0;
            if (reportType === 'yearly') {
                months.forEach(() => {
                    actual += Math.random() * (planned * 1.2); // Simulate monthly spending
                });
                actual /= months.length; // Average monthly spending for yearly view
            } else {
                actual = Math.random() * (planned * 1.2);
            }
            actual = Math.max(0, actual); // Ensure no negative spending
            totalPlanned += planned;
            totalActual += actual;
            plannedVsActual.push({ category, planned, actual });
        });

        return { plannedVsActual, totalPlanned, totalActual };
    }

    function updateBudgetOverview(data) {
        totalPlannedElement.textContent = `$${data.totalPlanned.toFixed(2)}`;
        totalActualElement.textContent = `$${data.totalActual.toFixed(2)}`;
        const difference = data.totalPlanned - data.totalActual;
        budgetDifferenceElement.textContent = `$${difference.toFixed(2)}`;
        budgetStatusElement.textContent = difference >= 0 ? 'Under Budget' : 'Over Budget';
        budgetStatusElement.className = difference >= 0 ? 'under-budget' : 'over-budget'; // You'll need CSS for these classes
        const utilizedPercentage = data.totalPlanned > 0 ? (data.totalActual / data.totalPlanned) * 100 : 0;
        budgetUtilizedElement.textContent = `${utilizedPercentage.toFixed(0)}%`;

        totalPlannedTableElement.textContent = `$${data.totalPlanned.toFixed(2)}`;
        totalActualTableElement.textContent = `$${data.totalActual.toFixed(2)}`;
        totalDifferenceTableElement.textContent = `$${difference.toFixed(2)}`;
        totalUtilizedTableElement.textContent = `${utilizedPercentage.toFixed(0)}%`;
    }

    function updateBudgetTable(reportData) {
        budgetTableBody.innerHTML = "";
        reportData.plannedVsActual.forEach(item => {
            const row = document.createElement('tr');
            const difference = item.planned - item.actual;
            const percentageUsed = item.planned > 0 ? (item.actual / item.planned) * 100 : 0;
            row.innerHTML = `
                <td>${item.category}</td>
                <td>$${item.planned.toFixed(2)}</td>
                <td>$${item.actual.toFixed(2)}</td>
                <td class="${difference >= 0 ? 'positive' : 'negative'}">$${difference.toFixed(2)}</td>
                <td>${percentageUsed.toFixed(0)}%</td>
            `;
            budgetTableBody.appendChild(row);
        });
    }

    function updateChart(reportData, reportType, selectedMonth, selectedCategories) {
        const labels = reportData.plannedVsActual.map(item => item.category);
        const plannedData = reportData.plannedVsActual.map(item => item.planned);
        const actualData = reportData.plannedVsActual.map(item => item.actual);

        if (budgetChart) budgetChart.destroy();

        budgetChart = new Chart(chartCanvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Planned Budget',
                        data: plannedData,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Actual Spending',
                        data: actualData,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: reportType === 'yearly' ? `Yearly Budget vs. Actual by Category (${document.getElementById('yearSelect').value})` : `Monthly Budget vs. Actual by Category (${selectedMonth}, ${document.getElementById('yearSelect').value})`
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount ($)'
                        }
                    }
                }
            }
        });
    }
});