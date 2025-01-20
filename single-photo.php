<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section class="details-photo">
        <?php get_template_part('template-parts/details-photo'); ?>
        
        <div class="photo__contact flexrow">
            <p>Cette photo vous intéresse ? <button class="btn" type="button"><a href="#" class="contact">Contact</a></button></p>
            <div class="site__navigation flexrow">                
                <div class="site__navigation__prev">
                    <?php
                    $prev_post = get_previous_post();                            
                    if ($prev_post) {
                        $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
                        $prev_post_id = $prev_post->ID;
                        echo '<a rel="prev" href="' . get_permalink($prev_post_id) . '" title="' . $prev_title . '" class="previous_post">';
                        if (has_post_thumbnail($prev_post_id)) {
                            echo '<div>' . get_the_post_thumbnail($prev_post_id, array(77, 60)) . '</div>';
                        } else {
                            echo '<img src="' . get_stylesheet_directory_uri() . '/assets/imgages/no-image.jpeg" alt="Pas de photo" width="77px"><br>';
                        }
                        echo '<img src="' . get_stylesheet_directory_uri() . '/assets/imgages/prev.png" alt="Photo précédente"></a>';
                    }
                    ?>
                </div>
                <div class="site__navigation__next">
                    <?php
                    $next_post = get_next_post();
                    if ($next_post) {
                        $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
                        $next_post_id = $next_post->ID;
                        echo '<a rel="next" href="' . get_permalink($next_post_id) . '" title="' . $next_title . '" class="next_post">';
                        if (has_post_thumbnail($next_post_id)) {
                            echo '<div>' . get_the_post_thumbnail($next_post_id, array(77, 60)) . '</div>';
                        } else {
                            echo '<img src="' . get_stylesheet_directory_uri() . '/assets/imgages/no-image.jpeg" alt="Pas de photo" width="77px"><br>';
                        }
                        echo '<img src="' . get_stylesheet_directory_uri() . '/assets/imgages/next.png" alt="Photo suivante"></a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="photo__others flexcolumn">
            <h2>Vous aimerez aussi</h2>        
            <div class="photo__others--images flexrow">
                <?php get_template_part('template-parts/photo-like'); ?>
                <button class="btn btn-all-photos" type="button">
                    <a href="<?php echo home_url('/'); ?>" aria-label="Page d'accueil">Toutes les photos</a>
                </button>
            </div>
        </div>
    </section>
<?php endwhile; endif; ?>

<?php get_footer(); ?>