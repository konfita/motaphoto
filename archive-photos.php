<?php
// Inclure le header
get_header(); ?>

<div class="archive-photos">
    <h1>Galerie de photos</h1>
    <div class="photo-list">
        <?php
        // Boucle WordPress pour afficher une liste de publications
        if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <div class="photo-item">
                    <!-- Affichage de la photo mise en avant avec lightbox -->
                    <?php
                    if (has_post_thumbnail()) {
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // URL de l'image pleine résolution
                        ?>
                        <a href="<?php echo esc_url($thumbnail_url); ?>" data-lightbox="gallery" data-title="<?php echo esc_attr(get_the_title()); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    <?php } ?>

                    <!-- Titre de la photo -->
                    <h2><?php the_title(); ?></h2>

                    <!-- Champs personnalisés (SCF) -->
                    <?php
                    $reference = get_post_meta(get_the_ID(), 'reference', true);
                    $categorie = get_post_meta(get_the_ID(), 'categorie', true);
                    $annee = get_post_meta(get_the_ID(), 'annee', true);
                    $format = get_post_meta(get_the_ID(), 'format', true);
                    $type = get_post_meta(get_the_ID(), 'type', true);

                    if ($reference) {
                        echo '<p><strong>Référence :</strong> ' . esc_html($reference) . '</p>';
                    }
                    if ($categorie) {
                        echo '<p><strong>Catégorie :</strong> ' . esc_html($categorie) . '</p>';
                    }
                    if ($annee) {
                        echo '<p><strong>Année :</strong> ' . esc_html($annee) . '</p>';
                    }
                    if ($format) {
                        echo '<p><strong>Format :</strong> ' . esc_html($format) . '</p>';
                    }
                    if ($type) {
                        echo '<p><strong>Type :</strong> ' . esc_html($type) . '</p>';
                    }
                    ?>
                </div>
            <?php endwhile;
        else :
            echo '<p>Aucune photo trouvée.</p>';
        endif;
        ?>
    </div>
</div>

<?php
// Inclure le footer
get_footer();
?>
