<?php
/**
 * Customizations to the WordPress administration area
 *
 * @package WordPress
 * @subpackage Baker Design Theme 1.0
 * @since 2.0
 ****************************************************************/

/**
 * Add the style select menu to the TinyMCE editor
 *
 * @param array $buttons Buttons for this row of the TinyMCE toolbar
 * @return array
 */
function my_add_style_select_to_tinymce( $buttons = array() ) {
  array_unshift( $buttons, 'styleselect' );
  return $buttons;
}
add_filter( 'mce_buttons_2', 'my_add_style_select_to_tinymce' );

/**
 * Customize the TinyMCE WYSIWYG editor
 *
 * @param array $init Default settings to be overridden
 * @return array The modified $init
 *
 * @link http://codex.wordpress.org/TinyMCE_Custom_Styles
 * @link http://wpengineer.com/1963/customize-wordpress-wysiwyg-editor/
 * @link http://wiki.moxiecode.com/index.php/TinyMCE:Control_reference
 */
function my_change_mce_buttons( $init ) {
    $block_formats = array(
        'Paragraph=p',
        'Address=address',
        'Pre=pre',
        'Heading 2=h2',
        'Heading 3=h3',
        'Heading 4=h4',
        'Heading 5=h5',
        'Heading 6=h6'
        );
    $init['block_formats'] = implode( ';', $block_formats );

    $style_formats = array(
        array(
            'title' => __( 'Blockquote citation', '%Text_Domain%' ),
            'selector' => 'blockquote p',
            'classes' => 'cite',
            'wrapper' => false
            )
        );
    $init['style_formats'] = json_encode( $style_formats );

    return $init;
}
add_filter( 'tiny_mce_before_init', 'my_change_mce_buttons' );

/**
 * Hide admin menus we don't need
 *
 * @global $menu
 * @return void
 */
function my_remove_admin_menus() {
    global $menu;
    $restricted = array( __( 'Posts' ), __( 'Comments' ) );
    end( $menu );
    while ( prev( $menu ) ) {
        $value = explode( ' ', $menu[ key( $menu ) ][0] );
        if ( in_array( $value['0'] != null ? $value[0] : '', $restricted ) ) {
            unset( $menu[ key( $menu ) ] );
        }
    }
    return;
}

/**
 * Remove the "Text Color" TinyMCE button
 *
 * @param array $buttons Buttons for this row of the TinyMCE toolbar
 * @return array
 */
function my_remove_forecolor_button( $buttons = array() ) {
    if ( $key = array_search( 'forecolor', $buttons ) ) {
        unset( $buttons[ $key ] );
    }
    return $buttons;
}

/**
 * Add custom admin JS/CSS
 *
 * @return  void
 */
function add_custom_admin_styles() {
    echo '<link type="text/css" rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/assets/css/admin.css" />';
    echo '<script type="text/javascript" src="' . get_template_directory_uri() . '/assets/js/admin.js" async ></script>';
}

/** Register/add filters & actions */
add_filter( 'mce_buttons_2', 'my_remove_forecolor_button' );
add_action('admin_head', 'add_custom_admin_styles');

/* Only hide if user is developer */
if ( get_current_user_id() === 1) {
    // show_admin_bar( false );
}

/** Custom WP Admin Menu Pages/Sub-Pages/Shortcuts */

# Add "Edit Home Page" submenu item to "Pages" nav in WP admin
function my_add_template_submenus() {
    $front_page_id = get_option('page_on_front');
    add_pages_page( 'Edit Home Page', 'Edit Home Page', 'edit_pages', 'post.php?post=' . $front_page_id . '&action=edit');
    add_submenu_page( 'tools.php', 'Import/Export ACF', 'Import/Export ACF',
        'manage_options', 'edit.php?post_type=acf-field-group&page=acf-settings-tools');
    // add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
    // ( 'tools', 'Import/Export ACF', 'edit_pages', 'edit.php?post_type=acf-field-group&page=acf-settings-tools');
}

/** Add Filters/Actions */
add_action('admin_menu', 'my_add_template_submenus');
