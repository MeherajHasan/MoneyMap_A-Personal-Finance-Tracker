// Elements
const searchExpenseInput = document.querySelector('input[name="searchExpense"]');
const searchExpenseBtn = document.querySelector('button[name="searchExpenseBtn"]');
const expenseCategoryList = document.getElementById('expense-category-list');

const searchBudgetInput = document.querySelector('input[name="searchBudget"]');
const searchBudgetBtn = document.querySelector('button[name="searchBudgetBtn"]');
const budgetCategoryList = document.getElementById('budget-category-list');

// Mock Data for john.doe@gmail.com
const expenseCategories = ["Groceries", "Utilities", "Transportation", "Healthcare"];
const budgetCategories = ["Monthly Savings", "Emergency Fund", "Vacation Fund", "Education Savings"];

// Email Validation (Basic, no Regex)
const isValidEmail = (email) => {
    return email.includes('@') && email.includes('.') && email.indexOf('@') < email.lastIndexOf('.');
};

// Clear List Function
const clearList = (listElement) => {
    while (listElement.firstChild) {
        listElement.removeChild(listElement.firstChild);
    }
};

// Generate List Items with Edit and Delete
const generateListItems = (categories, listElement) => {
    categories.forEach(category => {
        const li = document.createElement('li');
        li.classList.add('category-item');

        const nameSpan = document.createElement('span');
        nameSpan.textContent = category;
        nameSpan.classList.add('category-name');

        // Edit and Delete Buttons
        const editBtn = document.createElement('button');
        editBtn.textContent = 'Edit';
        editBtn.classList.add('edit-btn');

        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Delete';
        deleteBtn.classList.add('delete-btn');

        // Save Button (Initially Hidden)
        const saveBtn = document.createElement('button');
        saveBtn.textContent = 'Save';
        saveBtn.classList.add('save-btn');
        saveBtn.style.display = 'none';

        // Event Listeners
        editBtn.addEventListener('click', () => {
            nameSpan.contentEditable = true;
            nameSpan.focus();
            editBtn.style.display = 'none';
            saveBtn.style.display = 'inline-block';
        });

        saveBtn.addEventListener('click', () => {
            nameSpan.contentEditable = false;
            editBtn.style.display = 'inline-block';
            saveBtn.style.display = 'none';
        });

        deleteBtn.addEventListener('click', () => {
            if (confirm(`Are you sure you want to delete "${category}"?`)) {
                li.remove();
            }
        });

        // Append elements to the list item
        li.appendChild(nameSpan);
        li.appendChild(editBtn);
        li.appendChild(saveBtn);
        li.appendChild(deleteBtn);
        listElement.appendChild(li);
    });
};

// Expense Categories Search Event
searchExpenseBtn.addEventListener('click', (e) => {
    e.preventDefault();

    const email = searchExpenseInput.value.trim();
    clearList(expenseCategoryList);

    // Validation
    if (email === "") {
        const errorMsg = document.createElement('p');
        errorMsg.textContent = "⚠️ Email field is required.";
        errorMsg.classList.add('error-msg');
        expenseCategoryList.appendChild(errorMsg);
        return;
    }
    
    if (!isValidEmail(email)) {
        const errorMsg = document.createElement('p');
        errorMsg.textContent = "⚠️ Please enter a valid email address.";
        errorMsg.classList.add('error-msg');
        expenseCategoryList.appendChild(errorMsg);
        return;
    }

    // Search Logic (Mocked Data for 'john.doe@gmail.com')
    if (email === "john.doe@gmail.com") {
        generateListItems(expenseCategories, expenseCategoryList);
    } else {
        const errorMsg = document.createElement('p');
        errorMsg.textContent = "⚠️ No expense categories found for this user.";
        errorMsg.classList.add('error-msg');
        expenseCategoryList.appendChild(errorMsg);
    }
});

// Budget Categories Search Event
searchBudgetBtn.addEventListener('click', (e) => {
    e.preventDefault();
    
    const email = searchBudgetInput.value.trim();
    clearList(budgetCategoryList);

    // Validation
    if (email === "") {
        const errorMsg = document.createElement('p');
        errorMsg.textContent = "⚠️ Email field is required.";
        errorMsg.classList.add('error-msg');
        budgetCategoryList.appendChild(errorMsg);
        return;
    }
    
    if (!isValidEmail(email)) {
        const errorMsg = document.createElement('p');
        errorMsg.textContent = "⚠️ Please enter a valid email address.";
        errorMsg.classList.add('error-msg');
        budgetCategoryList.appendChild(errorMsg);
        return;
    }

    // Search Logic (Mocked Data for 'john.doe@gmail.com')
    if (email === "john.doe@gmail.com") {
        generateListItems(budgetCategories, budgetCategoryList);
    } else {
        const errorMsg = document.createElement('p');
        errorMsg.textContent = "⚠️ No budget categories found for this user.";
        errorMsg.classList.add('error-msg');
        budgetCategoryList.appendChild(errorMsg);
    }
});
