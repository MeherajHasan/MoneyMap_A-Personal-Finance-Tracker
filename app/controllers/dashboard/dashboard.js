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
    // Update the sync status in the UI
    syncBtn.disabled = false;
  }, 2000); // Simulate a 2-second sync process
});

// Profile Button Event Listener
profileBtn.addEventListener('click', () => {
  window.location.href = '../'; // Redirect to profile page --> not complete
});

// Notification Button Event Listener
notificationBtn.addEventListener('click', () => {
  window.location.href = '/notifications'; // Redirect to notifications page --> not complete
});

// Logout Button Event Listener
logoutBtn.addEventListener('click', () => {
  window.location.href = '../../view/auth/login.html'; //logout logic --> not complete
});

// Sidebar Item Click Handling
sidebarItems.forEach(item => {
  item.addEventListener('click', (event) => {
    const submenu = item.nextElementSibling;
    
    // Check if the next sibling is a submenu and toggle display
    if (submenu && submenu.classList.contains('submenu')) {
      // Toggle submenu display using inline styles (no CSS involved)
      if (submenu.style.display === 'block') {
        submenu.style.display = 'none'; // Hide the submenu
      } else {
        submenu.style.display = 'block'; // Show the submenu
      }
    } else {
      // If no submenu, navigate to the corresponding page (or handle action)
      const href = item.getAttribute('href');
      if (href && href !== "#") {
        window.location.href = href; // Navigate to the link (if any)
      }
    }
  });
});

// Submenu Item Click Handling
const submenuItems = document.querySelectorAll('.submenu > li > a');
submenuItems.forEach(submenuItem => {
  submenuItem.addEventListener('click', (event) => {
    const href = submenuItem.getAttribute('href');
    if (href && href !== "#") {
      window.location.href = href; // Navigate to the corresponding page
    }
  });
});

// Simulate setting dynamic data for widgets
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
