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
            <?php
                // Récupérer l'article suivant
                $next_post = get_next_post();
                if ($next_post) {
                    echo '<div class="current-photo">';
                    echo get_the_post_thumbnail($next_post->ID, 'large', ['class' => 'main-photo']);
                    echo '</div>';
                }
            ?>

            <div class="nav-arrows">
                <?php
                    // Flèche précédente
                    $prev_post = get_previous_post();
                    if ($prev_post) {
                        echo '<a rel="prev" href="' . get_permalink($prev_post) . '" class="nav-arrow prev-arrow">‹</a>';
                    }

                    // Flèche suivante
                    $next_post = get_next_post();
                    if ($next_post) {
                        echo '<a rel="next" href="' . get_permalink($next_post) . '" class="nav-arrow next-arrow">›</a>';
                    }
                ?>
            </div>
        </div>

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
