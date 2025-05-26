document.addEventListener('DOMContentLoaded', () => {
    const debtList = document.getElementById('debtList');
    const noDebtsMessage = document.getElementById('noDebts');

    if (debtList) {
        const items = debtList.querySelectorAll('li');
        if (items.length === 0) {
            noDebtsMessage.style.display = 'block';
        } else {
            noDebtsMessage.style.display = 'none';
        }
    }
});
