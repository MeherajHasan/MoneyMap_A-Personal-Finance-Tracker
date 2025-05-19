const form = document.querySelector('.budget-form');
const budgetCategory = document.getElementById('budgetCategory');
const budgetAmount = document.getElementById('budgetAmount');
const spentAmount = document.getElementById('spentAmount');
const budgetStartDate = document.getElementById('budgetStartDate');
const budgetEndDate = document.getElementById('budgetEndDate');

const amountError = document.getElementById('amountError');
const spentError = document.getElementById('spentError');
const startDateError = document.getElementById('startDateError');
const endDateError = document.getElementById('endDateError');
const emptyError = document.getElementById('emptyError');

function clearErrors() {
    amountError.textContent = '';
    spentError.textContent = '';
    startDateError.textContent = '';
    endDateError.textContent = '';
    emptyError.textContent = '';
}

form.addEventListener('submit', function (e) {
    clearErrors();
    let valid = true;

    const category = budgetCategory.value.trim();
    const amount = parseFloat(budgetAmount.value);
    const spent = parseFloat(spentAmount.value);
    const startDate = budgetStartDate.value.trim();
    const endDate = budgetEndDate.value.trim();

    if (!category || !budgetAmount.value || !spentAmount.value || !startDate || !endDate) {
        emptyError.textContent = 'All required fields must be filled.';
        valid = false;
    }

    if (isNaN(amount) || amount <= 0) {
        amountError.textContent = 'Budget amount must be a valid number greater than zero.';
        valid = false;
    }

    if (isNaN(spent) || spent < 0) {
        spentError.textContent = 'Spent amount must be a valid number (0 or more).';
        valid = false;
    }

    if (startDate && endDate && startDate > endDate) {
        endDateError.textContent = 'End date must be after start date.';
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    }
});
