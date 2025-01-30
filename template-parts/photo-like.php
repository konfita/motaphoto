<?php 
$categorie_id = get_field('categorie', get_queried_object_id());

if (empty($categorie_id)) {
    echo 'Aucune catégorie trouvée pour cette publication.';
    return;
}

$custom_args = array(
    'post_type' => 'photos',
    'posts_per_page' => 2,
    'meta_query' => [
        ['key' => 'categorie', 'value' => $categorie_id, 'compare' => '=']
    ],
    'post__not_in' => array(get_queried_object_id()),
);

$query = new WP_Query($custom_args);
?>

<?php if ($query->have_posts()) : ?>
    <article class="container-common flexrow">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="news-info brightness">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="thumbnail">
                        <!-- Lien vers la page single -->
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" aria-label="Voir plus sur <?php the_title(); ?>">
                            <?php the_post_thumbnail('desktop-home'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </article>
<?php else : ?>
    <p>Désolé, aucun article ne correspond à cette requête.</p>
<?php endif;

wp_reset_query();
?>