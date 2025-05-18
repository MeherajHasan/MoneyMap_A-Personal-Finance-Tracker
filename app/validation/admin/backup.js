document.addEventListener("DOMContentLoaded", () => {
    const backupForm = document.querySelector("#backupForm");

    backupForm.addEventListener("submit", () => {
        alert("Database backup is being created. Your download will start shortly.");
    });
});
