document.addEventListener('DOMContentLoaded', () => {
    const billTableBody = document.getElementById('bill-table-body');
    const paidCount = document.getElementById('paid-count');
    const dueCount = document.getElementById('due-count');

    // Demo bill data
    const bills = [
        { id: 1, name: 'Electricity Bill - April', amount: 1200, dueDate: '2025-04-10', status: 'Paid' },
        { id: 2, name: 'Internet Bill - April', amount: 800, dueDate: '2025-04-15', status: 'Due' },
        { id: 3, name: 'Water Bill - April', amount: 400, dueDate: '2025-04-05', status: 'Paid' },
        { id: 4, name: 'Gas Bill - April', amount: 600, dueDate: '2025-04-20', status: 'Due' },
    ];

    let paid = 0;
    let due = 0;

    bills.forEach(bill => {
        if (bill.status === 'Paid') paid++;
        else due++;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${bill.name}</td>
            <td>${bill.amount}</td>
            <td>${bill.dueDate}</td>
            <td>${bill.status}</td>
            <td><a href="edit-bill.php?id=${bill.id}" class="btn btn-edit">Edit</a></td>
        `;
        billTableBody.appendChild(row);
    });

    paidCount.textContent = paid;
    dueCount.textContent = due;
});