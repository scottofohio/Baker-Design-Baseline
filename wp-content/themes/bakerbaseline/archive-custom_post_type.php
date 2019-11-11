<?php
/**
 * post type archive
 *
 *
 * @package WordPress
 * @subpackage Baker Design Theme 1.0
 * @since 2.0
 */
 ?>

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

<?php get_footer(); ?>