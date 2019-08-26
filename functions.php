<?php
/**
 * Baker Design Baseline Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link http://bakerdesign.co
 *
 * For more information on hooks, actions, and filters,
 * @link https://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Baker Design Theme 1.0
 * @since 2.0
 */

require_once dirname( __FILE__ ) . '/functions/common-functions.php';

/* Globals */
my_require( dirname( __FILE__ ) . '/functions/globals.php' );

/* Adjustments to the Admin */
my_require( dirname( __FILE__ ) . '/functions/admin.php' );

/* Function aliases/fallbacks */
my_require( dirname( __FILE__ ) . '/functions/aliases.php' );

/* Utiltiy  */
my_require( dirname( __FILE__ ) . '/functions/utility.php' );

/* All things NAV */
my_require( dirname( __FILE__ ) . '/functions/navigation.php' );

/* Loads CSS and JS */
my_require( dirname( __FILE__ ) . '/functions/enqueue.php' );
my_require( dirname( __FILE__ ) . '/functions/nav-walker.php' );

/* General Options and Aditions  */
my_require( dirname( __FILE__ ) . '/functions/theme-options.php' );