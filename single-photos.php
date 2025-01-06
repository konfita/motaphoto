<?php
// Inclure le header
get_header(); ?>

<div class="single-photos">
    <?php
    // Boucle WordPress
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <div class="photo-details">
                <!-- Titre de la photo -->
                <h1><?php the_title(); ?></h1>

                <!-- Photo mise en avant -->
                <div class="photo-image">
                    <?php
                        if (has_post_thumbnail()) {
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // URL de l'image pleine résolution
                    ?>
                    <a href="<?php echo esc_url($thumbnail_url); ?>" data-lightbox="gallery" data-title="<?php echo esc_attr(get_the_title()); ?>">
                        <?php the_post_thumbnail('large'); ?>
                    </a>
                    <?php } ?>
                </div>


                <!-- Champs personnalisés -->
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

                    // Catégorie et Format (SCF)
                    $categorie = get_post_meta(get_the_ID(), 'categories', true); // Remplacez par votre slug SCF
                    $format = get_post_meta(get_the_ID(), 'formats', true); // Remplacez par votre slug SCF

                    if ($categorie) {
                        echo '<p><strong>Catégorie :</strong> ' . esc_html($categorie) . '</p>';
                    }
                    if ($format) {
                        echo '<p><strong>Format :</strong> ' . esc_html($format) . '</p>';
                    }
                    ?>
                </div>
            </div>
        <?php
        endwhile;
    endif;
    ?>
</div>

<?php
// Inclure le footer
get_footer();
?>
