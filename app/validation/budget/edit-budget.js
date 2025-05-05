const form = document.querySelector('.budget-form');
const budgetCategory = document.getElementById('budgetCategory');
const budgetAmount = document.getElementById('budgetAmount');
const budgetSpent = document.getElementById('budgetSpent');
const budgetStartDate = document.getElementById('budgetStartDate');
const budgetEndDate = document.getElementById('budgetEndDate');
const budgetNotes = document.getElementById('budgetNotes');

const categoryError = document.getElementById('categoryError');
const amountError = document.getElementById('amountError');
const spentError = document.getElementById('spentError');
const startDateError = document.getElementById('startDateError');
const endDateError = document.getElementById('endDateError');
const emptyError = document.getElementById('emptyError');

function clearErrors() {
    categoryError.textContent = '';
    amountError.textContent = '';
    spentError.textContent = '';
    startDateError.textContent = '';
    endDateError.textContent = '';
    emptyError.textContent = '';
}

function containsIllegalCharacters(input) {
    for (let i = 0; i < input.length; i++) {
        const char = input[i];
        const code = char.charCodeAt(0);
        const isLetter = (code >= 65 && code <= 90) || (code >= 97 && code <= 122);
        const isDigit = code >= 48 && code <= 57;
        const isAllowedSymbol = char === ' ' || char === ',' || char === '-';
        if (!isLetter && !isDigit && !isAllowedSymbol) {
            return true;
        }
    }
    return false;
}

form.addEventListener('submit', function (e) {
    e.preventDefault();
    clearErrors();

    let valid = true;

    const categoryValue = budgetCategory.value.trim();
    const amountValue = parseFloat(budgetAmount.value);
    const spentValue = parseFloat(budgetSpent.value);
    const startDate = budgetStartDate.value;
    const endDate = budgetEndDate.value;

    if (
        !categoryValue &&
        !budgetAmount.value.trim() &&
        !budgetSpent.value.trim() &&
        !startDate &&
        !endDate &&
        !budgetNotes.value.trim()
    ) {
        emptyError.textContent = 'At least one field has to be changed';
        valid = false;
    }

    if (categoryValue && containsIllegalCharacters(categoryValue)) {
        categoryError.textContent = 'Category contains illegal characters.';
        valid = false;
    }

    if (budgetAmount.value.trim() && isNaN(amountValue)) {
        amountError.textContent = 'Amount must be a number.';
        valid = false;
    } else if (!isNaN(amountValue) && amountValue < 0) {
        amountError.textContent = 'Amount cannot be negative.';
        valid = false;
    }

    if (budgetSpent.value.trim() && isNaN(spentValue)) {
        spentError.textContent = 'Spent amount must be a number.';
        valid = false;
    } else if (!isNaN(spentValue) && spentValue < 0) {
        spentError.textContent = 'Spent amount cannot be negative.';
        valid = false;
    }

    if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
        endDateError.textContent = 'End date must be after start date.';
        valid = false;
    }

    if (valid) {
        window.location.href = 'budget-dashboard.html';
    }
});
