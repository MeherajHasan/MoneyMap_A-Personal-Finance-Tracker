document.addEventListener('DOMContentLoaded', () => {
    const categoryTableBody = document.getElementById('categoryTableBody');

    categoryTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-edit')) {
            const oldCategoryName = e.target.dataset.category;
            const newCategoryName = prompt(`Edit category "${oldCategoryName}":`, oldCategoryName);

            if (newCategoryName === null) return; // Cancelled

            const trimmedName = newCategoryName.trim();

            if (trimmedName === "") {
                alert("Category name cannot be empty.");
                return;
            }

            if (!isValidCategoryName(trimmedName)) {
                alert("Category name contains invalid characters.\nAllowed: A-Z, a-z, 0-9, space, '.', ',', '-'");
                return;
            }

            if (trimmedName === oldCategoryName) {
                alert("No changes were made.");
                return;
            }

            // Create form and submit
            const form = document.createElement('form');
            form.method = 'post';
            form.action = window.location.href;

            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'edit';

            const oldCategoryInput = document.createElement('input');
            oldCategoryInput.type = 'hidden';
            oldCategoryInput.name = 'oldCategory';
            oldCategoryInput.value = oldCategoryName;

            const newCategoryInput = document.createElement('input');
            newCategoryInput.type = 'hidden';
            newCategoryInput.name = 'newCategory';
            newCategoryInput.value = trimmedName;

            form.appendChild(actionInput);
            form.appendChild(oldCategoryInput);
            form.appendChild(newCategoryInput);

            document.body.appendChild(form);
            form.submit();
        }
    });

    function isValidCategoryName(str) {
        for (let i = 0; i < str.length; i++) {
            const c = str[i];
            if (!(
                (c >= 'a' && c <= 'z') ||
                (c >= 'A' && c <= 'Z') ||
                (c >= '0' && c <= '9') ||
                c === ' ' || c === '.' || c === ',' || c === '-'
            )) {
                return false;
            }
        }
        return true;
    }
});
