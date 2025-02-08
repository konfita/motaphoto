<div class="lightbox-overlay" id="lightbox-overlay"></div>

<div class="lightbox hidden" id="lightbox-container">
    <button class="lightbox__close btn-close" id="close-lightbox" type="button">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/close.png" alt="Fermer la lightbox" />
    </button>

    <div class="lightbox__content">
        <div class="lightbox__image">
            <img id="lightbox-img" src="" alt="Image en plein écran">
        </div>
        <div class="lightbox__info">
            <h2 id="lightbox-title"></h2>
            <div class="lightbox__nav">
                <button class="lightbox__prev nav-button">← Précédent</button>
                <button class="lightbox__next nav-button">Suivant →</button>
            </div>
        </div>
    </div>

    <!-- Zone où le contenu AJAX sera injecté -->
    <div id="lightbox__container_content" class="hidden">
        <div class="lightbox__loader">Chargement...</div>
    </div>
</div>
