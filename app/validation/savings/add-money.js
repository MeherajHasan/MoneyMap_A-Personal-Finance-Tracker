document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("addMoneyForm");

    const goalName = document.getElementById("goalName");
    const amount = document.getElementById("amount");
    const transactionDate = document.getElementById("transactionDate");

    const nameError = document.getElementById("nameError");
    const amountError = document.getElementById("amountError");
    const dateError = document.getElementById("dateError");

    form.addEventListener("submit", function (e) {
        let hasError = false;

        nameError.textContent = "";
        amountError.textContent = "";
        dateError.textContent = "";

        if (!goalName.value) {
            nameError.textContent = "Please select a savings goal.";
            hasError = true;
        }

        if (!amount.value) {
            amountError.textContent = "Amount is required.";
            hasError = true;
        } else if (parseFloat(amount.value) <= 0) {
            amountError.textContent = "Amount must be greater than 0.";
            hasError = true;
        }

        if (!transactionDate.value) {
            dateError.textContent = "Please select a transaction date.";
            hasError = true;
        }

        if (hasError) {
            e.preventDefault(); 
        }
    });
});
