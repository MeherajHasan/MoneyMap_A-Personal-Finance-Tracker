document.addEventListener('DOMContentLoaded', function () {
    const generateBtn = document.getElementById('generate-custom-report');
    const errorDiv = document.querySelector('.custom-range .error');
    const tableBody = document.getElementById('transaction-table-body');
    const chartCanvas = document.getElementById('income-expense-chart');

    let chart;

    generateBtn.addEventListener('click', function () {
        const fromDate = document.getElementById('custom-start-date').value;
        const toDate = document.getElementById('custom-end-date').value;

        errorDiv.textContent = '';

        if (!fromDate || !toDate) {
            errorDiv.textContent = 'Both From and To dates are required.';
            return;
        }

        if (fromDate > toDate) {
            errorDiv.textContent = 'From date must be earlier than To date.';
            return;
        }

        const transactions = [
            { date: '2025-05-01', type: 'Income', category: 'Salary', title: 'May Salary', amount: 3000 },
            { date: '2025-05-05', type: 'Expense', category: 'Groceries', title: 'Supermarket', amount: 150 },
            { date: '2025-05-10', type: 'Expense', category: 'Utilities', title: 'Electricity', amount: 90 },
            { date: '2025-05-15', type: 'Income', category: 'Freelance', title: 'Project Payment', amount: 800 },
            { date: '2025-05-20', type: 'Expense', category: 'Transport', title: 'Gas & Bus', amount: 70 },
        ];

        const filtered = transactions.filter(tx => tx.date >= fromDate && tx.date <= toDate);

        tableBody.innerHTML = '';
        filtered.forEach(tx => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${tx.date}</td>
                <td>${tx.type}</td>
                <td>${tx.category}</td>
                <td>${tx.title}</td>
                <td>${tx.amount.toFixed(2)}</td>
            `;
            tableBody.appendChild(row);
        });

        let incomeTotal = 0, expenseTotal = 0;
        filtered.forEach(tx => {
            if (tx.type === 'Income') incomeTotal += tx.amount;
            else if (tx.type === 'Expense') expenseTotal += tx.amount;
        });

        if (chart) chart.destroy();

        chart = new Chart(chartCanvas, {
            type: 'bar',
            data: {
                labels: ['Income', 'Expense'],
                datasets: [{
                    label: 'Amount ($)',
                    data: [incomeTotal, expenseTotal],
                    backgroundColor: ['#4CAF50', '#F44336']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Income vs Expense Summary' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 500 }
                    }
                }
            }
        });
    });
});
