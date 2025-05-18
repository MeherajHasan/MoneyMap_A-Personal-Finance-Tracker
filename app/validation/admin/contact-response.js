// Sample demo responses
const demoData = [
    { id: 1, name: "John Doe", email: "john.doe@example.com", message: "Need help with account recovery.", response_date: "2025-05-18" },
    { id: 2, name: "Jane Smith", email: "jane.smith@example.com", message: "Feedback on the new dashboard.", response_date: "2025-05-17" },
    { id: 3, name: "Mark Brown", email: "mark.brown@example.com", message: "Inquiry about premium features.", response_date: "2025-05-16" }
];

// Function to generate rows
const generateRows = () => {
    const tbody = document.getElementById('response-table-body');
    tbody.innerHTML = ""; // Clear existing rows

    demoData.forEach(response => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${response.id}</td>
            <td>${response.name}</td>
            <td><a href="mailto:${response.email}">${response.email}</a></td>
            <td>${response.message}</td>
            <td>${response.response_date}</td>
            <td>
                <a href="mailto:${response.email}?subject=Reply to your query on MoneyMap" target="_blank" class="btn">Reply</a>
                <a href="#" class="btn-delete" onclick="deleteResponse(${response.id})">Delete</a>
            </td>
        `;
        tbody.appendChild(row);
    });
};

// Function to delete a response
const deleteResponse = (id) => {
    if (confirm("Are you sure you want to delete this response?")) {
        const index = demoData.findIndex(item => item.id === id);
        if (index !== -1) {
            demoData.splice(index, 1);
            generateRows();
            alert("Response deleted successfully.");
        }
    }
};

// Initialize demo data
document.addEventListener('DOMContentLoaded', generateRows);
