function isNameValid(name) {
  if (name === '') return false;
  for (let i = 0; i < name.length; i++) {
    const c = name[i];
    if (
      !( (c >= 'a' && c <= 'z') ||
         (c >= 'A' && c <= 'Z') ||
          c === ' '
      )
    ) {
      return false;
    }
  }
  return true;
}

function isEmailValid(email) {
  const atPos = email.indexOf('@');
  const dotPos = email.lastIndexOf('.');
  if (
    atPos < 1 ||
    dotPos < atPos + 2 ||
    dotPos === email.length - 1 
  ) {
    return false;
  }
  return true;
}

function isPhoneValid(phone) {
  if (phone === '') return false;
  for (let i = 0; i < phone.length; i++) {
    const c = phone[i];
    if (!(c >= '0' && c <= '9')) {
      return false;
    }
  }
  return true;
}

window.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('.profile-form');

  form.addEventListener('submit', (e) => {
    let hasError = false;

    document.querySelectorAll('.error').forEach(el => el.textContent = '');

    const name = form.name.value.trim();
    const email = form.email.value.trim();
    const phone = form.phone.value.trim();
    const password = form.password.value;
    const confirmPassword = form['confirm-password'].value;

    if (name === '') {
      document.getElementById('error-name').textContent = 'Full Name is required.';
      hasError = true;
    } else if (!isNameValid(name)) {
      document.getElementById('error-name').textContent = 'Name can only contain letters and spaces.';
      hasError = true;
    }

    if (email === '') {
      document.getElementById('error-email').textContent = 'Email is required.';
      hasError = true;
    } else if (!isEmailValid(email)) {
      document.getElementById('error-email').textContent = 'Invalid email format.';
      hasError = true;
    }

    if (phone === '') {
      document.getElementById('error-phone').textContent = 'Phone number is required.';
      hasError = true;
    } else if (!isPhoneValid(phone)) {
      document.getElementById('error-phone').textContent = 'Phone number must be digits only.';
      hasError = true;
    }

    if (password !== '') {
      if (password.length < 8) {
        document.getElementById('error-password').textContent = 'Password must be at least 8 characters.';
        hasError = true;
      }
      if (password !== confirmPassword) {
        document.getElementById('error-confirm-password').textContent = 'Passwords do not match.';
        hasError = true;
      }
    }

    if (hasError) {
      e.preventDefault(); 
    }
  });
});
