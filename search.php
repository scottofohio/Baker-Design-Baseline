<?php
/**
 * The template for displaying Search pages
 *	
 * Template Name: Search Page
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage BakerDesign
 * @since 2.0
 **************************************************************** 
 ****************************************************************/

// Initiate the global variable 
get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section>
        	<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	        <?php the_excerpt(); ?>
	        <a href="<?php the_permalink(); ?>">Read More</a>
        </section>
    </article><!-- #post-<?php the_ID(); ?> -->
<?php endwhile; ?>
<?php echo my_post_nav_links(); ?>
<?php get_sidebar(); ?>


<?php
get_footer();
