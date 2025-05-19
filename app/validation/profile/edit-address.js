document.getElementById('save-btn').addEventListener('click', function () {
    const addressField = document.getElementById('address');
    const errorMSG = document.getElementById('errorMSG');
    const form = document.getElementById('edit-address');
    const address = addressField.value.trim();

    errorMSG.textContent = '';

    if (address === '') {
        errorMSG.textContent = "Address cannot be empty.";
        return;
    }

    for (let i = 0; i < address.length; i++) {
        const ch = address[i];
        if (!(
            (ch >= 'a' && ch <= 'z') ||
            (ch >= 'A' && ch <= 'Z') ||
            (ch >= '0' && ch <= '9') ||
            ch === ' ' || ch === ',' || ch === '.' || ch === '-' || ch === '/' ||
            ch === '(' || ch === ')' || ch === '#'
        )) {
            errorMSG.textContent = "Address contains invalid characters.";
            return;
        }
    }

    form.submit();
});

document.getElementById('cancel-btn').addEventListener('click', function () {
    window.location.href = 'profile.php';
});
