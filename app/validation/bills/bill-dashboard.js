document.addEventListener("DOMContentLoaded", () => {
    const deleteButtons = document.querySelectorAll(".btn-delete");

    deleteButtons.forEach(button => {
        button.addEventListener("click", (e) => {
            const confirmDelete = confirm("Are you sure you want to delete this bill?");
            if (!confirmDelete) {
                e.preventDefault();
            }
        }); 
    });
});
