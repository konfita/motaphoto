<div class="photo-gallery">
    <div class="photo-grid">
        <?php
        // Récupérer les filtres via AJAX (POST) ou via l'URL (GET)
        $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : (isset($_GET['categorie']) ? sanitize_text_field($_GET['categorie']) : '');
        $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : (isset($_GET['format']) ? sanitize_text_field($_GET['format']) : '');

        // Construire la requête
        $meta_query = array('relation' => 'AND');
        if ($categorie) {
            $meta_query[] = array(
                'key' => 'categorie',
                'value' => $categorie,
                'compare' => '='
            );
        }
        if ($format) {
            $meta_query[] = array(
                'key' => 'format',
                'value' => $format,
                'compare' => '='
            );
        }

        // Requête WP_Query
        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => 8,
            'meta_query' => $meta_query,
        );

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
                        ?>
                        <a href="<?php echo esc_url($thumbnail_url); ?>" data-lightbox="gallery" data-title="<?php echo esc_attr(get_the_title()); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    <?php } ?>
                    <h2><?php the_title(); ?></h2>
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