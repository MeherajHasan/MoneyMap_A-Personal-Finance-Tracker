document.addEventListener("DOMContentLoaded", function () {
    const contactBtn = document.getElementById("contactAdminBtn");

    if (contactBtn) {
        contactBtn.addEventListener("click", function (e) {
            e.preventDefault(); 
            const email = "hasanmeheraj639@gmail.com";
            const subject = "Query on account";
            const mailtoLink = `mailto:${email}?subject=${encodeURIComponent(subject)}`;

            window.open(mailtoLink, '_blank');
        });
    }
});
