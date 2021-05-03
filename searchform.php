<?php
/**
 * Search Form
 *
 * @package WordPress
 * @subpackage BakerDesign
 * @since 2.0
 ****************************************************************/
?>

<form method="get" action="<?php echo home_url( '/' ); ?>" class="search" role="search">
  <label for="<?php echo $search_input_id; ?>" class="screen-reader-text"><?php _e( 'Search for:', '%Text_Domain%' ); ?></label>
  <input type="text" name="s" id="<?php echo $search_input_id; ?>" value="<?php the_search_query(); ?>" />
  <button class="button" type="submit" value="<?php echo esc_attr( __( 'Search', '%Text_Domain%' ) ); ?>"><?php _e( 'Search', '%Text_Domain%' ); ?></button>
</form><!-- form.search -->
