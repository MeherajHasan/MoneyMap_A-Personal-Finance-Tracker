function validatePassword(event) {
    event.preventDefault();  // Prevent the default form submission

    const newPass = document.getElementById('newPass').value.trim();
    const confirmPass = document.getElementById('confirmPass').value.trim();
    const errorElement = document.getElementById('passError');
    let errorMsg = '';

    errorElement.textContent = '';

    // Check if either password field is empty
    if (newPass === '' || confirmPass === '') {
        errorMsg = 'Password fields cannot be empty';
    }
    // Check if both passwords have at least 8 characters
    else if (newPass.length < 8 || confirmPass.length < 8) {
        errorMsg = 'Passwords must be at least 8 characters long';
    }
    // Check if both passwords match
    else if (newPass !== confirmPass) {
        errorMsg = 'Passwords do not match';
    }

    // If there's an error message, show it and prevent form submission
    if (errorMsg !== '') {
        errorElement.textContent = errorMsg;
        return false;
    }

    // If everything is valid, redirect to login.html
    window.location.href = 'login.html';
    return false;  // Prevent form submission to the server
}
