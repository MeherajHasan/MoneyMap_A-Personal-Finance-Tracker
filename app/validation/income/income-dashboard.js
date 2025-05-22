window.addEventListener('DOMContentLoaded', () => {
    const typeFilter = document.getElementById('typeFilter');
    const dateFilter = document.getElementById('dateFilter');

    // Pre-fill filters based on URL
    const urlParams = new URLSearchParams(window.location.search);
    const selectedType = urlParams.get('type');
    const selectedDate = urlParams.get('date');

    if (selectedType) {
        typeFilter.value = selectedType;
    }

    if (selectedDate) {
        dateFilter.value = selectedDate;
    }

    // Apply filters on change
    typeFilter.addEventListener('change', () => {
        applyFilters();
    });

    dateFilter.addEventListener('change', () => {
        applyFilters();
    });

    function applyFilters() {
        const type = typeFilter.value;
        const date = dateFilter.value;

        const url = new URL(window.location.href);
        url.searchParams.set('type', type);
        url.searchParams.set('date', date);

        window.location.href = url.toString();
    }
});

function deleteIncome(incomeId) {
    if (confirm("Are you sure you want to delete this income record?")) {
        const url = new URL(window.location.href);
        url.searchParams.set('delete', incomeId);
        window.location.href = url.toString();
    }
}

