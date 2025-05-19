function isValidNameString(str) {
    for (let i = 0; i < str.length; i++) {
        const c = str[i];
        if (
            !(
                (c >= 'a' && c <= 'z') ||
                (c >= 'A' && c <= 'Z') ||
                (c >= '0' && c <= '9') ||
                c === ' ' || c === '.' || c === ',' || c === '-'
            )
        ) {
            return false;
        }
    }
    return true;
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.expense-form');
    const category = document.getElementById('expenseCategory');
    const nameInput = document.getElementById('expenseName');
    const amountInput = document.getElementById('expenseAmount');
    const dateInput = document.getElementById('expenseDate');
    const notesInput = document.getElementById('expenseNotes');

    const categoryError = document.getElementById('categoryError');
    const nameError = document.getElementById('nameError');
    const amountError = document.getElementById('amountError');
    const dateError = document.getElementById('dateError');


    form.addEventListener('submit', (e) => {
        let hasError = false;

        if (!category.value) {
            categoryError.innerHTML = "Please select a category.";
            hasError = true;
        } else {
            categoryError.innerHTML = "";
        }

        const nameVal = nameInput.value.trim();
        if (nameVal.length === 0) {
            nameError.innerHTML = "Name is required.";
            hasError = true;
        } else if (!isValidNameString(nameVal)) {
            nameError.innerHTML = "Name contains invalid characters.";
            hasError = true;
        } else {
            nameError.innerHTML = "";
        } 

        const amountVal = amountInput.value.trim();
        const amountNum = Number(amountVal);
        if (amountVal.length === 0) {
            amountError.innerHTML = "Amount is required.";
            hasError = true;
        } else if (isNaN(amountNum) || amountNum <= 0) {
            amountError.innerHTML = "Amount must be a positive number.";
            hasError = true;
        } else {
            amountError.innerHTML = "";
        }

        if (!dateInput.value) {
            dateError.innerHTML = "Date is required.";
            hasError = true;
        } else {
            dateError.innerHTML = "";
        }

        if (hasError) {
            e.preventDefault();
        }
    });
});
