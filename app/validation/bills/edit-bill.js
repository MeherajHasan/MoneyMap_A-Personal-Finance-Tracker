document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('edit-bill-form');
    const billNameInput = document.getElementById('bill-name');
    const amountInput = document.getElementById('amount');
    const dueDateInput = document.getElementById('due-date');
    const statusSelect = document.getElementById('status');

    const errorName = document.getElementById('error-name');
    const errorAmount = document.getElementById('error-amount');
    const errorDate = document.getElementById('error-date');
    const errorStatus = document.getElementById('error-status');
    const errorNoChange = document.getElementById('error-no-change');

    const initial = {
        billName: billNameInput.value,
        amount: amountInput.value,
        dueDate: dueDateInput.value,
        status: statusSelect.value,
    };

    function isValidBillName(name) {
        for (let i = 0; i < name.length; i++) {
            const c = name[i];
            if (!(
                (c >= 'a' && c <= 'z') ||
                (c >= 'A' && c <= 'Z') ||
                (c >= '0' && c <= '9') ||
                c === ' ' || c === '.' || c === ',' || c === '-'
            )) {
                return false;
            }
        }
        return true;
    }

    function clearErrors() {
        errorName.textContent = '';
        errorAmount.textContent = '';
        errorDate.textContent = '';
        errorStatus.textContent = '';
        errorNoChange.textContent = '';
    }

    form.addEventListener('submit', (e) => {
        clearErrors();

        let isValid = true;

        if (
            billNameInput.value === initial.billName &&
            amountInput.value === initial.amount &&
            dueDateInput.value === initial.dueDate &&
            statusSelect.value === initial.status
        ) {
            errorNoChange.textContent = 'Please change at least one field before submitting.';
            isValid = false;
        }

        const nameTrimmed = billNameInput.value.trim();
        if (nameTrimmed === '') {
            errorName.textContent = 'Bill name cannot be empty.';
            isValid = false;
        } else if (!isValidBillName(nameTrimmed)) {
            errorName.textContent = 'Bill name contains invalid characters.';
            isValid = false;
        }

        const amountVal = amountInput.value.trim();
        if (amountVal === '' || isNaN(amountVal) || Number(amountVal) <= 0) {
            errorAmount.textContent = 'Amount must be a positive number.';
            isValid = false;
        }

        if (dueDateInput.value.trim() === '') {
            errorDate.textContent = 'Due date must be selected.';
            isValid = false;
        }

        if (statusSelect.value !== 'Paid' && statusSelect.value !== 'Due') {
            errorStatus.textContent = 'Status must be either Paid or Due.';
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});
