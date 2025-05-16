// Query Selectors
const fullNameField = document.getElementById('full-name');
const idTypeField = document.getElementById('id-type');
const nidPassportField = document.getElementById('nid-passport');
const genderField = document.getElementById('gender');
const emailField = document.getElementById('email');
const phoneField = document.getElementById('phone');
const addressField = document.getElementById('address');
const linkedAccField = document.getElementById('linked-acc');
const userPhoto = document.getElementById('user-photo');

const uploadBtn = document.getElementById('upload');
const deleteBtn = document.getElementById('delete-acc');

// Edit Buttons
const editNameBtn = document.getElementById('edit-Name');
const identityEditBtn = document.getElementById('identity-edit');
const genderEditBtn = document.getElementById('gender-edit');
const mailEditBtn = document.getElementById('mail-edit');
const phoneEditBtn = document.getElementById('phone-edit');
const addressEditBtn = document.getElementById('address-edit');
const passwordEditBtn = document.getElementById('password-edit');
const linkedAccEditBtn = document.getElementById('linked-acc-edit');

const userData = {
    fullName: "John Doe",
    idType: "Passport",
    nidPassportNumber: "AB1234567",
    gender: "Male",
    email: "johndoe@example.com",
    phone: "+880123456789",
    address: "123, Example Street, Dhaka, Bangladesh",
    linkedAccounts: "Bank A, Bank B",
    photoUrl: "../../../public/assets/check.png"
};

const loadProfileData = () => {
    fullNameField.innerText = userData.fullName;
    idTypeField.innerText = userData.idType;
    nidPassportField.innerText = userData.nidPassportNumber;
    genderField.innerText = userData.gender;
    emailField.innerText = userData.email;
    phoneField.innerText = userData.phone;
    addressField.innerText = userData.address;
    linkedAccField.innerText = userData.linkedAccounts;

    if (userData.photoUrl) {
        userPhoto.src = userData.photoUrl;
    } else {
        userPhoto.src = "../../../public/assets/profile.png";
    }
};

const fileInput = document.createElement('input');
fileInput.type = 'file';
fileInput.accept = 'image/*';
fileInput.style.display = 'none';
document.body.appendChild(fileInput);

uploadBtn.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            userPhoto.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

editNameBtn.addEventListener('click', () => {
    window.location.href = 'edit-name.php';
});

identityEditBtn.addEventListener('click', () => {
    window.location.href = 'edit-identity.php';
});

mailEditBtn.addEventListener('click', () => {
    window.location.href = 'edit-mail.php';
});

phoneEditBtn.addEventListener('click', () => {
    window.location.href = 'edit-phone.php';
});

addressEditBtn.addEventListener('click', () => {
    window.location.href = 'edit-address.php';
});

passwordEditBtn.addEventListener('click', () => {
    window.location.href = 'edit-pass.php';
});

linkedAccEditBtn.addEventListener('click', () => {
    alert("This feature is under development process.");
});

deleteBtn.addEventListener('click', () => {
    if (confirm("Are you sure you want to delete your account?")) {
        window.location.href = 'delete-acc.php';
    }
});

window.addEventListener('DOMContentLoaded', loadProfileData);
