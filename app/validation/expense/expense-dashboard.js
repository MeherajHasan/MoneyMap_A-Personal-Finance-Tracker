const categoryFilter = document.getElementById("categoryFilter");
const dateFilter = document.getElementById("dateFilter");
const expenseTableBody = document.getElementById("expenseTableBody");

function filterTable() {
    const categoryValue = categoryFilter.value.toLowerCase();
    const dateValue = dateFilter.value;
    const rows = expenseTableBody.querySelectorAll("tr");

    rows.forEach(row => {
        const category = row.cells[0].textContent.toLowerCase();
        const date = row.cells[3].textContent;

        if ((categoryValue === "all" || category.includes(categoryValue)) &&
            (dateValue === "" || date.startsWith(dateValue))) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

categoryFilter.addEventListener("change", function () {
    filterTable();
});

dateFilter.addEventListener("input", function () {
    filterTable();
});
