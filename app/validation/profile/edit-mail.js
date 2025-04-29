document.addEventListener("DOMContentLoaded", function() {
    const saveButton = document.getElementById('save-btn');
    const cancelButton = document.getElementById('cancel-btn');
    const emailField = document.getElementById('email');
    const errorMessage = document.getElementById('errorMSG');
    const currentEmail = document.getElementById('current-email');

    const demoEmail = "demo@moneyMap.com";

    const loadCurrentEmail = () => {
        const storedEmail = localStorage.getItem('email'); 
        if (storedEmail) {
            currentEmail.textContent = storedEmail;
        } else {
            currentEmail.textContent = demoEmail;
        }
    };

    loadCurrentEmail();

    const isValidEmail = (email) => {
        const parts = email.split('@');
        if (parts.length !== 2) return false;

        const domainParts = parts[1].split('.');
        if (domainParts.length < 2) return false;

        return true;
    };

    saveButton.addEventListener('click', function() {
        const email = emailField.value.trim();
        
        if (email === "") {
            errorMessage.textContent = "Email cannot be empty!";
            errorMessage.style.color = "#e74c3c";
            errorMessage.style.fontWeight = "bold";
        } else if (!isValidEmail(email)) {
            errorMessage.textContent = "Invalid email format!";
            errorMessage.style.color = "#e74c3c";
            errorMessage.style.fontWeight = "bold";
        } else {
            localStorage.setItem('email', email);

            const confirmation = window.confirm("Email updated successfully! Do you want to go back to the profile?");
            if (confirmation) {
                window.location.href = "profile.html";
            }
        }
    });

    cancelButton.addEventListener('click', function() {
        window.location.href = "profile.html";
    });
});
