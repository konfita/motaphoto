jQuery(document).ready(function($) {
    let page = 2; // Commence à la page suivante

    $('#load-more').on('click', function() {
        $.ajax({
            url: ajax_params.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_photos',
                page: page,
            },
            success: function(response) {
                if (response) {
                    $('.photo-grid').append(response); // Ajoute les nouvelles photos
                    page++;
                } else {
                    $('#load-more').hide(); // Cache le bouton si plus de photos
                }
            }
        });
    });
});
