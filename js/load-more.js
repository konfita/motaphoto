jQuery(document).ready(function($) {
    let page = 2; // Commence à la page suivante

    $('#load-more').on('click', function() {
        $.ajax({
            url: ajax_params.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_photos', // Nom de l'action
                page: page,
            },
            success: function(response) {
                if (response === 'no_more_posts') {
                    $('#load-more').hide(); // Masquer le bouton s'il n'y a plus de posts
                } else if (response) {
                    $('.photo-grid').append(response);
                    page++;
                }
            }
        });
    });
});