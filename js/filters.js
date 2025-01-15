jQuery(document).ready(function($) {
    $('#filters-form').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: ajax_params.ajax_url,
            type: 'POST',
            data: {
                action: 'load_and_filter_photos', // Nom de l'action
                form_data: formData
            },
            success: function(response) {
                if (response.success) {
                    $('.gallery').html(response.data); // Met à jour la galerie
                } else {
                    console.error('Erreur lors du filtrage des photos');
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX:', error);
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const categoryFilter = document.getElementById("categorie"); // ID corrigé
    const formatFilter = document.getElementById("format"); // ID corrigé
    const sortFilter = document.getElementById("sort-by"); // ID corrigé

    // Fonction pour mettre à jour l'affichage des photos
    function updatePhotos() {
        const category = categoryFilter.value;
        const format = formatFilter.value;
        const sort = sortFilter.value;

        const data = {
            action: "load_and_filter_photos", // Action corrigée
            category: category,
            format: format,
            sort: sort,
        };

        // Envoyer une requête AJAX à WordPress
        fetch(ajax_params.ajax_url, { // Utilisation de ajax_params.ajax_url
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams(data),
        })
            .then((response) => response.json()) // Utilisation de .json() au lieu de .text()
            .then((response) => {
                if (response.success) {
                    document.querySelector(".gallery").innerHTML = response.data; // Mise à jour de la galerie
                } else {
                    console.error('Erreur lors du filtrage des photos');
                }
            })
            .catch((error) => console.error("Erreur :", error));
    }

    categoryFilter.addEventListener("change", updatePhotos);
    formatFilter.addEventListener("change", updatePhotos);
    sortFilter.addEventListener("change", updatePhotos);
});