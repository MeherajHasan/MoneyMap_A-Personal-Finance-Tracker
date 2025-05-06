const overspentCategories = [
    'Food & Groceries',
    'Entertainment',
    'Utilities',
    'Transportation'
  ];
  
  document.addEventListener('DOMContentLoaded', () => {
    const categoriesList = document.getElementById('overspent-categories');
    const acknowledgeBtn = document.getElementById('acknowledge-btn');
    const notification = document.querySelector('.notification');
  
    overspentCategories.forEach(category => {
      const li = document.createElement('li');
      li.textContent = category;
      categoriesList.appendChild(li);
    });
  
    acknowledgeBtn.addEventListener('click', () => {
      notification.style.display = 'none';
      window.location.href = '../../views/budget/budget-dashboard.php';
    });
  });
  