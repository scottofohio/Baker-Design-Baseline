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
$module = array();
$module['module'] = get_post();
$module["module_fields"] = get_fields( $module["module"]->ID);
get_header();

// Get the type of module
$term = wp_get_post_terms( $module['module']->ID, 'module_type_taxonomy');

// Create the HTML Wrapper, using the term slug as a class
// Use the post name for an ID 
if( $term) { 

	// Create the class and template strings
	$term_str = "";
	$term_class = "";
	$term_val = "";

	// Get the term slug, split into array
	$term_array = explode( "_", $term[0]->slug);
			
	// Loop through slug, creating strings from the parts
	for( $i=0; $i<sizeof( $term_array); $i++) {
		$term_str = $term_str . "/" . $term_val . $term_array[$i];
		$term_class = $term_class . " module-" . $term_val . $term_array[$i];
		$term_val = $term_array[$i] . "_";
	}

	// Add final part to template string
	$term_str = $term_str . "/template"; ?>

	<section id="<?php echo $module['module']->post_name; ?>" class="<?php echo $term_class; ?> <?php echo $module["module_fields"]["background_color"] ?>" >
				
		<?php // Get the module template
		get_template_part( "templates/" . $module['module']->post_type . $term_str); ?>

	</section>
<?php } ?>

<?php get_footer(); ?>
