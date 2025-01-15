</main>

<footer class="footer">
  <nav class="footer__nav">
    <?php
      if (has_nav_menu('footer')) {
        wp_nav_menu(array(
          'theme_location' => 'footer',
          'menu_class' => 'footer-menu',
        ));
      }
    ?>
  </nav>
  <?php wp_footer() ?>
</footer>

</body>
</html>

</main>
