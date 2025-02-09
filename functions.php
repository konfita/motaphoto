<?php
// Chargement de la police du site 
function enqueue_custom_fonts() {
    wp_enqueue_style('space-mono-font', 'https://fonts.googleapis.com/css2?family=Space+Mono&display=swap', false);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_fonts');

// Chargement du CSS du thème parent
function motaphoto_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'motaphoto_child_enqueue_styles');

// Fonction principale pour charger les styles
function motaphoto_enqueue_styles() {
    // Charger le style principal
    wp_enqueue_style(
        'main-style', // Identifiant unique
        get_stylesheet_directory_uri() . '/style.css', // style.css du thème
        array(),
        '1.0.0'
    );

    // Charger le style spécifique au header
    wp_enqueue_style(
        'modale', // Identifiant unique
        get_stylesheet_directory_uri() . '/modale.css', // Chemin vers style-header.css
        array('main-style'), // Dépend du style principal
        '1.0.0'
    );

    // Charger le style principal 
    wp_enqueue_style(
        'main-style', // Identifiant unique
        get_stylesheet_directory_uri() . '/style.css', // style.css du thème
        array(),
        '1.0.0'
    );

    // Charger le style spécifique à la page photo
    if (is_page_template('single-photo-template.php')) {
        wp_enqueue_style(
            'style-photo', // Identifiant unique
            get_stylesheet_directory_uri() . '/style-photo.css', // Chemin vers style-photo.css
            array('main-style'), // Dépend du style principal
            filemtime(get_stylesheet_directory() . '/style-photo.css') // Version basée sur la date de modification
        );
    }
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_styles');

// Enregistrement des menus (principal et footer)
function motaphoto_register_menus() {
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'motaphoto'), // Menu principal
        'footer_menu' => __('Footer Menu', 'motaphoto'), // Menu footer
    ));
}
add_action('init', 'motaphoto_register_menus');

function theme_scripts() {
    wp_enqueue_script('menu-script', get_stylesheet_directory_uri() . '/js/menu.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'theme_scripts');

// Enqueue des fichiers JS
function enqueue_contact_modale_assets() {
    wp_enqueue_script('modale-script', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
    wp_enqueue_script('filters-js', get_stylesheet_directory_uri() . '/js/filters.js', ['jquery'], null, true);

    // Localiser le script AJAX 
    wp_localize_script('filters-js', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_contact_modale_assets');




// Enregistrement du type de contenu personnalisé "Photos"
function register_photos_cpt() {
    register_post_type('photos', array(
        'labels' => array(
            'name' => 'Photos',
            'singular_name' => 'Photo',
            'add_new' => 'Ajouter une photo',
            'add_new_item' => 'Ajouter une nouvelle photo',
            'edit_item' => 'Modifier la photo',
            'new_item' => 'Nouvelle photo',
            'view_item' => 'Voir la photo',
            'search_items' => 'Rechercher des photos',
            'not_found' => 'Aucune photo trouvée',
            'not_found_in_trash' => 'Aucune photo dans la corbeille',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'photos'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
    ));
}
add_action('init', 'register_photos_cpt');

// Enregistrement des scripts et localisation AJAX
function motaphoto_enqueue_scripts() {
    wp_enqueue_script('load-more-photos', get_stylesheet_directory_uri() . '/js/load-more.js', array('jquery'), null, true);

    wp_localize_script('load-more-photos', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_scripts');

function load_more_photos() {
    $paged = $_POST['page'];

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'paged' => $paged,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <div class="photo-item">
                    <?php
                        if (has_post_thumbnail()) {
                            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // URL de l'image pleine résolution
                            $photo_id = get_the_ID(); // Récupérer l'ID de la photo
                    ?>
                    <a href="<?php echo esc_url(get_permalink($photo_id)); ?>" data-lightbox="gallery" data-title="<?php echo esc_attr(get_the_title()); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                    <?php } ?>
            </div>
        <?php }
    } else {
        echo 'no_more_posts'; // Indicateur pour dire qu'il n'y a plus de posts
    }

    wp_reset_postdata();
    wp_die(); // Termine l'exécution de la requête AJAX
}

add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

// Fonction pour filtrer et charger des photos via AJAX
function load_and_filter_photos() {
    // Inclure le fichier photo-gallery.php
    get_template_part('template-parts/photo-gallery');
    wp_die(); // Terminer l'exécution de la requête AJAX
}

// Enregistrer l'action AJAX pour les utilisateurs connectés et non connectés
add_action('wp_ajax_load_and_filter_photos', 'load_and_filter_photos');
add_action('wp_ajax_nopriv_load_and_filter_photos', 'load_and_filter_photos');

// Fonction pour forcer l'utilisation du template personnalisé pour les photos
function motaphoto_single_photo_template($template) {
    global $post;

    // Vérifier si c'est une publication du type "photos"
    if ($post->post_type == 'photos') {
        // Chemin vers votre template personnalisé
        $new_template = locate_template(array('single-photo-template.php'));
        if (!empty($new_template)) {
            return $new_template;
        }
    }

    return $template;
}
add_filter('single_template', 'motaphoto_single_photo_template');

function get_next_photo_ajax() {

    // Vérifier le nonce pour la sécurité
    check_ajax_referer('photo_navigation_nonce', 'security');

    // Récupérer l'ID du post actuel depuis la requête AJAX
    $current_post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    if ($current_post_id == 0) {
        wp_send_json_error('ID du post actuel non valide.');
        return;
    }

    // Créer une requête personnalisée pour récupérer le post suivant
    $args = array(
        'post_type'      => 'photos', 
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'orderby'        => 'date',// Trier par sa date
        'order'          => 'ASC',// Ascendant
        'date_query'     => array(
            'after' => get_the_date('Y-m-d H:i:s', $current_post_id), // Récupérer les posts après le post actuel grâce à mla date
        ),
    );

    $next_query = new WP_Query($args);

    $next_image_url = '';
    $next_post_url = '';

    if ($next_query->have_posts()) {
        while ($next_query->have_posts()) {
            $next_query->the_post();
            $next_post_id = get_the_ID();
            // Récupérer l'URL du post
            $next_post_url = get_permalink($next_post_id);

            // Récupérer l'image attachée
            $attachments = get_attached_media('image', $next_post_id);
            if (!empty($attachments)) {
                $attachment = array_shift($attachments);
                $next_image_url = wp_get_attachment_image_src($attachment->ID, 'photo-detail-thumb')[0];
            } else {
                error_log('Aucune image attachée trouvée pour ce post.');
            }
        }
    } else {
        error_log('Aucun post suivant trouvé.');
    }

    wp_reset_postdata(); // Réinitialiser les données de la requête principale

    // Retourner l'URL de l'image
    if (!empty($next_image_url)) {
        wp_send_json_success(array('image_url' => $next_image_url, 'post_url' => $next_post_url));
    } else {
        wp_send_json_error('Aucune image trouvée pour la photo suivante.');
    }

    // Réinitialise les données de la requête principale
    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_get_next_photo', 'get_next_photo_ajax');
add_action('wp_ajax_nopriv_get_next_photo', 'get_next_photo_ajax');
