function fetchExpenseData(callback) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../controllers/fetchExpenseData.php', true);

    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Accept', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                callback(data);
            } else {
                console.error('Error fetching expense data');
            }
        }
    };

    xhr.send(JSON.stringify({}));
}

fetchExpenseData(function (data) {
    const monthsRaw = Array.from(new Set(data.map(item => item.month))).sort();

    const monthLabels = monthsRaw.map(month => {
        const [year, monthNum] = month.split('-');
        const date = new Date(year, monthNum - 1);
        return date.toLocaleString('default', { month: 'short', year: 'numeric' });
    });

    const categories = Array.from(new Set(data.map(item => item.category_name))).sort();

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
        'rgba(238, 130, 238, 0.7)',
        'rgba(255, 215, 0, 0.7)',
        'rgba(0, 191, 255, 0.7)',
        'rgba(220, 20, 60, 0.7)',
        'rgba(128, 0, 0, 0.7)',
        'rgba(0, 128, 128, 0.7)'
    ];

    const datasets = categories.map((cat, index) => {
        const amounts = monthsRaw.map(month => {
            const record = data.find(d => d.month === month && d.category_name === cat);
            return record ? Number(record.total_amount) : 0;
        });
        return {
            label: cat,
            backgroundColor: colors[index % colors.length],
            data: amounts
        };
    });

    const ctx = document.getElementById('expenseBarChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: datasets
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    stacked: false,
                    title: { display: true, text: 'Month' }
                },
                y: {
                    stacked: false,
                    beginAtZero: true,
                    title: { display: true, text: 'Expense Amount' }
                }
            },
            plugins: {
                title: { display: true, text: 'Monthly Expense by Category' },
                legend: { position: 'top' }
            }
        }
    });
});
