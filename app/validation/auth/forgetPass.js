const form = document.getElementById("forgetForm");
const emailInput = document.getElementById("email");
const errorEl = document.getElementById("forgotMSG");
const submitBtn = document.getElementById("forgotSubmitBtn");

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

emailInput.addEventListener("input", () => {
  const email = emailInput.value.trim();

  if (email === "") {
    errorEl.textContent = "Please enter an email address.";
    submitBtn.disabled = true;
  } else if (!validateEmail(email)) {
    errorEl.textContent = "Please enter a valid email address.";
    submitBtn.disabled = true;
  } else {
    errorEl.textContent = "";
    submitBtn.disabled = false;
  }
});

form.addEventListener("submit", function (e) {
  e.preventDefault(); 

  const email = emailInput.value.trim();
  if (validateEmail(email)) {
      window.location.href = 'emailVerify.html';
  } else {
      errorEl.textContent = "Please enter a valid email address.";
      submitBtn.disabled = true;
  }
});
