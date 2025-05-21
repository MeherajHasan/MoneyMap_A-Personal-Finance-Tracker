document.addEventListener('DOMContentLoaded', () => {
  const searchForm = document.querySelector('form[action="' + location.pathname + '"]');
  const searchEmailInput = searchForm ? searchForm.querySelector('input[name="searchEmail"]') : null;
  const searchError = document.getElementById('searchError');

  const updateForm = document.querySelector('form[method="post"]:not([action])');
  const updateError = document.getElementById('updateError');

  function isValidName(name) {
    for (let i = 0; i < name.length; i++) {
      const ch = name[i];
      if (
        !(
          (ch >= 'a' && ch <= 'z') ||
          (ch >= 'A' && ch <= 'Z') ||
          ch === '.' ||
          ch === '-'
        )
      ) {
        return false;
      }
    }
    return true;
  }

  function isDigitsOnly(str) {
    for (let i = 0; i < str.length; i++) {
      const ch = str[i];
      if (ch < '0' || ch > '9') {
        return false;
      }
    }
    return true;
  }

  function manualEmailCheck(email) {
    const atPos = email.indexOf('@');
    const dotPos = email.lastIndexOf('.');
    if (atPos < 1 || dotPos < atPos + 2 || dotPos === email.length - 1) {
      return false;
    }
    return true;
  }

  if (searchForm) {
    searchForm.addEventListener('submit', e => {
      const email = searchEmailInput.value.trim();
      if (email === '') {
        e.preventDefault();
        searchError.textContent = 'Email field is required';
      } else if (!manualEmailCheck(email)) {
        e.preventDefault();
        searchError.textContent = 'Invalid email address';
      } else {
        searchError.textContent = '';
      }
    });
  }

  if (updateForm) {
    updateForm.addEventListener('submit', e => {
      let errorMsg = '';
      const fname = updateForm.elements['fname'].value.trim();
      const lname = updateForm.elements['lname'].value.trim();
      const phone = updateForm.elements['phone'].value.trim();
      const gender = updateForm.elements['gender'].value;
      const dob = updateForm.elements['dob'].value;
      const address = updateForm.elements['address'].value.trim();
      const account_status = updateForm.elements['account_status'].value;
      const role = updateForm.elements['role'].value;

      if (fname === '') {
        errorMsg = 'First name is required';
      } else if (!isValidName(fname)) {
        errorMsg = 'First name must contain only letters';
      } else if (lname === '') {
        errorMsg = 'Last name is required';
      } else if (!isValidName(lname)) {
        errorMsg = 'Last name must contain only letters';
      } else if (phone === '') {
        errorMsg = 'Phone number is required';
      } else if (!isDigitsOnly(phone)) {
        errorMsg = 'Phone number must be digits only';
      } else if (phone.length < 6) {
        errorMsg = 'Phone number must be at least 6 digits';
      } else if (gender === '') {
        errorMsg = 'Gender is required';
      } else if (!['0', '1'].includes(gender)) {
        errorMsg = 'Invalid gender selected';
      } else if (address === '') {
        errorMsg = 'Address is required';
      } else if (dob === '') {
        errorMsg = 'Date of birth is required';
      } else {
        const dobDate = new Date(dob);
        const today = new Date();
        const minDob = new Date(today.getFullYear() - 12, today.getMonth(), today.getDate());
        if (dobDate > minDob) {
          errorMsg = 'User must be at least 12 years old';
        }
      } 

      if (account_status === '') {
        errorMsg = 'Account status is required';
      } else if (!['0', '2'].includes(account_status)) {
        errorMsg = 'Invalid account status';
      } else if (role === '') {
        errorMsg = 'Role is required';
      } else if (!['admin', 'user'].includes(role)) {
        errorMsg = 'Invalid role selected';
      }

      if (errorMsg !== '') {
        e.preventDefault();
        updateError.textContent = errorMsg;
      } else {
        updateError.textContent = '';
      }
    });
  }
});
