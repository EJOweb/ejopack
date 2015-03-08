<?php
/**
 * Plugin Name: EJOpack
 * Plugin URI: http://github.com/ejoweb
 * Description: Bundle of modules to support and extend the theme. By EJOweb.
 * Version: 0.3.3
 * Author: Erik Joling
 * Author URI: http://www.erikjoling.nl/
 *
 * Minimum PHP version: 5.3.0
 *
 * @package   EJOpack
 * @version   0.1.0
 * @since     0.1.0
 * @author    Erik Joling <erik@ejoweb.nl>
 * @copyright Copyright (c) 2015, Erik Joling
 * @link      http://github.com/ejoweb
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// add_action( 'plugins_loaded', array( 'Jetpack', 'load_modules' ), 100 );
// $modules = array_filter( Jetpack::get_active_modules(), array( 'Jetpack', 'is_module' ) );
// require Jetpack::get_module_path( $module );
// get_active_modules() {
// 		$active = Jetpack_Options::get_option( 'active_modules' );
// }
// class Jetpack_Carousel {
//	no instance
// }
// new Jetpack_Carousel;

class EJOpack 
{
	//* Holds the instance of this class.
	private static $instance;

	//* Modules setup
	private static $available_modules = array(
		'feature-last-post',
		'facebook-likebox',
		'performance-testing',
		'menu-marquee',
		'fancybox',
		'selectivizr',
		'extended-recent-posts-widget',
		'font-awesome',
		'dynamic-sidebars',
		'wordpress-admin-control',
		'testimonials-heavy',
	);

	public $active_modules;

	//* Plugin setup.
	public function __construct() {

		/* Set the properties needed by the plugin. */
		add_action( 'plugins_loaded', array( $this, 'setup' ), 101 );

		/* Load the base files. */
		add_action( 'plugins_loaded', array( $this, 'load_base' ), 102 );

		/* Load the modules files. */
		add_action( 'plugins_loaded', array( $this, 'load_active_modules' ), 103 );

	}

	//* Defines the directory path and URI for the plugin.
	public function setup() 
	{
		// Store directory path and url of this plugin
		define( 'EJOPACK_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'EJOPACK_URI', trailingslashit( plugin_dir_url(  __FILE__ ) ) );

		// Store base directory path and url of this plugin
		define( 'EJOPACK_BASE_DIR', trailingslashit( EJOPACK_DIR . 'base' ) );
		define( 'EJOPACK_BASE_URI', trailingslashit( EJOPACK_URI . 'base' ) );

		// Store module directory path and url of this plugin
		define( 'EJOPACK_MODULES_DIR', trailingslashit( EJOPACK_DIR . 'modules' ) );
		define( 'EJOPACK_MODULES_URI', trailingslashit( EJOPACK_URI . 'modules' ) );

		//* Set version based on metadata at top of this file
		$plugin_data = get_file_data( __FILE__, array('Version' => 'Version') );
		define( 'EJOPACK_VERSION', $plugin_data['Version'] );
	}

	public static function get_available_modules()
	{
		return apply_filters( 'ejopack_available_modules', self::$available_modules );
	}

	//* Loads base.
	public function load_base() 
	{
		require EJOPACK_BASE_DIR . 'write_log.php';
	}

	//* Loads modules.
	public function load_active_modules() 
	{
		require EJOPACK_MODULES_DIR . 'test.php';
		// $active_modules = array();
		// $active_modules = apply_filters('ejopack_active_modules', $active_modules);

		// // write_log($active_modules);

		// require EJOPACK_MODULES_DIR . 'module.php';

		// // Load the files of all active modules
		// foreach ($active_modules as $module) {
		// 	// Get module file
		// 	$file = $this->get_module_file( $module );
		// 	if ( ! file_exists( $file ) ) {
		// 		continue;
		// 	}
		// 	require $file;
		// }
	}

	//*
	public function add_settings_page()
	{
		add_management_page(  
			'EJOpack Instellingen', 
			'EJOpack', 
			'manage_options', 
			'ejopack-settings', 
			array( $this, 'settings_page' ) 
		);
	}

	//*
	public function settings_page()
	{
	?>
		<div class='wrap' style="max-width:960px;">
			<h2>EJOpack Instellingen</h2>
		</div>
	<?php
	}

	//* Returns the instance.
	public static function init() 
	{
		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

new EJOpack;
