document.addEventListener('DOMContentLoaded', () => {
    const categoryTableBody = document.getElementById('categoryTableBody');

    categoryTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-edit')) {
            const oldCategoryName = e.target.dataset.category;
            const newCategoryName = prompt(`Edit category "${oldCategoryName}":`, oldCategoryName);

            if (newCategoryName !== null && newCategoryName.trim() !== "") {
                // Create a form and submit it to update the category
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
                newCategoryInput.value = newCategoryName.trim();

                form.appendChild(actionInput);
                form.appendChild(oldCategoryInput);
                form.appendChild(newCategoryInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    });
});