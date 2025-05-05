const categoryFilter = document.getElementById("categoryFilter");
const monthFilter = document.getElementById("monthFilter");
const budgetTableBody = document.getElementById("budgetTableBody");
const deleteButtons = document.querySelectorAll(".btn-small.delete");

function filterTable() {
    const categoryValue = categoryFilter.value.toLowerCase();
    const monthValue = monthFilter.value;
    const rows = budgetTableBody.querySelectorAll("tr");

    rows.forEach(row => {
        const category = row.cells[0].textContent.toLowerCase();
        const startDate = row.cells[4].textContent;
        const endDate = row.cells[5].textContent;

        // Filter by category and month
        const isCategoryMatch = categoryValue === "all" || category.includes(categoryValue);
        const isMonthMatch = monthValue === "" || (startDate.startsWith(monthValue) || endDate.startsWith(monthValue));

        if (isCategoryMatch && isMonthMatch) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function handleDeleteClick(event) {
    const row = event.target.closest("tr");
    const confirmDelete = confirm("Are you sure you want to delete this budget record?");
    
    if (confirmDelete) {
        row.remove();
    }
}

categoryFilter.addEventListener("change", function () {
    filterTable();
});

monthFilter.addEventListener("input", function () {
    filterTable();
});

deleteButtons.forEach(button => {
    button.addEventListener("click", handleDeleteClick);
});
