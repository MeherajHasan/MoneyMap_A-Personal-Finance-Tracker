document.addEventListener('DOMContentLoaded', () => {
    const deleteLinks = document.querySelectorAll('.btn-danger');

    deleteLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            if (!confirm('Are you sure you want to delete this goal?')) {
                e.preventDefault();
            }
        });
    });
});
