<?php
// Inclure le header
get_header(); ?>

<form id="filters-form" method="GET" class="filters">
    <!-- Filtres à gauche -->
    <div class="filters-left">
        <div class="filter">
            <label for="categorie">Catégorie :</label>
            <select name="categorie" id="categorie">
                <option value="">Toutes</option>
                <option value="Mariage">Mariage</option>
                <option value="Réception">Réception</option>
                <option value="Concert">Concert</option>
                <option value="Télévision">Télévision</option>
            </select>
        </div>
        <div class="filter">
            <label for="format">Format :</label>
            <select name="format" id="format">
                <option value="">Tous</option>
                <option value="Paysage">Paysage</option>
                <option value="Portrait">Portrait</option>
            </select>
        </div>
    </div>

    <!-- Tri à droite -->
    <div class="filters-right">
        <div class="filter">
            <label for="sort-by">Trier par :</label>
            <select name="sort_by" id="sort-by">
                <option value="date_desc">Date (récent)</option>
                <option value="date_asc">Date (ancien)</option>
                <option value="title_asc">Titre (A-Z)</option>
                <option value="title_desc">Titre (Z-A)</option>
            </select>
        </div>
    </div>
</form>

<div class="photo-gallery">
    <div class="photo-grid">
        <?php
        // Récupérer les filtres
        $categorie = isset($_GET['categorie']) ? sanitize_text_field($_GET['categorie']) : '';
        $format = isset($_GET['format']) ? sanitize_text_field($_GET['format']) : '';

        // Construire la requête
        $meta_query = array('relation' => 'AND');
        if ($categorie) {
            $meta_query[] = array(
                'key' => 'categories',
                'value' => $categorie,
                'compare' => '='
            );
        }
        if ($format) {
            $meta_query[] = array(
                'key' => 'formats',
                'value' => $format,
                'compare' => '='
            );
        }

        // Requête WP_Query
        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => 8,
            'meta_query' => $meta_query,
        );
        $query = new WP_Query($args);

        // Boucle WordPress
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post(); ?>
                <div class="photo-item">
                    <?php
                    if (has_post_thumbnail()) {
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // URL de l'image pleine résolution
                        ?>
                        <a href="<?php echo esc_url($thumbnail_url); ?>" data-lightbox="gallery" data-title="<?php echo esc_attr(get_the_title()); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    <?php } ?>
                    <h2><?php the_title(); ?></h2>
                </div>
            <?php endwhile;
        else :
            echo '<p>Aucune photo trouvée.</p>';
        endif;

        // Réinitialiser les données post
        wp_reset_postdata();
        ?>
    </div>

    <!-- Bouton "Afficher plus" avec data-url -->
    <button id="load-more" class="btn-load-more" data-url="<?php echo esc_url( admin_url('admin-ajax.php') ); ?>">Afficher plus</button>
    
</div>

<?php
// Inclure le footer
get_footer();
?>
