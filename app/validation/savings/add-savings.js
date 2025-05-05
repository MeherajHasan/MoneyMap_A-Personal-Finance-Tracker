const form = document.getElementById('add-savings-form');
const goalName = document.getElementById('goal-name');
const targetAmount = document.getElementById('target-amount');
const targetDate = document.getElementById('target-date');
const description = document.getElementById('description');

const nameError = document.getElementById('nameError');
const amountError = document.getElementById('amountError');
const dateError = document.getElementById('dateError');
const emptyError = document.getElementById('emptyError'); // Get the emptyError paragraph

function clearErrors() {
    nameError.textContent = '';
    amountError.textContent = '';
    dateError.textContent = '';
    emptyError.textContent = ''; // Clear the empty error as well
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
    const nameValue = goalName.value.trim();
    const amountValue = parseFloat(targetAmount.value);
    const dateValue = targetDate.value.trim();
    const descriptionValue = description.value.trim();

    // Check if any required fields are empty
    if (!nameValue || isNaN(amountValue) || !dateValue) {
        emptyError.textContent = 'All fields must be filled out.';
        valid = false;
    } else if (containsIllegalCharacters(nameValue)) {
        nameError.textContent = 'Goal name contains illegal characters.';
        valid = false;
    } else if (isNaN(amountValue)) {
        amountError.textContent = 'Target amount must be a number.';
        valid = false;
    } else if (amountValue <= 0) {
        amountError.textContent = 'Target amount must be greater than 0.';
        valid = false;
    }

    // Ensure target date is greater than the current date
    const currentDate = new Date();
    const targetDateValue = new Date(dateValue);

    if (targetDateValue <= currentDate) {
        dateError.textContent = 'Target date must be in the future.';
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    } else {
        e.preventDefault();
        window.location.href = 'savings-dashboard.html';
    }
});
