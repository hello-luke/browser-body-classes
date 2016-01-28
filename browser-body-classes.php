<?php

/**
 * Plugin Name:       Browser Body Class
 * Plugin URI:       
 * Description:       Add unique classes to the body tag for easy styling based on user's device and browser
 * Version:           1.0.0
 * Author:            Łukasz Kowalski
 * Author URI:        http://heloluke.eu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Run the plugin
 * @since 1.0.0
 */
function browser_body_classes_run() {

	if (is_admin()){

		require( plugin_dir_path( __FILE__ ) . 'admin/class-browser-body-classes-admin.php' );
		add_action( 'plugins_loaded', array( 'Browser_Body_Classes_Admin', 'get_instance' ) );

	}

	if ( ! is_admin() ) {

		require( plugin_dir_path( __FILE__ ) . 'public/class-browser-body-classes.php' );
		add_action( 'plugins_loaded', array( 'Browser_Body_Classes', 'get_instance' ) );

	}

}

browser_body_classes_run();