document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add-bill-form');

    const billName = document.getElementById('bill-name');
    const amount = document.getElementById('amount');
    const dueDate = document.getElementById('due-date');
    const status = document.getElementById('status');

    const errorName = billName.nextElementSibling;
    const errorAmount = amount.nextElementSibling;
    const errorDate = dueDate.nextElementSibling;
    const errorStatus = status.nextElementSibling;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Clear previous errors
        errorName.textContent = '';
        errorAmount.textContent = '';
        errorDate.textContent = '';
        errorStatus.textContent = '';

        let isValid = true;

        // Required fields
        if (billName.value.trim() === '') {
            errorName.textContent = 'Bill name is required.';
            isValid = false;
        }
        if (amount.value.trim() === '') {
            errorAmount.textContent = 'Amount is required.';
            isValid = false;
        }
        if (dueDate.value === '') {
            errorDate.textContent = 'Due date is required.';
            isValid = false;
        }
        if (status.value === '') {
            errorStatus.textContent = 'Status is required.';
            isValid = false;
        }

        const name = billName.value.trim();
        for (let i = 0; i < name.length; i++) {
            const c = name[i];
            if (
                !(c >= 'a' && c <= 'z') &&
                !(c >= 'A' && c <= 'Z') &&
                !(c >= '0' && c <= '9') &&
                c !== ' ' && c !== '.' && c !== ',' && c !== '-'
            ) {
                errorName.textContent = 'Bill name contains invalid characters.';
                isValid = false;
                break;
            }
    }

        // Amount validation
        const amountVal = amount.value.trim();
        if (amountVal !== '' && (isNaN(amountVal) || Number(amountVal) <= 0)) {
            errorAmount.textContent = 'Amount must be a positive number.';
            isValid = false;
        }

        if (isValid) {
            form.submit(); 
        }
    });
});
