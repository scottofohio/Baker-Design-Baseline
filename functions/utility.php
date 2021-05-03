<?php
/**
 * Functions meant to extend core WordPress functionality
 * @package WordPress
 * @subpackage BakerDesign
 * @since 2.0
 ****************************************************************/

/**
 * Check to see if the current page is the login/register page
 * Use this in conjunction with is_admin() to separate the front-end from the back-end of your theme
 *
 * @return bool
 */
if ( ! function_exists( 'is_login_page' ) ) {
    function is_login_page() {
        return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
    }
}

/**
 * Get the post thumbnail from post ID
 *
 * @param $post_id int
 * @param $image_size str
 * @return str
 */
function my_get_post_thumbnail_uri($post_id = -1, $image_size = 'full') {
    if ($post_id === -1) {
        global $post;
        $post_id = $post->ID;
    }
    $thumb_id = get_post_meta($post_id, '_thumbnail_id', true );

    $thumb_url_array = wp_get_attachment_image_src($thumb_id, $image_size, true);
    $thumb_url = $thumb_url_array[0];
    if ( contains('wp-includes/images/media/default', $thumb_url) === false ) {
        return $thumb_url;
    }
}

/**
 * Get post or page (or whatever) by slug
 *
 * @param  str $page_slug
 * @param  str $type the post type
 * @return str
 */
function get_page_by_slug( $page_slug, $object_var = null ) {
    global $wpdb;
    $output = OBJECT;
    $return_val = null;
    $page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s", $page_slug, 'page' ) );
    if ( $page ) {
        $return_val = get_post($page, $output);
    } else {
        $page = $wpdb->get_var($wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s", $page_slug, 'post' ) );
        if ( $page ) {
            $return_val = get_post($page, $output);
        }
    }
    if ( is_object($return_val) ) {
        if ( $object_var !== null ) {
            $return_val = get_array_item((array)$return_val, $object_var);
        }
        return $return_val;
    }
    return null;
}

/**
 * Get post or page ID by slug
 *
 * @param  str $page_slug
 * @param  str $type the post type
 * @return str
 */
function get_id_by_slug($page_slug) {
    return get_page_by_slug($page_slug, 'ID');
}

/**
 * Get post or page (or whatever) permalink by slug
 *
 * @param  str $page_slug
 * @param  str $type the post type
 * @return str
 */
function get_permalink_by_slug($page_slug) {
    return get_permalink(get_id_by_slug($page_slug));
}

function my_get_page_id($context) {
    $pid = get_id_by_slug('bold-' . $context);
    $pid = ($pid === null) ? get_the_id() : $pid;
    return $pid;
}

function my_get_archive_type($context = null) {
    $context = ($context === null) ? get_the_slug() : $context;
    $context = str_replace('bold-', '', $context);
    if ( $context === 'blog' || $context === 'articles' ) {
        return 'post';
    } else {
        if (post_type_exists($context)) {
            return $context;
        } else {
            return get_post_type(get_id_by_slug($context));
        }
    }
    return null;
}


/**
 * Get the content w/o echo
 *
 * @return true
 */
function my_get_the_content($pg_id = null) {
    if ($pg_id !== null) {
        return get_post_field('post_content', $pg_id);
    } else {
        return apply_filters('the_content', get_the_content(''));
    }
}

/**
 * Get last item of current page path
 *  - Example Usage:
 *     get_current_page_path_last('http://domain.com/first/child/'); // <= returns '/child/'
 *
 * @return str
 */
function my_get_paged() {
    $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
    if ( intval(get_current_page_path_last()) > 0 ) {
        $paged = intval(get_current_page_path_last());
    }
    return $paged;
}

/**
 * Get the permalink, rewriting 'redirect_single' posts
 *
 * @param  int $postid
 * @return str
 */
function my_get_the_permalink($postid = null) {
    $postid = ($postid === null) ? get_the_ID() : $postid;
    $post_obj = get_post($postid);
    $post_obj = get_post_type_object($post_obj->post_type);
    if (property_exists($post_obj, 'redirect_single') && $post_obj->redirect_single === true) {
        return '#' . get_the_slug($postid);
    } elseif (property_exists($post_obj, 'redirect_single') && $post_obj->redirect_single !== false) {
        if ( my_get_field($post_obj->redirect_single) !== '' ) {
            return my_get_field($post_obj->redirect_single);
        } else {
            return get_the_permalink($postid);
        }
    } else {
        return get_the_permalink($postid);
    }
}

/**
 * Shortcut for `echo my_get_the_permalink( ... )` - accepts the same arguments
 *
 * @param  $postid
 * @return void
 */
function my_the_permalink($postid = null) {
    echo my_get_the_permalink($postid);
}

/**
 * Returns value of post type object's property (e.g. 'capability_type')
 *
 * @param  str $posttype
 * @param  str property
 * @param  var $fallback
 * @return var
 */
function my_get_post_type_prop($posttype, $property, $fallback = null) {
    $posttype = ($posttype === null) ? get_post_type() : $posttype;
    $post_obj = get_post_type_object($posttype);
    $post_prop = property_exists($post_obj, $property) ? get_array_item($post_obj, $property) : $fallback;
    return $post_prop;
}

/**
 * Check for custom post type's posts_per_page_limit setting
 *
 * @param  $posttype
 * @return int
 */
function my_get_posts_per_page_limit($posttype = null) {
    $posttype = ($posttype === null) ? get_post_type() : $posttype;
    $post_obj = get_post_type_object($posttype);
    $posts_per_page_limit = property_exists($post_obj, 'posts_per_page_limit') ? $post_obj->posts_per_page_limit : get_option( 'posts_per_page' );
    return $posts_per_page_limit;
}

/**
 * Check if current page is a blog page
 *
 * @return bool
 */
function is_blog() {
    return ( get_current_page_path() === '/blog/' || is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() );
}

/**
* Add user meta
*
* @param $var variable to test
* @return void
*/
function my_add_meta($type = 'user', $meta_key = 'my_user', $meta_value = -1) {
    if ($type === 'user') {
        add_user_meta($user_id, 'my_' . $meta_key, $meta_value);
    } else {
        add_post_meta(get_the_ID(), 'my_' . $meta_key, $meta_value);
    }
}

/**
* Get current page slug
*
* @return string
*/
function get_the_slug() {
    return basename(get_permalink());
}

/**
* Output current page slug
*
* @return void
*/
function the_slug() {
    echo basename(get_permalink());
}

/**
 * Get site root path
 *
 * @return string
 */
function get_site_root_path() {
    $full_path = getcwd();
    $ar = explode("wp-", $full_path);
    return $ar[0];
}
