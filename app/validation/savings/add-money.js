document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("addMoneyForm");
  const amountInput = document.getElementById("amount");
  const transactionDateInput = document.getElementById("transactionDate");
  const amountError = amountInput.nextElementSibling;
  const dateError = transactionDateInput.nextElementSibling;
  const maxToSaveInput = document.getElementById("amountToSave");

  form.addEventListener("submit", (e) => {
    let hasError = false;

    amountError.textContent = "";
    dateError.textContent = "";

    const amountValue = amountInput.value.trim();
    const maxToSave = parseFloat(maxToSaveInput.value);
    const transactionDateValue = transactionDateInput.value.trim();

    if (amountValue === "") {
      amountError.textContent = "Please enter an amount.";
      hasError = true;
    } else {
      const amountNum = parseFloat(amountValue);
      if (isNaN(amountNum)) {
        amountError.textContent = "Amount must be a valid number.";
        hasError = true;
      } else if (amountNum <= 0) {
        amountError.textContent = "Amount must be greater than zero.";
        hasError = true;
      } else if (amountNum > maxToSave) {
        amountError.textContent = "Amount exceeds the maximum allowed to save.";
        hasError = true;
      }
    }

    if (transactionDateValue === "") {
      dateError.textContent = "Please select a date.";
      hasError = true;
    }

    if (hasError) {
      e.preventDefault();
    }
  });
});
