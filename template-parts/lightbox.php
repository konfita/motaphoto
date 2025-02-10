<div id="lightbox-overlay" class="lightbox-overlay" style="display: none;">
    <div class="lightbox-content">

        <button class="lightbox-close">
        <span>x</span>
        </button>

        <button class="lightbox-prev" id="prevArrowLightbox">
        <span><</span><span class="description-photo">   Précédente</span>
        </button>

        <div class="lightbox-image-container">
            <img src="" alt="" class="lightbox-image">
        </div>

        <button class="lightbox-next" id="nextArrowLightbox">
            <span class="description-photo">Suivante   </span><span>></span>
        </button>

        <div class="lightbox-info">
            <span class="lightbox-reference description-photo">
                <?php echo esc_html(get_field('reference_photo')); ?>
            </span>
            <span class="lightbox-category description-photo">
                <?php
                // Récupérer la première catégorie associée à la taxonomie 'evenement'
                $terms = get_the_terms(get_the_ID(), 'evenement');
                if ($terms && !is_wp_error($terms)) {
                    echo esc_html($terms[0]->name);
                }
                ?>
            </span>
        </div>
    </div>
</div>
