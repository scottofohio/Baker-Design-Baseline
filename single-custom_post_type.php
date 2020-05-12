<?php
/**
 * Single Custom Post Type
 * 
 * @package WordPress
 * @subpackage Baker Design Theme 1.0
 * @since 2.0
 **************************************************************** 
 ****************************************************************/
get_header(); ?>
<section id="blog-content">
<?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <?php the_excerpt(); ?>
    </article><!-- #post-<?php the_ID(); ?> -->
<?php endwhile; ?>   

<?php get_sidebar(); ?>
</section>  
<?php get_footer(); ?>