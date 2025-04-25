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

  passErrorMSG1.textContent = "";
  passErrorMSG2.textContent = "";

  if (!newPass) {
    passErrorMSG1.textContent = "Please enter a new password.";
    isValid = false;
  } else if (newPass.length < 8) {
    passErrorMSG1.textContent = "Password must be at least 8 characters long.";
    isValid = false;
  }

  if (confirmPass && confirmPass !== newPass) {
    passErrorMSG2.textContent = "Passwords do not match.";
    isValid = false;
  }

  submitBtn.disabled = !isValid;
}

newPassInput.addEventListener("input", validate);
confirmPassInput.addEventListener("input", validate);

form.addEventListener("submit", (e) => {
  if (submitBtn.disabled) e.preventDefault();
});
