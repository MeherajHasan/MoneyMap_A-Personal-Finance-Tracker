document.addEventListener('DOMContentLoaded', () => {
    const generateBtn = document.getElementById('generateBtn');
    const incomeTableBody = document.querySelector('#incomeTable tbody');
    const chartCanvas = document.getElementById('incomeChart');
    const downloadBtn = document.getElementById('downloadBtn');
    let incomeChart;

    generateBtn.addEventListener('click', () => {
        const year = document.getElementById('yearSelect').value;
        const month = document.getElementById('monthSelect').value;
        const reportType = document.querySelector('input[name="reportType"]:checked').value;

        const selectedTypes = Array.from(document.querySelectorAll('input[name="incomeType"]:checked'))
            .map(input => input.value);

        const dummyData = generateDummyData(reportType, year, month, selectedTypes);

        updateIncomeTable(dummyData);
        updateChart(dummyData, reportType, month);
    });

    downloadBtn.addEventListener('click', () => {
        // Create a CSV file for downloading
        const rows = [];
        rows.push(['Date', 'Income Type', 'Amount ($)', 'Description']);

        const tableRows = incomeTableBody.querySelectorAll('tr');
        tableRows.forEach(row => {
            const rowData = Array.from(row.cells).map(cell => cell.innerText);
            rows.push(rowData);
        });

        const csvContent = "data:text/csv;charset=utf-8," + rows.map(row => row.join(',')).join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'income_report.csv');
        link.click();
    });

    function generateDummyData(reportType, year, month, incomeTypes) {
        const data = [];
        const months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        const range = reportType === "yearly" ? 12 : 1;
        const loopMonths = reportType === "yearly" ? months : [month];

        loopMonths.forEach((mon, idx) => {
            incomeTypes.forEach(type => {
                const amount = Math.floor(Math.random() * 1000) + 100;
                const date = `${mon} ${Math.floor(Math.random() * 28) + 1}, ${year}`;
                data.push({
                    date: date,
                    type: type.charAt(0).toUpperCase() + type.slice(1) + " Income",
                    amount: amount,
                    description: `${type} income for ${mon}`
                });
            });
        });

        return data;
    }

    function updateIncomeTable(data) {
        incomeTableBody.innerHTML = "";
        data.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.date}</td>
                <td>${item.type}</td>
                <td>${item.amount}</td>
                <td>${item.description}</td>
            `;
            incomeTableBody.appendChild(row);
        });
    }

    function updateChart(data, reportType, selectedMonth) {
        const labels = [...new Set(data.map(d => d.date.split(' ')[0]))];
        const grouped = {};

        data.forEach(item => {
            const key = reportType === 'yearly' ? item.date.split(' ')[0] : item.date.split(' ')[1]; // Use month for monthly report
            if (!grouped[key]) grouped[key] = {};
            if (!grouped[key][item.type]) grouped[key][item.type] = 0;
            grouped[key][item.type] += item.amount;
        });

        const chartLabels = Object.keys(grouped);
        const chartData = [];

        // Group the income data by types
        const incomeTypes = ['Main Income', 'Side Income', 'Irregular Income'];
        incomeTypes.forEach(type => {
            const typeData = chartLabels.map(label => grouped[label][type] || 0);
            chartData.push(typeData);
        });

        if (incomeChart) incomeChart.destroy();

        incomeChart = new Chart(chartCanvas, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: incomeTypes.map((type, index) => ({
                    label: type,
                    data: chartData[index],
                    backgroundColor: ['#4FC3F7', '#81C784', '#FFB74D'][index], // Different colors for each income type
                }))
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    title: {
                        display: true,
                        text: reportType === 'yearly' ? 'Monthly Income Overview' : `${selectedMonth} Income Breakdown`
                    }
                },
                scales: {
                    x: { title: { display: true, text: reportType === 'yearly' ? 'Month' : 'Date' } },
                    y: { title: { display: true, text: 'Income ($)' } }
                }
            }
        });
    }
});
