document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('custom-search-form');
    const fromDate = document.getElementById('from_date');
    const toDate = document.getElementById('to_date');

    form.addEventListener('submit', (e) => {
        fromDate.setCustomValidity('');
        toDate.setCustomValidity('');

        const from = fromDate.value;
        const to = toDate.value;

        if (from && to && new Date(from) > new Date(to)) {
            toDate.setCustomValidity('To Date must be after From Date');
            toDate.reportValidity();
            e.preventDefault(); 
        }
    });
});

// (function () {
//     const chartJsCdn = 'https://cdn.jsdelivr.net/npm/chart.js';

//     function loadChartJs(callback) {
//         if (window.Chart) {
//             callback();
//             return;
//         }
//         const script = document.createElement('script');
//         script.src = chartJsCdn;
//         script.onload = callback;
//         document.head.appendChild(script);
//     }

//     function showError(message) {
//         const container = document.getElementById('graphContainer');
//         container.innerHTML = `<p style="color: red; font-weight: bold; padding: 20px;">${message}</p>`;
//     }

//     function drawLineChart() {
//         const container = document.getElementById('graphContainer');
//         container.innerHTML = `<canvas id="lineChart" width="700" height="400"></canvas>`;

//         const ctx = document.getElementById('lineChart').getContext('2d');

//         // Parse the transaction data (from PHP)
//         const dates = transactionData.map(t => t.date);
//         const amounts = transactionData.map(t => parseFloat(t.amount));

//         if (dates.length === 0) {
//             showError("No data available for the selected range.");
//             return;
//         }

//         // Draw the chart
//         new Chart(ctx, {
//             type: 'line',
//             data: {
//                 labels: dates,
//                 datasets: [{
//                     label: 'Amount Over Time',
//                     backgroundColor: 'rgba(79, 195, 247, 0.5)',
//                     borderColor: 'rgba(11, 89, 153, 1)',
//                     data: amounts,
//                     fill: true,
//                     tension: 0.3,
//                     pointRadius: 5,
//                     pointHoverRadius: 7,
//                 }]
//             },
//             options: {
//                 responsive: true,
//                 plugins: {
//                     legend: {
//                         labels: {
//                             color: '#0D1B2A',
//                             font: {
//                                 size: 14,
//                                 weight: 'bold'
//                             }
//                         }
//                     }
//                 },
//                 scales: {
//                     x: {
//                         type: 'time',
//                         time: {
//                             unit: 'day'
//                         },
//                         ticks: { color: '#1B263B', font: { size: 12 } },
//                         grid: { color: '#e0e0e0' }
//                     },
//                     y: {
//                         ticks: { color: '#1B263B', font: { size: 12 } },
//                         grid: { color: '#e0e0e0' },
//                         beginAtZero: true
//                     }
//                 }
//             }
//         });
//     }

//     function validateForm(event) {
//         event.preventDefault();

//         const status = document.getElementById('status').value.trim();
//         const fromDate = document.getElementById('from_date').value.trim();
//         const toDate = document.getElementById('to_date').value.trim();

//         const container = document.getElementById('graphContainer');
//         container.innerHTML = '';

//         if (!status) {
//             showError('Please select a status.');
//             return;
//         }
//         if (!fromDate) {
//             showError('Please select a "From Date".');
//             return;
//         }
//         if (!toDate) {
//             showError('Please select a "To Date".');
//             return;
//         }

//         if (new Date(fromDate) > new Date(toDate)) {
//             showError('"From Date" cannot be after "To Date".');
//             return;
//         }

//         loadChartJs(drawLineChart);
//     }

//     document.addEventListener('DOMContentLoaded', () => {
//         const form = document.getElementById('custom-search-form');
//         form.addEventListener('submit', validateForm);
//     });
// })();
