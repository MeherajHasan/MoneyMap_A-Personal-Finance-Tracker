document.getElementById('resetPassForm').addEventListener('submit', function (e) {
    const newPassInput = document.getElementById('newPass');
    const confirmPassInput = document.getElementById('confirmPass');
    const error1 = document.getElementById('passErrorMSG1');
    const error2 = document.getElementById('passErrorMSG2');

    let valid = true;

    error1.textContent = '';
    error2.textContent = '';

    const newPass = newPassInput.value.trim();
    const confirmPass = confirmPassInput.value.trim();

    if (newPass.length === 0) {
        error1.textContent = 'New password is required.';
        valid = false;
        newPassInput.focus();
    } else if (newPass.length < 8) {
        error1.textContent = 'Password must be at least 8 characters.';
        valid = false;
        newPassInput.focus();
    }

    if (confirmPass.length === 0) {
        error2.textContent = 'Confirm password is required.';
        valid = false;
        if (valid) confirmPassInput.focus(); 
    } else if (newPass !== confirmPass) {
        error2.textContent = 'Passwords do not match.';
        valid = false;
        if (valid) confirmPassInput.focus();
    }

    if (!valid) {
        e.preventDefault();
    }
});
