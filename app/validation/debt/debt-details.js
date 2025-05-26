document.addEventListener("DOMContentLoaded", () => {
    const valueItems = document.querySelectorAll('.detail-item .value');
    valueItems.forEach(item => {
        item.addEventListener("click", () => {
            alert(`Copied: ${item.textContent.trim()}`);
            navigator.clipboard.writeText(item.textContent.trim());
        });
    });

    const actionLinks = document.querySelectorAll('.actions a');
    actionLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            if (link.textContent.includes("Payment")) {
                alert("You are being redirected to make a payment.");
            } else if (link.textContent.includes("Edit")) {
                alert("You are being redirected to edit the debt.");
            }
        });
    });
});
