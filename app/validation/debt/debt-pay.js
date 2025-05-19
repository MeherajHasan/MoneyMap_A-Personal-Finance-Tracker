const form = document.querySelector('.debt-form');
const paymentAmount = document.getElementById('paymentAmount');
const paymentError = document.getElementById('paymentError');

// demo value
const remainingAmount = 5000; 

function clearErrors() {
    paymentError.textContent = '';
}

function validatePaymentAmount(value) {
    if (isNaN(value) || value <= 0) {
        paymentError.textContent = 'Payment amount must be a positive number.';
        return false;
    } else if (value > remainingAmount) {
        paymentError.textContent = `Amount cannot exceed remaining payable amount ($${remainingAmount.toFixed(2)}).`;
        return false;
    }
    return true;
}

form.addEventListener('submit', function (e) {
    clearErrors();
    const value = parseFloat(paymentAmount.value);

    if (!validatePaymentAmount(value)) {
        e.preventDefault(); 
        paymentError.style.display = 'block';
    }
});
