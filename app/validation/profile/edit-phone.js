document.addEventListener("DOMContentLoaded", function() {
    const saveButton = document.getElementById('save-btn');
    const cancelButton = document.getElementById('cancel-btn');
    const phoneField = document.getElementById('phone');
    const errorMessage = document.getElementById('errorMSG');
    const currentPhone = document.getElementById('current-phone');

    const demoPhone = "1234567890";

    const loadCurrentPhone = () => {
        const storedPhone = localStorage.getItem('phone'); 
        if (storedPhone) {
            currentPhone.textContent = storedPhone;
        } else {
            currentPhone.textContent = demoPhone;
        }
    };

    loadCurrentPhone();

    saveButton.addEventListener('click', function() {
        const newPhone = phoneField.value.trim();

        if (newPhone === "") {
            errorMessage.textContent = "Phone number cannot be empty!";
            errorMessage.style.color = "#e74c3c";
            errorMessage.style.fontWeight = "bold";
        } else {
            let isValid = true;
            for (let i = 0; i < newPhone.length; i++) {
                const char = newPhone[i];
                if (char < '0' || char > '9') {
                    isValid = false;
                    break;
                }
            }

            if (!isValid) {
                errorMessage.textContent = "Phone number must contain only digits!";
                errorMessage.style.color = "#e74c3c";
                errorMessage.style.fontWeight = "bold";
            } else if (newPhone.length < 6) {
                errorMessage.textContent = "Phone number must be at least 6 characters long!";
                errorMessage.style.color = "#e74c3c";
                errorMessage.style.fontWeight = "bold";
            } else {
                localStorage.setItem('phone', newPhone);
                window.location.href = "../../views/profile/profile.php";
            }
        }
    });

    cancelButton.addEventListener('click', function() {
        window.location.href = "../../views/dashboard/dashboard.php";
    });
});
