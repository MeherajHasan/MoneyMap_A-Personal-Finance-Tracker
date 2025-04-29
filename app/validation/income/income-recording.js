document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("log-paycheck-btn").addEventListener("click", () => {
        window.location.href = "../../views/income/paycheck.html";
    });

    document.getElementById("setup-recurring-btn").addEventListener("click", () => {
        window.location.href = "../../views/income/recurring-income-setup.html";
    });

    document.getElementById("track-side-hustle-btn").addEventListener("click", () => {
        window.location.href = "../../views/income/side-hustle-tracker.html";
    });
});
