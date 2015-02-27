<?php
/**
 * Plugin Name: EJOpack
 * Plugin URI: http://github.com/ejoweb
 * Description: Bundle of modules to support and extend the theme.
 * Version: 0.2.2
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

	//* Stores the base directory path for this plugin.
	public static $base_dir;

	//* Stores the base directory uri for this plugin.
	public static $base_uri;

	//* Stores the modules directory path for this plugin.
	public static $modules_dir;

	//* Stores the modules directory uri for this plugin.
	public static $modules_uri;

	//* Modules setup
	public static $available_modules = array(
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

	public static $active_modules = array(
		// 'menu-marquee',
		// 'wordpress-admin-control',
		'testimonials-heavy',
	);

	//* Plugin setup.
	private function __construct() {

		/* Set the properties needed by the plugin. */
		add_action( 'plugins_loaded', array( $this, 'setup' ), 1 );

		/* Load the modules files. */
		add_action( 'plugins_loaded', array( $this, 'load_base' ), 2 );

		/* Load the modules files. */
		add_action( 'plugins_loaded', array( $this, 'load_modules' ), 3 );
	}

	//* Defines the directory path and URI for the plugin.
	public function setup() 
	{
		// Store directory path and url of this plugin
		self::$dir = trailingslashit( plugin_dir_path( __FILE__ ) );
		self::$uri = trailingslashit( plugin_dir_url(  __FILE__ ) );

		// Store base directory path and url of this plugin
		self::$base_dir = trailingslashit( self::$dir . 'base' );
		self::$base_uri = trailingslashit( self::$uri . 'base' );

		// Store module directory path and url of this plugin
		self::$modules_dir = trailingslashit( self::$dir . 'modules' );
		self::$modules_uri = trailingslashit( self::$uri . 'modules' );

		// Get metadata of this plugin
		$plugin_data = get_plugin_data( __FILE__ );

		// Store version of this plugin
		self::$version = $plugin_data['Version'];
	}

	//* Loads base.
	public function load_base() 
	{
		require self::$base_dir . 'write_log.php';
	}

	//* Loads modules.
	public function load_modules() 
	{
		require self::$modules_dir . 'module.php';

		// Load the files of all active modules
		foreach (self::$available_modules as $module) {

			// Check if active
			if ( in_array( $module, self::$active_modules ) ) {

				// Get module file
				$file = self::get_module_file( $module );
				if ( ! file_exists( $file ) ) {
					continue;
				}

				require $file;
			}
		}
	}

	//* Generate a module's path from its slug.
	public static function get_module_file( $slug ) 
	{
		return self::get_module_path($slug) . "{$slug}.php";
	}

	//* Generate a module's path from its slug.
	public static function get_module_path( $slug ) 
	{
		return trailingslashit( self::$modules_dir . $slug );
	}

	//* Generate a module's uri from its slug.
	public static function get_module_uri( $slug ) 
	{
		return trailingslashit( self::$modules_uri . $slug );
	}

	//* Returns the instance.
	public static function get_instance() 
	{
		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

EJOpack::get_instance();
