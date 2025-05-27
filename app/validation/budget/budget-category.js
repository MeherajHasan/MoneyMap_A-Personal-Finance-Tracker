function isValidCategoryName(name) {
    for (let i = 0; i < name.length; i++) {
        const char = name[i];
        if (!(
            (char >= 'a' && char <= 'z') ||
            (char >= 'A' && char <= 'Z') ||
            (char >= '0' && char <= '9') ||
            char === ' ' || char === '.' || char === ',' || char === '-'
        )) {
            return false;
        }
    }
    return true;
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.add-category');
    const input = document.getElementById('newCategory');
    const errorText = document.getElementById('emptyError');

    if (form && input && errorText) {
        form.addEventListener('submit', function (e) {
            const name = input.value.trim();

            if (name === '') {
                e.preventDefault();
                errorText.textContent = 'Category name is required.';
                input.focus();
            } else if (!isValidCategoryName(name)) {
                e.preventDefault();
                errorText.textContent = 'Category name contains invalid characters.';
                input.focus();
            } else {
                errorText.textContent = '';
            }
        });
    }
});
