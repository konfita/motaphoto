document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function () {
            mobileMenu.classList.toggle('active');
        });
    } else {
        console.error("Les éléments #menu-toggle ou #mobile-menu n'existent pas dans le DOM.");
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modale-container');
    const openButton = document.getElementById('contactLink');
    const closeButton = document.getElementById('close-modale');

    if (modal && openButton && closeButton) {
        openButton.addEventListener('click', (e) => {
            e.preventDefault();
            modal.style.display = 'flex';
            modal.style.opacity = '1';
            modal.setAttribute('aria-hidden', 'false');
        });

        closeButton.addEventListener('click', () => {
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.setAttribute('aria-hidden', 'true');
        });

        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
                modal.style.opacity = '0';
                modal.setAttribute('aria-hidden', 'true');
            }
        });
    } else {
        console.error("Un ou plusieurs éléments de la modale n'existent pas dans le DOM.");
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Ouvrir la popup au clic sur le bouton Contact
    const contactButton = document.querySelector('.photo__contact .btn');
    const popup = document.getElementById('contact-popup');
    const closePopup = document.querySelector('.close-popup');

    if (contactButton && popup && closePopup) {
        contactButton.addEventListener('click', function (e) {
            e.preventDefault();
            popup.style.display = 'flex';
        });

        // Fermer la popup au clic sur la croix
        closePopup.addEventListener('click', function () {
            popup.style.display = 'none';
        });

        // Fermer la popup au clic en dehors du contenu
        window.addEventListener('click', function (e) {
            if (e.target === popup) {
                popup.style.display = 'none';
            }
        });
    }
});