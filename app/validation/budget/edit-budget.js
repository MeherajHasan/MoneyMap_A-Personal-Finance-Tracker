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

function isValidCategoryNameManual(name) {
    if (name.trim() === '') return { valid: false, message: 'Category name cannot be empty.' };

    for (let i = 0; i < name.length; i++) {
        const char = name[i];
        if (!(
            (char >= 'A' && char <= 'Z') ||
            (char >= 'a' && char <= 'z') ||
            char === ' '
        )) {
            return { valid: false, message: 'Only letters and spaces are allowed in the category name.' };
        }
    }

    return { valid: true };
}

form.addEventListener('submit', function (e) {
    clearErrors();

    let valid = true;

    const categoryValue = budgetCategory.value.trim();
    const amountValue = parseFloat(budgetAmount.value);
    const spentValue = parseFloat(budgetSpent.value);
    const startDate = budgetStartDate.value.trim();
    const endDate = budgetEndDate.value.trim();
    const notesValue = budgetNotes.value.trim();

    if (
        !categoryValue &&
        !budgetAmount.value.trim() &&
        !budgetSpent.value.trim() &&
        !startDate &&
        !endDate &&
        !notesValue
    ) {
        e.preventDefault();
        emptyError.textContent = 'At least one field has to be changed';
        return;
    }

    if (categoryValue) {
        const result = isValidCategoryNameManual(categoryValue);
        if (!result.valid) {
            e.preventDefault();
            categoryError.textContent = result.message;
            valid = false;
        }
    }

    if (budgetAmount.value.trim()) {
        if (isNaN(amountValue)) {
            e.preventDefault();
            amountError.textContent = 'Amount must be a number.';
            valid = false;
        } else if (amountValue < 0) {
            e.preventDefault();
            amountError.textContent = 'Amount cannot be negative.';
            valid = false;
        }
    }

    if (budgetSpent.value.trim()) {
        if (isNaN(spentValue)) {
            e.preventDefault();
            spentError.textContent = 'Spent amount must be a number.';
            valid = false;
        } else if (spentValue < 0) {
            e.preventDefault();
            spentError.textContent = 'Spent amount cannot be negative.';
            valid = false;
        }
    }

    if (startDate && !endDate) {
        e.preventDefault();
        endDateError.textContent = 'End date is required if start date is given.';
        valid = false;
    }

    if (endDate && !startDate) {
        e.preventDefault();
        startDateError.textContent = 'Start date is required if end date is given.';
        valid = false;
    }

    if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
        e.preventDefault();
        endDateError.textContent = 'End date must be after start date.';
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    }
});
