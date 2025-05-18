document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add-bill-form');

    const billName = document.getElementById('bill-name');
    const amount = document.getElementById('amount');
    const dueDate = document.getElementById('due-date');
    const status = document.getElementById('status');

    const errorName = document.getElementById('error-name');
    const errorAmount = document.getElementById('error-amount');
    const errorDate = document.getElementById('error-date');
    const errorStatus = document.getElementById('error-status');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Clear previous errors
        errorName.textContent = '';
        errorAmount.textContent = '';
        errorDate.textContent = '';
        errorStatus.textContent = '';

        let isValid = true;

        // Check all fields filled
        if (billName.value.trim() === '' || amount.value.trim() === '' || dueDate.value === '' || status.value === '') {
            errorStatus.textContent = 'All fields are required.';
            isValid = false;
        }

        // Bill name validation (only letters, digits, space, dash, underscore)
        const name = billName.value.trim();
        for (let i = 0; i < name.length; i++) {
            const c = name[i];
            const code = c.charCodeAt(0);
            const isLetter = (code >= 65 && code <= 90) || (code >= 97 && code <= 122);
            const isDigit = (code >= 48 && code <= 57);
            const isOtherValid = c === ' ' || c === '-' || c === '_';

            if (!isLetter && !isDigit && !isOtherValid) {
                errorName.textContent = 'Bill name contains invalid characters.';
                isValid = false;
                break;
            }
        }

        // Amount must be a number
        const amountVal = amount.value.trim();
        if (amountVal !== '' && isNaN(amountVal)) {
            errorAmount.textContent = 'Amount must be a number.';
            isValid = false;
        }

        if (!isValid) return;

        // Redirect after successful validation
        window.location.href = 'bill-dashboard.php';
    });
});
