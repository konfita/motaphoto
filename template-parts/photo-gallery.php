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
            while ($query->have_posts()) : $query->the_post(); ?>
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
</div>
