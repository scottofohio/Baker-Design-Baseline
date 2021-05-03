<?php
/**
 * The Header for the Baker Design Baseline Theme
 *
 * Displays all of the header and navigation
 *
 * @package WordPress
 * @subpackage BakerDesign
 * @since 2.0
 */

global $module;
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<title><?php meta_title(); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!-- force IE out of compatability mode for any version -->
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<!-- force mobile view 100% -->
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.png" rel="shortcut icon" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>  
<header role="banner" class="site-header">
  <a href="<?php echo get_bloginfo('url'); ?>" class="site-logo">SITE NAME</a>
  <button class="hamburger">Menu</button>
  <nav class="main-nav">
    <ul>
      <?php site_menus('primary-nav'); ?>
    </ul>
  </nav>
  <nav class="utility-nav">
    <ul>
      <?php site_menus('utility-nav'); ?>
    </ul>
  </nav>
</header>
<main id="maincontent"> <!-- Site container --> 