const form = document.getElementById("contactForm");
const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");
const subjectInput = document.getElementById("subject");
const messageInput = document.getElementById("message");
const captchaInput = document.getElementById("captcha");
const captchaDisplay = document.getElementById("captchaDisplay");

const nameError = document.getElementById("nameError");
const emailError = document.getElementById("emailError");
const subjectError = document.getElementById("subjectError");
const messageError = document.getElementById("messageError");
const captchaError = document.getElementById("captchaError");

let correctCaptchaAnswer = 0;
let captchaWrongAttempts = 0;

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

function isValidName(name) {
  for (let i = 0; i < name.length; i++) {
    const ch = name[i];
    const code = ch.charCodeAt(0);
    if (
      !(
        (code >= 65 && code <= 90) ||
        (code >= 97 && code <= 122) ||
        ch === " " ||
        ch === "." ||
        ch === "-"
      )
    ) {
      return false;
    }
  }
  return true;
}

function generateCaptcha() {
  const num1 = Math.floor(Math.random() * 10) + 1;
  const num2 = Math.floor(Math.random() * 10) + 1;
  correctCaptchaAnswer = num1 + num2;
  captchaDisplay.innerHTML = `What is ${num1} + ${num2}?`;
}

function validateForm() {
  // 1. First check if any field is empty
  if (
    nameInput.value.trim() === "" ||
    emailInput.value.trim() === "" ||
    subjectInput.value.trim() === "" ||
    messageInput.value.trim() === "" ||
    captchaInput.value.trim() === ""
  ) {
    captchaError.innerHTML = "All the fields must be filled up.";
    return false;
  } else {
    captchaError.innerHTML = "";
  }

  let valid = true;

  if (!isValidName(nameInput.value.trim())) {
    nameError.innerHTML = "Illegal character(s) in name!";
    valid = false;
  } else {
    nameError.innerHTML = "";
  }

  if (!validateEmail(emailInput.value.trim())) {
    emailError.innerHTML = "Please enter a valid email.";
    valid = false;
  } else {
    emailError.innerHTML = "";
  }

  if (parseInt(captchaInput.value.trim()) !== correctCaptchaAnswer) {
    captchaWrongAttempts++;
    generateCaptcha();
    captchaInput.value = "";
    valid = false;

    if (captchaWrongAttempts >= 5) {
      alert("Too many wrong attempts! Redirecting to Home Page...");

      window.location.href = "../../../public/index.php";
      return false;
    } else if (captchaWrongAttempts >= 3) {
      captchaError.innerHTML =
        "Incorrect CAPTCHA! Warning: Multiple wrong attempts detected.";
    } else {
      captchaError.innerHTML = "Incorrect CAPTCHA answer. Please try again.";
    }
  } else {
    captchaError.innerHTML = "";
    captchaWrongAttempts = 0;
  }

  return valid;
}

form.addEventListener("submit", function (e) {
  if (!validateForm()) {
    e.preventDefault();
  } else {
    e.preventDefault();
    window.location.href = "../../views/contact/confirmation.php";
  }
});

generateCaptcha();
