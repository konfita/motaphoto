<div class="photo-gallery">
    <div class="photo-grid">
        <?php
        // Récupérer les filtres via AJAX (POST) ou via l'URL (GET)
        $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : (isset($_GET['categorie']) ? sanitize_text_field($_GET['categorie']) : '');
        $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : (isset($_GET['format']) ? sanitize_text_field($_GET['format']) : '');

        // Construire la requête WP_Query
        $args = array(
            'post_type'      => 'photos',
            'posts_per_page' => 8,
        );

        // Construire la tax_query pour filtrer les taxonomies
        $tax_query = array('relation' => 'AND');

        if (!empty($categorie)) {
            $tax_query[] = array(
                'taxonomy' => 'categorie', // Assurez-vous que cette taxonomie existe
                'field'    => 'slug',
                'terms'    => $categorie,
            );
        }

        if (!empty($format)) {
            $tax_query[] = array(
                'taxonomy' => 'format', // Assurez-vous que cette taxonomie existe
                'field'    => 'slug',
                'terms'    => $format,
            );
        }

        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }

        // Appliquer le tri si nécessaire
        $sort_by = isset($_POST['sort_by']) ? sanitize_text_field($_POST['sort_by']) : (isset($_GET['sort_by']) ? sanitize_text_field($_GET['sort_by']) : 'date_desc');
        if ($sort_by === 'date_asc') {
            $args['orderby'] = 'date';
            $args['order'] = 'ASC';
        } elseif ($sort_by === 'date_desc') {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        } elseif ($sort_by === 'title_asc') {
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
        } elseif ($sort_by === 'title_desc') {
            $args['orderby'] = 'title';
            $args['order'] = 'DESC';
        }

        $query = new WP_Query($args);

        // Boucle WordPress
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // URL de l'image pleine résolution
                $photo_id = get_the_ID();
                $photo_reference = get_field('reference', $photo_id, true);
                // var_dump($photo_reference);
                $category_terms = get_the_terms($photo_id, 'categorie');
                $category_name = (!empty($category_terms) && !is_wp_error($category_terms)) ? $category_terms[0]->name : '';
                ?>
                <div class="photo-item">
                    <div class="photo-overlay">
                        <a href="#" class="photo-expand"
                        data-photo-id="<?php echo esc_attr($photo_id); ?>"
                        data-url="<?php echo esc_url($thumbnail_url); ?>"
                        data-reference="<?php echo esc_html($photo_reference); ?>"
                        data-category="<?php echo esc_html($category_name); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                            <span class="fullscreen-icon">🔍</span> <!-- Icône plein écran -->
                        </a>
                    </div>
                </div>
            <?php endwhile;
        else :
            echo '<p>Aucune photo trouvée.</p>';
        endif;

        // Réinitialiser les données post
        wp_reset_postdata();
        ?>
    </div>

    <!-- Bouton "Afficher plus" avec data-url -->
    <button id="load-more" class="btn-load-more" data-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">Afficher plus</button>
    <?php get_template_part('template-parts/lightbox'); ?>
</div>

<!-- Inclure le script photo-gallery.js -->
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/photo-gallery.js"></script>
