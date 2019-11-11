<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Baker Design Theme 1.0
 * @since 2.0
 **************************************************************** 
 ****************************************************************/

// Initiate the global variable
global $module;

// Get the page data
if (function_exists('get_fields')) {
    $module["page"] = get_post();
    $module["page_fields"] = get_fields($module["page"]->ID);
    $fields = $module['page_fields']['modules'];

    get_header();

    // var_dump($fields);
    while (have_posts()) : the_post();

    foreach ($fields as $field) :
    $module_slug = str_replace('_', '-', $field['acf_fc_layout']);
    echo get_template_part('modules/' . $module_slug);
    endforeach;

    endwhile;
} else {
  echo '<p>Please activate the plugin Advanced Custom Fields Pro</p>';
}
get_footer();
