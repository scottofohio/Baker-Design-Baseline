<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage BakerDesign
 * @since 2.0
 **************************************************************** 
 ****************************************************************/

global $module;

// Get the page data
if (function_exists('get_fields')) {
    $module["page"] = get_post();
    $module["page_fields"] = get_fields($module["page"]->ID);
    $fields = $module['page_fields']['modules'];
   
    get_header();
   
    while (have_posts()) : the_post();
      if(get_the_content()) { ?> 
      <figure class="banner-image">
        <?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'full'); ?>
      </figure>
      <div class="page-content">
        <article>
        <h1><?php the_title(); ?></h1>
        <?php  the_content(); ?>
        </article>
      </div><?php 
       
      }
        if (!empty($fields)) {
            foreach ($fields as $field) :
            $module_slug = str_replace('_', '-', $field['acf_fc_layout']);
            echo get_template_part('modules/' . $module_slug);
            // var_dump($field);
            endforeach;
        }
    endwhile;
} else {
  echo '<p>Please activate the plugin Advanced Custom Fields Pro</p>';
}
get_footer();
