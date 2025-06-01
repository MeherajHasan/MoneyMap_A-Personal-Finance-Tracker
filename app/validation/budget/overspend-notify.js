document.addEventListener('DOMContentLoaded', () => {
  const acknowledgeBtn = document.getElementById('acknowledge-btn');
  acknowledgeBtn.addEventListener('click', () => {
    window.location.href = 'budget-dashboard.php';
  });
}); 
