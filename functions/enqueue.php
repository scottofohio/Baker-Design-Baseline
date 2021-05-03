<?php
/***********************************************************************
BakerDesign
Enqueue Scripts
*
* @return void
*
* @uses get_stylesheet_directory_uri()
* @uses wp_enqueue_script()
* @uses wp_enqueue_style()
* @uses wp_register_script()
* @uses wp_register_style()
*/
function register_styles_scripts() {
    
    // Main CSS File & Javascript Files
    wp_register_style( 'styles', get_stylesheet_directory_uri() . '/assets/css/app.css', null, null, 'all' );
    wp_register_script( 'app', get_stylesheet_directory_uri() . '/assets/js/app.js', array( 'jquery', 'lib', 'mapbox' ), null, true );
    
    // Libraries and Plugins  
    wp_register_script( 'lib', get_stylesheet_directory_uri() . '/assets/js/lib.js', array( 'jquery' ), null, true );
    // Modernizr
    wp_register_script( 'modernizr', get_stylesheet_directory_uri() . '/assets/js/modernizr.js', null, null, false );

    if ( ! is_admin() && ! is_login_page() ) {
        wp_enqueue_style( 'styles' );
        wp_enqueue_script( 'modernizr' );
        wp_enqueue_script( 'app' );
        wp_enqueue_script( 'lib' );
        wp_enqueue_script( 'mapbox' );
    }
}

/** Register/add filters & actions */

add_action( 'init', 'register_styles_scripts' );
