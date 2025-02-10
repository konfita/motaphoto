<?php
$photo_id = get_the_ID();
$thumbnail_url = get_the_post_thumbnail_url($photo_id, 'large');
$reference = get_field('reference_photo', $photo_id);
$category = wp_get_post_terms($photo_id, 'categorie', array('fields' => 'names'));
?>

<div class="photo-item" data-id="<?php echo esc_attr($photo_id); ?>">
    <div class="photo-container">
        <?php if ($thumbnail_url) : ?>
            <?php the_post_thumbnail('medium', array(
                'class' => 'photo-thumbnail',
                'loading' => 'lazy'
            )); ?>
            
            <div class="photo-overlay">
                <button class="photo-expand" 
                        data-photo-id="<?php echo esc_attr($photo_id); ?>"
                        data-photo-src="<?php echo esc_url($thumbnail_url); ?>"
                        data-photo-ref="<?php echo esc_attr($reference); ?>"
                        data-photo-cat="<?php echo esc_attr(!empty($category[0]) ? $category[0] : ''); ?>">
                    <i class="fas fa-expand"></i>
                </button>

                <div class="photo-meta">
                    <span class="photo-reference"><?php echo esc_html($reference); ?></span>
                    <span class="photo-category"><?php echo esc_html(!empty($category[0]) ? $category[0] : ''); ?></span>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>