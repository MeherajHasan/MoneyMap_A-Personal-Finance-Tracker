const syncBtn = document.getElementById('syncBtn');
const profileBtn = document.getElementById('profileBtn');
const notificationBtn = document.getElementById('notificationBtn');
const logoutBtn = document.getElementById('logoutBtn');
const sidebarItems = document.querySelectorAll('.nav-menu > li > a');
const syncStatus = document.getElementById('sync-status');
const widgetAmounts = document.querySelectorAll('.widget-amount');
const incomeWidgetAmount = document.getElementById('income-widget').querySelector('.widget-amount');
const expenseWidgetAmount = document.getElementById('expense-widget').querySelector('.widget-amount');
const budgetWidgetAmount = document.getElementById('budget-widget').querySelector('.widget-amount');
const savingsWidgetAmount = document.getElementById('savings-widget').querySelector('.widget-amount');
const debtWidgetAmount = document.getElementById('debt-widget').querySelector('.widget-amount');
const netWorthWidgetAmount = document.getElementById('net-worth-widget').querySelector('.widget-amount');

syncBtn.addEventListener('click', () => {
  syncStatus.innerHTML = 'Syncing...';
  syncBtn.disabled = true;

  // Simulate syncing process with a timeout
  setTimeout(() => {
    const currentDate = new Date();
    const lastSyncedDate = currentDate.toLocaleString(); 

    syncStatus.innerHTML = `Last Synced: ${lastSyncedDate}`;
    
    syncBtn.disabled = false;
  }, 2000); 
});

profileBtn.addEventListener('click', () => {
  window.location.href = '../../views/profile/profile.html'; 
});

// Notification Button Event Listener
notificationBtn.addEventListener('click', () => {
  window.location.href = '/notifications'; // Redirect to notifications page --> not complete
});

// Logout Button Event Listener
logoutBtn.addEventListener('click', () => {
  window.location.href = '../../views/auth/login.html'; //logout logic --> not complete
});

sidebarItems.forEach(item => {
  item.addEventListener('click', (event) => {
    const submenu = item.nextElementSibling;
    
    if (submenu && submenu.classList.contains('submenu')) {
      
      if (submenu.style.display === 'block') {
        submenu.style.display = 'none'; 
      } else {
        submenu.style.display = 'block'; 
      }
    } else {
      
      const href = item.getAttribute('href');
      if (href && href !== "#") {
        window.location.href = href; 
      }
    }
  });
});

const submenuItems = document.querySelectorAll('.submenu > li > a');
submenuItems.forEach(submenuItem => {
  submenuItem.addEventListener('click', (event) => {
    const href = submenuItem.getAttribute('href');
    if (href && href !== "#") {
      window.location.href = href; 
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

// Call function to initialize widget data
setWidgetData();
