document.getElementById("contactForm").addEventListener("submit", function (e) {
  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const subject = document.getElementById("subject").value.trim();
  const message = document.getElementById("message").value.trim();
  const captcha = document.getElementById("captcha").value.trim();

  let isValid = true;

  document.getElementById("nameError").textContent = "";
  document.getElementById("emailError").textContent = "";
  document.getElementById("subjectError").textContent = "";
  document.getElementById("messageError").textContent = "";
  document.getElementById("captchaError").textContent = "";

  if (name === "") {
    document.getElementById("nameError").textContent = "Full name is required.";
    isValid = false;
  } else {
    for (let i = 0; i < name.length; i++) {
      const char = name[i];
      if (!(
        (char >= 'A' && char <= 'Z') ||
        (char >= 'a' && char <= 'z') ||
        (char >= '0' && char <= '9') ||
        char === ' ' || char === '.' || char === ',' || char === '-'
      )) {
        document.getElementById("nameError").textContent = "Name contains invalid characters.";
        isValid = false;
        break;
      }
    }
  }

  if (email === "") {
    document.getElementById("emailError").textContent = "Email is required.";
    isValid = false;
  } else {
    const atPos = email.indexOf("@");
    const dotPos = email.indexOf(".", atPos + 2);
    if (
      atPos < 1 ||
      dotPos === -1 ||
      dotPos === email.length - 1
    ) {
      document.getElementById("emailError").textContent = "Invalid email format.";
      isValid = false;
    }
  }

  if (subject === "") {
    document.getElementById("subjectError").textContent = "Subject is required.";
    isValid = false;
  }

  if (message === "") {
    document.getElementById("messageError").textContent = "Message is required.";
    isValid = false;
  }

  if (captcha === "") {
    document.getElementById("captchaError").textContent = "CAPTCHA is required.";
    isValid = false;
  }

  if (!isValid) {
    e.preventDefault();
  }
});
