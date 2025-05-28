document.addEventListener('DOMContentLoaded', function () {
    fetch('../../controllers/fetchAnalysisData.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('income').innerText = 'Total Income: $' + data.total_income;
            document.getElementById('expense').innerText = 'Total Expenses: $' + data.total_expense;
            document.getElementById('balance').innerText = 'Net Balance: $' + data.net_balance;

            const lineCtx = document.getElementById('lineChart').getContext('2d');
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Income',
                            borderColor: '#0D47A1',
                            data: data.monthly_income
                        },
                        {
                            label: 'Expenses',
                            borderColor: '#F44336',
                            data: data.monthly_expense
                        }
                    ]

                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Income vs. Expenses Over Time',
                            font: {
                                size: 18,
                                weight: 'bold'
                            },
                            color: '#333'
                        }
                    }
                }
            });

            const pieConfig = (ctx, label1, val1, label2, val2, color1, color2) => ({
                type: 'pie',
                data: {
                    labels: [label1, label2],
                    datasets: [{
                        data: [val1, val2],
                        backgroundColor: [color1, color2]
                    }]
                },
                options: {
                    responsive: true
                }
            });

            new Chart(document.getElementById('budgetPie'), pieConfig(
                null, 'Used', data.total_spent, 'Remaining', data.total_budget - data.total_spent, '#42A5F5', '#90CAF9'
            ));
            new Chart(document.getElementById('debtPie'), pieConfig(
                null, 'Paid', data.debt_paid, 'Payable', data.debt_payable, '#66BB6A', '#EF5350'
            ));
            new Chart(document.getElementById('savingsPie'), pieConfig(
                null, 'Saved', data.savings, 'Remaining Goal', data.savings_goal - data.savings, '#FFCA28', '#FFA726'
            ));
        });
});