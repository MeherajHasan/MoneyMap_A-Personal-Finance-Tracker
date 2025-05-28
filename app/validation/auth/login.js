const form = document.getElementById("loginForm");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const emailError = document.getElementById("emailError");
const passwordError = document.getElementById("passwordError");
const submitBtn = document.getElementById("loginSubmitBtn");

function validateEmail(email) {
    if (!email) return false;
    const parts = email.trim().split("@");
    if (parts.length !== 2) return false;

    const local = parts[0];
    if (!local || local.length > 64) return false;

    const domainParts = parts[1].split(".");
    if (domainParts.length < 2) return false;

    for (let part of domainParts) {
        if (!part || part.length > 63) return false;
    }
    return true;
}

function validateForm() {
    let valid = true;

    if (emailInput.value.trim() === "") {
        emailError.textContent = "Please enter your email.";
        valid = false;
    } else if (!validateEmail(emailInput.value.trim())) {
        emailError.textContent = "Please enter a valid email address.";
        valid = false;
    } else { 
        emailError.textContent = "";
    }

    if (passwordInput.value.trim() === "") {
        passwordError.textContent = "Please enter your password.";
        valid = false;
    } else {
        passwordError.textContent = "";
    }

    submitBtn.disabled = !valid;
    return valid;
}

emailInput.addEventListener("input", validateForm);
passwordInput.addEventListener("input", validateForm);

form.addEventListener("submit", function(e) {
    if (!validateForm()) {
        e.preventDefault(); 
    }
});
