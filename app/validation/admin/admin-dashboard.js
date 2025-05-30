const profileBtn = document.getElementById('profileBtn');
const notificationBtn = document.getElementById('notificationBtn');
const logoutBtn = document.getElementById('logoutBtn');
const sidebarItems = document.querySelectorAll('.nav-menu > li > a');

profileBtn.addEventListener('click', () => {
  window.location.href = 'admin-profile.php';
});

notificationBtn.addEventListener('click', () => {
  alert('This feature is under development. Stay tuned!');
});

logoutBtn.addEventListener('click', () => {
  // window.location.href = '../../controllers/auth/logout.php';
});
 
sidebarItems.forEach(item => {
  item.addEventListener('click', event => {
    const submenu = item.nextElementSibling;
    if (submenu && submenu.classList.contains('submenu')) {
      submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
      event.preventDefault();
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
      case 'total-users-widget':
        window.location.href = 'user-management.php';
        break;
      case 'categories-widget':
        window.location.href = 'category-management.php';
        break;
      case 'transactions-widget':
        window.location.href = 'data-oversight.php';
        break;
      case 'backup-widget':
        window.location.href = 'backup.php';
        break;
      case 'feedback-widget':
        window.location.href = 'contact-response.php';
        break;
      default:
        alert('Feature under development');
    }
  });
});
