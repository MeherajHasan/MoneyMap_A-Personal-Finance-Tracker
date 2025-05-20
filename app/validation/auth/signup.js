const form = document.getElementById("signupForm");
const idTypeSelect = document.getElementById("idType");
const passportExpiryGroup = document.getElementById("passportExpiryContainer");

function sanitize(str) {
    return str.trim();
}

function isOnlyLettersAndSpaces(str) {
    for (let i = 0; i < str.length; i++) {
        const c = str[i];
        if (!(('A' <= c && c <= 'Z') || ('a' <= c && c <= 'z') || c === ' ')) {
            return false;
        }
    }
    return true;
}

function isAlphanumeric(str) {
    for (let i = 0; i < str.length; i++) {
        const c = str[i];
        if (!(('A' <= c && c <= 'Z') || ('a' <= c && c <= 'z') || ('0' <= c && c <= '9'))) {
            return false;
        }
    }
    return true;
}

function isDigitsOnly(str) {
    for (let i = 0; i < str.length; i++) {
        if (!(str[i] >= '0' && str[i] <= '9')) {
            return false;
        }
    }
    return true;
}

function isValidEmailSimple(email) {
    const atPos = email.indexOf("@");
    const dotPos = email.lastIndexOf(".");
    return atPos > 0 && dotPos > atPos + 1 && dotPos < email.length - 1;
}

function isAtLeast12YearsOld(dob) {
    const dobDate = new Date(dob);
    if (isNaN(dobDate.getTime())) return false;
    const now = new Date();
    const twelveYearsAgo = new Date(now.getFullYear() - 12, now.getMonth(), now.getDate());
    return dobDate <= twelveYearsAgo;
}

function handleIDSelection() {
    const idType = idTypeSelect.value;
    if (idType === "passport") {
        passportExpiryGroup.style.display = "block";
    } else {
        passportExpiryGroup.style.display = "none";
    }
}

function validateForm() {
    const errors = [];

    const fname = sanitize(form.fname.value);
    const lname = sanitize(form.lname.value);
    const idType = form.idType.value;
    const idInput = sanitize(form.idInput.value);
    const passportExpiry = form.passportExpiry.value;
    const countryCode = form.countryCode.value;
    const phone = sanitize(form.phone.value);
    const email = sanitize(form.email.value);
    const password = form.password.value;
    const confirmPassword = form.confirmPassword.value;
    const gender = form.gender.value;
    const dob = form.dob.value;
    const address = sanitize(form.address.value);
    const photo = form.photo.files[0];

    if (!fname) {
        errors.push("First name is required.");
    } else if (!isOnlyLettersAndSpaces(fname)) {
        errors.push("First name must contain only letters and spaces.");
    }

    if (!lname) {
        errors.push("Last name is required.");
    } else if (!isOnlyLettersAndSpaces(lname)) {
        errors.push("Last name must contain only letters and spaces.");
    }

    if (!idType) {
        errors.push("Identification type is required.");
    }

    if (!idInput) {
        errors.push(`${idType} number is required.`);
    } else {
        if (idInput.length < 6 || idInput.length > 20) {
            errors.push(`${idType} number must be 6 to 20 characters long.`);
        } else if (!isAlphanumeric(idInput)) {
            errors.push(`${idType} number must contain only letters and numbers.`);
        }
    }

    if (idType === "passport") {
        if (!passportExpiry) {
            errors.push("Passport expiry date is required.");
        } else {
            const expiry = new Date(passportExpiry);
            const today = new Date();
            if (expiry <= today) {
                errors.push("Passport expiry date must be greater than today.");
            }
        }
    }

    if (!countryCode) {
        errors.push("Country code is required.");
    }

    if (!phone) {
        errors.push("Phone number is required.");
    } else {
        if (phone.length < 6 || phone.length > 15) {
            errors.push("Phone number must be 6 to 15 digits.");
        } else if (!isDigitsOnly(phone)) {
            errors.push("Phone number must contain only digits.");
        }
    }

    if (!email) {
        errors.push("Email is required.");
    } else if (!isValidEmailSimple(email)) {
        errors.push("Email must be valid and contain '@' and '.' with '@' before '.'");
    }

    if (!password) {
        errors.push("Password is required.");
    } else if (password.length < 8) {
        errors.push("Password must be at least 8 characters.");
    }

    if (!confirmPassword) {
        errors.push("Confirm Password is required.");
    } else if (password !== confirmPassword) {
        errors.push("Passwords do not match.");
    }

    if (!gender) {
        errors.push("Gender is required.");
    }

    if (!dob) {
        errors.push("Date of birth is required.");
    } else if (!isAtLeast12YearsOld(dob)) {
        errors.push("You must be at least 12 years old.");
    }

    if (!address) {
        errors.push("Address is required.");
    }

    if (!photo) {
        errors.push("Photo upload is required.");
    } else {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(photo.type)) {
            errors.push("Only JPG, PNG, and GIF images are allowed.");
        }
    }

    if (errors.length > 0) {
        alert(errors.join("\n"));
        return false;
    }

    return true;
}

idTypeSelect.addEventListener("change", handleIDSelection);

form.addEventListener("submit", function (e) {
    e.preventDefault();
    if (validateForm()) {
        form.submit();
    }
});
