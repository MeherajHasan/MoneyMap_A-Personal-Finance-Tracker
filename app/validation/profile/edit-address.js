document.addEventListener("DOMContentLoaded", function() {
    const saveButton = document.getElementById('save-btn');
    const cancelButton = document.getElementById('cancel-btn');
    const addressField = document.getElementById('address');
    const errorMessage = document.getElementById('errorMSG');
    const currentAddress = document.getElementById('current-address');

    const demoAddress = "1234, MoneyMap Street, City, Country";

    const loadCurrentAddress = () => {
        const storedAddress = localStorage.getItem('address'); 
        if (storedAddress) {
            currentAddress.textContent = storedAddress;
        } else {
            currentAddress.textContent = demoAddress;
        }
    };

    loadCurrentAddress();

    saveButton.addEventListener('click', function() {
        if (addressField.value.trim() === "") {
            errorMessage.textContent = "Address cannot be empty!";
            errorMessage.style.color = "#e74c3c";
            errorMessage.style.fontWeight = "bold";
        } else {
            localStorage.setItem('address', addressField.value.trim());

            const confirmation = window.confirm("Address updated successfully! Do you want to go back to the profile?");
            if (confirmation) {
                window.location.href = "../../views/profile/profile.php";
            }
        }
    });

    cancelButton.addEventListener('click', function() {
        window.location.href = "../../views/dashboard/dashboard.php";
    });
});
