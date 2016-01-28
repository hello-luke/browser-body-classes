<?php

/**
 * Define the main plugin class
 * @since 1.0.0
 * @package Browser_Body_Classes
 */

// Don't allow this file to be accessed directly.
if ( ! defined( 'WPINC' ) ) die;

class Browser_Body_Classes{

	/**
	 * Allow only one instance of this class.
	 * @since    1.0.0
	 */
	protected static $instance = null;

	public static function get_instance() {
		
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}

	/**
	 * Initialize the class
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->hooks();

	}

	/**
	 * Add hook
	 * @since    1.0.0
	 */
	public function hooks(){
		add_action( 'wp_enqueue_scripts', array(&$this, 'bbc_load_scripts'));
	}

	/**
	 * Load necessary scripts
	 * @since    1.0.0
	 */
	public function bbc_load_scripts() {

		$bbc_opts = get_option( 'bbc_options' ); 

		// JS
		if ( ! wp_script_is( 'jquery' )) wp_enqueue_script( 'jquery' );

		if ($bbc_opts['minify_scripts'] == 1){
			wp_enqueue_script( 'global-bbc-js', plugin_dir_url( __FILE__ ) . 'assets/js/bbc-global.min.js', array( 'jquery' ), false, true);
			wp_localize_script( 'global-bbc-js', 'bbc_options', $bbc_opts );
		} else {
			wp_enqueue_script( 'isMobile', plugin_dir_url( __FILE__ ) . 'assets/js/isMobile.js', array( 'jquery' ), false, true);
			wp_enqueue_script( 'bbc-js', plugin_dir_url( __FILE__ ) . 'assets/js/bbc-custom.js', array( 'jquery' ), false, true);
			wp_localize_script( 'bbc-js', 'bbc_options', $bbc_opts );
		}

	}

}