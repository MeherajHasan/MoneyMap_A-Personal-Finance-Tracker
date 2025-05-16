const form = document.getElementById("loginForm");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const emailError = document.getElementById("emailError");
const passwordError = document.getElementById("passwordError");
const submitBtn = document.getElementById("loginSubmitBtn");

function validateEmail(email) {
    const parts = email.trim().split("@");
    if (parts.length !== 2) return false;

    const local = parts[0];
    const domainParts = parts[1].split(".");

    if (!local || local.length > 64) return false;
    if (domainParts.length < 2) return false;

    for (let part of domainParts) {
        if (!part || part.length > 63) return false;
    }

    return true;
}

function validateForm() {
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    let emailValid = true;
    let passwordValid = false;

    if (email === "") {
        emailError.textContent = "Please enter an email address.";
        emailValid = false;
    } else if (!validateEmail(email)) {
        emailError.textContent = "Please enter a valid email address.";
        emailValid = false;
    } else if (email !== "xyz@gmail.com") {
        emailError.textContent = "Email not recognized.";
        emailValid = false;
    } else {
        emailError.textContent = "";
    }

    if (emailValid) {
        if (password === "") {
            passwordError.textContent = "Please enter your password.";
        } else if (password !== "11111111") {
            passwordError.textContent = "Incorrect password.";
        } else {
            passwordError.textContent = "";
            passwordValid = true;
        }
    } else {
        passwordError.textContent = "";
    }

    submitBtn.disabled = !(emailValid && passwordValid);
    return emailValid && passwordValid;
}

emailInput.addEventListener("input", validateForm);
passwordInput.addEventListener("input", validateForm);

form.addEventListener("submit", function (e) {
    e.preventDefault();
    if (validateForm()) {
        window.location.href = '../../views/dashboard/dashboard.php';
    }
});
