const syncBtn = document.getElementById('syncBtn');
const profileBtn = document.getElementById('profileBtn');
const notificationBtn = document.getElementById('notificationBtn');
const logoutBtn = document.getElementById('logoutBtn');
const sidebarItems = document.querySelectorAll('.nav-menu > li > a');
const syncStatus = document.getElementById('sync-status');
const incomeWidget = document.getElementById('income-widget');
const expenseWidget = document.getElementById('expense-widget');
const budgetWidget = document.getElementById('budget-widget');
const savingsWidget = document.getElementById('savings-widget');
const debtWidget = document.getElementById('debt-widget');
const billsWidget = document.getElementById('bills-widget');
const reportsWidget = document.getElementById('reports-widget');

syncBtn.addEventListener('click', () => {
    syncStatus.innerHTML = 'Syncing...';
    syncBtn.disabled = true;

    setTimeout(() => {
        const currentDate = new Date();
        const lastSyncedDate = currentDate.toLocaleString();
        syncStatus.innerHTML = `Last Synced: ${lastSyncedDate}`;
        syncBtn.disabled = false;
    }, 2000);
}); 

profileBtn.addEventListener('click', () => {
    window.location.href = '../../views/profile/profile.php';
});

notificationBtn.addEventListener('click', () => {
    alert('Notification system is under development.');
    //window.location.href = '/notifications';
});

sidebarItems.forEach(item => {
    item.addEventListener('click', event => {
        const href = item.getAttribute('href');
        if (href && href !== "#") {
            window.location.href = href;
        }
    });
});

const widgetButtons = document.querySelectorAll('.widget-action-btn');
widgetButtons.forEach(button => {
    button.addEventListener('click', () => {
        const widgetId = button.parentElement.id;
        switch (widgetId) {
            case 'income-widget':
                window.location.href = '../../views/income/income-dashboard.php';
                break;
            case 'expense-widget':
                window.location.href = '../../views/expense/expense-dashboard.php';
                break;
            case 'budget-widget':
                window.location.href = '../../views/budget/budget-dashboard.php';
                break;
            case 'savings-widget':
                window.location.href = '../../views/savings/savings-dashboard.php';
                break;
            case 'debt-widget':
                window.location.href = '../../views/debt/debt-dashboard.php';
                break;
            case 'bills-widget':
                window.location.href = '../../views/bills/bill-dashboard.php';
                break;
            case 'reports-widget':
                window.location.href = '../../views/reports/report.php';
                break;
        }
    });
});