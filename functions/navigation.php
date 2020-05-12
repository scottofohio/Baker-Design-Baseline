<?php
/***********************************************************************

Baker Design Theme 1.0
All Navigation Settings

/***********************************************************************/

/**
 * Main navigation menu functions
 *
 * @return str
 */
if ( ! function_exists( 'primary_navigation' ) ) {
    function primary_navigation() {
        wp_nav_menu(array(
          'theme_location' => 'primary-nav',
          'depth' => 2,
          'container' => false,
          'items_wrap' => '%3$s',
          'walker' => new wp_bootstrap_navwalker()
          )
        );
    }
}
if ( ! function_exists( 'footer_navigation' ) ) {
    function footer_navigation() {
        wp_nav_menu(array(
            'container' => false,
            'items_wrap' => '%3$s',
            'theme_location' => 'footer-nav'
        ));
    }
}
if ( ! function_exists( 'utility_navigation' ) ) {
    function utility_navigation() {
        wp_nav_menu(array(
            'theme_location' => 'utility-nav',
            'depth' => 1,
            'container' => false,
            'items_wrap' => '%3$s',
            'walker' => new wp_bootstrap_navwalker()
        ));
    }
}
if ( ! function_exists( 'secondary_footer_nav' ) ) {
  function secondary_footer_nav() {
      wp_nav_menu(array(
          'theme_location' => 'secondary-footer-nav',
          'container' => false,
          'items_wrap' => '%3$s'
      ));
  }
}

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

/**
 * Register site nav menus
 *
 * @return str
 */
register_nav_menus(array(
    'primary-nav' => 'Primary Navigation',
    'utility-nav' => 'Utility Navigation',
    'footer-nav' => 'Footer Navigation',
    'secondary-footer-nav' => 'Secondary Footer'
));



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