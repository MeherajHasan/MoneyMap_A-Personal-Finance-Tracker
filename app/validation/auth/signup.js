const form = document.getElementById("signupForm");
const fnameInput = document.getElementById("fname");
const lnameInput = document.getElementById("lname");
const idTypeSelect = document.getElementById("idType");
const idInput = document.getElementById("idInput");
const phoneInput = document.getElementById("phone");
const emailInput = document.getElementById("mail");
const passwordInput = document.getElementById("password");
const confirmPasswordInput = document.getElementById("confirmPassword");
const genderInputs = document.querySelectorAll("input[name='gender']");
const dobInput = document.getElementById("dob");
const addressInput = document.getElementById("address");
const photoInput = document.getElementById("photo");

const fnameError = document.getElementById("fnameError");
const lnameError = document.getElementById("lnameError");
const idTypeError = document.getElementById("idTypeError");
const idError = document.getElementById("idError");
const phoneError = document.getElementById("phoneError");
const emailError = document.getElementById("mailError");
const passError = document.getElementById("passError");
const confirmPassError = document.getElementById("confirmPassError");
const genderError = document.getElementById("genderError");
const dobError = document.getElementById("dobError");
const addressError = document.getElementById("addressError");
const photoError = document.getElementById("photoError");
const passportExpiryInput = document.getElementById("passportExpiry");
const passportExpiryError = document.getElementById("passportExpiryError");


function isValidName(name) {
    for (let i = 0; i < name.length; i++) {
        const ch = name[i];
        const code = ch.charCodeAt(0);
        if (!((code >= 65 && code <= 90) || (code >= 97 && code <= 122) || ch === '.' || ch === '-' || ch === "'")) {
            return false;
        }
    }
    return true;
}

function validateEmail(email) {
    const parts = email.trim().split("@");
    if (parts.length !== 2) return false;
    const local = parts[0];
    const domainParts = parts[1].split(".");
    if (!local || local.length > 64) return false;
    if (domainParts.length < 2) return false;
    for (let part of domainParts) {
        if (!part || part.length > 63) return false;
    }
    return true;
}

function handleIDSelection() {
    const type = idTypeSelect.value;
    const label = document.getElementById("idLabel");
    const container = document.getElementById("idInputContainer");
    const passportExpiryContainer = document.getElementById("passportExpiryContainer");

    if (type === "nid") {
        label.textContent = "NID Number:";
        idInput.placeholder = "Enter NID Number";
        idInput.type = "number";
        container.classList.remove("hidden");
        passportExpiryContainer.classList.add("hidden");
    } else if (type === "passport") {
        label.textContent = "Passport Number:";
        idInput.placeholder = "Enter Passport Number";
        idInput.type = "text";
        container.classList.remove("hidden");
        passportExpiryContainer.classList.remove("hidden");
    } else {
        container.classList.add("hidden");
        passportExpiryContainer.classList.add("hidden");
    }
}

function validateForm() {
    const genderSelected = Array.from(genderInputs).some(input => input.checked);

    if (
        fnameInput.value.trim() === "" ||
        lnameInput.value.trim() === "" ||
        idTypeSelect.value === "" ||
        idInput.value.trim() === "" ||
        phoneInput.value.trim() === "" ||
        emailInput.value.trim() === "" ||
        passwordInput.value.trim() === "" ||
        confirmPasswordInput.value.trim() === "" ||
        !genderSelected ||
        dobInput.value === "" ||
        addressInput.value.trim() === ""
    ) {
        photoError.innerHTML = "All fields must be fulfilled.";
        return false;
    } else {
        addressError.innerHTML = "";
    }

    if (photoInput.files.length === 0) {
        photoError.innerHTML = "Please upload a photo.";
        return false;
    } else {
        photoError.innerHTML = "";
    }

    let valid = true;
    if (!isValidName(fnameInput.value.trim())) {
        fnameError.textContent = "Illegal character(s) in first name!";
        valid = false;
    } else {
        fnameError.textContent = "";
    }

    if (!isValidName(lnameInput.value.trim())) {
        lnameError.textContent = "Illegal character(s) in last name!";
        valid = false;
    } else {
        lnameError.textContent = "";
    }

    const idType = idTypeSelect.value;
    if (idType === "nid") {
        const nid = idInput.value.trim();
        if (nid === "") {
            idError.textContent = "NID number is required.";
            valid = false;
        }
        else if (nid.length !== 10 && nid.length !== 17) {
            idError.textContent = "NID number must be 10 or 17 digits long.";
            valid = false;
        }
        else {
            idError.textContent = "";
        }
    }

    else if (idType === "passport") {
        const passportNumber = idInput.value.trim();
        const expiryValue = passportExpiryInput.value.trim();

        if (passportNumber === "") {
            idError.textContent = "Passport number is required.";
            valid = false;
        } else {
            let isAlphanumeric = true;
            for (let i = 0; i < passportNumber.length; i++) {
                const ch = passportNumber[i];
                const code = ch.charCodeAt(0);
                if (!((code >= 48 && code <= 57) || (code >= 65 && code <= 90))) {
                    isAlphanumeric = false;
                    break;
                }
            }

            if (!isAlphanumeric) {
                idError.textContent = "Passport number must be alphanumeric (Capital Letter & Number).";
                valid = false;
            } else if (passportNumber.length !== 10) {
                idError.textContent = "Passport number must be 10 characters long.";
                valid = false;
            } else {
                idError.textContent = "";
            }
        }

        if (expiryValue === "") {
            passportExpiryError.textContent = "Passport expiry date is required.";
            valid = false;
        } else {
            const expiryDate = new Date(expiryValue);
            const today = new Date();
            today.setHours(0, 0, 0, 0); // to ignore time comparison

            if (expiryDate <= today) {
                passportExpiryError.textContent = "Passport expiry date must be after today's date.";
                valid = false;
            } else {
                passportExpiryError.textContent = "";
            }
        }
    }

    const countryCode = document.getElementById("countryCode").value;
    const phoneNumber = phoneInput.value.trim();
    
    if (countryCode === "") {
        phoneError.textContent = "Please select a country code.";
        valid = false;
    } else if (phoneNumber.length < 6) {
        phoneError.textContent = "Phone number must be exactly 6 characters long.";
        valid = false;
    } else {
        phoneError.textContent = "";
    }

    if (!validateEmail(emailInput.value.trim())) {
        emailError.innerHTML = "Please enter a valid email address.";
        valid = false;
    } else {
        emailError.innerHTML = "";
    }

    if (passwordInput.value.trim().length < 8) {
        passError.innerHTML = "Password must be at least 8 characters.";
        valid = false;
    } else {
        passError.innerHTML = "";
    }

    if (confirmPasswordInput.value.trim() !== passwordInput.value.trim()) {
        confirmPassError.innerHTML = "Passwords do not match.";
        valid = false;
    } else {
        confirmPassError.innerHTML = "";
    }

    const dob = new Date(dobInput.value);
    const today = new Date();
    const age = today.getFullYear() - dob.getFullYear();
    const m = today.getMonth() - dob.getMonth();
    const d = today.getDate() - dob.getDate();

    const isUnder18 = age < 18 || (age === 18 && (m < 0 || (m === 0 && d < 0)));

    if (isUnder18) {
        dobError.textContent = "You must be at least 18 years old.";
        valid = false;
    } else {
        dobError.textContent = "";
    }

    return valid;
}

idTypeSelect.addEventListener("change", handleIDSelection);
form.addEventListener("submit", function (e) {
    if (!validateForm()) {
        e.preventDefault();
    }
});
