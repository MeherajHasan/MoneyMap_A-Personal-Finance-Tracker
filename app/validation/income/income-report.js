function fetchIncomeData(callback) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../../controllers/fetchIncomeData.php', true);

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
    xhr.send();
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

fetchIncomeData(function(data) {
    // Step 1: Extract unique raw month keys like "2025-05"
    const monthsRaw = Array.from(new Set(data.map(item => item.month))).sort();

    // Step 2: Format for labels like "May 2025"
    const monthLabels = monthsRaw.map(month => {
        const [year, monthNum] = month.split('-');
        const date = new Date(year, monthNum - 1);
        return date.toLocaleString('default', { month: 'short', year: 'numeric' }); // "May 2025"
    });

    // Step 3: Prepare datasets per income_type
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

    // Step 4: Render chart
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
                    stacked: false, // Bars side-by-side
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
