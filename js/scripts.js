document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('active');
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('contact-modal');
    const openButton = document.getElementById('open-modal');
    const closeButton = document.querySelector('.close-button');

    // Ouvrir la modale
    openButton.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    // Fermer la modale via le bouton X
    closeButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Fermer la modale en cliquant à l'extérieur
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
console.log('Script chargé');
console.log(document.getElementById('open-modal'));
console.log(document.getElementById('contact-modal'));

