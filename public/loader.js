// Wait until the page is fully loaded
window.addEventListener('load', () => {
    // Hide the loader
    document.getElementById('loader').style.opacity = '0';
    document.getElementById('loader').style.visibility = 'hidden';
    
    // Add the 'loaded' class to body
    document.body.classList.add('loaded');
});
