<?php
/**
 * The Header for the Baker Design Baseline Theme
 *
 * Displays all of the header and navigation
 *
 * @package WordPress
 * @subpackage Baker Design Theme 1.0
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
	<title><?php $p = get_post(); echo $p->post_title; ?> | <?php echo bloginfo( "name"); ?> | <?php echo get_the_excerpt($post->ID); ?></title>
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
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <a class="navbar-brand" href="<?php bloginfo('url') ?>">
      <img src="<?php echo get_template_directory_uri() ?>/assets/img/logo.svg" alt="Andrew Gither for Mayor">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="main-navbar-nav">
      <ul class="navbar-nav">
        <?php primary_navigation(); ?>
      </ul>
    </div>
  </nav>
</header>
<main id="maincontent"> <!-- Site container --> 