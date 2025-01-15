</main>

<footer class="footer">
  <div class="footer-container">
    <nav class="footer__nav">
      <?php
        if (has_nav_menu('footer_menu')) {
            wp_nav_menu(array(
                'theme_location' => 'footer_menu',
                'menu_class'     => 'footer__menu',
                'container'      => false,
            ));
        }
      ?>
    </nav>
    <?php wp_footer(); ?>
  </div>

</footer>

</body>
</html>

