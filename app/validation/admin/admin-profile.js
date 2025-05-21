document.querySelector('.profile-form').addEventListener('submit', function (e) {
    let hasError = false;

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const address = document.getElementById('address').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const currentPassword = document.getElementById('current-password').value;

    function isNameValid(name) {
        for (let i = 0; i < name.length; i++) {
            let c = name[i];
            if (!((c >= 'a' && c <= 'z') || (c >= 'A' && c <= 'Z') || c === ' ')) {
                return false;
            }
        }
        return true;
    }

    function isEmailValid(email) {
        return email.includes('@') && email.includes('.') && email.indexOf('@') < email.lastIndexOf('.');
    }

    function isPhoneValid(phone) {
        if (phone.length < 8 || phone.length > 15) return false;
        for (let i = 0; i < phone.length; i++) {
            if (!(phone[i] >= '0' && phone[i] <= '9')) {
                return false;
            }
        }
        return true;
    }

    if (currentPassword === '') {
        alert('Current password is required.');
        hasError = true;
    }

    if (name === '') {
        alert('Full Name is required.');
        hasError = true;
    } else if (!isNameValid(name)) {
        alert('Name can only contain letters and spaces.');
        hasError = true;
    } else if (name.split(' ').length < 2) {
        alert('Full Name must contain first and last name.');
        hasError = true;
    }

    if (email === '') {
        alert('Email is required.');
        hasError = true;
    } else if (!isEmailValid(email)) {
        alert('Invalid email format.');
        hasError = true;
    }

    if (phone === '') {
        alert('Phone number is required.');
        hasError = true;
    } else if (!isPhoneValid(phone)) {
        alert('Phone number must be 8-15 DIGITS only.');
        hasError = true;
    }

    if (address === '') {
        alert('Address is required.');
        hasError = true;
    }

    if (password !== '') {
        if (password.length < 8) {
            alert('Password must be at least 8 characters.');
            hasError = true;
        }
        if (password !== confirmPassword) {
            alert('Passwords do not match.');
            hasError = true;
        }
    }

    if (hasError) e.preventDefault();
});
