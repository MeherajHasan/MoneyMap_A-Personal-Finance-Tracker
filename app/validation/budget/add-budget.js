const form = document.querySelector('.budget-form');
const budgetCategory = document.getElementById('budgetCategory');
const budgetAmount = document.getElementById('budgetAmount');
const spentAmount = document.getElementById('spentAmount');
const budgetStartDate = document.getElementById('budgetStartDate');
const budgetEndDate = document.getElementById('budgetEndDate');
const budgetNotes = document.getElementById('budgetNotes');

const amountError = document.getElementById('amountError');
const spentError = document.getElementById('spentError');
const startDateError = document.getElementById('startDateError');
const endDateError = document.getElementById('endDateError');
const emptyError = document.getElementById('emptyError');

function clearErrors() {
    amountError.textContent = '';
    startDateError.textContent = '';
    endDateError.textContent = '';
    emptyError.textContent = '';
}

form.addEventListener('submit', function (e) {
    let valid = true;
    clearErrors();

    const categoryValue = budgetCategory.value.trim();
    const amountValue = parseFloat(budgetAmount.value);
    const spentValue = parseFloat(spentAmount.value);
    const startDateValue = budgetStartDate.value.trim();
    const endDateValue = budgetEndDate.value.trim();

    if (!categoryValue || !amountValue || !spentAmount || !startDateValue || !endDateValue) {
        emptyError.textContent = 'All fields must be filled out.';
        valid = false;
    }

    else if (isNaN(amountValue)) {
        amountError.textContent = 'Amount must be a valid number.';
        valid = false;
    } else if (amountValue <= 0) {
        amountError.textContent = 'Amount must be greater than zero.';
        valid = false;
    }

    else if (isNaN(amountValue)) {
        spentError.textContent = 'Amount must be a valid number.';
        valid = false;
    } else if (amountValue <= 0) {
        spentError.textContent = 'Amount must be greater than zero.';
        valid = false;
    }

    else if (startDateValue && endDateValue && startDateValue > endDateValue) {
        endDateError.textContent = 'End date must be after start date.';
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    } else {
        e.preventDefault(); // Remove this if you want real submission
        window.location.href = 'budget-dashboard.html';
    }
});
