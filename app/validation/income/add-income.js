const form = document.querySelector('.income-form');
const incomeSource = document.getElementById('incomeSource');
const incomeAmount = document.getElementById('incomeAmount');
const incomeDate = document.getElementById('incomeDate');

const sourceError = document.getElementById('sourceError');
const amountError = document.getElementById('amountError');
const dateError = document.getElementById('dateError');
const emptyError = document.getElementById('emptyError'); 

function clearErrors() {
    sourceError.textContent = '';
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
    const sourceValue = incomeSource.value.trim();
    const amountValue = parseFloat(incomeAmount.value);
    const dateValue = incomeDate.value.trim(); 

    if (!sourceValue || isNaN(amountValue) || !dateValue) {
        emptyError.textContent = 'All fields must be filled out.';
        valid = false;
    } else if (containsIllegalCharacters(sourceValue)) {
        sourceError.textContent = 'Source contains illegal characters.';
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
        window.location.href = 'income-dashboard.html';
    }
});