document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('.expense-form');
  const categorySelect = document.getElementById('expenseCategory');
  const nameInput = document.getElementById('expenseName');
  const amountInput = document.getElementById('expenseAmount');
  const dateInput = document.getElementById('expenseDate');
  const notesInput = document.getElementById('expenseNotes');

  const prevCategory = "House Rent";
  const prevName = "Monthly Rent";
  const prevAmount = 1200;
  const prevDate = "2025-05-01";
  const prevNotes = "Rent for May 2025";

  const categoryError = document.getElementById('categoryError');
  const nameError = document.getElementById('nameError');
  const amountError = document.getElementById('amountError');
  const dateError = document.getElementById('dateError');
  const emptyError = document.getElementById('emptyError');

  function clearErrors() {
    categoryError.textContent = '';
    nameError.textContent = '';
    amountError.textContent = '';
    dateError.textContent = '';
    emptyError.textContent = '';
  }

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

  form.addEventListener('submit', (e) => {
    clearErrors();

    let hasError = false;

    const category = categorySelect.value.trim();
    const name = nameInput.value.trim();
    const amountStr = amountInput.value.trim();
    const date = dateInput.value.trim();
    const notes = notesInput.value.trim();

    if (category === '') {
      categoryError.textContent = "Please select a category.";
      hasError = true;
    } else {
      const allowedCategories = ["House Rent", "Transportation", "Shopping", "Food", "Cosmetics", "Pet", "Medical", "Education"];
      if (!allowedCategories.includes(category)) {
        categoryError.textContent = "Invalid category selected.";
        hasError = true;
      }
    }

    if (name === '') {
      nameError.textContent = "Name is required.";
      hasError = true;
    } else if (!isValidNameString(name)) {
      nameError.textContent = "Name contains invalid characters.";
      hasError = true;
    }

    if (amountStr === '') {
      amountError.textContent = "Amount is required.";
      hasError = true;
    } else {
      const amount = Number(amountStr);
      if (isNaN(amount) || amount <= 0) {
        amountError.textContent = "Amount must be a positive number.";
        hasError = true;
      }
    }

    if (date === '') {
      dateError.textContent = "Date is required.";
      hasError = true;
    }

    if (!hasError) {
      if (
        category === prevCategory &&
        name === prevName &&
        Number(amountStr) === Number(prevAmount) &&
        date === prevDate &&
        notes === prevNotes
      ) {
        emptyError.textContent = "No changes detected. Please update at least one field.";
        hasError = true;
      }
    }

    if (hasError) {
      e.preventDefault();
    }
  });
});
