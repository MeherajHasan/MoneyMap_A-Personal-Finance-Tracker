const addCategoryBtn = document.getElementById('addCategoryBtn');
const newCategoryInput = document.getElementById('newCategory');
const categoryTableBody = document.getElementById('categoryTableBody');
const emptyError = document.getElementById('emptyError');

const form = document.querySelector('form.add-category');

form.addEventListener('submit', (e) => {
    clearError();

    const newCategoryName = newCategoryInput.value.trim();
    const validation = isValidCategoryNameManual(newCategoryName);

    if (!validation.valid) {
        e.preventDefault(); 
        showError(validation.message);
    }
});

function clearError() {
    emptyError.textContent = '';
    emptyError.style.color = '';
}

function showError(message) {
    emptyError.textContent = message;
    emptyError.style.color = 'red';
}

function isValidCategoryNameManual(name) {
    if (name.trim() === '') return { valid: false, message: 'Category name cannot be empty.' };

    for (let i = 0; i < name.length; i++) {
        const char = name[i];
        if (!(
            (char >= 'A' && char <= 'Z') ||
            (char >= 'a' && char <= 'z') ||
            char === ' '
        )) {
            return { valid: false, message: 'Only letters and spaces are allowed in the category name.' };
        }
    }

    return { valid: true };
}

function addNewCategoryToTable(categoryName) {
    const newRow = categoryTableBody.insertRow();
    const nameCell = newRow.insertCell();
    const actionCell = newRow.insertCell();

    nameCell.textContent = categoryName;
    actionCell.innerHTML = `
        <button class="btn btn-edit">Edit</button>
        <button class="btn btn-delete">Delete</button>
    `;

    newCategoryInput.value = '';
    clearError();
}

addCategoryBtn.addEventListener('click', () => {
    const newCategoryName = newCategoryInput.value.trim();
    const validation = isValidCategoryNameManual(newCategoryName);

    if (!validation.valid) {
        showError(validation.message);
        return;
    }

    const existingCategories = Array.from(categoryTableBody.querySelectorAll('td:first-child'))
        .map(td => td.textContent.toLowerCase());

    if (existingCategories.includes(newCategoryName.toLowerCase())) {
        showError('Category already exists!');
    } else {
        addNewCategoryToTable(newCategoryName);
        console.log(`Added new category: ${newCategoryName}`);
    }
});

categoryTableBody.addEventListener('click', (event) => {
    const target = event.target;
    const row = target.closest('tr');
    if (!row) return;
    const categoryNameCell = row.querySelector('td:first-child');
    const currentCategoryName = categoryNameCell.textContent;

    if (target.classList.contains('btn-edit')) {
        const newCategoryName = prompt('Edit category name:', currentCategoryName);

        if (newCategoryName !== null) {
            const trimmedName = newCategoryName.trim();
            const validation = isValidCategoryNameManual(trimmedName);

            if (!validation.valid) {
                alert(validation.message);
                return;
            }

            const existingCategories = Array.from(categoryTableBody.querySelectorAll('td:first-child'))
                .map(td => td.textContent.toLowerCase());

            if (!existingCategories.includes(trimmedName.toLowerCase()) || trimmedName.toLowerCase() === currentCategoryName.toLowerCase()) {
                categoryNameCell.textContent = trimmedName;
                clearError();
                console.log(`Updated category from "${currentCategoryName}" to "${trimmedName}"`);
            } else {
                alert('Category already exists!');
            }
        }
    }

    if (target.classList.contains('btn-delete')) {
        const confirmed = confirm(`Are you sure you want to delete the category "${currentCategoryName}"?`);
        if (confirmed) {
            row.remove();
            clearError();
            console.log(`Deleted category: ${currentCategoryName}`);
        }
    }
});
