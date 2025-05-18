document.getElementById('save-profile').addEventListener('click', function () {
    // Validate inputs (you can add more validation here if needed)
    const form = document.getElementById('admin-profile-form');
    const inputs = form.querySelectorAll('input');

    for (const input of inputs) {
        if (input.value.trim() === '') {
            alert(`${input.name} cannot be empty!`);
            input.focus();
            return;
        }
    }

    // Submit the form
    form.submit();
});
