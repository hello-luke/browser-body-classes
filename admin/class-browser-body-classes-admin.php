<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Browser_Body_Classes
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

class Browser_Body_Classes_Admin{

	
	/**
     * Options Page title/menu title
     * @var string
     */
	protected $admin_page_title;protected $admin_menu_title;

	/* Allow only one instance of this class. */
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

		$this->admin_page_title = __( 'Browser Body Classes' );
		$this->admin_menu_title = __( 'Browser Body Classes' );

		// Initialize our hooks
		$this->hooks();

	}

	/**
	 * Initiate our hooks
	 * @since 1.0.0
	 */
	public function hooks() {

		add_action( 'admin_init', array( $this, 'set_default_values' ) );
		add_action( 'admin_menu', array( $this, 'plugin_add_options'));
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_bbc_scripts' ) );

	}

	/**
	 * Set plugin default values
	 * @since    1.0.0
	 */
	public function set_default_values(){

		$bbc_defaults = array(
			'show_device_type'=> 0,
			'show_os_type'=> 0,
			'show_browser_type'=> 0,
			'show_browser_version'=> 1,
			'show_seven_inch'=> 0,
			'show_orientation'=> 0,
			'minify_scripts'=> 1,
		);

		add_option( 'bbc_options', $bbc_defaults );

	}

	/**
	 * Add Options Page
	 * @since    1.0.0
	 */
	public function plugin_add_options() {

		add_submenu_page( 'options-general.php', $this->admin_page_title, $this->admin_menu_title, 'manage_options', 'browser-body-classes-options', array(&$this, 'render_options_page'));
		
	}

	/**
	 * Options Page content
	 * @since  1.0.0
	 */
	public function render_options_page() {

		$this->options = get_option( 'bbc_options' );
		?>

		<div class="wrap bbc-options-wrap">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>            
			<form method="post" action="options.php">
			<?php
				// This prints out all hidden setting fields
				settings_fields( 'bbc_option_group' );   
				do_settings_sections( 'bbc_settings' );
				submit_button(); 
			?>
			</form>
		</div>
		<?php
	}

	/**
	 * Add options
	 * @since  1.0.0
	 */
	public function page_init() {

		register_setting(
			'bbc_option_group', // Option group
			'bbc_options', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		dd_settings_section(
			'bbc_general_settings', // ID
			'Enter your settings below:', // Title
			array( $this, 'print_section_info' ), // Callback
			'bbc_settings' // Page
		);

		// Add option for device type class
		add_settings_field(
			'show_device_type', // ID
			'Add device type class?', // Title 
			array( $this, 'show_device_type_callback' ), // Callback
			'bbc_settings', // Page
			'bbc_general_settings' // Section     
		);

		// Add option for os type class
		add_settings_field(
			'show_os_type', // ID
			'Add OS type class?', // Title 
			array( $this, 'show_os_type_callback' ), // Callback
			'bbc_settings', // Page
			'bbc_general_settings' // Section     
		);

		// Add option for browser type class
		add_settings_field(
			'show_browser_type', // ID
			'Add browser type class?', // Title 
			array( $this, 'show_browser_type_callback' ), // Callback
			'bbc_settings', // Page
			'bbc_general_settings' // Section     
		);

		// Add option for browser version class
		add_settings_field(
			'show_browser_version', // ID
			'Add browser version class?', // Title 
			array( $this, 'show_browser_version_callback' ), // Callback
			'bbc_settings', // Page
			'bbc_general_settings' // Section     
		);

		// Add option for browser version class
		add_settings_field(
			'show_browser_version', // ID
			'Add browser version class?', // Title 
			 array( $this, 'show_browser_version_callback' ), // Callback
			'bbc_settings', // Page
			'bbc_general_settings' // Section     
		);

		// Add option for browser version class
		add_settings_field(
			'show_seven_inch', // ID
			'Add seven inch device class?', // Title 
			array( $this, 'show_seven_inch_callback' ), // Callback
			'bbc_settings', // Page
			'bbc_general_settings' // Section     
		);

		// Add option for browser version class
		add_settings_field(
			'show_orientation', // ID
			'Add device orientation class?', // Title 
			array( $this, 'show_orientation_callback' ), // Callback
			'bbc_settings', // Page
			'bbc_general_settings' // Section     
		);

		// Add option for lighweight
		add_settings_field(
			'minify_scripts', // ID
			'Minify scripts?', // Title 
			array( $this, 'minify_scripts_callback' ), // Callback
			'bbc_settings', // Page
			'bbc_general_settings' // Section     
		);

	}

	/**
     * Sanitize each setting field as needed
     * @since  1.0.0
     * @param array $input Contains all settings fields as array keys
     */
	public function sanitize( $input ){

		//create empty array of new values
		$new_input = array();

		$options_arr = array('show_device_type','show_os_type','show_browser_type','show_browser_version','show_seven_inch','show_orientation','minify_scripts');

		foreach ($options_arr as $option) {

			if( isset( $input[$option] ) )
				$new_input[$option] = absint( $input[$option] );
			else
				$new_input[$option] = 0;

		}

		return $new_input;

	}

	/** 
     * Print the Section text
     * @since  1.0.0
     */
	public function print_section_info() {
		//empty
	}

	// Progress Bar show/hide on hompage callback
	public function show_device_type_callback() {

		$options = get_option( 'bbc_options' );
		?>
		<input id="show-device" type='checkbox' name='bbc_options[show_device_type]' <?php checked( $options['show_device_type'], 1 ); ?> value='1'>
		<span>Example: desktop / tablet / phone</span>
		<?php

	}

	// Progress Bar show/hide on hompage callback
	public function show_os_type_callback() {

		$options = get_option( 'bbc_options' );
		?>
		<input id="show-os" type='checkbox' name='bbc_options[show_os_type]' <?php checked( $options['show_os_type'], 1 ); ?> value='1'>
		<span>Example: mac, windows, android, ios, windows-phone </span>
		<?php

	}

	public function show_browser_type_callback() {

		$options = get_option( 'bbc_options' );
		?>
		<input id="show-browser" type='checkbox' name='bbc_options[show_browser_type]' <?php checked( $options['show_browser_type'], 1 ); ?> value='1'>
		<span>Example: chrome, safari, ie, opera </span>
		<?php

	}

	public function show_browser_version_callback() {

		$options = get_option( 'bbc_options' );
		?>
		<input id="show-browser-version" type='checkbox' name='bbc_options[show_browser_version]' <?php checked( $options['show_browser_version'], 1 ); ?> value='1'>
		<span>Example: chrome48, safari9, ie11 </span>
		<?php

	}

	public function show_seven_inch_callback() {

		$options = get_option( 'bbc_options' );
		?>
		<input id="seven-inch" type='checkbox' name='bbc_options[show_seven_inch]' <?php checked( $options['show_seven_inch'], 1 ); ?> value='1'>
		<span>"seven-inch" class is added for: Nexus 7, Kindle Fire, Nook Tablet 7 inch, Galaxy Tab 7 inch</span>
		<?php

	}

	public function show_orientation_callback() {

		$options = get_option( 'bbc_options' );
		?>
		<input id="device-orientation" type='checkbox' name='bbc_options[show_orientation]' <?php checked( $options['show_orientation'], 1 ); ?> value='1'>
		<span>Example: portrait, landscape, orientation-changed</span>
		<?php

	}

	public function minify_scripts_callback() {

		$options = get_option( 'bbc_options' );
		?>
		<input id="minify-scripts" type='checkbox' name='bbc_options[minify_scripts]' <?php checked( $options['minify_scripts'], 1 ); ?> value='1'>
		<span>Use only 1 minified js file to generate your classes (only 4 KB )</span>
		<?php

	}

	// load necessary styles
	public function load_bbc_scripts(){
		wp_enqueue_style( 'bbc-admin-styles', plugin_dir_url( __FILE__ ) . 'assets/css/browser-body-classes-admin.css' );
	}

}