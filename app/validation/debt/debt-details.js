document.addEventListener('DOMContentLoaded', function() {
    const debtSelect = document.getElementById('selectDebt');
    const debtInfoSection = document.getElementById('debtInformation');
    const noDebtSelectedMessage = document.getElementById('noDebtSelected');

    const debts = [
        {
            id: 1,
            debtName: 'Car Loan',
            payeeName: 'Bank ABC',
            debtDate: '2023-05-01',
            maxPaymentDate: '2025-05-01',
            principalAmount: 5000,
            interestRate: 5,
            minimumPayment: 200,
            notes: 'Car loan with a 5% interest rate.',
            paidAmount: 1000,
            remainingPayableAmount: 4000,
            estimatedTotalWithInterest: 4200
        },
        {
            id: 2,
            debtName: 'Home Loan',
            payeeName: 'Home Bank',
            debtDate: '2022-06-15',
            maxPaymentDate: '2032-06-15',
            principalAmount: 15000,
            interestRate: 3.5,
            minimumPayment: 500,
            notes: 'Home loan with a 3.5% interest rate.',
            paidAmount: 5000,
            remainingPayableAmount: 10000,
            estimatedTotalWithInterest: 10350
        }
    ];

    function populateDebtSelect() {
        debts.forEach(debt => {
            const option = document.createElement('option');
            option.value = debt.id;
            option.textContent = debt.debtName;
            debtSelect.appendChild(option);
        });
    }

    // Show debt details when a debt is selected
    function displayDebtDetails(debtId) {
        const debt = debts.find(d => d.id === parseInt(debtId));

        if (debt) {
            document.getElementById('debtNameDisplay').textContent = debt.debtName;
            document.getElementById('payeeNameDisplay').textContent = debt.payeeName;
            document.getElementById('debtDateDisplay').textContent = debt.debtDate;
            document.getElementById('maxPaymentDateDisplay').textContent = debt.maxPaymentDate || '-';
            document.getElementById('principalAmountDisplay').textContent = '$' + debt.principalAmount.toFixed(2);
            document.getElementById('interestRateDisplay').textContent = debt.interestRate + '%';
            document.getElementById('minimumPaymentDisplay').textContent = '$' + debt.minimumPayment.toFixed(2);
            document.getElementById('notesDisplay').textContent = debt.notes || '-';
            document.getElementById('paidAmountDisplay').textContent = '$' + debt.paidAmount.toFixed(2);
            document.getElementById('payableAmountDisplay').textContent = '$' + debt.remainingPayableAmount.toFixed(2);
            document.getElementById('totalWithInterestDisplay').textContent = '$' + debt.estimatedTotalWithInterest.toFixed(2);

            debtInfoSection.style.display = 'block';
            noDebtSelectedMessage.style.display = 'none';
        } else {
            debtInfoSection.style.display = 'none';
            noDebtSelectedMessage.style.display = 'block';
        }
    }

    debtSelect.addEventListener('change', function() {
        const selectedDebtId = debtSelect.value;
        displayDebtDetails(selectedDebtId);
    });

    populateDebtSelect();
});
