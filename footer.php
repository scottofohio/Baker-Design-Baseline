<?php
/**
 * The Footer for the Baker Design Baseline Theme
 *
 *
 * @package WordPress
 * @subpackage Baker Design Theme 1.0
 * @since 2.0
 */
 ?>
</main> <!-- # end site container --> 

<footer class="site-footer">

    <div>
      <div class="footer-intro">
        <figure>
          <img src="<?php echo get_template_directory_uri() ?>/assets/img/logo.png" alt="">
        </figure>
        <nav>
         <ul class="nav social-nav">
           <li><a target="_blank" class="facebook" href="https://www.facebook.com/andyginther/">Facebook</a></li>
           <li><a target="_blank"  class="instagram" href="https://www.instagram.com/andyginther">Instagram</a></li>
           <li><a target="_blank"  class="twitter" href="https://twitter.com/andrewginther">Twitter</a></li>
         </ul>
        </nav>
      </div>

      <nav class="footer-nav ">
        <ul class="nav">
          <?php footer_navigation(); ?>
        </ul>
      </nav>
    </div>
  
  <nav class="secondary-footer-nav">
    <ul class="nav">
      <li><p>&copy; <?php echo date('Y'); ?>  <?php echo bloginfo('name'); ?></p> <!-- copyright --></li>
        <?php secondary_footer_nav(); ?>
    </ul>
    <ul class="nav">
      <li>Address</li>
      <li> Phone</li>
    </ul>
  </nav>
	
</footer>

<?php wp_footer(); ?>
</body>
</html>