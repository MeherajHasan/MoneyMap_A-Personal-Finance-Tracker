document.addEventListener('DOMContentLoaded', function () {
    function fetchSavingsData(callback) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../../controllers/fetchSavingsData.php', true);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                callback(data);
            }
        };
        xhr.send();
    }

    fetchSavingsData(function (data) {
        const container = document.getElementById('savingsChartContainer');
        const colors = ['#0D1B2A', '#87CEEB']; 

        data.forEach((savings, index) => {
            const saved = Number(savings.saved_amount);
            const target = Number(savings.target_amount);
            const chartId = `savingsChart${index}`;

            const section = document.createElement('div');
            section.className = 'chart-section';

            const title = document.createElement('h3');
            title.textContent = savings.goal_name;

            const canvas = document.createElement('canvas');
            canvas.id = chartId;

            section.appendChild(title);
            section.appendChild(canvas);
            container.appendChild(section);

            const ctx = canvas.getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Target', 'Saved'],
                    datasets: [{
                        label: savings.goal_name,
                        data: [target, saved],
                        backgroundColor: colors,
                        barThickness: 80,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: { display: false }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Amount'
                            }
                        },
                        y: {
                            ticks: {
                                font: { size: 14 }
                            }
                        }
                    }
                }
            });
        });
    });
});
