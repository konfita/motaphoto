<?php 
    // Vérifier l'activation de SCF
    if ( !class_exists('SCF')) return;

    // Récupération des champs SCF
    $categorie  = SCF::get('categorie');
    $format = SCF::get('format');
    $reference = SCF::get('reference');
    $type = SCF::get('type');
    $annee = SCF::get('annee');
    $essais = SCF::get('categorie');
?>

<article class="container__photo flexcolumn">
    <div class="photo__info flexrow">
        <div class="photo__info--description flexcolumn">
            <h1><?php the_title(); ?></h1>
            <ul class="flexcolumn">
                <!-- Affiche les données SCF -->
                <li class="reference">Référence : 
                    <?php 
                        if($reference) {
                            echo $reference;
                        } else {
                            echo ('Inconnue');
                        }
                    ?>
                </li>
                <li>Catégorie :
                    <?php 
                        if($categorie) {
                            echo $categorie;
                        } else {
                            echo ('Inconnue');
                        }
                    ?>
                </li>
                <li>Format :             
                    <?php 
                        if($format) {
                            echo $format;
                        } else {
                            echo ('Inconnu');
                        }
                    ?>
                </li>
                <li>Type :              
                    <?php 
                        if($type) {
                            echo $type;
                        } else {
                            echo ('Inconnu');
                        }
                    ?>
                </li>
                <li>Année : 
                    <?php echo the_time( 'Y' ); ?>
                </li>
            </ul>
        </div>
        <div class="photo__info--image flexcolumn">
            <div class="container--image brightness">
                <!-- permet d’afficher l’image mise en avant -->
                <?php the_post_thumbnail('medium_large'); ?>            
                <span class="openLightbox"></span>
            </div>                     
            <form>
                <input type="hidden" name="postid" class="postid" value="<?php the_id(); ?>">
                <button class="openLightbox" title="Afficher la photo en plein écran" alt="Afficher la photo en plein écran"
                    data-postid="<?php echo get_the_id(); ?>"       
                    data-arrow="false"
                    data-nonce="<?php echo wp_create_nonce('motaphoto_lightbox'); ?>"
                    data-action="motaphoto_lightbox"
                    data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>"
                >
                </button>
            </form>
        </div>         
    </div>
</article>

