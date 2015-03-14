<?php
/**
 * Plugin Name: EJOpack
 * Plugin URI: http://github.com/ejoweb
 * Description: Bundle of modules to support and extend the theme. By EJOweb.
 * Version: 0.4.0
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

//* Load classes
require( EJOpack::$dir . 'classes/class.settings.php' );

final class EJOpack 
{
	//* Holds the instance of this class.
	private static $instance;

	//* Stores the version of this plugin.
	public static $version;

	//* Stores the directory path for this plugin.
	public static $dir;

	//* Stores the directory URI for this plugin.
	public static $uri;

	//* Stores the inc directory path for this plugin.
	public static $inc_dir;

	//* Stores the inc directory uri for this plugin.
	public static $inc_uri;

	//* Stores the base directory path for this plugin.
	public static $base_dir;

	//* Stores the base directory uri for this plugin.
	public static $base_uri;

	//* Stores the modules directory path for this plugin.
	public static $modules_dir;

	//* Stores the modules directory uri for this plugin.
	public static $modules_uri;

	//* Stores all the modules
	public static $all_modules;

	//* Stores the active modules
	public static $active_modules;

	//* Plugin setup.
	private function __construct() 
	{
		//* Set the properties needed by the plugin.
		add_action( 'plugins_loaded', array( $this, 'setup' ) );

		//* Load the base files.
		add_action( 'plugins_loaded', array( $this, 'load_base' ) );

		//* Load the modules files.
		add_action( 'plugins_loaded', array( $this, 'load_modules' ) );

		//* Call class for settingspage
		EJOpack_Settings::init();
	}

	//* Defines the directory path and URI for the plugin.
	public static function setup() 
	{
		// Store directory path and url of this plugin
		self::$dir = trailingslashit( plugin_dir_path( __FILE__ ) );
		self::$uri = trailingslashit( plugin_dir_url(  __FILE__ ) );

		// Store inc directory path and url of this plugin
		self::$inc_dir = trailingslashit( self::$dir . 'inc' );
		self::$inc_uri = trailingslashit( self::$uri . 'inc' );

		// Store base directory path and url of this plugin
		self::$base_dir = trailingslashit( self::$dir . 'base' );
		self::$base_uri = trailingslashit( self::$uri . 'base' );

		// Store module directory path and url of this plugin
		self::$modules_dir = trailingslashit( self::$dir . 'modules' );
		self::$modules_uri = trailingslashit( self::$uri . 'modules' );

		//* Set version based on metadata at top of this file
		self::$version = self::get_version(); 

		//* Stores all the modules
		self::$all_modules = self::get_all_modules();

		//* Stores the active modules
		self::$active_modules = self::get_active_modules();
	}

	//* Get version number
	private static function get_version()
	{
		//* Get metadata of this plugin
		$plugin_data = get_file_data( __FILE__, array('Version' => 'Version') );

		//* Return version number
		return $plugin_data['Version'];
	}

	//* Get all modules
	private static function get_all_modules()
	{
		//* Get path of all folders in module-directory
		$module_subdirectories = glob( self::$modules_dir . '*', GLOB_ONLYDIR );

		//* Get slug from module paths
		$module_list = array_map( 'basename', $module_subdirectories );

		//* Remove waiting-line from module
		if ( ($key = array_search( '_concept-modules', $module_list)) !== false ) 
			unset($module_list[$key]);

		//* Return the list
		return $module_list;
	}

	//* Get all modules
	private static function get_active_modules()
	{
		//* Load active modules from database
		$active_modules = get_option( '_ejopack_active_modules', array() );

		//* Temporary activation solution
		$active_modules[] = 'testimonials-heavy';
		$active_modules[] = 'menu-marquee';

		//* Return the slugs
		return $active_modules;
	}

	//* Loads base.
	public static function load_base() 
	{
		// require EJOPACK_BASE_DIR . 'write_log.php';
		require  self::$base_dir . 'write_log.php';
	}

	//* Loads modules.
	public function load_modules() 
	{
		// require EJOPACK_MODULES_DIR . 'test.php';
		// write_log( self::$active_modules );

		
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

	

	//* Returns the instance.
	public static function init() 
	{
		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

//* Call EJOpack
EJOpack::init();
