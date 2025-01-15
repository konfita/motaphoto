jQuery(document).ready(function($) {
    // Fonction pour mettre à jour l'affichage des photos
    function updatePhotos() {
        const category = $('#categorie').val();
        const format = $('#format').val();
        const sort = $('#sort-by').val();

        $.ajax({
            url: ajax_params.ajax_url,
            type: 'POST',
            data: {
                action: 'load_and_filter_photos', // Action WordPress
                categorie: category,
                format: format,
                sort_by: sort
            },
            success: function(response) {
                $('.photo-gallery').html(response); // Mettre à jour la galerie
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX:', error);
            }
        });
    }

    // Écouter les changements dans les filtres
    $('#categorie, #format, #sort-by').on('change', function() {
        updatePhotos();
    });
});