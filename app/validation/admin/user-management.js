document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[method="post"]:not([name])'); // selects the edit form
    if (!form) return;

    function isLettersAndSpaces(str) {
        for (let i = 0; i < str.length; i++) {
            const c = str[i].toLowerCase();
            if (!((c >= 'a' && c <= 'z') || c === ' ')) return false;
        }
        return str.length > 0;
    }

    function isValidCountryCode(code) {
        if (code.length === 0) return false;
        if (code[0] === '+') {
            for (let i = 1; i < code.length; i++) {
                if (!(code[i] >= '0' && code[i] <= '9')) return false;
            }
            return true;
        } else {
            for (let i = 0; i < code.length; i++) {
                if (!(code[i] >= '0' && code[i] <= '9')) return false;
            }
            return true;
        }
    }

    function isDigitsOnly(str) {
        if (str.length === 0) return false;
        for (let i = 0; i < str.length; i++) {
            if (!(str[i] >= '0' && str[i] <= '9')) return false;
        }
        return true;
    }

    function validateForm() {
        const errors = [];

        const fname = form.fname.value.trim();
        const lname = form.lname.value.trim();
        const countryCode = form.country_code.value.trim();
        const phone = form.phone.value.trim();
        const gender = form.gender.value;
        const dob = form.dob.value;
        const address = form.address.value.trim();
        const accountStatus = form.account_status.value;
        const role = form.role.value;

        if (!isLettersAndSpaces(fname)) {
            errors.push('First name must contain only letters and spaces and cannot be empty.');
        }
        if (!isLettersAndSpaces(lname)) {
            errors.push('Last name must contain only letters and spaces and cannot be empty.');
        }
        if (!isValidCountryCode(countryCode)) {
            errors.push('Country code must be numeric or start with "+".');
        }
        if (!isDigitsOnly(phone)) {
            errors.push('Phone number must be digits only and cannot be empty.');
        }
        if (gender !== '0' && gender !== '1') {
            errors.push('Please select a valid gender.');
        }
        if (dob === '') {
            errors.push('Date of birth is required.');
        }
        if (address === '') {
            errors.push('Address is required.');
        }
        if (!['0', '1', '2', '3'].includes(accountStatus)) {
            errors.push('Please select a valid account status.');
        }
        if (role !== 'admin' && role !== 'user') {
            errors.push('Please select a valid role.');
        }

        if (errors.length > 0) {
            alert(errors.join('\n'));
            return false;
        }
        return true;
    }

    form.addEventListener('submit', (e) => {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
});
