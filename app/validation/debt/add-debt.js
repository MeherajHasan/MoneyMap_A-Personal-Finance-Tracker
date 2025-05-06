const form = document.getElementById('addDebtForm');
const debtName = document.getElementById('debtName');
const payeeName = document.getElementById('payeeName');
const debtDate = document.getElementById('debtDate');
const maxPaymentDate = document.getElementById('maxPaymentDate');
const principalAmount = document.getElementById('principalAmount');
const interestRate = document.getElementById('interestRate');
const minimumPayment = document.getElementById('minimumPayment');
const notes = document.getElementById('notes');

const debtNameError = document.getElementById('debtNameError');
const payeeNameError = document.getElementById('payeeNameError');
const debtDateError = document.getElementById('debtDateError');
const maxPaymentDateError = document.getElementById('maxPaymentDateError');
const principalAmountError = document.getElementById('principalAmountError');
const interestRateError = document.getElementById('interestRateError');
const minimumPaymentError = document.getElementById('minimumPaymentError');
const notesError = document.getElementById('notesError');

function clearErrors() {
    debtNameError.textContent = '';
    payeeNameError.textContent = '';
    debtDateError.textContent = '';
    maxPaymentDateError.textContent = '';
    principalAmountError.textContent = '';
    interestRateError.textContent = '';
    minimumPaymentError.textContent = '';
    notesError.textContent = '';
}

form.addEventListener('submit', function (e) {
    let valid = true;
    clearErrors();

    const debtNameValue = debtName.value.trim();
    const payeeNameValue = payeeName.value.trim();
    const debtDateValue = debtDate.value.trim();
    const principalAmountValue = parseFloat(principalAmount.value);
    const interestRateValue = parseFloat(interestRate.value);
    const minimumPaymentValue = parseFloat(minimumPayment.value);

    if (!debtNameValue || !payeeNameValue || !debtDateValue || !interestRateValue || !minimumPaymentValue) {
        notesError.textContent = 'All fields must be filled out.';
        valid = false;
    } else if (principalAmountValue <= 0) {
        principalAmountError.textContent = 'Please enter a valid principal amount.';
        valid = false;
    } else if (interestRateValue <= 0) {
        interestRateError.textContent = 'Please enter a valid interest rate.';
        valid = false;
    } else if (minimumPaymentValue <= 0) {
        minimumPaymentError.textContent = 'Please enter a valid minimum payment.';
        valid = false;
    }

    if (!valid) {
        e.preventDefault(); 
    } else {
        e.preventDefault();
        setTimeout(() => {
            window.location.href = '../../views/debt/debt-dashboard.php'; 
        }, 100);
    }
});
