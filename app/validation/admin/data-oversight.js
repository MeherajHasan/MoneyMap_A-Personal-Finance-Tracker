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