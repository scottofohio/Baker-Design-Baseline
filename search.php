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
 * @subpackage Baker Design Theme 1.0
 * @since 2.0
 **************************************************************** 
 ****************************************************************/

// Initiate the global variable 

global $module;
$page = get_post(15416);
$fields = get_fields($page->ID);
$url = get_stylesheet_directory_uri();

//preserving the search query
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

if( strlen($query_string) > 0 ) {
	foreach($query_args as $key => $string) {
		$query_split = explode("=", $string);
		$search_query[$query_split[0]] = urldecode($query_split[1]);
	} 
} 

$search = new WP_Query($search_query);


get_header(); ?>
<section class="gray-background">
	<article>
		<div class="wide-800c">
			<div>
				<h1 class="center-text">Search Results</h1>
			</div>
			<div class="search-box">
				<div class="searchbar-wrapper pos-relative">
					<?php get_search_form(); ?>
				</div>
			</div>
			<div class="results-box">
				<div class="results-inner">
				<?php // Call the search items
				if ( have_posts() ) :

				 	$args1 = array(
						'posts_per_page'   => -1,
						'orderby'          => 'date',
						'order'            => 'DESC',
						'post_type'        => array('page'),
						'post_status'      => 'publish',
					);
					$all_pages = get_posts( $args1 );

					// Start the Loop.
					while ( have_posts() ) : the_post();
						// set current post to module
						$module["value"] = $post;

						// if page, echo page title
						if( $module["value"]->post_type == "page") { ?>
							<div class="result-block">
									<figure>
										<?php echo wp_get_attachment_image(get_field('search_image'), 'fullsize660'); ?>
									</figure>
								<div>
									<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									<p><?php echo get_field('search_description'); ?></p>
								</div>
								
							</div>
						<?php }

						if( $module["value"]->post_type == "module" ) {
							$term = get_the_terms($module["value"]->ID, 'module_type_taxonomy');
							$exclude = array(157, 479, 618, 625, 628, 629, 643, 644);
							if (!in_array( $term[0]->term_id, $exclude)) {?>
								
									<?php 
									$link = "";
									$page_name = "";
									$title = '';
									$excerpt = '';
									// Get which page this module is on
									foreach ($all_pages as $page) {
										$m = $page->modules;
										$pre = '';
										$ar = '';
										if( isset( $m) && is_array( $m)) {
											if( in_array( $module["value"]->ID, $m)) {
												$fields = get_fields($module["value"]->ID);
												if ($fields["title"]) {
													$title = $fields["title"];
												} elseif ($fields["headline"]) {
													$title = $fields["headline"];
												}
												$link = get_permalink( $page->ID) . "#" . $module['value']->post_name;
												$page_name = $page->post_title;
												$excerpt = $page->post_excerpt;
												break;
											}
										} elseif( isset( $ar) && is_array( $ar)) {
											if( in_array( $module["value"]->ID, $ar)) {
												$fields = get_fields($module["value"]->ID);
												if ($fields["title"]) {
													$title = $fields["title"];
												} elseif ($fields["headline"]) {
													$title = $fields["headline"];
												} elseif ($fields["title_left"][0]['title']) {
													$title = $fields["title_left"][0]['title'] . ' - ' . $fields["title_right"][0]['title'];
												}
												$link = get_permalink( $page->ID) . "#" . $module['value']->post_name;
												$page_name = $page->post_title;
												$excerpt = $page->post_excerpt;
												
												break;
											}
										} 
									} ?>
									<?php if (!empty($title)) { ?>
									<div class="result-block">
										<figure>
											<?php echo wp_get_attachment_image( get_field('search_image', $page->ID), 'fullsize660'); ?>
										</figure>
										<div>
											<h4><a href="<?php echo $link; ?>"><?php echo $page_name;
												echo ': ' . $title; ?></a></h4>
											<?php echo '<p>'. get_field('search_description', $page->ID) .'</p>'; ?>
												
												
										</div>
									</div>
								<?php } ?>
							<?php }
						}
						
						if( $module["value"]->post_type == "mini-module") { ?>
								
									<?php 
									$link = "";
									$page_name = "";
									$title = '';
									$miniFields = array('mini', 'left_mini', 'right_mini');

									// Get which page this module is on
									foreach ($all_pages as $page) {
										$m = $page->modules;
										if( isset( $m) && is_array( $m)) {
											foreach ($m as $mod) {
												foreach ($miniFields as $type) {
													$temp = get_field($type, $mod);
													if( isset( $temp) && is_array( $temp)) {
														foreach ($temp as $mini) {
															if ($module["value"]->ID === $mini->ID) {
																$fields = get_fields($mini->ID);
																$link = get_permalink( $page->ID) . "#" . $module['value']->post_name;
																$page_name = $page->post_title;
																break;
															} 
														}
													}
												}
											}
										}
									} ?>

									<?php if ($fields["title"]) {
										$title = $fields["title"];
									} elseif ($fields["module_title"]) {
										$title = $fields["module_title"];
									} ?>
									<?php if (!empty($title)) { ?>
									<div class="result-block">
										<figure>
											<?php echo wp_get_attachment_image( get_field('search_image', $page->ID), 'fullsize660'); ?>
										</figure>
										<div>
											<h4><a href="<?php echo $link; ?>"><?php echo $page_name;
												echo ': ' . $title; ?></a></h4>
											<?php echo '<p>'. get_field('search_description', $page->ID) .'</p>'; ?>									
										</div>
									</div>
								<?php } ?>
								
						<?php } 
						/* this is for testing
						else {
							echo $module["value"]->post_type .' -- '. $module["value"]->post_title;
						} */

					endwhile;
				else :
					// If no content, include the "No posts found" template.
					//get_template_part( 'formats/search/content', 'none' );?>
						<div class="search-title">
							
							<h4>Sorry, No Search Results for: <?php echo get_search_query(); ?></h4>

						</div>
				<?php
				endif; ?>
				</div>
			</div>
			<div class="loader"></div>
			<div id="load-more-link" class="load-more center-text">
				<?php echo get_next_posts_link('Load More', 0); ?> 
			</div>
		</div> <!-- end .wide-800c -->
	</article>
</section>


<?php
get_footer(); 
