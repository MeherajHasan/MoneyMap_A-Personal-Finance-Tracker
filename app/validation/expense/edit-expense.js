const form = document.querySelector('.expense-form');
const expenseCategory = document.getElementById('expenseCategory');
const expenseAmount = document.getElementById('expenseAmount');
const expenseDate = document.getElementById('expenseDate');
const expenseNotes = document.getElementById('expenseNotes');

const categoryError = document.getElementById('categoryError');
const amountError = document.getElementById('amountError');
const dateError = document.getElementById('dateError');
const emptyError = document.getElementById('emptyError');

function clearErrors() {
    categoryError.textContent = '';
    amountError.textContent = '';
    dateError.textContent = '';
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
    const categoryValue = expenseCategory.value.trim();
    const amountValue = parseFloat(expenseAmount.value);

    if (!categoryValue && !expenseAmount.value.trim() && !expenseDate.value) {
        emptyError.textContent = 'At least one of the fields needs to be changed.';
        valid = false;
    } else if (containsIllegalCharacters(categoryValue)) {
        categoryError.textContent = 'Category contains illegal characters.';
        valid = false;
    } else if (isNaN(amountValue)) {
        amountError.textContent = 'Amount must be a number.';
        valid = false;
    } else if (amountValue < 0) {
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
