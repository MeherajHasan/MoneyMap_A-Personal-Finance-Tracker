// Elements
const searchInput = document.querySelector('input[name="searchEmail"]');
const searchBtn = document.querySelector('button[name="search"]');
const editForm = document.querySelector('form button[name="update"]')?.form;

// Utility: Show alert after update success (via sessionStorage flag)
document.addEventListener('DOMContentLoaded', () => {
    if (sessionStorage.getItem('userUpdated') === 'true') {
        sessionStorage.removeItem('userUpdated');
        alert('User information updated successfully!');
    }
});

// When the update form is submitted, set the flag before submission
if (editForm) {
    editForm.addEventListener('submit', () => {
        sessionStorage.setItem('userUpdated', 'true');
    });
}

// Email Validation (basic, no regex)
const isValidEmail = (email) => {
    return email.includes('@') && email.includes('.') && email.indexOf('@') < email.lastIndexOf('.');
};

// Optional: You can add client-side validation for the search form if you want
searchBtn.addEventListener('click', (e) => {
    const email = searchInput.value.trim();

    // Clear previous errors if any (for example, if you want to show them on page)
    // For simplicity, alert for invalid search email:
    if (email === '') {
        e.preventDefault();
        alert('⚠️ Please enter an email to search.');
        searchInput.focus();
        return;
    }
    if (!isValidEmail(email)) {
        e.preventDefault();
        alert('⚠️ Please enter a valid email address.');
        searchInput.focus();
        return;
    }
});
