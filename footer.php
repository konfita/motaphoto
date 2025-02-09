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
  <?php wp_footer(); ?>
</footer>

</body>
</html>

</main>
