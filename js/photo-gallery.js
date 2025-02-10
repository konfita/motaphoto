document.addEventListener('DOMContentLoaded', function () {
    console.log("Script chargé");

    const prevArrow = document.getElementById('prevArrowLightbox');
    const nextArrow = document.getElementById('nextArrowLightbox');
    const closeButton = document.querySelector('.lightbox-close');
    const overlay = document.querySelector('.lightbox-overlay');
    const content = document.querySelector('.lightbox-content');
    
    function openLightbox(photoData) {
        console.log("Ouverture de la lightbox avec :", photoData);

        const lightboxOverlay = document.querySelector('.lightbox-overlay');
        const image = document.querySelector('.lightbox-image');
        const reference = document.querySelector('.lightbox-reference');
        const category = document.querySelector('.lightbox-category');

        if (image && reference && category) {
            image.src = photoData.url;
            reference.textContent = photoData.reference;
            category.textContent = photoData.category;
            lightboxOverlay.dataset.currentPhotoId = photoData.id;
            lightboxOverlay.style.display = 'flex';
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
        if (!currentPostId) {
            console.error("Aucune photo actuelle détectée.");
            return;
        }

        fetch(lightbox_ajax_object.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=${action}&security=${lightbox_ajax_object.security}&post_id=${currentPostId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadPhoto(data.data.url, data.data.id);
                document.querySelector('.lightbox-reference').textContent = data.data.reference;
                document.querySelector('.lightbox-category').textContent = data.data.category;
            }
        })
        .catch(error => console.error('Erreur AJAX:', error));
    }

    if (prevArrow) {
        prevArrow.addEventListener('click', function (e) {
            e.preventDefault();
            handleArrowClick("get_previous_lightbox_photo_ajax");
        });
    }

    if (nextArrow) {
        nextArrow.addEventListener('click', function (e) {
            e.preventDefault();
            handleArrowClick("get_next_lightbox_photo_ajax");
        });
    }

    document.querySelectorAll('.photo-expand').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            const photoId = this.dataset.photoId;
            fetch(lightbox_ajax_object.ajax_url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=get_photo_data&security=${lightbox_ajax_object.security}&photo_id=${photoId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    openLightbox(data.data);
                }
            })
            .catch(() => console.error('Erreur AJAX.'));
        });
    });

    if (closeButton) closeButton.addEventListener('click', closeLightbox);
    if (overlay) overlay.addEventListener('click', closeLightbox);
    if (content) content.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    document.querySelectorAll(".fullscreen-icon").forEach(icon => {
        icon.addEventListener("click", function (e) {
            e.preventDefault();
            const parentLink = this.closest(".photo-expand");
            if (parentLink) parentLink.click();
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const fullscreenIcons = document.querySelectorAll(".fullscreen-icon");

    fullscreenIcons.forEach(icon => {
        icon.addEventListener("click", function (event) {
            event.preventDefault(); // Empêcher l'action par défaut

            // Récupérer les données de la photo
            const photoId = this.getAttribute("data-photo-id");
            const photoUrl = this.getAttribute("data-url");
            const photoReference = this.getAttribute("data-reference");
            const photoCategory = this.getAttribute("data-category");

            // Vérifier si la lightbox existe
            const lightbox = document.querySelector("#lightbox"); 
            if (lightbox) {
                // Mise à jour de l'image dans la lightbox
                lightbox.querySelector(".lightbox-image").src = photoUrl;
                lightbox.querySelector(".lightbox-reference").textContent = photoReference;
                lightbox.querySelector(".lightbox-category").textContent = photoCategory;

                // Afficher la lightbox
                lightbox.classList.add("visible");
            }
        });
    });
});
