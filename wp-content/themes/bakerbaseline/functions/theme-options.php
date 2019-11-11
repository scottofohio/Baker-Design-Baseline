<?php

/***********************************************************************

Baker Design Theme 1.0
General Options and functions

/***********************************************************************/

/**
 * Add filters
 **/

add_post_type_support('page', 'excerpt');
add_theme_support('post-thumbnails');

/*
 * Create Thumbnail sizes
 */

add_image_size('fullsize1400', 1400, 700, array('center', 'center'));
add_image_size('fullsize1200', 1200, 330, array('center', 'center'));
add_image_size('square500', 500, 500, array('center', 'center'));
add_image_size('square300', 300, 300, array('center', 'center'));
add_image_size("600X400", 600, 400);

/**
 * Remove post type supports
 *
 * @return void
 * @uses admin_menu()
 * @uses remove_post_type_support()
 */

add_action('init', 'my_remove_editor_from_post_type');

function my_remove_editor_from_post_type() {
  remove_post_type_support('page', 'editor');
  remove_post_type_support('tribe_events', 'editor');
}

function remove_post_custom_fields() {
  remove_meta_box('postcustom', 'tribe_events', 'normal');
}

add_action('admin_menu', 'remove_post_custom_fields');

/*
Register the sidebar
*/

function arphabet_widgets_init() {

    register_sidebar(array(
        'name'          => 'Sidebar',
        'id'            => 'sidebar',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<p class="sidebar-title">',
        'after_title'   => '</p>',
    ));

}
add_action('widgets_init', 'arphabet_widgets_init');


/**
 * Generates and outputs the theme's #site-logo
 * The front page will be a <span> tag while interior pages will be links to the homepage
 *
 * @return void
 *
 * @uses get_bloginfo()
 * @uses is_front_page()
 * @uses site_url()
 */
function site_logo() {
    if (is_front_page()) {
        $logo = sprintf('<span id="site-logo">%s</span>', get_bloginfo('name'));
    } else {
        $logo = sprintf('<a href="%s" id="site-logo">%s</a>', site_url('/'), get_bloginfo('name'));
    }
    print $logo;
}

function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
/**
 * Create a nicely formatted <title> element for the page
 * Based on twentytwelve_wp_title()
 *
 * @global $page
 * @global $paged
 * @param str $title The default title text
 * @param str $sep Optional separator
 * @return str
 *
 * @uses get_bloginfo()
 * @uses is_feed()
 * @uses is_front_page()
 * @uses is_home()
 */
function custom_wp_title($title, $sep) {
    global $paged, $page;
    if (!is_feed()) {
        $title .= get_bloginfo('name');
        // Add the site description on blog/front page
        $site_description = get_bloginfo('description', 'display');

        if ($site_description && (is_home() || is_front_page())) {
            $title = sprintf('%s %s %s', $title, $sep, $site_description);
        }

        if ($paged >= 2 || $page >= 2) {
            $title = sprintf('%s %s %s', $title, $sep, sprintf(__('Page %s', '%Text_Domain%'), max($paged, $page)));
        }
    }
    return $title;
}
add_filter('wp_title', 'custom_wp_title', 10, 2);

/**
 * Register dynamic sidebars
 *
 * @uses register_sidebar()
 */
function register_dynamic_sidebars() {
    $sidebars = array(
        array(
            'id'   => 'primary-sidebar',
            'name' => __('Primary sidebar', '%Text_Domain%'),
        ),
    );

    foreach ($sidebars as $sidebar) {
        register_sidebar($sidebar);
    }
}
add_action('widgets_init', 'register_dynamic_sidebars');

/**
 * Register the site favicon, if it exists
 *
 * @uses get_template_directory_uri()
 */
function register_favicon() {
    printf('<link href="%s/favicon.png" rel="shortcut icon" />' . PHP_EOL, get_template_directory_uri() . '/assets/img');
}
add_action('login_head', 'register_favicon');
add_action('admin_head', 'register_favicon');

/*
Custom Post Filtering

*/

add_action('restrict_manage_posts', 'my_restrict_manage_posts');

function my_restrict_manage_posts() {
    global $typenow;
    if ($typenow == 'module') {
        $args = array(
            'show_option_all' => "Show All Module Types",
            'orderby'         => 'name',
            'order'           => 'ASC',
            'taxonomy'        => 'module_type_taxonomy',
            'name'            => 'module_type_taxonomy',
        );
        wp_dropdown_categories($args);
    }
}

add_action('request', 'ia_my_request');
function ia_my_request($request) {
    if (is_admin() && $GLOBALS['PHP_SELF'] == '/wp-admin/edit.php' && isset($request['post_type']) && $request['post_type'] == 'module') {
        $request['module_type_taxonomy'] = get_term($request['module_type_taxonomy'], 'module_type_taxonomy')->slug;
    }
    return $request;
}

/*
Highlight Correct Menu Item for Custom Post Type Archive
*/

function ia_nav_classes($classes) {
    // Remove "current_page_parent" class
    $classes = array_diff($classes, array('current_page_parent'));

    // If this is the "news" custom post type, highlight the correct menu item
    if (in_array('menu-item-16624', $classes) && get_post_type() === 'conference') {
        $classes[] = 'current-menu-ancestor';
    }
    if (in_array('menu-item-16622', $classes) && get_post_type() === 'resources') {
        $classes[] = 'current-menu-ancestor';
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'ia_nav_classes');

/*
*
* Custom Ajax Function
*
*/ 

add_action('wp_ajax_ajax_function', 'ajax_function');

add_action('wp_ajax_nopriv_ajax_function', 'ajax_function');

function ajax_function() {
    get_template_part("formats/ajax/" . $_POST["format"]);
    //get_template_part( "formats/ajax/events-ajax");
    die();
}

// Filter Yoast Meta Priority
add_filter('wpseo_metabox_prio', function () {return 'low';});
add_filter('appip_metabox_priority_filter', function () {return 'low';});

function get_depth($postid)
{
    $depth = ($postid == get_option('page_on_front')) ? -1 : 0;
    while ($postid > 0) {
        $postid = get_post_ancestors($postid);
        $postid = $postid[0];
        $depth++;
    }
    return $depth;
}

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
      'page_title' 	=> 'Footer',
      'menu_title'	=> 'Footer',
      'menu_slug' 	=> 'footer',
      'capability'	=> 'edit_posts',
      'redirect'		=> false
  ));
}