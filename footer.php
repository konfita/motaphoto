</main>

<footer class="footer">
  <nav class="footer__nav">
    <?php
      if (has_nav_menu('footer_menu')) {
        wp_nav_menu(array(
          'theme_location' => 'footer_menu', // Utilisez 'footer_menu' ici
          'menu_class' => 'footer-menu',
        ));
      } else {
        echo '<p>Aucun menu footer n\'est défini.</p>';
      }
    ?>
  </nav>
  <div class="lightbox-overlay">
    <div class="lightbox-content">
        <span class="close-lightbox">&times;</span>
        <img src="" class="lightbox-image">
        <div class="lightbox-info">
            <span class="photo-title"></span>
            <div class="lightbox-navigation">
                <button class="prev-photo">Précédente</button>
                <button class="next-photo">Suivante</button>
            </div>
        </div>
    </div>
  </div>
  <?php wp_footer(); ?>
</footer>

</body>
</html>

</main>
