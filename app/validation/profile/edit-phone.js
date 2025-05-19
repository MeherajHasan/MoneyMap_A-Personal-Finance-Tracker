document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('edit-phone');
    const phoneInput = document.getElementById('phone');
    const errorMSG = document.getElementById('errorMSG');
    const successMSG = document.getElementById('successMSG');
    const saveBtn = document.getElementById('save-btn');
    const cancelBtn = document.getElementById('cancel-btn');

    function isDigitsOnly(str) {
        for (let i = 0; i < str.length; i++) {
            const ch = str[i];
            if (ch < '0' || ch > '9') {
                return false;
            }
        }
        return true;
    }

    saveBtn.addEventListener('click', function () {
        errorMSG.textContent = '';
        successMSG.textContent = '';

        const phone = phoneInput.value.trim();

        if (phone === '') {
            errorMSG.textContent = 'New phone number is required.';
            return;
        }
        if (!isDigitsOnly(phone)) {
            errorMSG.textContent = 'Phone number can contain digits only.';
            return;
        }
        if (phone.length < 6) {
            errorMSG.textContent = 'Phone number must be at least 6 digits.';
            return;
        }
        form.submit();
    });

    cancelBtn.addEventListener('click', function () {
        phoneInput.value = '';
        errorMSG.textContent = '';
        successMSG.textContent = '';
    });
});
