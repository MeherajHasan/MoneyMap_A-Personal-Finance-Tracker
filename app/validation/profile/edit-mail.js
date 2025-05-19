document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('edit-mail');
  const emailInput = document.getElementById('email');
  const errorMSG = document.getElementById('errorMSG');
  const saveBtn = document.getElementById('save-btn');
  const cancelBtn = document.getElementById('cancel-btn');

  saveBtn.addEventListener('click', () => {
    const email = emailInput.value.trim();
    errorMSG.textContent = '';

    if (email === '') {
      errorMSG.textContent = 'Email is required.';
      return;
    }

    const atPos = email.indexOf('@');
    const dotPos = email.lastIndexOf('.');

    if (atPos === -1 || dotPos === -1 || atPos > dotPos) {
      errorMSG.textContent = 'Invalid email format.';
      return;
    }

    form.submit();
  });

  cancelBtn.addEventListener('click', () => {
    window.location.href = 'profile.php';
  });
});
