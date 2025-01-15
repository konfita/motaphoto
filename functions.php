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

// Enqueue des fichiers JS et CSS 
function enqueue_contact_modale_assets() {
    wp_enqueue_script('modale-script', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
    wp_enqueue_script('filters-js', get_stylesheet_directory_uri() . '/js/filters.js', ['jquery'], null, true);

    // Localiser le script AJAX 
    wp_localize_script('filters-js', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));

}
add_action('wp_enqueue_scripts', 'enqueue_contact_modale_assets');

function enqueue_lightbox_scripts() {
    // Enqueue Lightbox CSS
    wp_enqueue_style('lightbox-css', get_stylesheet_directory_uri() . '/lightbox.css');

    // Enqueue Lightbox JS
    wp_enqueue_script('lightbox-js', get_stylesheet_directory_uri() . '/js/lightbox.js', array('jquery'), null, true);

    // Optionnel : Ajouter des options ou des configurations supplémentaires
    wp_add_inline_script('lightbox-js', 'lightbox.option({
        resizeDuration: 200,
        wrapAround: true,
        showImageNumberLabel: true,
        disableScrolling: true
    })');
}
add_action('wp_enqueue_scripts', 'enqueue_lightbox_scripts');

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
        'taxonomies' => array('category', 'post_tag'),
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
                    the_post_thumbnail('medium');
                }
                ?>
                <h2><?php the_title(); ?></h2>
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