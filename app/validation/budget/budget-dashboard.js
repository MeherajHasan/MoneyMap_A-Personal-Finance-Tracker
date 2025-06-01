const categoryFilter = document.getElementById("categoryFilter");
const monthFilter = document.getElementById("monthFilter");
const budgetTableBody = document.getElementById("budgetTableBody");

function filterTable() {
    const categoryValue = categoryFilter.value.toLowerCase();
    const monthValue = monthFilter.value;
    const rows = budgetTableBody.querySelectorAll("tr");

    rows.forEach(row => {
        const category = row.cells[0].textContent.toLowerCase();
        const start = new Date(row.cells[4].textContent);
        const end = new Date(row.cells[5].textContent);
        const selected = new Date(monthValue + "-01");

        const isCategoryMatch = categoryValue === "all" || category === categoryValue;
        const isMonthMatch = !monthValue || (start <= selected && end >= selected);

        row.style.display = (isCategoryMatch && isMonthMatch) ? "" : "none";
    });
}

categoryFilter.addEventListener("change", filterTable);
monthFilter.addEventListener("input", filterTable);

window.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (!urlParams.has("month")) {
        document.querySelector("form.filters").submit();
    }
});
