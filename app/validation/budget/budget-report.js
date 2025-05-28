document.addEventListener('DOMContentLoaded', function () {
    function fetchBudgetData(callback) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../controllers/fetchBudgetData.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');  // Tell server we send JSON
        xhr.setRequestHeader('Accept', 'application/json');        // Tell server we want JSON response

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    callback(data);
                } else {
                    console.error('Error fetching budget data:', xhr.status);
                }
            }
        };

        xhr.send(JSON.stringify({}));
    }

    fetchBudgetData(function (data) {
        const ctx = document.getElementById('budgetChart').getContext('2d');

        const grouped = {};
        const allLabels = [];

        data.forEach(item => {
            const month = item.month_label;
            const category = item.category_name;
            const label = `${category} (${month})`;

            allLabels.push(label);

            grouped[label] = {
                amount: Number(item.amount),
                spent: Number(item.spent_amount)
            };
        });

        const backgroundColors = {
            amount: '#0D47A1',   // dark blue
            spent: '#29B6F6'     // light blue
        };

        const datasets = [
            {
                label: 'Target Amount',
                data: allLabels.map(label => grouped[label]?.amount || 0),
                backgroundColor: backgroundColors.amount
            },
            {
                label: 'Spent Amount',
                data: allLabels.map(label => grouped[label]?.spent || 0),
                backgroundColor: backgroundColors.spent
            }
        ];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: allLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                indexAxis: 'x',
                plugins: {
                    title: {
                        display: true,
                        text: 'Budget vs Spent per Category by Month'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
});
