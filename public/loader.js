// Wait until the page is fully loaded
window.addEventListener('load', () => {
    const loader = document.getElementById('loader');
    loader.style.opacity = '0';
    loader.style.visibility = 'hidden';
    loader.style.pointerEvents = 'none'; 

    document.body.classList.add('loaded');
});
