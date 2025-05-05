const form = document.querySelector('.savings-form');
const goalName = document.getElementById('savingsGoalName');
const amount = document.getElementById('savingsAmount');
const targetDate = document.getElementById('savingsTargetDate');
const currentAmount = document.getElementById('savingsCurrentAmount');
const notes = document.getElementById('savingsNotes');

const nameError = document.getElementById('nameError');
const amountError = document.getElementById('amountError');
const dateError = document.getElementById('dateError');
const currentAmountError = document.getElementById('currentAmountError');
const emptyError = document.getElementById('emptyError');

function clearErrors() {
    nameError.textContent = '';
    amountError.textContent = '';
    dateError.textContent = '';
    currentAmountError.textContent = '';
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
    let valid = true;
    clearErrors();

    const goalNameValue = goalName.value.trim();
    const amountValue = parseFloat(amount.value);
    const currentValue = parseFloat(currentAmount.value);
    const dateValue = targetDate.value.trim();

    if (
        !goalNameValue &&
        !amount.value.trim() &&
        !dateValue &&
        !currentAmount.value.trim() &&
        !notes.value.trim()
    ) {
        emptyError.textContent = 'At least one of the fields needs to be changed.';
        valid = false;
    }

    if (goalNameValue && containsIllegalCharacters(goalNameValue)) {
        nameError.textContent = 'Goal name contains illegal characters.';
        valid = false;
    }

    if (amount.value.trim()) {
        if (isNaN(amountValue)) {
            amountError.textContent = 'Amount must be a number.';
            valid = false;
        } else if (amountValue < 0) {
            amountError.textContent = 'Amount cannot be negative.';
            valid = false;
        }
    }

    if (currentAmount.value.trim()) {
        if (isNaN(currentValue)) {
            currentAmountError.textContent = 'Current savings must be a number.';
            valid = false;
        } else if (currentValue < 0) {
            currentAmountError.textContent = 'Current savings cannot be negative.';
            valid = false;
        }
    }

    if (!valid) {
        e.preventDefault();
    } else {
        e.preventDefault(); 
        window.location.href = 'savings-dashboard.html';
    }
});
