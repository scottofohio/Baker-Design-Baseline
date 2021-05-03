<?php
/**
* The template for displaying all single posts
*
*
* @package WordPress
* @subpackage BakerDesign
* @since 2.0
**************************************************************** 
****************************************************************/
// Initiate the global variable
global $module;
global $post;


get_header();

while ( have_posts() ) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h1 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
    <?php the_content(); ?>
    <a href="<?php the_permalink(); ?>">Read More</a>
  </article><!-- #post-<?php the_ID(); ?><?php 
endwhile; 


get_footer();