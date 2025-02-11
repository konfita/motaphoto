<div class="photo-gallery">
    <div class="photo-grid">
        <?php
        $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : (isset($_GET['categorie']) ? sanitize_text_field($_GET['categorie']) : '');
        $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : (isset($_GET['format']) ? sanitize_text_field($_GET['format']) : '');

        $args = array(
            'post_type'      => 'photos',
            'posts_per_page' => 8,
        );

        $tax_query = array('relation' => 'AND');

        if (!empty($categorie)) {
            $tax_query[] = array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => $categorie,
            );
        }

        if (!empty($format)) {
            $tax_query[] = array(
                'taxonomy' => 'format',
                'field'    => 'slug',
                'terms'    => $format,
            );
        }

        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $photo_id = get_the_ID();
                $photo_reference = get_field('reference', $photo_id, true);
                $category_terms = get_the_terms($photo_id, 'categorie');
                $category_name = (!empty($category_terms) && !is_wp_error($category_terms)) ? $category_terms[0]->name : '';
                ?>
                <div class="photo-item">
                    <div class="photo-overlay">
                        <?php the_post_thumbnail('medium'); ?>

                        <!-- Icône plein écran (lightbox) -->
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icon_fullscreen.png" 
                            alt="Plein écran" 
                            class="fullscreen-icon" 
                            data-photo-id="<?php echo esc_attr($photo_id); ?>"
                            data-url="<?php echo esc_url($thumbnail_url); ?>" 
                            data-reference="<?php echo esc_html($photo_reference); ?>"
                            data-category="<?php echo esc_html($category_name); ?>">

                        <!-- Icône œil (lien vers single-photo-template.php) -->
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
                    </div>
                </div>
            <?php endwhile;
        else :
            echo '<p>Aucune photo trouvée.</p>';
        endif;
        wp_reset_postdata();
        ?>
    </div>
    <button id="load-more" class="btn-load-more" data-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">Afficher plus</button>
</div>
