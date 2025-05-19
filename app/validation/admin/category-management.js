document.addEventListener("DOMContentLoaded", () => {
  const expenseForm = document.querySelector('form[action$="category-management.php"]:nth-of-type(1)');
  const expenseInput = expenseForm.querySelector('input[name="searchExpense"]');

  const budgetForm = document.querySelector('form[action$="category-management.php"]:nth-of-type(2)');
  const budgetInput = budgetForm.querySelector('input[name="searchBudget"]');

  function simpleEmailCheck(email) {
    const atPos = email.indexOf("@");
    const dotPos = email.lastIndexOf(".");
    if (atPos < 1) return false;        
    if (dotPos < atPos + 2) return false;  
    if (dotPos === email.length - 1) return false;
    return true;
  }

  expenseForm.addEventListener("submit", (e) => {
    const val = expenseInput.value.trim();
    if (val === "") {
      alert("Please enter an email to search in Expense Categories.");
      e.preventDefault();
      return;
    }
    if (!simpleEmailCheck(val)) {
      alert("Please enter a valid email address in Expense Categories.");
      e.preventDefault();
    }
  });

  budgetForm.addEventListener("submit", (e) => {
    const val = budgetInput.value.trim();
    if (val === "") {
      alert("Please enter an email to search in Budget Categories.");
      e.preventDefault();
      return;
    }
    if (!simpleEmailCheck(val)) {
      alert("Please enter a valid email address in Budget Categories.");
      e.preventDefault();
    }
  });
});
