<?php
/**
 * Plugin Name: EJOpack
 * Plugin URI: http://github.com/ejoweb
 * Description: Bundle of modules to support and extend the theme.
 * Version: 0.1.0
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

class EJOpack 
{
	//* Holds the instance of this class.
	private static $instance;

	//* Stores the version of this plugin.
	public static $version;

	//* Stores the directory path for this plugin.
	public static $dir;

	//* Stores the directory URI for this plugin.
	public static $uri;

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
		'menu-marquee',
		'wordpress-admin-control',
		'testimonials-heavy',
	);

	//* Plugin setup.
	public function __construct() {

		/* Set the properties needed by the plugin. */
		add_action( 'plugins_loaded', array( $this, 'setup' ), 1 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( $this, 'load_modules' ), 3 );
	}

	//* Defines the directory path and URI for the plugin.
	public function setup() 
	{
		// Store directory path and url of this plugin
		self::$dir = trailingslashit( plugin_dir_path( __FILE__ ) );
		self::$uri = trailingslashit( plugin_dir_url(  __FILE__ ) );

		// Get metadata of this plugin
		$plugin_data = get_plugin_data( __FILE__ );

		// Store version of this plugin
		self::$version = $plugin_data['Version'];
	}

	//* Loads modules.
	public function load_modules() 
	{
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
		return self::$dir . "modules/{$slug}/";
	}

	//* Generate a module's uri from its slug.
	public static function get_module_uri( $slug ) 
	{
		return self::$uri . "modules/{$slug}/";
	}

	//* Returns the instance.
	public static function init() 
	{
		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

EJOpack::init();

