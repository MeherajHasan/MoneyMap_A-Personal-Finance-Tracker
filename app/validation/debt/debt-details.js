document.addEventListener("DOMContentLoaded", () => {
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
