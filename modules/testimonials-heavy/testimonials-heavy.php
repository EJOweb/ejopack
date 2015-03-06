<?php

final class EJO_Testimonials extends EJOpack_Module 
{
	//* Holds the instance of this class.
	protected static $instance;

	//* Version number of this module
	public static $version = '0.8.1';

	//* Store the post_type of this module
	public static $post_type = 'ejo_testimonials';

	//* Store the slug of this module
	public static $slug;

	//* Stores the directory path for this module.
	public static $dir;

	//* Stores the directory URI for this module.
	public static $uri;

	//* Plugin setup.
	protected function __construct() 
	{
		/* SETUP */

		//* Setup data
		self::set_module_data();

		//* Include class files
		self::include_classes();

		//* Register Post Type
		add_action( 'init', array( $this, 'register_testimonials_post_type' ) );

		//* Metabox
		new EJO_Testimonials_Metabox( self::$post_type, self::$slug, self::$dir, self::$uri );

		//* Settings
		new EJO_Testimonials_Settings( self::$post_type, self::$slug, self::$dir, self::$uri );
	
		/* WIDGET */
		add_action( 'widgets_init', array( 'EJO_Testimonials_Widget', 'register' ) );
	}

	//* Setup
	private static function set_module_data() 
	{
		//* Slug
		self::$slug = self::get_slug( __FILE__ );

		//* Path & Url
		self::$dir = EJOpack::get_module_path( self::$slug );
		self::$uri = EJOpack::get_module_uri( self::$slug );
	}

	//* Setup
	private static function include_classes() 
	{
		//* Metabox
		include_once( self::$dir . 'inc/testimonials-metabox-class.php' );

		//* Settings
		include_once( self::$dir . 'inc/testimonials-settings-class.php' );

		//* Widget
		include_once( self::$dir . 'inc/testimonials-widget.php' );
	}

	//* Register Post Type
	public function register_testimonials_post_type() 
	{
		include( self::$dir . 'inc/register-post-type.php' );
	}
}

EJO_Testimonials::init();

include_once( EJO_Testimonials::$dir . 'inc/helper-functions.php' );