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

