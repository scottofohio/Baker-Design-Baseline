<?php
/**
 * The Footer for the Baker Design Baseline Theme
 *
 *
 * @package WordPress
 * @subpackage BakerDesign
 * @since 2.0
 */
 ?>
</main> <!-- # end site container --> 
<footer class="site-footer">
<p class="copyright">&copy; <?php the_date('Y');  ?>  SITE NAME </p>
  <nav class="footer-nav">
    <ul>
      <?php site_menus('footer-nav'); ?>
    </ul>
  </nav>
</footer>
<?php wp_footer(); ?>
</body>
</html>