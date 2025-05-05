document.addEventListener('DOMContentLoaded', function () {
    const savingsGoals = [
        { name: 'Vacation', targetAmount: 5000, savedAmount: 1200, targetDate: 'Dec 2025' },
        { name: 'Emergency', targetAmount: 10000, savedAmount: 3000, targetDate: 'Jan 2026' },
        { name: 'Buy A Car', targetAmount: 2000, savedAmount: 800, targetDate: 'Mar 2025' }
    ];

    const tableBody = document.querySelector('.savings-table tbody');
    const totalSavedElement = document.getElementById('total-saved');
    const totalGoalsElement = document.getElementById('total-goals');
    const goalsAchievedElement = document.getElementById('goals-achieved');

    function renderSavingsGoals() {
        tableBody.innerHTML = '';

        let totalSaved = 0;
        let totalGoals = savingsGoals.length;
        let goalsAchieved = 0;

        savingsGoals.forEach((goal) => {
            const row = document.createElement('tr');
            const progress = (goal.savedAmount / goal.targetAmount) * 100;
            const progressBar = `<progress value="${progress}" max="100"></progress>`;

            if (goal.savedAmount >= goal.targetAmount) {
                goalsAchieved++;
            }

            totalSaved += goal.savedAmount;

            row.innerHTML = `
                <td>${goal.name}</td>
                <td>$${goal.targetAmount.toFixed(2)}</td>
                <td>$${goal.savedAmount.toFixed(2)}</td>
                <td>${progressBar}</td>
                <td>${goal.targetDate}</td>
                <td>
                    <div class="actions">
                        <a href="edit-savings.html" class="btn btn-secondary">Edit</a>
                        <a href="#" class="btn btn-danger" onclick="deleteGoal('${goal.name}')">Delete</a>
                        <a href="add-money.html" class="btn btn-success">Add Money</a>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        totalSavedElement.textContent = `$${totalSaved.toFixed(2)}`;
        totalGoalsElement.textContent = totalGoals;
        goalsAchievedElement.textContent = goalsAchieved;
    }

    window.deleteGoal = function (goalName) {
        const confirmDelete = confirm(`Are you sure you want to delete the "${goalName}" savings goal?`);
        if (confirmDelete) {
            const goalIndex = savingsGoals.findIndex(goal => goal.name === goalName);
            if (goalIndex !== -1) {
                savingsGoals.splice(goalIndex, 1);
                renderSavingsGoals();
            }
        }
    };

    renderSavingsGoals();
});