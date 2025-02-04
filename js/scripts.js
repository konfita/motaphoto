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
    const closeButton = document.getElementById('close-modale');
    const buttons = document.querySelectorAll('.open-contact-modal'); // Boutons d'ouverture de la modale
    const inputRef = document.querySelector('input[name="photo-ref"]'); // L'input dans la modale
    const photoReference = document.querySelector('.photo-reference'); // La référence photo dans la page

    let referenceValue = '';
    if (photoReference) {
        referenceValue = photoReference.textContent.trim(); // Récupérer la valeur de la référence
    }

    if (modal && closeButton && buttons.length) {
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();

                // Priorité à data-refphoto du bouton, sinon utiliser la référence dans la page
                const ref = button.dataset.refphoto || referenceValue;

                // Mettre à jour l'input si une valeur est présente
                if (inputRef) {
                    inputRef.value = ref || ''; // Laisser vide si aucune valeur n'est disponible
                }

                // Ouvrir la modale
                modal.style.display = 'flex';
                modal.style.opacity = '1';
                modal.setAttribute('aria-hidden', 'false');
            });
        });

        // Fermeture de la modale avec le bouton close
        closeButton.addEventListener('click', () => {
            modal.style.display = 'none';
            modal.style.opacity = '0';
            modal.setAttribute('aria-hidden', 'true');
        });

        // Fermeture de la modale en cliquant à l'extérieur
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
                modal.style.opacity = '0';
                modal.setAttribute('aria-hidden', 'true');
            }
        });
    } else {
        console.error("Un ou plusieurs éléments nécessaires pour la modale sont introuvables dans le DOM.");
    }
});




document.addEventListener('DOMContentLoaded', function () {
    const prevArrow = document.querySelector('.previous_post .nav-arrow');
    const nextArrow = document.querySelector('.next_post .nav-arrow');
    const prevThumbnail = document.getElementById('prev-thumbnail');
    const nextThumbnail = document.getElementById('next-thumbnail');

    // Fonction pour afficher l'aperçu
    function showThumbnail(e, thumbnailContainer, thumbnailContent) {
        if (!thumbnailContent) return;
        thumbnailContainer.innerHTML = thumbnailContent;
        thumbnailContainer.style.display = 'block';
        thumbnailContainer.style.top = `1000px`;
        thumbnailContainer.style.right = `160px`;
    }

    // Fonction pour cacher l'aperçu
    function hideThumbnail(thumbnailContainer) {
        thumbnailContainer.style.display = 'none';
        thumbnailContainer.innerHTML = '';
    }

    // Gérer le survol des flèches
    if (prevArrow && prevThumbnail) {
        prevArrow.addEventListener('mouseenter', (e) => {
            const thumbnailContent = prevArrow.dataset.thumbnail;
            showThumbnail(e, prevThumbnail, thumbnailContent);
        });
        prevArrow.addEventListener('mouseleave', () => {
            hideThumbnail(prevThumbnail);
        });
    }

    if (nextArrow && nextThumbnail) {
        nextArrow.addEventListener('mouseenter', (e) => {
            const thumbnailContent = nextArrow.dataset.thumbnail;
            showThumbnail(e, nextThumbnail, thumbnailContent);
        });
        nextArrow.addEventListener('mouseleave', () => {
            hideThumbnail(nextThumbnail);
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const siteNavigation = document.getElementById('site-navigation');

    menuToggle.addEventListener('click', function() {
        siteNavigation.classList.toggle('active');
    });
});