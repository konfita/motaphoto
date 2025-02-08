document.addEventListener("DOMContentLoaded", function () {
  (function ($) {
      $(document).ready(function () {
          // Vérifier si on est sur la page d'accueil (front-page.php)
          if (!$("body").hasClass("home")) {
              return; // Arrêter le script si ce n'est pas la page d'accueil
          }

          let idPhoto = null;
          let idValue = 0;
          let totalPhotos = $(".photo-item img");
          let nbTotalPhotos = totalPhotos.length;

          // Fonction pour afficher la lightbox
          function showLightbox(index) {
              idValue = index;
              idPhoto = $(totalPhotos[index]).data("postid");
              updateLightbox();
              $(".lightbox").addClass("active");
              $(".lightbox-overlay").addClass("active");
          }

          // Fonction pour fermer la lightbox
          function closeLightbox() {
              $(".lightbox").removeClass("active");
              $(".lightbox-overlay").removeClass("active");
          }

          // Afficher la lightbox au survol
          $(".photo-item img").mouseenter(function () {
              let index = totalPhotos.index(this);
              showLightbox(index);
          });

          // Fermeture au passage de la souris hors de l'image
          $(".lightbox").mouseleave(closeLightbox);

          // Fermeture avec la touche Échap
          $("body").keyup(function (e) {
              if (e.key === "Escape") closeLightbox();
          });
      });
  })(jQuery);
});
