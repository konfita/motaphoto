<?php
// Chargement du CSS du thème parent
function motaphoto_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'motaphoto_child_enqueue_styles');

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

// Ajoutez une fonction pour gérer la requête AJAX 
function load_more_photos() {
    $page = $_POST['page'];

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'paged' => $page,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="photo-item">
                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail('medium');
                }
                ?>
                <h2><?php the_title(); ?></h2>
            </div>
        <?php endwhile;
    endif;

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


// Fonction AJAX pour charger et filtrer les photos
function load_and_filter_photos() {
    parse_str($_POST['form_data'], $form_data);

    $page = isset($form_data['page']) ? intval($form_data['page']) : 1;

    $meta_query = array('relation' => 'AND');
    if (!empty($form_data['categorie'])) {
        $meta_query[] = array(
            'key' => 'categories',
            'value' => $form_data['categorie'],
            'compare' => '='
        );
    }
    if (!empty($form_data['format'])) {
        $meta_query[] = array(
            'key' => 'formats',
            'value' => $form_data['format'],
            'compare' => '='
        );
    }

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'paged' => $page,
        'meta_query' => $meta_query,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="photo-item">
                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail('medium');
                }
                ?>
                <h2><?php the_title(); ?></h2>
            </div>
        <?php endwhile;
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_load_and_filter_photos', 'load_and_filter_photos');
add_action('wp_ajax_nopriv_load_and_filter_photos', 'load_and_filter_photos');
