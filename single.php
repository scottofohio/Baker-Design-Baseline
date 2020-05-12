<?php
/**
* The template for displaying all single posts
*
*
* @package WordPress
* @subpackage Baker Design Theme 1.0
* @since 2.0
**************************************************************** 
****************************************************************/
// Initiate the global variable
global $module;
global $post;
$module["module"] = get_post();
$module["module_fields"] = get_fields( $module["module"]->ID);
$url = get_bloginfo("url");
$url_icon = get_stylesheet_directory_uri();

get_header(); ?>

<?php get_footer(); ?>
