document.addEventListener('DOMContentLoaded', function () {
    const debtList = document.getElementById('debtList');
    const totalDebtElement = document.getElementById('totalDebt');
    const totalMinimumPaymentElement = document.getElementById('totalMinimumPayment');
    const totalInterestRateElement = document.getElementById('totalInterestRate');
    const noDebtsElement = document.getElementById('noDebts');

    const debtsData = [
        {
            id: 1,
            name: 'Credit Card',
            principal: 1200.00,
            minimumPayment: 50.00,
            interestRate: 18.99,
        },
        {
            id: 2,
            name: 'Student Loan',
            principal: 15500.00,
            minimumPayment: 150.00,
            interestRate: 5.50,
        },
    ];

    function renderDebtDashboard(debts) {
        let totalDebt = 0;
        let totalMinimumPayment = 0;
        let weightedInterestSum = 0;
        let totalPrincipal = 0;

        debtList.innerHTML = ''; 

        if (debts.length === 0) {
            noDebtsElement.style.display = 'block';
        } else {
            noDebtsElement.style.display = 'none';
            debts.forEach(debt => {
                totalDebt += debt.principal;
                totalMinimumPayment += debt.minimumPayment;
                weightedInterestSum += (debt.principal * debt.interestRate);
                totalPrincipal += debt.principal;

                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    <div class="debt-info">
                        <span class="debt-name">${debt.name}</span>
                        <span class="debt-amount">$${debt.principal.toFixed(2)}</span>
                    </div>
                    <div class="debt-actions">
                        <a href="edit-debt.php?id=${debt.id}" class="btn-edit">Edit</a>
                        <a href="debt-details.php?id=${debt.id}" class="btn-details">Details</a>
                        <a href="debt-pay.php?id=${debt.id}" class="btn-pay">Pay</a>
                    </div>
                `;
                debtList.appendChild(listItem);
            });

            const averageInterestRate = totalPrincipal > 0 ? (weightedInterestSum / totalPrincipal) : 0;
            totalDebtElement.textContent = `$${totalDebt.toFixed(2)}`;
            totalMinimumPaymentElement.textContent = `$${totalMinimumPayment.toFixed(2)}`;
            totalInterestRateElement.textContent = debts.length > 0 ? `${averageInterestRate.toFixed(2)}%` : '-';
        }
    }

    renderDebtDashboard(debtsData);
});