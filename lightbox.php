<div class="photo-gallery">
    <div class="photo-grid">
        <?php
        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                if (has_post_thumbnail()) {
                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $photo_id = get_the_ID();
                    $photo_title = get_the_title();
        ?>
                <div class="photo-item">
                    <div class="photo-wrapper">
                        <a href="#" class="lightbox-trigger" data-src="<?php echo esc_url($thumbnail_url); ?>" data-title="<?php echo esc_attr($photo_title); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                            <div class="hover-overlay">
                                <span class="fullscreen-text">Plein écran</span>
                            </div>
                        </a>
                    </div>
                </div>
        <?php
                }
            endwhile;
        else :
            echo '<p>Aucune photo trouvée.</p>';
        endif;

        wp_reset_postdata();
        ?>
    </div>

    <button id="load-more" class="btn-load-more" data-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">Afficher plus</button>
</div>

<!-- Lightbox -->
<div id="lightbox" class="lightbox">
    <div class="lightbox-overlay"></div>
    <div class="lightbox-content">
        <img id="lightbox-image" src="" alt="">
        <div class="lightbox-info">
            <span id="lightbox-title"></span>
            <button class="lightbox-close">&times;</button>
            <button class="lightbox-prev">&#10094;</button>
            <button class="lightbox-next">&#10095;</button>
        </div>
    </div>
</div>
