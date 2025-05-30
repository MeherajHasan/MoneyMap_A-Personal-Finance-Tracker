document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".debt-form");
    const paymentInput = document.getElementById("paymentAmount");
    const errorSpan = document.querySelector(".error-message");

    const minText = document.getElementById("minAmount").textContent.trim();
    const maxText = document.getElementById("remainingAmount").textContent.trim();

    const minPayment = parseFloat(minText.replace('$', ''));
    const maxPayment = parseFloat(maxText.replace('$', ''));

    form.addEventListener("submit", function (e) {
        const value = paymentInput.value.trim();
        let error = "";

        if (value === "") {
            error = "Payment amount is required.";
        } else if (isNaN(value) || parseFloat(value) <= 0) {
            error = "Payment amount must be a positive number.";
        } else if (parseFloat(value) < minPayment) {
            error = `Payment amount must be at least $${minPayment.toFixed(2)}.`;
        } else if (parseFloat(value) > maxPayment) {
            error = `Payment amount cannot exceed $${maxPayment.toFixed(2)}.`;
        }

        if (error !== "") {
            e.preventDefault();
            errorSpan.textContent = error;
        } else {
            errorSpan.textContent = "";
        }
    });
});
