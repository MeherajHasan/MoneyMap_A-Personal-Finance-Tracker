const idType = document.getElementById('id-type');
const idNumber = document.getElementById('id-number');
const passportExpiryDiv = document.getElementById('passport-expiry');
const passportExpiryInput = document.getElementById('passport-expiry-date');
const errorMSG = document.getElementById('errorMSG');
const saveBtn = document.getElementById('save-btn');
const cancelBtn = document.getElementById('cancel-btn');

idType.addEventListener('change', function () {
    if (idType.value === 'Passport') {
        passportExpiryDiv.style.display = 'block';
    } else {
        passportExpiryDiv.style.display = 'none';
        passportExpiryInput.value = '';
    }
});

saveBtn.addEventListener('click', function () {
    errorMSG.textContent = '';
    if (idType.value === '') {
        errorMSG.textContent = 'Select an identity type';
        return;
    }
    if (idType.value === 'Passport') {
        const number = idNumber.value.trim();
        const expiry = passportExpiryInput.value;
        if (number === '' || expiry === '') {
            errorMSG.textContent = 'Passport number and expiry date are required';
            return;
        }
        if (number.length <= 8) {
            errorMSG.textContent = 'Passport number must be more than 8 characters';
            return;
        }
        for (let i = 0; i < number.length; i++) {
            const c = number.charCodeAt(i);
            if (!((c >= 48 && c <= 57) || (c >= 65 && c <= 90))) {
                errorMSG.textContent = 'Passport number must contain only A-Z and 0-9';
                return;
            }
        }
        const today = new Date();
        const expiryDate = new Date(expiry);
        today.setHours(0, 0, 0, 0);
        if (expiryDate <= today) {
            errorMSG.textContent = 'Passport expiry date must be in the future';
            return;
        }
    } else if (idType.value === 'NID') {
        const number = idNumber.value.trim();
        if (number === '') {
            errorMSG.textContent = 'NID number is required';
            return;
        }
        for (let i = 0; i < number.length; i++) {
            const c = number.charCodeAt(i);
            if (!(c >= 48 && c <= 57)) {
                errorMSG.textContent = 'NID number must contain only digits';
                return;
            }
        }
        if (!(number.length === 10 || number.length === 17)) {
            errorMSG.textContent = 'NID number must be 10 or 17 digits';
            return;
        }
    }
    window.location.href = '../../views/profile/profile.php';
});

cancelBtn.addEventListener('click', function () {
    window.location.href = '../../views/dashboard/dashboard.php';
});
