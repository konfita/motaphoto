jQuery(document).ready(function($) {
    $('#filters-form').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: ajax_params.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_photos',
                form_data: formData
            },
            success: function(response) {
                $('.photo-grid').html(response); // Met à jour la galerie
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const categoryFilter = document.getElementById("filter-categories");
    const formatFilter = document.getElementById("filter-formats");
    const sortFilter = document.getElementById("filter-sort");

    // Fonction pour mettre à jour l'affichage des photos
    function updatePhotos() {
        const category = categoryFilter.value;
        const format = formatFilter.value;
        const sort = sortFilter.value;

        const data = {
            action: "filter_photos",
            category: category,
            format: format,
            sort: sort,
        };

        // Envoyer une requête AJAX à WordPress
        fetch(ajaxurl, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams(data),
        })
            .then((response) => response.text())
            .then((html) => {
                document.querySelector(".photo-grid").innerHTML = html;
            })
            .catch((error) => console.error("Erreur :", error));
    }

    categoryFilter.addEventListener("change", updatePhotos);
    formatFilter.addEventListener("change", updatePhotos);
    sortFilter.addEventListener("change", updatePhotos);
});
