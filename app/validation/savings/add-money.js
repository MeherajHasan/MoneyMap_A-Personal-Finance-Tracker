const form = document.getElementById('addMoneyForm');
const goalNameSelect = document.getElementById('goalName');
const amountInput = document.getElementById('amount');
const transactionDateInput = document.getElementById('transactionDate');
const notesInput = document.getElementById('notes');

const nameError = document.getElementById('nameError');
const amountError = document.getElementById('amountError');
const dateError = document.getElementById('dateError');
const emptyError = document.getElementById('emptyError'); // Get the emptyError paragraph

// Pre-defined goals
const availableGoals = [
    { name: 'Vacation' },
    { name: 'Emergency' },
    { name: 'Buy A Car' }
];

// Function to clear error messages
function clearErrors() {
    nameError.textContent = '';
    amountError.textContent = '';
    dateError.textContent = '';
    emptyError.textContent = ''; // Clear the empty error as well
}

// Function to check for illegal characters
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

// Populate the goal name select dropdown
availableGoals.forEach(goal => {
    const option = document.createElement('option');
    option.value = goal.name;
    option.textContent = goal.name;
    goalNameSelect.appendChild(option);
});

// Form submit event listener
form.addEventListener('submit', function (e) {
    let isValid = true;
    clearErrors(); // Clear any existing error messages

    const goalNameValue = goalNameSelect.value.trim();
    const amountValue = parseFloat(amountInput.value);
    const transactionDateValue = transactionDateInput.value.trim();
    const notesValue = notesInput.value.trim();

    // Check if required fields are filled out
    if (!goalNameValue || isNaN(amountValue) || !transactionDateValue) {
        emptyError.textContent = 'All fields must be filled out.';
        isValid = false;
    } else if (containsIllegalCharacters(goalNameValue)) {
        nameError.textContent = 'Goal name contains illegal characters.';
        isValid = false;
    } else if (isNaN(amountValue)) {
        amountError.textContent = 'Amount must be a valid number.';
        isValid = false;
    } else if (amountValue <= 0) {
        amountError.textContent = 'Amount must be greater than zero.';
        isValid = false;
    }

    const currentDate = new Date();
    const transactionDate = new Date(transactionDateValue);

    if (transactionDate <= currentDate) {
        dateError.textContent = 'Transaction date must be in the future.';
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault(); 
    } else {
        e.preventDefault(); 
        const formData = {
            goalName: goalNameSelect.value,
            amount: amountValue,
            transactionDate: transactionDateValue,
            notes: notesValue
        };

        console.log('Form Data:', formData);
        window.location.href = 'savings-dashboard.html'; 
    }
});
