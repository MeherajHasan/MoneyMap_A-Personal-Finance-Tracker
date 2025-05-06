document.addEventListener('DOMContentLoaded', function () {
    const totalSavedElement = document.getElementById('totalSaved');
    const totalGoalsElement = document.getElementById('totalGoals');
    const goalsAchievedElement = document.getElementById('goalsAchieved');
    const averageSavingsElement = document.getElementById('averageSavings');
    const goalProgressList = document.getElementById('goalProgressList');
    const transactionsBody = document.getElementById('transactionsBody');
    const noTransactionsElement = document.getElementById('noTransactions');

    const savingsGoals = [
        { name: 'Vacation', targetAmount: 5000, savedAmount: 1500 },
        { name: 'Emergency Fund', targetAmount: 10000, savedAmount: 6000 },
        { name: 'New Laptop', targetAmount: 1500, savedAmount: 1500 },
    ];

    const savingsTransactions = [
        { date: '2025-05-05', goal: 'Vacation', type: 'Deposit', amount: 200, notes: 'Monthly contribution' },
        { date: '2025-05-01', goal: 'Emergency Fund', type: 'Deposit', amount: 1000, notes: 'Initial deposit' },
        { date: '2025-04-20', goal: 'Vacation', type: 'Deposit', amount: 100, notes: 'Birthday money' },
        { date: '2025-04-15', goal: 'New Laptop', type: 'Deposit', amount: 500, notes: 'Saving up' },
        { date: '2025-04-01', goal: 'Emergency Fund', type: 'Deposit', amount: 500, notes: 'Regular save' },
        { date: '2025-03-25', goal: 'Vacation', type: 'Deposit', amount: 200, notes: 'Bonus' },
        { date: '2025-03-10', goal: 'New Laptop', type: 'Deposit', amount: 1000, notes: 'Part of salary' },
    ];

    function renderReport() {
        let totalSaved = 0;
        let goalsAchieved = 0;

        savingsGoals.forEach(goal => {
            totalSaved += goal.savedAmount;
            if (goal.savedAmount >= goal.targetAmount) {
                goalsAchieved++;
            }
        });

        totalSavedElement.textContent = `$${totalSaved.toFixed(2)}`;
        totalGoalsElement.textContent = savingsGoals.length;
        goalsAchievedElement.textContent = goalsAchieved;

        const averageSavings = savingsGoals.length > 0 ? totalSaved / savingsGoals.length : 0;
        averageSavingsElement.textContent = `$${averageSavings.toFixed(2)}`;

        renderGoalProgress();
        renderTransactions();
    }

    function renderGoalProgress() {
        goalProgressList.innerHTML = '';
        savingsGoals.forEach(goal => {
            const progress = goal.targetAmount > 0 ? (goal.savedAmount / goal.targetAmount) * 100 : 0;
            const listItem = document.createElement('li');
            listItem.innerHTML = `
                <span>${goal.name}</span>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: ${progress}%;"></div>
                    <span>${progress.toFixed(0)}%</span>
                </div>
            `;
            goalProgressList.appendChild(listItem);
        });
    }

    function renderTransactions() {
        transactionsBody.innerHTML = '';
        if (savingsTransactions.length === 0) {
            noTransactionsElement.style.display = 'block';
            return;
        }
        noTransactionsElement.style.display = 'none';

        savingsTransactions.sort((a, b) => new Date(b.date) - new Date(a.date)); // Sort by date descending

        savingsTransactions.forEach(transaction => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${transaction.date}</td>
                <td>${transaction.goal}</td>
                <td>${transaction.type}</td>
                <td>${transaction.type === 'Deposit' ? '+' : '-'}$${transaction.amount.toFixed(2)}</td>
                <td>${transaction.notes || ''}</td>
            `;
            transactionsBody.appendChild(row);
        });
    }

    renderReport();
});