document.addEventListener('DOMContentLoaded', function() {
    function fetchDebtData(callback) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../../controllers/fetchDebtData.php', true);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    callback(data);
                } else {
                    console.error('Error fetching debt data', xhr.status, xhr.responseText);
                }
            }
        };
        xhr.send(); 
    }

    fetchDebtData(function(data) {
        const container = document.getElementById('debtChartContainer');

        const colors = [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(201, 203, 207, 0.7)',
            'rgba(255, 99, 71, 0.7)',
            'rgba(60, 179, 113, 0.7)',
            'rgba(106, 90, 205, 0.7)',
            'rgba(0, 191, 255, 0.7)',
            'rgba(255, 105, 180, 0.7)',
            'rgba(160, 82, 45, 0.7)',
            'rgba(72, 209, 204, 0.7)',
            'rgba(0, 128, 128, 0.7)',
            'rgba(255, 215, 0, 0.7)'
        ];

        data.forEach((debt, index) => {
            const paid = Number(debt.paid_amount);
            const total = Number(debt.total_amount);
            const payable = total - paid;

            const chartId = `debtChart${index}`;

            const chartSection = document.createElement('div');
            chartSection.className = 'chart-section';
            chartSection.style.marginBottom = '40px';

            const title = document.createElement('h3');
            title.textContent = debt.debt_name;
 
            const canvas = document.createElement('canvas');
            canvas.id = chartId;
            canvas.width = 400; 
            canvas.height = 400; 

            chartSection.appendChild(title);
            chartSection.appendChild(canvas);
            container.appendChild(chartSection);

            const ctx = canvas.getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Paid', 'Payable'],
                    datasets: [{
                        data: [paid, payable],
                        backgroundColor: [colors[index % colors.length], colors[(index + 1) % colors.length]],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: { display: false },
                        legend: { position: 'right' }
                    }
                }
            });
        });
    });
});