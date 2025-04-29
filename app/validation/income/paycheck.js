document.addEventListener("DOMContentLoaded", () => {
    const saveBtn = document.getElementById("save-btn");
    const cancelBtn = document.getElementById("cancel-btn");

    const payeeInput = document.getElementById("payee-name");
    const amountInput = document.getElementById("amount");
    const dateInput = document.getElementById("date");
    const errorMsg = document.getElementById("errorMSG");

    saveBtn?.addEventListener("click", () => {
        const payee = payeeInput.value.trim();
        const amount = amountInput.value.trim();
        const date = dateInput.value;

        errorMsg.textContent = "";
        errorMsg.style.color = "red";

        if (!payee || !amount || !date) {
            errorMsg.textContent = "Please fill in all fields.";
            return;
        }

        // Manual validation for payee (only letters, space, ., -)
        for (let i = 0; i < payee.length; i++) {
            const ch = payee[i];
            const isLetter = (ch >= 'A' && ch <= 'Z') || (ch >= 'a' && ch <= 'z');
            const isValidChar = isLetter || ch === ' ' || ch === '.' || ch === '-';
            if (!isValidChar) {
                errorMsg.textContent = "Payee name can only contain letters, spaces, dots, and hyphens.";
                return;
            }
        }

        // Manual validation for amount (only digits and > 0)
        for (let i = 0; i < amount.length; i++) {
            if (amount[i] < '0' || amount[i] > '9') {
                errorMsg.textContent = "Amount must only contain digits.";
                return;
            }
        }

        if (parseInt(amount) <= 0) {
            errorMsg.textContent = "Amount must be greater than 0.";
            return;
        }

        // All validations passed
        window.location.href = "../../views/income/income-recording.html";
    });

    cancelBtn?.addEventListener("click", () => {
        window.location.href = "../../views/dashboard/dashboard.html";
    });
});
