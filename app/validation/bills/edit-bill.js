document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('edit-bill-form');

  const billNameInput = document.getElementById('bill-name');
  const amountInput = document.getElementById('amount');
  const dueDateInput = document.getElementById('due-date');
  const statusSelect = document.getElementById('status');

  const errorName = document.getElementById('error-name');
  const errorAmount = document.getElementById('error-amount');
  const errorDate = document.getElementById('error-date'); // not really used for empty but can clear
  const errorStatus = document.getElementById('error-status');

  // Store original values to compare changes
  const original = {
    name: billNameInput.value.trim(),
    amount: amountInput.value.trim(),
    dueDate: dueDateInput.value,
    status: statusSelect.value
  };

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    // Clear previous errors
    errorName.textContent = '';
    errorAmount.textContent = '';
    errorDate.textContent = '';
    errorStatus.textContent = '';

    const name = billNameInput.value.trim();
    const amount = amountInput.value.trim();
    const dueDate = dueDateInput.value;
    const status = statusSelect.value;

    let valid = true;

    // Check if any field is empty
    if (!name || !amount || !dueDate || !status) {
      errorStatus.textContent = 'All fields are required.';
      valid = false;
    }

    // Validate bill name (only letters, digits, spaces, dash, underscore allowed)
    if (name) {
      for (let i = 0; i < name.length; i++) {
        const c = name[i];
        const code = c.charCodeAt(0);
        const isLetter = (code >= 65 && code <= 90) || (code >= 97 && code <= 122);
        const isDigit = (code >= 48 && code <= 57);
        const isAllowed = c === ' ' || c === '-' || c === '_';

        if (!isLetter && !isDigit && !isAllowed) {
          errorName.textContent = 'Bill name contains invalid characters.';
          valid = false;
          break;
        }
      }
    }

    // Validate amount (must be number > 0)
    if (amount) {
      const num = parseFloat(amount);
      if (isNaN(num) || num < 0) {
        errorAmount.textContent = 'Amount must be a number zero or greater.';
        valid = false;
      }
    }

    // Check if anything changed
    if (valid) {
      if (
        name === original.name &&
        amount === original.amount &&
        dueDate === original.dueDate &&
        status === original.status
      ) {
        errorStatus.textContent = 'Please change at least one field before saving.';
        valid = false;
      }
    }

    if (valid) {
      // Redirect to dashboard on success
      window.location.href = 'bill-dashboard.php';
    }
  });
});
