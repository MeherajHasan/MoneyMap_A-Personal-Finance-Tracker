document.addEventListener("DOMContentLoaded", function() {
    const saveButton = document.getElementById('save-btn');
    const cancelButton = document.getElementById('cancel-btn');
    const currentPasswordField = document.getElementById('current-password');
    const newPasswordField = document.getElementById('new-password');
    const confirmPasswordField = document.getElementById('confirm-password');
    const errorMessage = document.getElementById('errorMSG');

    const demoPassword = "11111111";  // Default password if no stored password is available
    const storedPassword = localStorage.getItem('password') || demoPassword; // Fallback to demoPassword if no password is stored

    saveButton.addEventListener('click', function() {
        const currentPassword = currentPasswordField.value.trim();
        const newPassword = newPasswordField.value.trim();
        const confirmPassword = confirmPasswordField.value.trim();

        if (currentPassword === "" || newPassword === "" || confirmPassword === "") {
            errorMessage.textContent = "All fields are required!";
            errorMessage.style.color = "#e74c3c";
            errorMessage.style.fontWeight = "bold";
        } else if (currentPassword !== storedPassword && currentPassword !== demoPassword) {
            errorMessage.textContent = "Current password is incorrect!";
            errorMessage.style.color = "#e74c3c";
            errorMessage.style.fontWeight = "bold";
        } else if (newPassword === currentPassword) {
            errorMessage.textContent = "New password cannot be the same as the current password!";
            errorMessage.style.color = "#e74c3c";
            errorMessage.style.fontWeight = "bold";
        } else if (newPassword.length < 8 || confirmPassword.length < 8) {
            errorMessage.textContent = "Password must be at least 8 characters long!";
            errorMessage.style.color = "#e74c3c";
            errorMessage.style.fontWeight = "bold";
        } else if (newPassword !== confirmPassword) {
            errorMessage.textContent = "New passwords do not match!";
            errorMessage.style.color = "#e74c3c";
            errorMessage.style.fontWeight = "bold";
        } else {
            localStorage.setItem('password', newPassword);  // Save the new password
            window.location.href = "profile.html";
        }
    });

    cancelButton.addEventListener('click', function() {
        window.location.href = "profile.html";
    });
});
