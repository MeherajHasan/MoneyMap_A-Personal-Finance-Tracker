const form = document.getElementById("emailVerifyForm");
const codeInput = document.getElementById("verifyCode");
const errorMSG = document.getElementById("verifyMSG");
const confirmBtn = document.getElementById("verifyConfirmBtn");

const actualCode = "111111";

function isAllDigits(input) {
    for (let i = 0; i < input.length; i++) {
        if (input[i] < "0" || input[i] > "9") {
            return false;
        }
    }
    return true;
}

codeInput.addEventListener("input", () => {
    validateCode();
});

form.addEventListener("submit", function (e) {
    e.preventDefault(); 

    if (validateCode()) {
        window.location.href = 'resetPass.html';
    }
});

function validateCode() {
    const input = codeInput.value.trim();
    errorMSG.textContent = "";

    if (!input) {
        errorMSG.textContent = "Please enter the verification code.";
        confirmBtn.disabled = true;
        return false;
    }

    if (!isAllDigits(input)) {
        errorMSG.textContent = "Code must contain only numbers.";
        confirmBtn.disabled = true;
        return false;
    }

    if (input.length !== 6) {
        errorMSG.textContent = "Code must be exactly 6 digits.";
        confirmBtn.disabled = true;
        return false;
    }

    if (input !== actualCode) {
        errorMSG.textContent = "Verification code is incorrect.";
        confirmBtn.disabled = true;
        return false;
    }

    confirmBtn.disabled = false;
    return true;
}

confirmBtn.disabled = true;