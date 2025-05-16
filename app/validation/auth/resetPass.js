const form = document.getElementById("resetPassForm");
const newPassInput = document.getElementById("newPass");
const confirmPassInput = document.getElementById("confirmPass");
const passErrorMSG1 = document.getElementById("passErrorMSG1");
const passErrorMSG2 = document.getElementById("passErrorMSG2");
const submitBtn = document.getElementById("resetPassBtn");

submitBtn.disabled = true;

function validate() {
    const newPass = newPassInput.value.trim();
    const confirmPass = confirmPassInput.value.trim();

    let isValid = true;

    passErrorMSG1.innerHTML = "";
    passErrorMSG2.innerHTML = "";

    if (!newPass) {
        passErrorMSG1.innerHTML = "Please enter a new password.";
        isValid = false;
    } else if (newPass.length < 8) {
        passErrorMSG1.innerHTML = "Password must be at least 8 characters long.";
        isValid = false;
    }

    if (!confirmPass) {
        passErrorMSG2.innerHTML = "Please confirm your new password.";
        isValid = false;
    } else if (confirmPass !== newPass) {
        passErrorMSG2.innerHTML = "Passwords do not match.";
        isValid = false;
    }

    submitBtn.disabled = !isValid;
    return isValid;
}

newPassInput.addEventListener("input", validate);
confirmPassInput.addEventListener("input", validate);

form.addEventListener("submit", (e) => {
    e.preventDefault();

    if (validate()) {
        window.location.href = '../../views/auth/login.php';
    }
});