document.addEventListener("DOMContentLoaded", function () {
    console.log("Script chargé");

    const lightbox = document.getElementById("lightbox-overlay");

    // Ouvrir la lightbox uniquement sur l'icône plein écran
    document.querySelectorAll(".fullscreen-icon").forEach(icon => {
        icon.addEventListener("click", function (event) {
            event.preventDefault();

            const photoData = {
                url: this.dataset.url,
                reference: this.dataset.reference,
                category: this.dataset.category
            };

            if (lightbox) {
                lightbox.querySelector(".lightbox-image").src = photoData.url;
                lightbox.querySelector(".lightbox-reference").textContent = photoData.reference;
                lightbox.querySelector(".lightbox-category").textContent = photoData.category;

                lightbox.style.display = "flex"; // Afficher la lightbox
            }
        });
    });

    // Fermer la lightbox
    document.querySelector(".lightbox-close").addEventListener("click", function () {
        lightbox.style.display = "none";
    });

    lightbox.addEventListener("click", function (e) {
        if (e.target === lightbox) {
            lightbox.style.display = "none";
        }
    });
});
