const syncBtn = document.getElementById('syncBtn');
const profileBtn = document.getElementById('profileBtn');
const notificationBtn = document.getElementById('notificationBtn');
const logoutBtn = document.getElementById('logoutBtn');
const sidebarItems = document.querySelectorAll('.nav-menu > li > a');
const syncStatus = document.getElementById('sync-status');
const incomeWidgetAmount = document.getElementById('income-widget').querySelector('.widget-amount');
const expenseWidgetAmount = document.getElementById('expense-widget').querySelector('.widget-amount');
const budgetWidgetAmount = document.getElementById('budget-widget').querySelector('.widget-amount');
const savingsWidgetAmount = document.getElementById('savings-widget').querySelector('.widget-amount');
const debtWidgetAmount = document.getElementById('debt-widget').querySelector('.widget-amount');
const netWorthWidgetAmount = document.getElementById('net-worth-widget').querySelector('.widget-amount');

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

// logoutBtn.addEventListener('click', () => {
//   window.location.href = '../../views/auth/login.html';
// });

sidebarItems.forEach(item => {
  item.addEventListener('click', event => {
    const submenu = item.nextElementSibling;
    if (submenu && submenu.classList.contains('submenu')) {
      submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
    } else {
      const href = item.getAttribute('href');
      if (href && href !== "#") {
        window.location.href = href;
      }
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
      case 'net-worth-widget':
        alert('Net Worth feature is under development.');
        break;
    }
  });
});

const setWidgetData = () => {
  incomeWidgetAmount.textContent = "$5000";
  expenseWidgetAmount.textContent = "$2000";
  budgetWidgetAmount.textContent = "$3000";
  savingsWidgetAmount.textContent = "$1500";
  debtWidgetAmount.textContent = "$4000";
  netWorthWidgetAmount.textContent = "$10,000";
};

setWidgetData();
