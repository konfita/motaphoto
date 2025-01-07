<?php
// Inclure le header
get_header(); 
?>

<button id="open-modal">Contactez-nous</button>

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

<section class="photo-gallery">
    <?php get_template_part('template-parts/photo-gallery'); ?>
</section>

<?php
// Inclure le footer
get_footer();
?>
