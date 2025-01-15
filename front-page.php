<?php
// Inclure le header
get_header(); 
?>

<div class="hero">
    <img class="hero__background" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/nathalie-11.jpeg" alt="Photo d'événement">
    <h1>Photographe Event</h1>
</div>

<form id="filters-form" method="GET" class="filters">
    <!-- Filtres à gauche -->
    <div class="filters-left">
        <div class="filter">
            <select name="categorie" id="categorie">
                <option value="" disabled selected>Catégorie</option>
                <option value="Mariage">Mariage</option>
                <option value="Réception">Réception</option>
                <option value="Concert">Concert</option>
                <option value="Télévision">Télévision</option>
            </select>
        </div>
        <div class="filter">
            <select name="format" id="format">
                <option value="" disabled selected>Format</option>
                <option value="Paysage">Paysage</option>
                <option value="Portrait">Portrait</option>
            </select>
        </div>
    </div>

    <!-- Tri à droite -->
    <div class="filters-right">
        <div class="filter">
            <select name="sort_by" id="sort-by">
                <option value="" disabled selected>Tri</option>
                <option value="date_desc">Date (récent)</option>
                <option value="date_asc">Date (ancien)</option>
                <option value="title_asc">Titre (A-Z)</option>
                <option value="title_desc">Titre (Z-A)</option>
            </select>
        </div>
    </div>
</form>



<section class="photo-gallery">
    <?php get_template_part('template-parts/photo-gallery'); ?>
</section>

<?php
// Inclure le footer
get_footer();
?>