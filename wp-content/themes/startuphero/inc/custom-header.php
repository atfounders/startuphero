<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 *
 * @package Confit
 * @since Confit 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Rework this function to remove WordPress 3.4 support when WordPress 3.6 is released.
 *
 * @uses confit_header_style()
 * @uses confit_admin_header_style()
 * @uses confit_admin_header_image()
 *
 * @package Confit
 */
function confit_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'default-text-color'     => 'E94F1D',
		'width'                  => 222,
		'height'                 => 78,
		'max-width'              => 444,
		'flex-width'             => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'confit_header_style',
		'admin-head-callback'    => 'confit_admin_header_style',
		'admin-preview-callback' => 'confit_admin_header_image',
	);

	$args = apply_filters( 'confit_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}
}
add_action( 'after_setup_theme', 'confit_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @todo Remove this function when WordPress 3.6 is released.
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Confit
 * @since Confit 1.1
 */

if ( ! function_exists( 'get_custom_header' ) ) {
	function get_custom_header() {
		return (object) array(
			'url'           => get_header_image(),
			'thumbnail_url' => get_header_image(),
			'width'         => HEADER_IMAGE_WIDTH,
			'height'        => HEADER_IMAGE_HEIGHT,
		);
	}
}

if ( ! function_exists( 'confit_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see confit_custom_header_setup().
 *
 * @since Confit 1.0
 */
function confit_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // confit_header_style

if ( ! function_exists( 'confit_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see confit_custom_header_setup().
 *
 * @since Confit 1.0
 */
function confit_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
		max-width: 222px;
	}
	#headimg h1,
	#desc {
		margin: 0;
		padding: 0;
	}
	#headimg h1 {
		font-family: 'Muli', Helvetica, Arial, sans-serif;
		font-size: 24px;
		font-weight: 300;
		line-height: 1;
	}
	#headimg h1 a {
		color: #E94F1D;
		text-decoration: none;
	}
	#headimg h1 a:hover {
		color: #85AA0C;
	}
	#desc {
		color: #8C8885 !important;
		font-family: "Enriqueta", Helvetica, Arial, sans-serif;
		font-size: 13px;
		font-weight: 400;
		line-height: 1.8571428571;
	}
	#headimg img {
		display: block;
		margin: 0 auto 24px;
		max-width: 100%
	}
	</style>
<?php
}
endif; // confit_admin_header_style

if ( ! function_exists( 'confit_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see confit_custom_header_setup().
 *
 * @since Confit 1.0
 */
function confit_admin_header_image() { ?>
	<div id="headimg">
		<?php
		if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_header_textcolor() . ';"';
		?>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
	</div>
<?php }
endif; // confit_admin_header_image