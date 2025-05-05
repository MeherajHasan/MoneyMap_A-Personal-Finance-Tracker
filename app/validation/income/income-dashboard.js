const typeFilter = document.getElementById("typeFilter");
const dateFilter = document.getElementById("dateFilter");
const incomeTableBody = document.getElementById("incomeTableBody");
const deleteButtons = document.querySelectorAll(".btn-small.delete");

function filterTable() {
    const typeValue = typeFilter.value.toLowerCase();
    const dateValue = dateFilter.value;
    const rows = incomeTableBody.querySelectorAll("tr");

    rows.forEach(row => {
        const type = row.cells[0].textContent.toLowerCase();
        const date = row.cells[3].textContent;

        // Filter by type and date
        if ((typeValue === "all" || type.includes(typeValue)) &&
            (dateValue === "" || date.startsWith(dateValue))) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function handleDeleteClick(event) {
    const row = event.target.closest("tr");
    const confirmDelete = confirm("Are you sure you want to delete this income record?");
    
    if (confirmDelete) {
        row.remove();
    }
}

typeFilter.addEventListener("change", function () {
    filterTable();
});

dateFilter.addEventListener("input", function () {
    filterTable();
});

deleteButtons.forEach(button => {
    button.addEventListener("click", handleDeleteClick);
});
