function fetchIncomeData(filterParams, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../controllers/fetchIncomeData.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Accept', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                callback(data);
            } else {
                console.error('Error fetching data');
            }
        }
    };

    xhr.send(JSON.stringify(filterParams));
}

const incomeTypeLabels = {
    0: 'Regular Main',
    1: 'Regular Side',
    2: 'Irregular'
};

const incomeTypeColors = {
    0: 'rgba(54, 162, 235, 0.7)',  // blue
    1: 'rgba(255, 206, 86, 0.7)',  // yellow
    2: 'rgba(75, 192, 192, 0.7)'   // green
};

// Example: Fetch for year 2025, you can make this dynamic
fetchIncomeData({ year: "2025" }, function(data) {
    const monthsRaw = Array.from(new Set(data.map(item => item.month))).sort();

    const monthLabels = monthsRaw.map(month => {
        const [year, monthNum] = month.split('-');
        const date = new Date(year, monthNum - 1);
        return date.toLocaleString('default', { month: 'short', year: 'numeric' });
    });

    const datasets = [0, 1, 2].map(type => {
        const amounts = monthsRaw.map(month => {
            const record = data.find(d => d.month === month && Number(d.income_type) === type);
            return record ? Number(record.total_amount) : 0;
        });
        return {
            label: incomeTypeLabels[type],
            backgroundColor: incomeTypeColors[type],
            data: amounts
        };
    });

    const ctx = document.getElementById('incomeBarChart').getContext('2d');
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
                    title: { display: true, text: 'Income Amount' }
                }
            },
            plugins: {
                title: { display: true, text: 'Monthly Income by Type' },
                legend: { position: 'top' }
            }
        }
    });
});
