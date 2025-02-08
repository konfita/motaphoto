document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu-overlay');
    const menuClose = document.querySelector('.menu-close');

    if (menuToggle && mobileMenu && menuClose) {
        // Ouvrir le menu
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.add('active');
        });

        // Fermer le menu
        menuClose.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
        });

        // Fermer le menu en cliquant à l'extérieur (optionnel)
        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) {
                mobileMenu.classList.remove('active');
            }
        });
    } else {
        console.error("Un ou plusieurs éléments du menu mobile n'existent pas dans le DOM.");
    }
});