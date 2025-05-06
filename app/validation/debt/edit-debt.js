const form = document.querySelector('.debt-form');
const debtName = document.getElementById('debtName');
const payeeName = document.getElementById('payeeName');
const debtAmount = document.getElementById('principalAmount'); 
const interestRate = document.getElementById('interestRate');
const debtDate = document.getElementById('debtDate');
const maxPaymentDate = document.getElementById('maxPaymentDate');
const debtNotes = document.getElementById('notes');

const nameError = document.getElementById('debtNameError');
const payeeError = document.getElementById('payeeNameError');
const amountError = document.getElementById('principalAmountError');
const rateError = document.getElementById('interestRateError');
const dateError = document.getElementById('debtDateError');
const emptyError = document.getElementById('emptyError');

function clearErrors() {
    nameError.textContent = '';
    payeeError.textContent = '';
    amountError.textContent = '';
    rateError.textContent = '';
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
    
    const debtNameValue = debtName.value.trim();
    const payeeNameValue = payeeName.value.trim();
    const debtAmountValue = parseFloat(debtAmount.value);
    const interestRateValue = parseFloat(interestRate.value);
    const debtDateValue = debtDate.value.trim();
    const maxPaymentDateValue = maxPaymentDate.value.trim();

    if (!debtNameValue && !payeeNameValue && !debtAmount.value.trim() && !debtDateValue && !maxPaymentDateValue) {
        emptyError.textContent = 'At least one of the fields needs to be changed.';
        valid = false;
    } else if (containsIllegalCharacters(debtNameValue)) {
        nameError.textContent = 'Debt name contains illegal characters.';
        valid = false;
    } else if (containsIllegalCharacters(payeeNameValue)) {
        payeeError.textContent = 'Payee name contains illegal characters.';
        valid = false;
    } else if (isNaN(debtAmountValue)) {
        amountError.textContent = 'Amount must be a number.';
        valid = false;
    } else if (debtAmountValue < 0) {
        amountError.textContent = 'Amount cannot be negative.';
        valid = false;
    } else if (isNaN(interestRateValue)) {
        rateError.textContent = 'Interest rate must be a number.';
        valid = false;
    } else if (interestRateValue < 0) {
        rateError.textContent = 'Interest rate cannot be negative.';
        valid = false;
    } else if (!debtDateValue) {
        dateError.textContent = 'Debt date is required.';
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    } else {
        e.preventDefault();
        window.location.href = '../../views/debt/debt-dashboard.php';
    }
});
