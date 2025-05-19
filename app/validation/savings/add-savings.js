document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("add-savings-form");

    const goalNameInput = document.getElementById("goal-name");
    const amountInput = document.getElementById("target-amount");
    const dateInput = document.getElementById("target-date");

    const nameError = document.getElementById("nameError");
    const amountError = document.getElementById("amountError");
    const dateError = document.getElementById("dateError");

    form.addEventListener("submit", function (e) {
        let isValid = true;

        nameError.textContent = "";
        amountError.textContent = "";
        dateError.textContent = "";

        const goalName = goalNameInput.value.trim();
        const amount = amountInput.value.trim();
        const date = dateInput.value;

        if (goalName === "") {
            nameError.textContent = "Goal name is required.";
            isValid = false;
        } else {
            for (let i = 0; i < goalName.length; i++) {
                const c = goalName[i];
                if (!(
                    (c >= 'a' && c <= 'z') ||
                    (c >= 'A' && c <= 'Z') ||
                    (c >= '0' && c <= '9') ||
                    c === ' ' || c === '.' || c === ',' || c === '-'
                )) {
                    nameError.textContent = "Only letters, digits, spaces, ., , and - are allowed.";
                    isValid = false;
                    break;
                }
            }
        }

        if (amount === "") {
            amountError.textContent = "Target amount is required.";
            isValid = false;
        } else if (isNaN(amount) || parseFloat(amount) <= 0) {
            amountError.textContent = "Enter a valid amount greater than 0.";
            isValid = false;
        }

        if (date === "") {
            dateError.textContent = "Target date is required.";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});
