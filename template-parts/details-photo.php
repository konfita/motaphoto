<?php 
    // Récupération des taxonomies
    $categorie_terms = get_the_terms(get_the_ID(), 'categorie');
    $format_terms = get_the_terms(get_the_ID(), 'format');

    // Transformer en chaînes de caractères
    $categorie = $categorie_terms ? implode(', ', wp_list_pluck($categorie_terms, 'name')) : 'Inconnue';
    $format = $format_terms ? implode(', ', wp_list_pluck($format_terms, 'name')) : 'Inconnu';
    $reference = get_field('reference');
    $type = get_field('type');
    $annee = get_field('annee');
?>  

<article class="container-photo">
    <div class="bloc-photo-info">
        <div class="photo-info">
            <h1><?php the_title(); ?></h1>
            <ul>
                <li>Référence : <span class="photo-reference"><?php echo $reference ?: 'Inconnue'; ?></span></li>
                <li>Catégorie : <?php echo $categorie ?: 'Inconnue'; ?></li>
                <li>Format : <?php echo $format ?: 'Inconnu'; ?></li>
                <li>Type : <?php echo $type ?: 'Inconnu'; ?></li>
                <li>Année : <?php echo $annee; ?></li>
            </ul>
        </div>
        <div class="photo-photo">
            <div class="container brightness">
                <?php the_post_thumbnail('medium_large', ['alt' => get_the_title()]); ?>
            </div>
        </div>
    </div>
</article>

