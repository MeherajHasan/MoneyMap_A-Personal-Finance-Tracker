document.addEventListener('DOMContentLoaded', () => {
    const generateBtn = document.getElementById('generateBtn');
    const expenseTableBody = document.querySelector('#expenseTable tbody');
    const chartCanvas = document.getElementById('expenseChart');
    const downloadBtn = document.getElementById('downloadBtn');
    let expenseChart;

    generateBtn.addEventListener('click', () => {
        const year = document.getElementById('yearSelect').value;
        const month = document.getElementById('monthSelect').value;
        const reportType = document.querySelector('input[name="reportType"]:checked').value;

        const selectedTypes = Array.from(document.querySelectorAll('input[name="expenseCategory"]:checked')) // Use 'expenseCategory' to match HTML
            .map(input => input.value);

        const dummyData = generateDummyData(reportType, year, month, selectedTypes);

        updateExpenseTable(dummyData);
        updateChart(dummyData, reportType, month, selectedTypes); // Pass selectedTypes to updateChart
    });

    downloadBtn.addEventListener('click', () => {
        const rows = [];
        rows.push(['Date', 'Expense Type', 'Amount ($)', 'Description']);

        const tableRows = expenseTableBody.querySelectorAll('tr');
        tableRows.forEach(row => {
            const rowData = Array.from(row.cells).map(cell => cell.innerText);
            rows.push(rowData);
        });

        const csvContent = "data:text/csv;charset=utf-8," + rows.map(row => row.join(',')).join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'expense_report.csv');
        link.click();
    });

    function generateDummyData(reportType, year, month, expenseTypes) {
        const data = [];
        const months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        const loopMonths = reportType === "yearly" ? months : [month];

        loopMonths.forEach(mon => {
            expenseTypes.forEach(type => {
                const amount = Math.floor(Math.random() * 500) + 50;
                const date = `${mon} ${Math.floor(Math.random() * 28) + 1}, ${year}`;
                data.push({
                    date: date,
                    type: type + " Expense", // Keep the " Expense" suffix for consistency if needed
                    amount: amount,
                    description: `${type} expense for ${mon}`
                });
            });
        });

        return data;
    }

    function updateExpenseTable(data) {
        expenseTableBody.innerHTML = "";
        data.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.date}</td>
                <td>${item.type}</td>
                <td>${item.amount}</td>
                <td>${item.description}</td>
            `;
            expenseTableBody.appendChild(row);
        });
    }

    function updateChart(data, reportType, selectedMonth, expenseTypes) { // Accept selectedTypes
        const labels = [...new Set(data.map(d => d.date.split(' ')[0]))];
        const grouped = {};

        data.forEach(item => {
            const key = reportType === 'yearly' ? item.date.split(' ')[0] : item.date.split(' ')[1];
            if (!grouped[key]) grouped[key] = {};
            if (!grouped[key][item.type]) grouped[key][item.type] = 0;
            grouped[key][item.type] += item.amount;
        });

        const chartLabels = Object.keys(grouped);
        const chartData = [];

        expenseTypes.forEach(type => { 
            const typeData = chartLabels.map(label => grouped[label][type + " Expense"] || 0); // Adjust key if you kept the suffix
            chartData.push(typeData);
        });

        if (expenseChart) expenseChart.destroy();

        expenseChart = new Chart(chartCanvas, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: expenseTypes.map((type, index) => ({ 
                    label: type,
                    data: chartData[index],
                    backgroundColor: ['#FFB74D', '#E57373', '#64B5F6', '#A1887F', '#BA68C8', '#4DB6AC', '#F06292', '#9575CD'][index % 8], // More colors
                }))
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    title: {
                        display: true,
                        text: reportType === 'yearly' ? 'Monthly Expense Overview' : `${selectedMonth} Expense Breakdown`
                    }
                },
                scales: {
                    x: { title: { display: true, text: reportType === 'yearly' ? 'Month' : 'Date' } },
                    y: { title: { display: true, text: 'Expense ($)' } }
                }
            }
        });
    }
});