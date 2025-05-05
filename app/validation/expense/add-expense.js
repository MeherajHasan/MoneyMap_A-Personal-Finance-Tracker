const form = document.querySelector('.expense-form');
const expenseCategory = document.getElementById('expenseCategory');
const expenseName = document.getElementById('expenseName');
const expenseAmount = document.getElementById('expenseAmount');
const expenseDate = document.getElementById('expenseDate');

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
    const categoryValue = expenseCategory.value; 
    const nameValue = expenseName.value.trim();
    const amountValue = parseFloat(expenseAmount.value);
    const dateValue = expenseDate.value.trim(); 

    if (!categoryValue || !nameValue || isNaN(amountValue) || !dateValue) {
        emptyError.textContent = 'All fields must be filled out.';
        valid = false;
    } else if (containsIllegalCharacters(nameValue)) {
        nameError.textContent = 'Name contains illegal characters.';
        valid = false;
    } else if (isNaN(amountValue)) {
        amountError.textContent = 'Amount must be a number.';
        valid = false;
    }
    else if (amountValue < 0) {
        amountError.textContent = 'Amount cannot be negative.';
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    } else {
        e.preventDefault();
        window.location.href = 'expense-dashboard.html';
    }
});