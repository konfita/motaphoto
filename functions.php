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
                <div class="photo-overlay">
                    <?php
                        if (has_post_thumbnail()) {
                            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // URL de l'image pleine résolution
                            $photo_id = get_the_ID(); // Récupérer l'ID de la photo
                            $category_name = (!empty($category_terms) && !is_wp_error($category_terms)) ? $category_terms[0]->name : '';
                            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $photo_reference = get_field('reference', $photo_id, true);
                            $category_terms = get_the_terms($photo_id, 'categorie');
                            $category_name = (!empty($category_terms) && !is_wp_error($category_terms)) ? $category_terms[0]->name : '';
                    ?>
                    
                    <?php the_post_thumbnail('medium'); ?>
                    <!-- Icône plein écran (lightbox)  -->

                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icon_fullscreen.png" 
                            alt="Plein écran" 
                            class="fullscreen-icon" 
                            data-photo-id="<?php echo esc_attr($photo_id); ?>"
                            data-url="<?php echo esc_url($thumbnail_url); ?>" 
                            data-reference="<?php echo esc_html($photo_reference); ?>"
                            data-category="<?php echo esc_html($category_name); ?>">

                    <!-- Icône œil (lien vers single-photo-template.php)  -->
                        <a href="<?php echo get_permalink(); ?>">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/eye_icon.png" 
                                alt="Voir la photo" 
                                class="eye-icon">
                        </a>
                        <div class="info-photo">
                            <div class="titre-left">
                            <?php the_title(); ?>
                            </div>
                            <div class="categorie-right">
                                <?php echo esc_html($category_name); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
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








/* Fonction AJAX pour récupérer la photo précédente dans la lightbox */
function get_previous_lightbox_photo_ajax() {
    check_ajax_referer('lightbox_nonce', 'security');

    $current_post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    if ($current_post_id === 0) {
        wp_send_json_error(['error' => 'ID du post actuel invalide.']);
        wp_die();
    }

    // Récupérer la date du post actuel
    $post_date = get_post_field('post_date', $current_post_id);
    if (!$post_date) {
        wp_send_json_error(['error' => 'Date du post non trouvée.']);
        wp_die();
    }

    $args = array(
        'post_type'      => 'photos',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post__not_in'   => array($current_post_id), // Exclure le post actuel
        'date_query'     => array(
            array(
                'before'     => $post_date,
                'inclusive'  => false
            )
        ),
    );

    $previous_query = new WP_Query($args);

    if ($previous_query->have_posts()) {
        $previous_query->the_post();
        $previous_post_id = get_the_ID();
        $image_url = get_the_post_thumbnail_url($previous_post_id, 'full');

        wp_send_json_success([
            'id' => $previous_post_id,
            'url' => $image_url ?: '',
            'reference' => get_field('reference', $previous_post_id),
            'category' => wp_get_post_terms($previous_post_id, 'categorie')[0]->name ?? 'Non classé'
        ]);
    } else {
        wp_send_json_error(['error' => 'Aucune photo précédente trouvée.']);
    }

    wp_reset_postdata();
    wp_die();
}

function get_next_lightbox_photo_ajax() {
    check_ajax_referer('lightbox_nonce', 'security');

    $current_post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    if ($current_post_id === 0) {
        wp_send_json_error(['error' => 'ID du post actuel invalide.']);
        wp_die();
    }

    // Récupérer la date du post actuel
    $post_date = get_post_field('post_date', $current_post_id);
    if (!$post_date) {
        wp_send_json_error(['error' => 'Date du post non trouvée.']);
        wp_die();
    }

    $args = array(
        'post_type'      => 'photos',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'ASC',
        'post__not_in'   => array($current_post_id),
        'date_query'     => array(
            array(
                'after'     => $post_date,
                'inclusive' => false
            )
        ),
    );

    $next_query = new WP_Query($args);

    if ($next_query->have_posts()) {
        $next_query->the_post();
        $next_post_id = get_the_ID();
        $image_url = get_the_post_thumbnail_url($next_post_id, 'full');

        wp_send_json_success([
            'id' => $next_post_id,
            'url' => $image_url ?: '',
            'reference' => get_field('reference', $next_post_id),
            'category' => wp_get_post_terms($next_post_id, 'categorie')[0]->name ?? 'Non classé'
        ]);
    } else {
        wp_send_json_error(['error' => 'Aucune photo suivante trouvée.']);
    }

    wp_reset_postdata();
    wp_die();
}


add_action('wp_ajax_get_next_lightbox_photo_ajax', 'get_next_lightbox_photo_ajax');
add_action('wp_ajax_nopriv_get_next_lightbox_photo_ajax', 'get_next_lightbox_photo_ajax');

add_action('wp_ajax_get_previous_lightbox_photo_ajax', 'get_previous_lightbox_photo_ajax');
add_action('wp_ajax_nopriv_get_previous_lightbox_photo_ajax', 'get_previous_lightbox_photo_ajax');


/* Fonction pour récupérer l'URL de l'image pour la lightbox */
function get_lightbox_image_url($attachment_id) {
    if (!$attachment_id) {
        return false;
    }

    // Récupérer les informations de l'image pour vérifier l'orientation
    $image_data = wp_get_attachment_metadata($attachment_id);
    if (!$image_data) {
        return false;
    }

    // Calculer l'orientation
    $orientation = ($image_data['width'] > $image_data['height']) ? 'landscape' : 'portrait';

    // Retourner l'URL de l'image en fonction de l'orientation
    if ($orientation === 'landscape') {
        return wp_get_attachment_image_url($attachment_id, 'photo-lightbox-landscape');
    } else {
        return wp_get_attachment_image_url($attachment_id, 'photo-lightbox-portrait');
    }
}

function enqueue_photo_gallery_scripts() {
    // Charger le script de la galerie
    wp_enqueue_script('photo-gallery', get_stylesheet_directory_uri() . '/js/photo-gallery.js', array(), null, true);

    // Passer les variables AJAX à JavaScript
    wp_localize_script('photo-gallery', 'lightbox_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('lightbox_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_photo_gallery_scripts');


function get_photo_data_ajax() {
    // Vérifier le nonce pour la sécurité
    check_ajax_referer('lightbox_nonce', 'security');

    // Vérifier l'ID de la photo
    $photo_id = isset($_POST['photo_id']) ? intval($_POST['photo_id']) : 0;
    if ($photo_id === 0) {
        wp_send_json_error('ID de la photo invalide.');
        return;
    }

    // Récupérer les informations de la photo
    $image_url = get_the_post_thumbnail_url($photo_id, 'full');
    $reference = get_field('reference', $photo_id);
    $category = wp_get_post_terms($photo_id, 'categorie')[0]->name ?? 'Non classé';

    // Vérification de l'URL de l'image
    if (!$image_url) {
        wp_send_json_error('Aucune image trouvée pour cette photo.');
        return;
    }

    // Envoyer la réponse en JSON
    wp_send_json_success([
        'id'        => $photo_id,
        'url'       => $image_url,
        'reference' => $reference,
        'category'  => $category
    ]);
}

// Enregistrer l'action AJAX pour les utilisateurs connectés et non connectés
add_action('wp_ajax_get_photo_data', 'get_photo_data_ajax');
add_action('wp_ajax_nopriv_get_photo_data', 'get_photo_data_ajax');
