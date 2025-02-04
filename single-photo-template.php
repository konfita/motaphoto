<?php
/*
Template Name: Single Photo Template
Template Post Type: photos
Description: Template pour afficher les photographies
*/
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 

    $ref = get_field('reference', get_the_ID());
?>
<section class="bloc-photo">
    <!-- Détails de la photo -->
    <?php get_template_part('template-parts/details-photo'); ?>

    <!-- Section "Cette photo vous intéresse ?" -->
    <div class="photo-contact flexrow">
        <p class="bloc-medium">
            Cette photo vous intéresse ?
            <button class="btn" type="button">
                <a class="open-contact-modal" data-refphoto="<?php echo esc_attr($ref); ?>">Contact</a>
            </button>
        </p>

        <!-- Navigation entre photos -->
        <div class="photo-navigation">
            <!-- <?php
                // Récupérer l'article suivant
                $next_post = get_next_post();
                if ($next_post) {
                    echo '<div class="current-photo">';
                    echo get_the_post_thumbnail($next_post->ID, 'large', ['class' => 'main-photo']);
                    echo '</div>';
                }
            ?> -->

            <div class="nav-arrows">
                <?php
                    // Flèche précédente
                    $prev_post = get_previous_post();
                    if ($prev_post) {
                        $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
                        $prev_post_id = $prev_post->ID;
                        $prev_thumbnail = get_the_post_thumbnail($prev_post_id, 'thumbnail'); // Récupère la miniature
                        echo '<a rel="prev" href="' . get_permalink($prev_post_id) . '" title="' . $prev_title . '" class="previous_post">';
                        echo '<span class="nav-arrow" data-thumbnail="' . esc_attr($prev_thumbnail) . '">‹</span></a>';
                    }
                    
                    $next_post = get_next_post();
                    if ($next_post) {
                        $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
                        $next_post_id = $next_post->ID;
                        $next_thumbnail = get_the_post_thumbnail($next_post_id, 'thumbnail'); // Récupère la miniature
                        echo '<a rel="next" href="' . get_permalink($next_post_id) . '" title="' . $next_title . '" class="next_post">';
                        echo '<span class="nav-arrow" data-thumbnail="' . esc_attr($next_thumbnail) . '">›</span></a>';
                    }
                ?>
            </div>
        </div>
        <div id="prev-thumbnail" class="hover-thumbnail"></div>
        <div id="next-thumbnail" class="hover-thumbnail"></div>
    </div>

    <!-- Section "Vous aimerez aussi" -->
    <div class="photo-others flexcolumn">
        <h2>Vous aimerez aussi</h2>        
        <div class="photo-others flexrow">
            <?php get_template_part('template-parts/photo-like'); ?>
        </div>
    </div>
</section>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
