function validatePassword() {
    event.preventDefault();

    const newPass = document.getElementById('newPass').value.trim();
    const confirmPass = document.getElementById('confirmPass').value.trim();
    let errorMsg = '';

    const errorElement = document.getElementById('passError');
    errorElement.textContent = '';

    if (newPass === '' || confirmPass === '') {
        errorMsg = 'Password fields cannot be empty';
    } else if (newPass.length < 8 || confirmPass.length < 8) {
        errorMsg = 'Passwords must be at least 8 characters long';
    } else if (newPass !== confirmPass) {
        errorMsg = 'Passwords do not match';
    }

    if (errorMsg !== '') {
        errorElement.textContent = errorMsg;
        return false;
    }

    window.location.href = 'login.html';
    return false;
}
