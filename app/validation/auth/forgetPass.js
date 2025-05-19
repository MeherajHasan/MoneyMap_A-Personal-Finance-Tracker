document.getElementById('forgetForm').addEventListener('submit', function (e) {
    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();
    const msg = document.getElementById('forgotMSG');

    msg.textContent = '';
    msg.style.color = '';

    function isValidEmail(email) {
        const atPos = email.indexOf('@');
        const dotPos = email.indexOf('.');

        if (atPos === -1 || dotPos === -1) return false;      
        if (atPos > dotPos) return false;                  
        return true;
    }

    if (email.length === 0) {
        e.preventDefault();
        msg.textContent = "Email is required.";
        msg.style.color = 'red';
        emailInput.focus();
    } else if (!isValidEmail(email)) {
        e.preventDefault();
        msg.textContent = "Email must contain '@' and '.', and '@' must come before '.'";
        msg.style.color = 'red';
        emailInput.focus();
    }
});
