<?php
/* 
Plugin Name: Version History
Plugin URI: 
Description: Adds the ability to track a site's version history publicly. Use the version-history-display shortcode to, well, display it on any page/post/whatever.
Version: 0.1
Author: Ryan Imel
Author URI: http://atfounders.com
License: GPL 
*/


// Post type creation
add_action( 'init', 'rwi_version_history_content_types' );

function rwi_version_history_content_types() {
	
	// Pros
	register_post_type( 'version_history_item',
		array(
			'labels' 			=> array(
				'name' 					=> __( 'Version History' ),
				'singular_name' 		=> __( 'Version History' ),
				'add_new' 				=> __( 'Add New' ),
				'add_new_item' 			=> __( 'Add New Item' ),
				'edit' 					=> __( 'Edit' ),
				'edit_item' 			=> __( 'Edit Item' ),
				'new_item' 				=> __( 'New Item' ),
				'view' 					=> __( 'View Item' ),
				'view_item' 			=> __( 'View Item' ),
				'search_items' 			=> __( 'Search Items' ),
				'not_found' 			=> __( 'No items found' ),
				'not_found_in_trash' 	=> __( 'No items found in Trash' ),
			),
			'public' 			=> false,
			'rewrite' 			=> array( 'slug' => 'version-history-item', 'with_front' => false ),
			'capability_type' 	=> 'page',
			'has_archive' 		=> false,
			'show_ui'			=> true,
			'show_in_menu'		=> 'tools.php',
			'supports' 			=> array( 'title', 'editor', ),
		)
	);
	
}

// Shortcode for displaying the Version History
add_shortcode( 'version-history-display', 'rwi_version_history_display' );

function rwi_version_history_display(){
	
	$display = '';
	
	$args = array(
		'post_type'			=> 'version_history_item',
		'posts_per_page'	=> -1,
	);
	$version_history = new WP_Query( $args );
	
	while ( $version_history->have_posts() ) :
		$version_history->the_post(); ?>
		<h3><?php the_title(); ?> &ndash; <?php the_date(); ?></h3>
		<?php the_content(); ?>
	<?php endwhile;

	wp_reset_query();
	wp_reset_postdata();
	
	return $display;
}
