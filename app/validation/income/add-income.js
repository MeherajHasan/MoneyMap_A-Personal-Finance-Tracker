document.querySelector('.income-form').addEventListener('submit', function (e) {
    let hasError = false;

    document.getElementById('sourceError').textContent = '';
    document.getElementById('amountError').textContent = '';
    document.getElementById('dateError').textContent = '';
    document.getElementById('emptyError').textContent = '';

    const incomeSource = document.getElementById('incomeSource').value.trim();
    if (incomeSource !== "") {
        for (let i = 0; i < incomeSource.length; i++) {
            const c = incomeSource[i];
            if (!(
                (c >= 'a' && c <= 'z') ||
                (c >= 'A' && c <= 'Z') ||
                (c >= '0' && c <= '9') ||
                c === ' ' || c === '.' || c === ',' || c === '-'
            )) {
                document.getElementById('sourceError').textContent = "Source contains invalid characters.";
                hasError = true;
                break;
            }
        }
    }

    const incomeAmount = document.getElementById('incomeAmount').value.trim();
    if (incomeAmount === "") {
        document.getElementById('amountError').textContent = "Amount is required.";
        hasError = true;
    } else if (isNaN(incomeAmount) || parseFloat(incomeAmount) <= 0) {
        document.getElementById('amountError').textContent = "Amount must be a positive number.";
        hasError = true;
    }

    const incomeDate = document.getElementById('incomeDate').value.trim();
    if (incomeDate === "") {
        document.getElementById('dateError').textContent = "Date is required.";
        hasError = true;
    }

    if (hasError) {
        document.getElementById('emptyError').textContent = "Please fix the errors above and resubmit.";
        e.preventDefault();
    }
});
