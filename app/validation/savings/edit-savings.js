document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.savings-form');
    const nameInput = document.getElementById('savingsGoalName');
    const amountInput = document.getElementById('savingsAmount');
    const dateInput = document.getElementById('savingsTargetDate');
    const currentInput = document.getElementById('savingsCurrentAmount');

    const nameError = document.getElementById('nameError');
    const amountError = document.getElementById('amountError');
    const dateError = document.getElementById('dateError');
    const currentError = document.getElementById('currentAmountError');
    const emptyError = document.getElementById('emptyError');

    form.addEventListener('submit', function (e) {
        let valid = true;

        nameError.textContent = '';
        amountError.textContent = '';
        dateError.textContent = '';
        currentError.textContent = '';
        emptyError.textContent = '';

        const name = nameInput.value.trim();
        if (name === '') {
            nameError.textContent = 'Goal name is required.';
            valid = false;
        } else {
            for (let i = 0; i < name.length; i++) {
                const c = name[i];
                if (!((c >= 'a' && c <= 'z') || (c >= 'A' && c <= 'Z') || c === ' ')) {
                    nameError.textContent = 'Only letters and spaces allowed.';
                    valid = false;
                    break;
                }
            }
        }

        const amount = parseFloat(amountInput.value);
        if (isNaN(amount) || amount <= 0) {
            amountError.textContent = 'Amount must be a positive number.';
            valid = false;
        }

        const dateValue = dateInput.value;
        if (!dateValue) {
            dateError.textContent = 'Target date is required.';
            valid = false;
        }

        const current = parseFloat(currentInput.value);
        if (isNaN(current) || current < 0) {
            currentError.textContent = 'Current savings must be a non-negative number.';
            valid = false;
        }

        if (!valid) {
            emptyError.textContent = 'Please correct the above errors.';
            e.preventDefault();
        }
    });
});
