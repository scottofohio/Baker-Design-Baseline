<?php
/**
 * Sidebar
 * 
 * @package WordPress
 * @subpackage BakerDesign
 * @since 2.0
 **************************************************************** 
 ****************************************************************/
if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) || is_active_sidebar( 'sidebar' )  ) : ?>
	<div id="secondary" class="secondary">

		<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
			<div id="widget-area" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar' ); ?>
			</div><!-- .widget-area -->
			
		<?php endif; ?>

	</div><!-- .secondary -->

<?php endif; ?>
