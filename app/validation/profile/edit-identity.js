document.addEventListener('DOMContentLoaded', () => {
    const idTypeSelect = document.getElementById('id-type');
    const passportExpiryDiv = document.getElementById('passport-expiry');
    const saveBtn = document.getElementById('save-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const form = document.getElementById('edit-identity');

    const idNumberInput = document.getElementById('id-number');
    const passportExpiryInput = document.getElementById('passport-expiry-date');
    const errorMsg = document.getElementById('errorMSG');

    // Show/hide passport expiry based on selection
    idTypeSelect.addEventListener('change', () => {
        if (idTypeSelect.value === 'Passport') {
            passportExpiryDiv.style.display = 'block';
        } else {
            passportExpiryDiv.style.display = 'none';
        }
    });

    saveBtn.addEventListener('click', () => {
        const idType = idTypeSelect.value;
        const idNumber = idNumberInput.value.trim();
        const passportExpiry = passportExpiryInput.value;

        errorMsg.textContent = '';

        if (!idType) {
            errorMsg.textContent = "Identity type is required.";
            return;
        }

        if (idNumber === '') {
            errorMsg.textContent = "ID number is required.";
            return;
        }

        for (let i = 0; i < idNumber.length; i++) {
            const c = idNumber[i];
            if (!(
                ('a' <= c && c <= 'z') ||
                ('A' <= c && c <= 'Z') ||
                ('0' <= c && c <= '9')
            )) {
                errorMsg.textContent = "ID number contains invalid characters.";
                return;
            }
        }

        if (idType === 'Passport' && passportExpiry === '') {
            errorMsg.textContent = "Passport expiry date is required.";
            return;
        }

        form.submit(); 
    });

    cancelBtn.addEventListener('click', () => {
        window.location.href = 'profile.php';
    });
});
