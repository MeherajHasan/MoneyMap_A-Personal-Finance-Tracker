const form = document.querySelector('.debt-form');
const paymentAmount = document.getElementById('paymentAmount');
const paymentError = document.getElementById('paymentError');

// Example data for demonstration (this should come from a backend in a real application)
const debtDetails = {
    debtName: 'Home Loan',
    payeeName: 'Bank of MoneyMap',
    remainingAmount: 5000 // In dollars
};

// Display the debt details dynamically
document.getElementById('debtNameDisplay').textContent = debtDetails.debtName;
document.getElementById('payeeNameDisplay').textContent = debtDetails.payeeName;
document.getElementById('payableAmountDisplay').textContent = `$${debtDetails.remainingAmount}`;

function clearErrors() {
    paymentError.textContent = ''; 
}

function validatePaymentAmount(paymentAmountValue) {
    if (isNaN(paymentAmountValue) || paymentAmountValue <= 0 || paymentAmountValue > debtDetails.remainingAmount) {
        paymentError.textContent = 'Please enter a valid payment amount.';
        return false;
    }

    return true;
}

form.addEventListener('submit', function (e) {
    e.preventDefault(); 

    const paymentAmountValue = parseFloat(paymentAmount.value);

    if (validatePaymentAmount(paymentAmountValue)) {
        debtDetails.remainingAmount -= paymentAmountValue;
        document.getElementById('payableAmountDisplay').textContent = `$${debtDetails.remainingAmount}`;

        window.location.href = '../../views/debt/debt-dashboard.php';
    } else {
        paymentError.style.display = 'block';
    }
});

