document.addEventListener('DOMContentLoaded', () => {
    const reportTypeSelect = document.getElementById('reportType');
    const sortBySelect = document.getElementById('sortBy');
    const sortOrderSelect = document.getElementById('sortOrder');
    const generateReportBtn = document.getElementById('generateReportBtn');
    const reportOutputDiv = document.getElementById('reportOutput');
    const noReportGenerated = document.getElementById('noReportGenerated');

    const debtsData = [
        {
            id: 1,
            name: 'Credit Card A',
            principal: 1200.00,
            minimumPayment: 50.00,
            interestRate: 18.99,
            debtDate: '2024-08-15',
            payeeName: 'Visa',
            maxPaymentDate: '2026-12-31',
            notes: 'Balance transfer with intro APR.',
            paidAmount: 300.00
        },
        {
            id: 2,
            name: 'Student Loan B',
            principal: 15500.00,
            minimumPayment: 150.00,
            interestRate: 5.50,
            debtDate: '2023-05-01',
            payeeName: 'EdFinancial',
            maxPaymentDate: '2033-05-01',
            notes: 'Federal direct loan.',
            paidAmount: 2500.00
        },
        {
            id: 3,
            name: 'Car Loan C',
            principal: 8000.00,
            minimumPayment: 200.00,
            interestRate: 7.25,
            debtDate: '2024-01-20',
            payeeName: 'Local Auto Finance',
            maxPaymentDate: '2029-01-20',
            notes: 'Used car loan.',
            paidAmount: 1200.00
        },
    ];

    function generateDebtSummary(debts) {
        if (debts.length === 0) {
            return '<p>No debts recorded.</p>';
        }

        let totalPrincipal = 0;
        let totalMinimumPayment = 0;
        let weightedInterestSum = 0;
        let totalPaidAmount = 0;

        debts.forEach(debt => {
            totalPrincipal += debt.principal;
            totalMinimumPayment += debt.minimumPayment;
            weightedInterestSum += (debt.principal * debt.interestRate);
            totalPaidAmount += debt.paidAmount || 0;
        });

        const averageInterestRate = totalPrincipal > 0 ? (weightedInterestSum / totalPrincipal) : 0;
        const totalPayableAmount = totalPrincipal - totalPaidAmount;

        return `
            <h3>Debt Summary</h3>
            <p><strong>Total Principal:</strong> $${totalPrincipal.toFixed(2)}</p>
            <p><strong>Total Paid Amount:</strong> $${totalPaidAmount.toFixed(2)}</p>
            <p><strong>Total Payable Amount:</strong> $${totalPayableAmount.toFixed(2)}</p>
            <p><strong>Total Minimum Payment:</strong> $${totalMinimumPayment.toFixed(2)}</p>
            <p><strong>Average Interest Rate:</strong> ${averageInterestRate.toFixed(2)}%</p>
            <p><strong>Number of Debts:</strong> ${debts.length}</p>
        `;
    }

    function generateDetailedDebtList(debts) {
        if (debts.length === 0) {
            return '<p>No debts recorded.</p>';
        }

        let tableHTML = `
            <h3>Detailed Debt List</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Payee</th>
                        <th>Principal</th>
                        <th>Interest Rate</th>
                        <th>Minimum Payment</th>
                        <th>Debt Date</th>
                        <th>Paid Amount</th>
                        <th>Payable Amount</th>
                    </tr>
                </thead>
                <tbody>
        `;

        debts.forEach(debt => {
            const payableAmount = debt.principal - (debt.paidAmount || 0);
            tableHTML += `
                <tr>
                    <td>${debt.name}</td>
                    <td>${debt.payeeName}</td>
                    <td>$${debt.principal.toFixed(2)}</td>
                    <td>${debt.interestRate.toFixed(2)}%</td>
                    <td>$${debt.minimumPayment.toFixed(2)}</td>
                    <td>${debt.debtDate}</td>
                    <td>$${(debt.paidAmount || 0).toFixed(2)}</td>
                    <td>$${payableAmount.toFixed(2)}</td>
                </tr>
            `;
        });

        tableHTML += `
                </tbody>
            </table>
        `;

        return tableHTML;
    }

    function generatePaymentSchedules(debts) {
        // simple way 
        if (debts.length === 0) {
            return '<p>No debts recorded for payment schedules.</p>';
        }

        let listHTML = `
            <h3>Payment Schedules (Simplified)</h3>
            <ul>
        `;

        debts.forEach(debt => {
            const payableAmount = debt.principal - (debt.paidAmount || 0);
            listHTML += `<li>${debt.name} (Principal: $${debt.principal.toFixed(2)}, Min. Payment: $${debt.minimumPayment.toFixed(2)}, Remaining: $${payableAmount.toFixed(2)})</li>`;
        });

        listHTML += `
            </ul>
            <p><strong>Note:</strong> Detailed payment schedules would require more complex calculations based on interest accrual and payment history.</p>
        `;

        return listHTML;
    }

    function sortDebts(debts, sortBy, sortOrder) {
        return [...debts].sort((a, b) => {
            let comparison = 0;
            if (sortBy === 'name') {
                comparison = a.name.localeCompare(b.name);
            } else if (sortBy === 'principal') {
                comparison = a.principal - b.principal;
            } else if (sortBy === 'interestRate') {
                comparison = a.interestRate - b.interestRate;
            } else if (sortBy === 'minimumPayment') {
                comparison = a.minimumPayment - b.minimumPayment;
            } else if (sortBy === 'debtDate') {
                comparison = new Date(a.debtDate) - new Date(b.debtDate);
            }

            return sortOrder === 'desc' ? comparison * -1 : comparison;
        });
    }

    generateReportBtn.addEventListener('click', function () {
        const reportType = reportTypeSelect.value;
        const sortBy = sortBySelect.value;
        const sortOrder = sortOrderSelect.value;

        const sortedDebts = sortDebts(debtsData, sortBy, sortOrder);

        reportOutputDiv.innerHTML = '';
        reportOutputDiv.style.display = 'block';
        noReportGenerated.style.display = 'none';

        if (sortedDebts.length > 0) {
            if (reportType === 'summary') {
                reportOutputDiv.innerHTML = generateDebtSummary(sortedDebts);
            } else if (reportType === 'details') {
                reportOutputDiv.innerHTML = generateDetailedDebtList(sortedDebts);
            } else if (reportType === 'payment-schedule') {
                reportOutputDiv.innerHTML = generatePaymentSchedules(sortedDebts);
            } else {
                reportOutputDiv.innerHTML = '<p>Invalid report type selected.</p>';
            }
        } else {
            reportOutputDiv.style.display = 'none';
            noReportGenerated.style.display = 'block';
        }
    });

    noReportGenerated.style.display = 'block';
});