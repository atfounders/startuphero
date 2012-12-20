<?php
/**
 * @package open table
 * @version 1.6
 */
/*
Plugin Name: Open Table
Plugin URI: http://wordpress.org/extend/plugins/open table/
Description:
Author: JCakeC
Version: 1.6
Author URI: http://wordpress.org/extend/plugins/open table/
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

class Open_Table_Widget extends WP_widget {

	var $text_domain = 'open-table-widget';
	var $widget_var_name = 'open_table_widget';
	var $default_values;
	var $widget_directory;


	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(
	 		$this->widget_var_name, // Base ID
			'Open Table Widget', // Name
			array( 'description' => __( 'Open Table Widget for WordPress', $this->text_domain ), ) // Args
		);

		$this->widget_path = plugin_dir_url( __FILE__ );

		$this->default_values = array(
						'title'       => __( 'My Open Table Widget', $this->text_domain ),
						'stuff'       => '' , //adding just to be sure it's there.
					);
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$instance = $this->default_check( $instance );
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		echo $this->build_element( $instance );

		echo $after_widget;
	}

	/**
	 * Value Default Value
	 *
	 * @param array  $instance Values from database.
	 * @param string $element Value to check
	 */
	public function default_value( $instance, $element ) {
		$return_value = '';
		if ( isset ( $instance[ $element ] ) ) {
			$return_value = $instance[ $element ];
		}
		else {
			$return_value = $this->default_values[ $element ];
		}

		return $return_value;
	}


	/**
	 * Value Default Check
	 *
	 * @param array  $instance Values from database.
	 * @param string $element Value to check
	 */
	public function default_check( $instance ) {
		$instance['title']   = $this->default_value( $instance, 'title' );
		$instance['stuff']   = $this->default_value( $instance, 'stuff' );
		return $instance;
	}


	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']   =  $new_instance['title'];
		$instance['stuff']   =  $new_instance['stuff'];
		$instance['params']  =  $this->extract_params( $instance['stuff'] );

		return $instance;
	}


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$instance = $this->default_check( $instance );
		$title = $instance['title'];
		$stuff = $instance['stuff'];
		include 'forms/widget-form.php';
	}

	/**
	 * Parse Javascript elements so we don't let them execute any weird code.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param string. The Javascript copies from OpenTable Website..
	 */
	public function extract_params( $js_string ) {
		$allowed_args = array(
						'rid',
						'bgcolor',
						'titlecolor',
						'subtitlecolor',
						'btnbgimage',
						'otlink',
						'icon',
						'mode',
					);
		$return_vals = array();
		$parts = parse_url( $js_string );

		if ( isset( $parts['query'] ) ) {
			parse_str( urldecode( $parts['query'] ), $parts['query'] );
		}

		foreach( $allowed_args as $arg  ) {
			if ( array_key_exists( $arg, $parts['query'] ) )
				$return_vals[$arg] = strip_tags( $parts['query'][$arg] );
		}

		return $return_vals;
	}

	function build_element( $instance ) {
		if ( array_key_exists( 'params', $instance ) ) {
			$instance['params'] = urlencode_deep( $instance['params'] );

			return '<script type="text/javascript" src="' . esc_url( 'http://www.opentable.com/frontdoor/default.aspx?rid=' .
					$instance['params']['rid'] .
					'&restref=' .
					$instance['params']['rid'] .
					'&bgcolor=' .
					$instance['params']['bgcolor'] .
					'&titlecolor=' .
					$instance['params']['titlecolor'] .
					'&subtitlecolor=' .
					$instance['params']['subtitlecolor'] .
					'&btnbgimage=' .
					$instance['params']['btnbgimage'] .
					'&otlink=' .
					$instance['params']['otlink'] .
					'&icon=' .
					$instance['params']['icon'] .
					'&mode=ist&hover=1'
			) . '"></script>';
		}

		return '';
	}
}
