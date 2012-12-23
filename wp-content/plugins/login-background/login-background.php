<?php
/* 
Plugin Name: Login Background
Plugin URI: http://github.com/ryanimel/login-background
Description: Add a file called <code>login-background.jpg</code> to your <code>/wp-content/</code> directory to easily add a background image to your WordPress login screen. Inspired by Mark Jaquith's simple Login Logo plugin.
Version: 0.1
Author: Ryan Imel
Author URI: http://ryanimel.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


class RWI_Login_Background_Plugin {
	static $instance;
	var $logo_locations;
	var $logo_location;
	var $logo_file_exists;


	public function __construct() {
		self::$instance = $this;
		add_action( 'login_head', array( $this, 'login_head' ) );
	}

	
	// Look for the file URL
	public function init() {
		global $blog_id;
		$this->logo_locations = array();
		$filename = 'login-background';
		
		if ( is_multisite() && function_exists( 'get_current_site' ) ) {
			// First, see if there is one for this specific site (blog)
			$this->logo_locations['site'] = array(
				'path' => WP_CONTENT_DIR . '/' . $filename . '-site-' . $blog_id . '.jpg',
				'url' => $this->maybe_ssl( WP_CONTENT_URL . '/' . $filename . '-site-' . $blog_id . '.jpg' )
			);

			// Next, we see if there is one for this specific network
			$site = get_current_site(); // Site = Network? Ugh.
			if ( $site && isset( $site->id ) ) {
				$this->logo_locations['network'] = array(
					'path' => WP_CONTENT_DIR . '/' . $filename . '-network-' . $site->id . '.jpg',
					'url' => $this->maybe_ssl( WP_CONTENT_URL . '/' . $filename . '-network-' . $site->id . '.jpg' )
					);
			}
		}
		// Finally, we do a global lookup
		$this->logo_locations['global'] =  array(
			'path' => WP_CONTENT_DIR . '/' . $filename . '.jpg',
			'url' => $this->maybe_ssl( WP_CONTENT_URL . '/' . $filename . '.jpg' )
			);
		
	}


	// Check whether SSL is needed
	private function maybe_ssl( $url ) {
		if ( is_ssl() )
			$url = preg_replace( '#^http://#', 'https://', $url );
		return $url;
	}
	
	
	// Does the file exist?
	private function logo_file_exists() {
		if ( ! isset( $this->logo_file_exists ) ) {
			foreach ( $this->logo_locations as $location ) {
				
				if ( file_exists( $location['path'] ) ) {
					$this->logo_file_exists = true;
					$this->logo_location = $location;
					break;
				} else {
					$this->logo_file_exists = false;
				}
			
			}
		}
		return !! $this->logo_file_exists;
	}


	// Function to get the file URL
	private function get_location( $what = '' ) {
		if ( $this->logo_file_exists() ) {
			
			if ( 'path' == $what || 'url' == $what )
				return $this->logo_location[$what];
			else
				return $this->logo_location;
		
		}
		return false;
	}


	// 
	public function login_headerurl() {
		return trailingslashit( get_bloginfo( 'url' ) );
	}


	// Hook into the login head
	public function login_head() {
		
		$this->init();
				
		if ( !$this->logo_file_exists() )
			return;
		
		add_filter( 'login_headerurl', array( $this, 'login_headerurl' ) );
		
		$thecolor = get_background_color();
		
		if ( !$thecolor ) {
			$thecolor = 'e6e6e6'; 
		}
	
	?>
	<!-- Login Background plugin: http://github.com/ryanimel/login-background/ -->
	<style type="text/css">
		body {
			background: #<?php echo $thecolor; ?> url(<?php echo esc_url_raw( $this->get_location( 'url' ) ); ?>) no-repeat top center !important;
		}

		#login {
			padding-top: 60px !important;
		}

		html {
			background: #e6e6e6;
		}

		#loginform {
			margin-bottom: 21px;
		}

		p#nav,
		p#backtoblog { 
			background: #fff;
			border: 1px solid #eee;
			margin-left: 8px !important;
			padding: 15px !important;
		}

		p#nav { 
			border-bottom: 0 !important;
			margin-bottom: -2px !important;
			padding-bottom: 2px !important;
			-moz-box-shadow: rgba(200, 200, 200, 0.7) 0px 4px 10px -1px;
			-webkit-box-shadow: rgba(200, 200, 200, 0.7) 0px 4px 10px -1px;
			box-shadow: rgba(200, 200, 200, 0.7) 0px 4px 10px -1px;
		}

		.login p#backtoblog {
			border-top: 0 !important;
			margin-bottom: 21px !important;
			padding-top: 5px !important;
		}

		.login p#backtoblog a {
			color: #999 !important;
			font-size: 9px !important;
		}

		#login {
			padding-bottom: 42px;
		}
	</style>
<?php
	}

}

// Bootstrap
new RWI_Login_Background_Plugin;
