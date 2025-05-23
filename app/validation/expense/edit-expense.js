document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('.expense-form');
  const categorySelect = document.getElementById('expenseCategory');
  const nameInput = document.getElementById('expenseName');
  const amountInput = document.getElementById('expenseAmount');
  const dateInput = document.getElementById('expenseDate');

  const categoryError = document.getElementById('categoryError');
  const nameError = document.getElementById('nameError');
  const amountError = document.getElementById('amountError');
  const dateError = document.getElementById('dateError');
  const emptyError = document.getElementById('emptyError');

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

  const prevCategory = document.querySelector('input[readonly][value="' + categorySelect.options[categorySelect.selectedIndex].text + '"]').value || "";
  const prevName = document.querySelector('input[readonly][value="' + nameInput.value + '"]').value || "";
  const prevAmount = document.querySelector('input[readonly][value*="$"]').value.replace('$', '') || "";
  const prevDate = document.querySelector('input[readonly][value="' + dateInput.value + '"]').value || "";
  const prevNotes = document.querySelector('textarea[readonly]').textContent || "";

  form.addEventListener('submit', (e) => {
    let hasError = false;

    categoryError.textContent = '';
    nameError.textContent = '';
    amountError.textContent = '';
    dateError.textContent = '';
    emptyError.textContent = '';

    if (categorySelect.value.trim() === '') {
      categoryError.textContent = "Please select a category.";
      hasError = true;
    }

    const nameVal = nameInput.value.trim();
    if (nameVal === '') {
      nameError.textContent = "Name is required.";
      hasError = true;
    } else if (!isValidNameString(nameVal)) {
      nameError.textContent = "Name contains invalid characters.";
      hasError = true;
    }

    const amountVal = amountInput.value.trim();
    const amountNum = parseFloat(amountVal);
    if (amountVal === '') {
      amountError.textContent = "Amount is required.";
      hasError = true;
    } else if (isNaN(amountNum) || amountNum <= 0) {
      amountError.textContent = "Amount must be a positive number.";
      hasError = true;
    }

    if (dateInput.value.trim() === '') {
      dateError.textContent = "Date is required.";
      hasError = true;
    }

    if (!hasError) {
      const notesVal = document.getElementById('expenseNotes').value;

      if (
        categorySelect.value === prevCategory &&
        nameVal === prevName &&
        parseFloat(amountVal) === parseFloat(prevAmount) &&
        dateInput.value === prevDate &&
        notesVal === prevNotes
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
