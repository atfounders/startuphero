<?php
/**
 * WordPress.com-specific functions and definitions
 *
 * @package Confit
 * @since Confit 1.0
 */

global $themecolors;

/**
 * Set a default theme color array for WP.com.
 *
 * @global array $themecolors
 * @since Confit 1.0
 */
$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'cdc9c9',
	'text' => '36312d',
	'link' => 'e94f1d',
	'url' => 'e94f1d',
);

/*
 * De-queue Google fonts if custom fonts are being used instead
 *
 * @since Confit 1.0
 */
function confit_dequeue_fonts() {
	if ( class_exists( 'TypekitData' ) ) {
		if ( TypekitData::get( 'upgraded' ) ) {
			$customfonts = TypekitData::get( 'families' );
			if ( ! $customfonts )
				return;

			$site_title = $customfonts['site-title'];
			$headings = $customfonts['headings'];
			$body_text = $customfonts['body-text'];

			if ( $site_title['id'] && $headings['id'] && $body_text['id'] ) {
				wp_dequeue_style( 'confit-font-muli' );
				wp_dequeue_style( 'confit-font-enriqueta' );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'confit_dequeue_fonts' );