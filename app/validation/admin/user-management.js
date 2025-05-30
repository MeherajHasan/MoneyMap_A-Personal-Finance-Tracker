document.addEventListener('DOMContentLoaded', () => {
  const searchForm = document.getElementById('searchForm');
  const searchError = document.getElementById('searchError');
  const updateError = document.getElementById('updateError');
  const updateSuccess = document.getElementById('updateSuccess');
  const editContainer = document.getElementById('editUserFormContainer');

  function isValidName(name) {
    for (let i = 0; i < name.length; i++) {
      const ch = name[i];
      if (
        !((ch >= 'a' && ch <= 'z') || (ch >= 'A' && ch <= 'Z') || ch === '.' || ch === '-')
      ) {
        return false;
      }
    }
    return true;
  }

  function isDigitsOnly(str) {
    for (let i = 0; i < str.length; i++) {
      if (str[i] < '0' || str[i] > '9') return false;
    }
    return true;
  }

  function isValidDOB(dobStr) {
    const dob = new Date(dobStr);
    const now = new Date();
    const ageLimit = new Date(now.getFullYear() - 12, now.getMonth(), now.getDate());
    return dob <= ageLimit;
  }

  searchForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const email = searchForm.searchEmail.value.trim();

    if (email === '') {
      searchError.textContent = 'Email field is required';
      return;
    }

    const res = await fetch('../../controllers/user-management-controller.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'search', searchEmail: email })
    });

    const data = await res.json();
    if (data.success) {
      searchError.textContent = '';
      renderEditForm(data.user);
    } else {
      searchError.textContent = data.message || 'User not found';
    }
  });

  function renderEditForm(user) {
    editContainer.innerHTML = `
      <form id="updateForm">
        <input type="hidden" name="email" value="${user.email}" />
        <label>First Name:</label><input type="text" name="fname" value="${user.fname}" /><br />
        <label>Last Name:</label><input type="text" name="lname" value="${user.lname}" /><br />
        <label>Phone:</label><input type="text" name="phone" value="${user.phone}" /><br />
        <label>Gender:</label>
        <select name="gender">
          <option value="0" ${user.gender == 0 ? 'selected' : ''}>Male</option>
          <option value="1" ${user.gender == 1 ? 'selected' : ''}>Female</option>
        </select><br />
        <label>Date of Birth:</label><input type="date" name="dob" value="${user.dob}" /><br />
        <label>Address:</label><input type="text" name="address" value="${user.address}" /><br />
        <label>Account Status:</label>
        <select name="account_status">
          <option value="0" ${user.account_status == 0 ? 'selected' : ''}>Active</option>
          <option value="2" ${user.account_status == 2 ? 'selected' : ''}>Suspended</option>
        </select><br />
        <label>Role:</label>
        <select name="role">
          <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
          <option value="user" ${user.role === 'user' ? 'selected' : ''}>User</option>
        </select><br />
        <button type="submit">Save Changes</button>
      </form>
    `;

    const updateForm = document.getElementById('updateForm');

    updateForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const fd = new FormData(updateForm);
      const userData = Object.fromEntries(fd.entries());

      const fname = userData.fname.trim();
      const lname = userData.lname.trim();
      const phone = userData.phone.trim();
      const gender = userData.gender;
      const dob = userData.dob;
      const address = userData.address.trim();
      const account_status = userData.account_status;
      const role = userData.role;

      updateError.textContent = '';
      updateSuccess.textContent = '';

      if (fname === '') {
        updateError.textContent = 'First name is required';
        return;
      }
      if (!isValidName(fname)) {
        updateError.textContent = 'First name must contain only letters';
        return;
      }

      if (lname === '') {
        updateError.textContent = 'Last name is required';
        return;
      }
      if (!isValidName(lname)) {
        updateError.textContent = 'Last name must contain only letters';
        return;
      }

      if (phone === '') {
        updateError.textContent = 'Phone number is required';
        return;
      }
      if (!isDigitsOnly(phone)) {
        updateError.textContent = 'Phone number must be digits only';
        return;
      }
      if (phone.length < 6) {
        updateError.textContent = 'Phone number must be at least 6 digits';
        return;
      }

      if (gender !== '0' && gender !== '1') {
        updateError.textContent = 'Invalid gender selected';
        return;
      }

      if (dob === '') {
        updateError.textContent = 'Date of birth is required';
        return;
      }
      if (!isValidDOB(dob)) {
        updateError.textContent = 'User must be at least 12 years old';
        return;
      }

      if (address === '') {
        updateError.textContent = 'Address is required';
        return;
      }

      if (account_status !== '0' && account_status !== '2') {
        updateError.textContent = 'Invalid account status';
        return;
      }

      if (role !== 'admin' && role !== 'user') {
        updateError.textContent = 'Invalid role selected';
        return;
      }

      userData.action = 'update';
      const res = await fetch('../../controllers/user-management-controller.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(userData)
      });

      const data = await res.json();
      if (data.success) {
        updateError.textContent = '';
        updateSuccess.textContent = data.message;
      } else {
        updateSuccess.textContent = '';
        updateError.textContent = data.message;
      }
    });
  }
});
