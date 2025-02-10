document.addEventListener('DOMContentLoaded', function () {

    console.log("Script chargé");

    const prevArrow = document.getElementById('prevArrowLightbox');
    const nextArrow = document.getElementById('nextArrowLightbox');

    if (prevArrow) {
        prevArrow.addEventListener('click', function (e) {
            e.preventDefault(); // ✅ Empêche un comportement par défaut
            console.log("Bouton Previous cliqué, action envoyée: get_previous_lightbox_photo_ajax");
            handleArrowClick("get_next_lightbox_photo_ajax");
        });
    } else {
        console.error("⚠ Erreur: prevArrow n'a pas été trouvé dans le DOM !");
    }

    if (nextArrow) {
        nextArrow.addEventListener('click', function (e) {
            e.preventDefault(); // ✅ Empêche un comportement par défaut
            console.log("Bouton Next cliqué, action envoyée: get_next_lightbox_photo_ajax");
            handleArrowClick("get_previous_lightbox_photo_ajax");
        });
    } else {
        console.error("⚠ Erreur: nextArrow n'a pas été trouvé dans le DOM !");
    }

    function openLightbox(photoData) {
        console.log("Ouverture de la lightbox avec :", photoData);

        const lightboxOverlay = document.querySelector('.lightbox-overlay');
        if (!lightboxOverlay) {
            console.error("La lightbox n'existe pas dans le DOM.");
            return;
        }

        const image = document.querySelector('.lightbox-image');
        const reference = document.querySelector('.lightbox-reference');
        const category = document.querySelector('.lightbox-category');

        if (image && reference && category) {
            image.src = photoData.url;
            reference.textContent = photoData.reference;
            category.textContent = photoData.category;
            lightboxOverlay.dataset.currentPhotoId = photoData.id;
            lightboxOverlay.style.display = 'flex';
        } else {
            console.error("Éléments de la lightbox non trouvés.");
        }
    }

    function closeLightbox() {
        const lightboxOverlay = document.querySelector('.lightbox-overlay');
        if (lightboxOverlay) {
            lightboxOverlay.style.display = 'none';
        }
    }

    function loadPhoto(url, postId) {
        const image = document.querySelector('.lightbox-image');
        const lightboxOverlay = document.querySelector('.lightbox-overlay');

        if (image && lightboxOverlay) {
            image.src = url;
            lightboxOverlay.dataset.currentPhotoId = postId;
        }
    }

    function handleArrowClick(action) {
        


        const currentPostId = document.querySelector('.lightbox-overlay')?.dataset.currentPhotoId;
        console.log("handleArrowClick appelé avec :", action, "Post ID:", currentPostId);
        console.log("Requête AJAX envoyée :", {
            action: action,
            security: lightbox_ajax_object.security,
            post_id: currentPostId
        });

        
        if (!currentPostId) {
            console.error("Aucune photo actuelle détectée.");
            return;
        }

        console.log("Données envoyées AJAX:", {
            action: action, // ✅ Correction ici
            security: lightbox_ajax_object.security,
            post_id: currentPostId
        });

        console.log("Requête AJAX envoyée :", `action=${action}&security=${lightbox_ajax_object.security}&post_id=${currentPostId}`);


        fetch(lightbox_ajax_object.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=${action}&security=${lightbox_ajax_object.security}&post_id=${currentPostId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Réponse AJAX complète :", data);
                loadPhoto(data.data.url, data.data.id);
                document.querySelector('.lightbox-reference').textContent = data.data.reference;
                document.querySelector('.lightbox-category').textContent = data.data.category;
            } else {
                console.error('Erreur :', data.data);
            }
        })
        .catch(error => console.error('Erreur AJAX:', error));
    }

    document.querySelectorAll('.photo-expand').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            const photoId = this.dataset.photoId;
            console.log("Image cliquée, ID :", photoId);

            fetch(lightbox_ajax_object.ajax_url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=get_photo_data&security=${lightbox_ajax_object.security}&photo_id=${photoId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    openLightbox(data.data);
                } else {
                    console.error('Erreur de récupération des données de la photo.');
                }
            })
            .catch(() => console.error('Erreur AJAX.'));
        });
    });

    const closeButton = document.querySelector('.lightbox-close');
    const overlay = document.querySelector('.lightbox-overlay');
    const content = document.querySelector('.lightbox-content');

    console.log("Vérification des boutons:", {
        prevArrow: prevArrow,
        nextArrow: nextArrow
    });

    if (closeButton) closeButton.addEventListener('click', closeLightbox);
    if (overlay) overlay.addEventListener('click', closeLightbox);
    if (content) content.addEventListener('click', function (e) {
        e.stopPropagation();
    });

});
// Il attend que la page charge et sélectionne toutes les icônes "plein écran".
// Quand on clique sur une icône 🔍, il simule un clic sur la photo, ce qui ouvre la lightbox.
document.addEventListener("DOMContentLoaded", function () {
    const fullscreenIcons = document.querySelectorAll(".fullscreen-icon");

    fullscreenIcons.forEach(icon => {
        icon.addEventListener("click", function (e) {
            e.preventDefault(); // Empêche le lien de changer de page

            const parentLink = this.closest(".photo-expand"); // Trouver le lien parent
            if (parentLink) {
                parentLink.click(); // Simuler un clic sur la photo pour ouvrir la lightbox
            }
        });
    });
});
