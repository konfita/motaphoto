<?php
/**
 * The single photo template.
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */

get_header();
?>

<?php
if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section class="photo_detail">
        <!-- Titre de la photo -->
        <h1><?php the_title(); ?></h1>

        <!-- Photo mise en avant avec Lightbox -->
        <div class="photo-image">
            <?php
            if (has_post_thumbnail()) {
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // URL de l'image en pleine résolution
            ?>
                <a href="<?php echo esc_url($thumbnail_url); ?>" data-lightbox="gallery" data-title="<?php echo esc_attr(get_the_title()); ?>">
                    <?php the_post_thumbnail('large'); ?>
                </a>
            <?php } else {
                echo '<img src="' . get_stylesheet_directory_uri() . '/assets/img/no-image.jpeg" alt="Pas de photo">';
            } ?>
        </div>

        <!-- Métadonnées de la photo -->
        <div class="photo-meta">
            <?php
            // Référence, Année, Type
            $reference = get_post_meta(get_the_ID(), 'reference', true);
            $annee = get_post_meta(get_the_ID(), 'annee', true);
            $type = get_post_meta(get_the_ID(), 'type', true);

            if ($reference) {
                echo '<p><strong>Référence :</strong> ' . esc_html($reference) . '</p>';
            }
            if ($annee) {
                echo '<p><strong>Année :</strong> ' . esc_html($annee) . '</p>';
            }
            if ($type) {
                echo '<p><strong>Type :</strong> ' . esc_html($type) . '</p>';
            }

            // Catégorie et Format
            $categories = get_the_terms(get_the_ID(), 'category');
            $formats = get_the_terms(get_the_ID(), 'format');

            if ($categories && !is_wp_error($categories)) {
                echo '<p><strong>Catégorie :</strong> ';
                foreach ($categories as $category) {
                    echo esc_html($category->name) . ' ';
                }
                echo '</p>';
            }

            if ($formats && !is_wp_error($formats)) {
                echo '<p><strong>Format :</strong> ';
                foreach ($formats as $format) {
                    echo esc_html($format->name) . ' ';
                }
                echo '</p>';
            }
            ?>
        </div>

        <!-- Bouton de contact -->
        <div class="photo__contact flexrow">
            <p>Cette photo vous intéresse ? <button class="btn" type="button"><a href="#" class="contact">Contact</a></button></p>
        </div>

        <!-- Navigation entre les photos précédentes et suivantes -->
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
                        echo '<img src="' . get_stylesheet_directory_uri() . '/assets/img/no-image.jpeg" alt="Pas de photo" width="77px"><br>';
                    }
                    echo '<img src="' . get_stylesheet_directory_uri() . '/assets/img/precedent.png" alt="Photo précédente"></a>';
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
                        echo '<img src="' . get_stylesheet_directory_uri() . '/assets/img/no-image.jpeg" alt="Pas de photo" width="77px"><br>';
                    }
                    echo '<img src="' . get_stylesheet_directory_uri() . '/assets/img/suivant.png" alt="Photo suivante"></a>';
                }
                ?>
            </div>
        </div>

        <!-- Suggestions d'autres photos -->
        <div class="photo__others flexcolumn">
            <h2>Vous aimerez aussi</h2>
            <div class="photo__others--images flexrow">
                <?php
                // Récupérer des photos similaires
                $args = array(
                    'post_type' => 'photo',
                    'posts_per_page' => 4,
                    'post__not_in' => array(get_the_ID()),
                );
                $related_photos = new WP_Query($args);
                if ($related_photos->have_posts()) :
                    while ($related_photos->have_posts()) : $related_photos->the_post();
                        get_template_part('template-parts/post/photo-common');
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            <button class="btn btn-all-photos" type="button">
                <a href="<?php echo home_url('/'); ?>" aria-label="Page d'accueil de Nathalie Mota">Toutes les photos</a>
            </button>
        </div>
    </section>
<?php endwhile; endif; ?>

<?php get_footer(); ?>