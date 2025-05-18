document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('.profile-form');
  const nameInput = document.getElementById('name');
  const emailInput = document.getElementById('email');
  const phoneInput = document.getElementById('phone');
  const addressInput = document.getElementById('address');
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirm-password');
  const photoInput = document.getElementById('photo');

  const errorName = document.getElementById('error-name');
  const errorEmail = document.getElementById('error-email');
  const errorPhone = document.getElementById('error-phone');
  const errorPassword = document.getElementById('error-password');
  const errorConfirmPassword = document.getElementById('error-confirm-password');
  const errorMSG = document.getElementById('errorMSG');

  // Store original values to check for changes
  const originalData = {
    name: nameInput.value.trim(),
    email: emailInput.value.trim(),
    phone: phoneInput.value.trim(),
    address: addressInput.value.trim(),
    password: '',
    confirmPassword: '',
    photo: ''
  };

  function clearErrors() {
    errorName.textContent = '';
    errorEmail.textContent = '';
    errorPhone.textContent = '';
    errorPassword.textContent = '';
    errorConfirmPassword.textContent = '';
    errorMSG.textContent = '';
  }

  function isLetterOrAllowed(char) {
    const allowed = [' ', '.', '-', '\''];
    return (
      (char >= 'A' && char <= 'Z') ||
      (char >= 'a' && char <= 'z') ||
      allowed.includes(char)
    );
  }

  function validateName(name) {
    if (name.length === 0) return false;
    for (let i = 0; i < name.length; i++) {
      if (!isLetterOrAllowed(name[i])) {
        return false;
      }
    }
    return true;
  }

  function validateEmail(email) {
    if (email.length === 0) return false;
    if (email.indexOf(' ') !== -1) return false;
    const atIndex = email.indexOf('@');
    if (atIndex <= 0 || atIndex !== email.lastIndexOf('@') || atIndex === email.length - 1) {
      return false;
    }
    const dotIndex = email.indexOf('.', atIndex);
    if (dotIndex === -1 || dotIndex === email.length - 1) {
      return false;
    }
    return true;
  }

  function validatePhone(phone) {
    if (phone.length === 0) return true; // empty phone is allowed
    for (let i = 0; i < phone.length; i++) {
      const c = phone[i];
      if (
        (c >= '0' && c <= '9') ||
        c === '+' ||
        c === '-' ||
        c === ' '
      ) {
        continue;
      }
      return false;
    }
    return true;
  }

  function hasChanges() {
    if (nameInput.value.trim() !== originalData.name) return true;
    if (emailInput.value.trim() !== originalData.email) return true;
    if (phoneInput.value.trim() !== originalData.phone) return true;
    if (addressInput.value.trim() !== originalData.address) return true;
    if (passwordInput.value.trim() !== '') return true;
    if (confirmPasswordInput.value.trim() !== '') return true;
    if (photoInput.files.length > 0) return true;
    return false;
  }

  form.addEventListener('submit', (e) => {
    clearErrors();

    let hasError = false;

    // Validate Name
    const nameValue = nameInput.value.trim();
    if (nameValue === '') {
      errorName.textContent = 'Name is required.';
      hasError = true;
    } else if (!validateName(nameValue)) {
      errorName.textContent = 'Name contains invalid characters.';
      hasError = true;
    }

    // Validate Email
    const emailValue = emailInput.value.trim();
    if (emailValue === '') {
      errorEmail.textContent = 'Email is required.';
      hasError = true;
    } else if (!validateEmail(emailValue)) {
      errorEmail.textContent = 'Invalid email format.';
      hasError = true;
    }

    // Validate Phone
    const phoneValue = phoneInput.value.trim();
    if (!validatePhone(phoneValue)) {
      errorPhone.textContent = 'Phone number contains invalid characters.';
      hasError = true;
    }

    // Validate Password
    if (passwordInput.value !== '') {
      if (passwordInput.value.length < 6) {
        errorPassword.textContent = 'Password must be at least 6 characters.';
        hasError = true;
      }
      if (passwordInput.value !== confirmPasswordInput.value) {
        errorConfirmPassword.textContent = 'Passwords do not match.';
        hasError = true;
      }
    } else if (confirmPasswordInput.value !== '') {
      errorConfirmPassword.textContent = 'Please enter password first.';
      hasError = true;
    }

    // Check for any changes made
    if (!hasChanges()) {
      errorMSG.textContent = 'No changes detected. Please update something before saving.';
      hasError = true;
    }

    if (hasError) {
      e.preventDefault();
    } else {
      e.preventDefault(); // prevent actual submit for demo purposes
      alert('Updated successfully!');
      window.location.href = 'admin-dashboard.php';
    }
  });
});
