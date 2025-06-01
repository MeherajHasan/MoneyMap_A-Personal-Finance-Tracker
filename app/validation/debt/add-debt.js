function isValidNameString(str) {
    for (let i = 0; i < str.length; i++) {
        const c = str[i];
        if (!(
            (c >= 'a' && c <= 'z') ||
            (c >= 'A' && c <= 'Z') ||
            (c >= '0' && c <= '9') ||
            c === ' ' || c === '.' || c === ',' || c === '-'
        )) {
            return false;
        }
    }
    return true;
} 

function isValidNotesString(str) {
    for (let i = 0; i < str.length; i++) {
        const c = str[i];
        if (!(
            (c >= 'a' && c <= 'z') ||
            (c >= 'A' && c <= 'Z') ||
            (c >= '0' && c <= '9') ||
            c === ' ' || c === '.' || c === ',' || c === '-' ||
            c === '!' || c === '?' || c === ':' || c === ';' ||
            c === '\n' || c === '\r'
        )) {
            return false;
        }
    }
    return true;
}

document.getElementById('addDebtForm').addEventListener('submit', function(event) {
    let isValid = true;

    const debtName = document.getElementById('debtName').value.trim();
    const payeeName = document.getElementById('payeeName').value.trim();
    const debtDate = document.getElementById('debtDate').value;
    const maxPaymentDate = document.getElementById('maxPaymentDate').value;
    const principalAmount = document.getElementById('principalAmount').value.trim();
    const interestRate = document.getElementById('interestRate').value.trim();
    const minimumPayment = document.getElementById('minimumPayment').value.trim();
    const notes = document.getElementById('notes').value.trim();

    document.getElementById('debtNameError').textContent = '';
    document.getElementById('payeeNameError').textContent = '';
    document.getElementById('debtDateError').textContent = '';
    document.getElementById('maxPaymentDateError').textContent = '';
    document.getElementById('principalAmountError').textContent = '';
    document.getElementById('interestRateError').textContent = '';
    document.getElementById('minimumPaymentError').textContent = '';
    document.getElementById('notesError').textContent = '';

    if (debtName === '') {
        document.getElementById('debtNameError').textContent = 'Debt name is required.';
        isValid = false;
    } else if (!isValidNameString(debtName)) {
        document.getElementById('debtNameError').textContent = 'Debt name contains invalid characters.';
        isValid = false;
    }

    if (payeeName === '') {
        document.getElementById('payeeNameError').textContent = 'Payee name is required.';
        isValid = false;
    } else if (!isValidNameString(payeeName)) {
        document.getElementById('payeeNameError').textContent = 'Payee name contains invalid characters.';
        isValid = false;
    }

    if (debtDate === '') {
        document.getElementById('debtDateError').textContent = 'Debt date is required.';
        isValid = false;
    }

    if (maxPaymentDate !== '') {
        if (debtDate !== '' && maxPaymentDate < debtDate) {
            document.getElementById('maxPaymentDateError').textContent = 'Maximum payment date cannot be before debt date.';
            isValid = false;
        }
    }

    if (principalAmount === '') {
        document.getElementById('principalAmountError').textContent = 'Principal amount is required.';
        isValid = false;
    } else if (isNaN(principalAmount) || Number(principalAmount) <= 0) {
        document.getElementById('principalAmountError').textContent = 'Principal amount must be a positive number.';
        isValid = false;
    }

    if (interestRate === '') {
        document.getElementById('interestRateError').textContent = 'Interest rate is required.';
        isValid = false;
    } else if (isNaN(interestRate) || Number(interestRate) < 0) {
        document.getElementById('interestRateError').textContent = 'Interest rate must be a non-negative number.';
        isValid = false;
    }

    if (minimumPayment === '') {
        document.getElementById('minimumPaymentError').textContent = 'Minimum payment is required.';
        isValid = false;
    } else if (isNaN(minimumPayment) || Number(minimumPayment) < 0) {
        document.getElementById('minimumPaymentError').textContent = 'Minimum payment must be a non-negative number.';
        isValid = false;
    }

    if (notes !== '') {
        if (!isValidNotesString(notes)) {
            document.getElementById('notesError').textContent = 'Notes contain invalid characters.';
            isValid = false;
        }
    }

    if (!isValid) {
        event.preventDefault();
    }
});
