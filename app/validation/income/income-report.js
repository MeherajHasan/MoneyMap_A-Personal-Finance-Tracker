document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById("incomeChart").getContext("2d");
    const tableRows = document.querySelectorAll("#incomeTable tbody tr");

    const labels = [];
    const amounts = [];

    tableRows.forEach(row => {
        const date = row.getAttribute("data-date");
        const amount = parseFloat(row.getAttribute("data-amount"));
        
        // Format the date as "MMM YYYY" or just "YYYY-MM" as needed
        const formattedDate = new Date(date).toLocaleDateString("en-US", {
            year: "numeric",
            month: "short"
        });

        const index = labels.indexOf(formattedDate);
        if (index !== -1) {
            amounts[index] += amount; // Group by month
        } else {
            labels.push(formattedDate);
            amounts.push(amount);
        }
    });

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [{
                label: "Income Amount ($)",
                data: amounts,
                backgroundColor: "#4FC3F7",
                borderColor: "#0D1B2A",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
