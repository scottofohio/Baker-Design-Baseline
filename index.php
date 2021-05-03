<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package BakerDesign
 * @subpackage theme2
 */

get_header(); ?>

<section class="post-feed-wrapper">
<h1>Blog Feed</h1>
<?php 
  while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <h1 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
      <?php the_excerpt(); ?>
      <a href="<?php the_permalink(); ?>">Read More</a>
    </article><?php the_ID(); ?><?php 
  endwhile; ?>
</section>
<?php
echo my_post_nav_links();
get_footer();
