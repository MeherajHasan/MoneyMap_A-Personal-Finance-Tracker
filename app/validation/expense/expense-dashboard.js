const categoryFilter = document.getElementById("categoryFilter");
const dateFilter = document.getElementById("dateFilter");
const expenseTableBody = document.getElementById("expenseTableBody");
const deleteButtons = document.querySelectorAll(".btn-small.delete");

function filterTable() {
    const categoryValue = categoryFilter.value.toLowerCase();
    const dateValue = dateFilter.value;
    const rows = expenseTableBody.querySelectorAll("tr");

    rows.forEach(row => {
        const category = row.cells[0].textContent.toLowerCase();
        const date = row.cells[3].textContent;

        // Filter by category and date
        if ((categoryValue === "all" || category.includes(categoryValue)) &&
            (dateValue === "" || date.startsWith(dateValue))) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function handleDeleteClick(event) {
    const row = event.target.closest("tr");
    const confirmDelete = confirm("Are you sure you want to delete this expense record?");
    
    if (confirmDelete) {
        row.remove();
    }
}

categoryFilter.addEventListener("change", function () {
    filterTable();
});

dateFilter.addEventListener("input", function () {
    filterTable();
});

deleteButtons.forEach(button => {
    button.addEventListener("click", handleDeleteClick);
});
