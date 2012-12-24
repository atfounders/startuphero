<?php
/*
Plugin Name: Startup Hero Functionality
Description: Special plugin just for StartupHero.com.
Version: 1.0
Author: Ryan Imel
License: GPLv2 or later
*/

// Enable post formats
add_theme_support( 
	'post-formats', 
	array( 
		'link' ) 
);

// Metabox class inclusion
add_action( 'init', 'startuphero_metabox_initialize', 9999 );

function startuphero_metabox_initialize() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'metabox/init.php';

}

// Create our metaboxes
add_filter( 'cmb_meta_boxes', 'startuphero_metabox_create' );

function startuphero_metabox_create( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_startuphero_';

	$meta_boxes[] = array(
		'id'         => 'startuphero_additional_info',
		'title'      => 'Additional Info',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Link Format URL',
				'desc' => 'Include the full URL with <code>http://</code>.',
				'id'   => $prefix . 'post_link_url',
				'type' => 'text',
			),
		),
	);

	return $meta_boxes;
}

// Remove dashboard widgets
add_action( 'wp_dashboard_setup', 'startuphero_remove_dashboard_widgets' );

function startuphero_remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
}

// Enable HTML in widget titles.
add_filter( 'widget_title', 'startuphero_html_in_widget_titles' );

function startuphero_html_in_widget_titles( $title ) {
	
	//HTML tag opening/closing brackets
	$title = str_replace( '[', '<', $title );
	$title = str_replace( '[/', '</', $title );
	
	// bold -- changed from 's' to 'strong' because of strikethrough code
	$title = str_replace( 'strong]', 'strong>', $title );
	$title = str_replace( 'b]', 'b>', $title );
	
	// italic
	$title = str_replace( 'em]', 'em>', $title );
	$title = str_replace( 'i]', 'i>', $title );
	
	// underline
	// $title = str_replace( 'u]', 'u>', $title ); // could use this, but it is deprecated so use the following instead
	$title = str_replace( '<u]', '<span style="text-decoration:underline;">', $title );
	$title = str_replace( '</u]', '</span>', $title );

	// superscript
	$title = str_replace( 'sup]', 'sup>', $title );
	
	// subscript
	$title = str_replace( 'sub]', 'sub>', $title );
	
	// del
	$title = str_replace( 'del]', 'del>', $title ); // del is like strike except it is not deprecated, but strike has wider browser support -- you might want to replace the following 'strike' section to replace all with 'del' instead	
	
	// strikethrough or <s></s>
	$title = str_replace( 'strike]', 'strike>', $title );
	$title = str_replace( 's]', 'strike>', $title ); // <s></s> was deprecated earlier than so we will convert it
	$title = str_replace( 'strikethrough]', 'strike>', $title ); // just in case you forget that it is 'strike', not 'strikethrough'
	
	// tt
	$title = str_replace( 'tt]', 'tt>', $title ); // Will not look different in some themes, like Twenty Eleven -- FYI: http://reference.sitepoint.com/html/tt	
	
	// marquee
	$title = str_replace( 'marquee]', 'marquee>', $title );
	
	// blink
	$title = str_replace( 'blink]', 'blink>', $title ); // only Firefox and Opera support this tag
	
	// wtitle1 (to be styled in style.css using .wtitle1 class)
	$title = str_replace( '<wtitle1]', '<span class="wtitle1">', $title );
	$title = str_replace( '</wtitle1]', '</span>', $title );
	
	// wtitle2 (to be styled in style.css using .wtitle2 class)
	$title = str_replace( '<wtitle2]', '<span class="wtitle2">', $title );
	$title = str_replace( '</wtitle2]', '</span>', $title );
	
	// editor (to be styled in style.css using .editor class)
	$title = str_replace( '<editor]', '<span class="editor">', $title );
	$title = str_replace( '</editor]', '</span>', $title );

	return $title;
}