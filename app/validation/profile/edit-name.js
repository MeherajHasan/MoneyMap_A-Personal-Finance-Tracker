document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('edit-name');
  const nameInput = document.getElementById('name');
  const errorMSG = document.getElementById('errorMSG');
  const saveBtn = document.getElementById('save-btn');
  const cancelBtn = document.getElementById('cancel-btn');

  function isValidBillName(name) {
    for (let i = 0; i < name.length; i++) {
      const char = name[i];
      if (!(
        (char >= 'a' && char <= 'z') ||
        (char >= 'A' && char <= 'Z') ||
        (char >= '0' && char <= '9') ||
        char === ' ' || char === '.' || char === ',' || char === '-'
      )) {
        return false;
      }
    }
    return true;
  }

  saveBtn.addEventListener('click', () => {
    const nameVal = nameInput.value.trim();

    if (nameVal === '') {
      errorMSG.textContent = 'Name cannot be empty.';
      return;
    }

    if (!isValidBillName(nameVal)) {
      errorMSG.textContent = 'Name contains invalid characters.';
      return;
    }

    errorMSG.textContent = '';
    form.submit();
  });

  cancelBtn.addEventListener('click', () => {
    window.history.back();
  });
});
