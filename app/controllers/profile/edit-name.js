document.addEventListener("DOMContentLoaded", function() {
    const saveButton = document.getElementById('save-btn');
    const cancelButton = document.getElementById('cancel-btn');
    const nameField = document.getElementById('name');
    const errorMessage = document.getElementById('errorMSG');
    const currentName = document.getElementById('current-name');

    const demoName = "John Doe";

    const loadCurrentName = () => {
        const storedName = localStorage.getItem('name');
        if (storedName) {
            currentName.textContent = storedName;
        } else {
            currentName.textContent = demoName;
        }
    };

    loadCurrentName();

    saveButton.addEventListener('click', function() {
        const nameValue = nameField.value.trim();
        if (nameValue === "") {
            errorMessage.textContent = "Name cannot be empty!";
            errorMessage.style.color = "#e74c3c";
            errorMessage.style.fontWeight = "bold";
        } else {
            const parts = nameValue.split(" ");
            if (parts.length < 2) {
                errorMessage.textContent = "Name must have two parts!";
                errorMessage.style.color = "#e74c3c";
                errorMessage.style.fontWeight = "bold";
            } else {
                let isValid = true;
                for (let i = 0; i < nameValue.length; i++) {
                    const char = nameValue.charAt(i);
                    if (!( (char >= 'A' && char <= 'Z') || (char >= 'a' && char <= 'z') || char === ' ' || char === '.' || char === '-' )) {
                        isValid = false;
                        break;
                    }
                }

                if (isValid) {
                    localStorage.setItem('name', nameValue);
                    window.location.href = "profile.html";
                } else {
                    errorMessage.textContent = "Invalid character in name!";
                    errorMessage.style.color = "#red";
                    errorMessage.style.fontWeight = "bold";
                }
            }
        }
    });

    cancelButton.addEventListener('click', function() {
        window.location.href = "profile.html";
    });
});
