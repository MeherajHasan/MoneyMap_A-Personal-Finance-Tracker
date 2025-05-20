window.addEventListener('load', () => {
  const form = document.getElementById('edit-password');
  const currentPasswordInput = document.getElementById('current-password');
  const newPasswordInput = document.getElementById('new-password');
  const confirmPasswordInput = document.getElementById('confirm-password');
  const errorMSG = document.getElementById('errorMSG');

  form.addEventListener('submit', (e) => {
    errorMSG.textContent = '';

    const currentPassword = currentPasswordInput.value.trim();
    const newPassword = newPasswordInput.value.trim();
    const confirmPassword = confirmPasswordInput.value.trim();

    if (currentPassword === '' || newPassword === '' || confirmPassword === '') {
      errorMSG.textContent = 'All fields are required.';
      e.preventDefault();
      return false;
    }

    if (newPassword.length < 8) {
      errorMSG.textContent = 'New password must be at least 8 characters long.';
      e.preventDefault();
      return false;
    }

    if (newPassword !== confirmPassword) {
      errorMSG.textContent = 'New password and confirm password do not match.';
      e.preventDefault();
      return false;
    }
    return true;
  });

  document.getElementById('cancel-btn').addEventListener('click', () => {
    window.history.back();
  });
});
