<?php
/***********************************************************************

BakerDesign
All Navigation Settings

/***********************************************************************/

/**
 * Main navigation menu functions
 *
 * @return str
 */
if ( ! function_exists( 'site_menus' ) ) {
    function site_menus($theme_location) {
        $nav_params = array(
          'theme_location' => $theme_location,
          'container' => false,
          'items_wrap' => '%3$s'
        ); 
        wp_nav_menu($nav_params);
    }
}

/**
 * Register site nav menus
 *
 * @return str
 */
register_nav_menus(array(
  'primary-nav' => 'Primary Navigation',
  'utility-nav' => 'Utility Navigation',
  'footer-nav' => 'Footer Navigation'
));

/**
 * Drop-in numeric pagination for archives, search results, etc.
 *
 * @return str
 */
function my_get_pagination() {
  global $wp_query;

    $big = 999999999; // Codex-sanctioned hack for search/archive pagination
    $args = array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'current' => max( 1, get_query_var( 'paged' ) ),
        'format' => '?paged=%#%',
        'end_size' => 3,
        'mid_size' => 2,
        'next_text' => __( '<span>Next</span>&raquo;', '%Text_Domain%' ),
        'prev_text' => __( '&laquo;<span>Previous</span>', '%Text_Domain%' ),
        'total' => $wp_query->max_num_pages,
        'before_page_number' => sprintf( '<span class="screen-reader-text">%s </span>', __( 'Page', '%Text_Domain%' ) ),
        'type' => 'list'
    );
    return paginate_links( $args );
}

/**
* Create previous/next post links
*
* @return str
*
* @uses get_previous_posts_link()
* @uses get_next_posts_link()
*/
function my_post_nav_links() {
    $nav = '';
    if ( $next = get_next_posts_link( __( '&laquo; Older Posts', '%Text_Domain%' ) ) ) {
        $nav .= sprintf( '<li class="next">%s</li>', $next );
    }
    if ( $prev = get_previous_posts_link( __( 'Newer Posts &raquo;', '%Text_Domain%' ) ) ) {
        $nav .= sprintf( '<li class="prev">%s</li>', $prev );
    }
    return ( $nav ? sprintf( '<ul class="post-nav-links">%s</ul>', str_replace('/page/', '/', $nav) ) : '' );
}





function breadcrumbs() {
  global $post;
  if (!is_front_page()) {
    echo '<nav class="breadcrumb">';

    echo '<a class="breadcrumb-item" href="'. get_bloginfo('url') .'">Home</a>';
    if ($ancestors = get_ancestors($post->ID, 'page', 'post_type')) {
        foreach ($ancestors as $ancestor) {
            echo '<a class="breadcrumb-item" href="'. get_the_permalink($ancestor) .'">' . get_the_title($ancestor) . '</a>';
        }
    }
    echo '<span class="breadcrumb-item active">' . get_the_title() . '</a>';

    echo '</nav>';
  }
}

add_action( 'admin_head-nav-menus.php', function() {
  add_meta_box( 'plugin-slug-menu-metabox', "Menu for Location", 'wpdocs_plugin_slug_render_menu_metabox', 'nav-menus', 'side', 'default', array( /*custom params*/ ) );
} );

function wpdocs_plugin_slug_render_menu_metabox( $object, $args )
{
global $nav_menu_selected_id;
// Create an array of objects that imitate Post objects

$menu_object = array(
  (object) array(
  
  )
  );
$menu_locations = get_posts(array('post_type' => 'locations', 'numberposts' => -1));

$count = 0;
foreach($menu_locations as $men_loc) {
  $menu_object[$count]->ID = $men_loc->ID;
  $menu_object[$count]->object_id = $men_loc->ID;
  $menu_object[$count]->db_id = $men_loc->ID;
  $menu_object[$count]->url = get_bloginfo('url') . '/menu/?location-menu=' . $men_loc->post_name;
  $menu_object[$count]->title = $men_loc->post_title;
  $menu_object[$count]->type = 'custom';
  $menu_object[$count]->type_label = $men_loc->post_title;
  $menu_object[$count]->classes = array();
  $menu_object[$count]->object = 'custom';
  $menu_object[$count]->menu_item_parent = '0';
  $menu_object[$count]->post_parent = '0';
  $menu_object[$count]->target = '';
  $menu_object[$count]->attr_title = '';
  $menu_object[$count]->description = '';
  $menu_object[$count]->xfn = '';
  $count++;
}


$db_fields = false;
// If your links will be hierarchical, adjust the $db_fields array below
if ( false ) { 
  $db_fields = array( 'parent' => 'parent', 'id' => 'post_parent' ); 
}

$walker = new Walker_Nav_Menu_Checklist( $db_fields );
$removed_args = array( 'action', 'customlink-tab', 'edit-menu-item', 'menu-item', 'page-tab', '_wpnonce', );
?>
<div id="plugin-slug-div">
  <div id="tabs-panel-plugin-slug-all" class="tabs-panel tabs-panel-active">
  <ul id="plugin-slug-checklist-pop" class="categorychecklist form-no-clear" >
    <?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $menu_object ), 0, (object) array( 'walker' => $walker ) ); ?>
  </ul>
  <p class="button-controls">
    <span class="add-to-menu">
      <input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-plugin-slug-menu-item" id="submit-plugin-slug-div" />
      <span class="spinner"></span>
    </span>
  </p>
</div>
<?php
}