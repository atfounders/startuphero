<?php
/**
 * Confit functions and definitions
 *
 * @package Confit
 * @since Confit 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Confit 1.0
 */
if ( ! isset( $content_width ) )
	// The max size for the background image is 1600px wide.
	$content_width = 1600;

if ( ! function_exists( 'confit_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Confit 1.0
 */
function confit_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * WordPress.com-specific functions and definitions
	 */
	require( get_template_directory() . '/inc/wpcom.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Confit, use a find and replace
	 * to change 'confit' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'confit', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Enable support for the Nova Restaurant Menus plugin that adds CPT for restaurent menus
	 */
	add_theme_support( 'nova-restaurant-menus' );

	/**
	 * Adding several sizes for Post Thumbnails
	 */
	add_image_size( 'large-background', 0, 0 );
	add_image_size( 'mobile-background', 0, 1024 );
	add_image_size( 'confit-thumbnail', 618, 0 );
	add_image_size( 'confit-menu-thumbnail', 138, 104, true );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'confit' ),
	) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'f6f6f6',
		'default-image' => get_template_directory_uri() . '/images/background.jpg',
	) );

	// Grab Open Table widget.
	require( get_template_directory() . '/inc/wp-open-table/wp-open-table.php' );

	/*
	// Disable temporarily Infinite Scroll until the Open Table jQuery issue gets resolved.
	add_theme_support( 'infinite-scroll', array(
		'type'           => 'scroll',
		'footer_widgets' => false,
		'container'      => 'content',
		'wrapper'        => true,
		'render'         => false,
		'footer'         => 'content',
		'posts_per_page' => false
	) );
	*/
}
endif; // confit_setup
add_action( 'after_setup_theme', 'confit_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Confit 1.0
 */
function confit_widgets_init() {
	register_widget( 'Open_Table_Widget' );

	register_sidebar( array(
		'name' => __( 'Sidebar', 'confit' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'confit_widgets_init' );

/**
 * Register Google fonts for Confit
 *
 * @since Confit 1.0
 */
function confit_fonts() {
	/* translators: If there are characters in your language that are not supported
	   by Muli, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Muli font: on or off', 'confit' ) ) {
		$protocol = is_ssl() ? 'https' : 'http';
		wp_register_style( 'confit-font-muli', "$protocol://fonts.googleapis.com/css?family=Muli:300,400,300italic,400italic", array(), null );
	}

	/* translators: If there are characters in your language that are not supported
	   by Enriqueta, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Enriqueta font: on or off', 'confit' ) ) {
		$protocol = is_ssl() ? 'https' : 'http';
		wp_register_style( 'confit-font-enriqueta', "$protocol://fonts.googleapis.com/css?family=Enriqueta:400,700&subset=latin,latin-ext", array(), null );
	}
}
add_action( 'init', 'confit_fonts' );

/**
 * Enqueue scripts and styles
 */
function confit_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_style( 'confit-font-muli' );

	wp_enqueue_style( 'confit-font-enriqueta' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120926', true );
}
add_action( 'wp_enqueue_scripts', 'confit_scripts' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 */
function confit_admin_fonts( $hook_suffix ) {
	if ( 'appearance_page_custom-header' != $hook_suffix )
		return;
	wp_enqueue_style( 'confit-font-muli' );
	wp_enqueue_style( 'confit-font-enriqueta' );
}
add_action( 'admin_enqueue_scripts', 'confit_admin_fonts' );

/**
 * Override background image with featured image if there is attached to a page.
 */
function confit_page_background_image() {
	global $post;

	// Check if it's on mobile or iPad and if it is set $mobile true.
	$mobile = false;

	if ( wp_is_mobile() )
		$mobile = true;

	// Get the normal background image.
	$background_image_url = get_background_image();

	// If it's not mobile and if it's not a page, then just bail.
	if ( ( false == $mobile ) && ! is_page()  ) :
		return;

	// It's not mobile but it's page and has a featured image then use the featured image as the background image.
	elseif ( ( false == $mobile ) && ( is_page() && '' != get_the_post_thumbnail( $post->ID ) ) ) :

		$background_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'mobile-background' ); ?>

		<style type="text/css">
		body.custom-background {
			background-image: url(<?php echo $background_image_url[0]; ?>);
		}
		</style><?php

	// It's a mobile but it's not a page or it's page that doesn't have featured image, then move the normal background image from body to #mobile-background-holder so that it sticks when we scroll.
	elseif ( ( true == $mobile ) && ! is_page()
		||   ( true == $mobile ) && ( is_page() && '' == get_the_post_thumbnail( $post->ID ) ) ) : ?>

		<style type="text/css">
		body.custom-background {
			background-image: none;
		}
		#mobile-background-holder {
			background-image: url(<?php echo $background_image_url; ?>);
		}
		</style><?php

	// It's a mobile and it's a page that has a featured image then use the featured image as background image but for #mobile-background-holder so that it sticks when we scroll.
	elseif ( ( true == $mobile ) && ( is_page() && '' != get_the_post_thumbnail( $post->ID ) ) ) :

		$background_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'mobile-background' ); ?>

		<style type="text/css">
		body.custom-background {
			background-image: none;
		}
		#mobile-background-holder {
			background-image: url(<?php echo $background_image_url[0]; ?>);
		}
		</style><?php

	endif;

}
add_action( 'wp_head', 'confit_page_background_image', 11 );

/**
 * Remove the widont filter because of the limited space for post/page title in the design.
 */
function confit_wido() {
	remove_filter( 'the_title', 'widont' );
}
add_action( 'init', 'confit_wido' );

/**
 * Add a Menu uploader to Customizer.
 */
function confit_customize( $wp_customize ) {
	$wp_customize->add_section( 'confit_settings', array(
		'title'      => __( 'Theme Option', 'confit' ),
		'priority'   => 35,
	) );

	$wp_customize->add_setting( 'menu_upload', array(
		'default'    => '',
	) );

	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'menu_upload', array(
		'label'      => __( 'Menu Upload (PDF recommended)', 'confit' ),
		'section'    => 'confit_settings',
		'settings'   => 'menu_upload',
	) ) );
}
add_action( 'customize_register', 'confit_customize' );

// Editor styles
add_editor_style( 'editor.css' );

// Set Distraction Free Writing width
set_user_setting( 'dfw_width', 570 );
