window.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("emailVerifyForm");
  const verifyCodeInput = document.getElementById("verifyCode");
  const verifyMsg = document.getElementById("verifyMSG");

  form.addEventListener("submit", (e) => {
    verifyMsg.textContent = "";     
    verifyMsg.style.color = "red";    

    const code = verifyCodeInput.value.trim();

    if (code.length === 0) {
      verifyMsg.textContent = "Verification code is required.";
      e.preventDefault();
      verifyCodeInput.focus();
      return;
    }

    if (code.length !== 6) {
      verifyMsg.textContent = "Verification code must be exactly 6 digits.";
      e.preventDefault();
      verifyCodeInput.focus();
      return;
    }

    for (let i = 0; i < code.length; i++) {
      const ch = code[i];
      if (ch < '0' || ch > '9') {
        verifyMsg.textContent = "Verification code must be exactly 6 digits.";
        e.preventDefault();
        verifyCodeInput.focus();
        return;
      }
    }

    verifyMsg.textContent = "";
  });
});
