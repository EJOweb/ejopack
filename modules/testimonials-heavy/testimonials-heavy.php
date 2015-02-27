<?php

class Testimonials_Heavy 
{
	//* Holds the instance of this class.
	private static $instance;

	//* Version number of this module
	public $version = '1.0.0';

	//* Store the slug of this module
	public static $slug = 'testimonials-heavy';

	//* Store the post_type of this module
	public static $post_type_name = 'ejo_testimonials';

	//* Plugin setup.
	public function __construct() 
	{
		add_action( 'init', array( $this, 'register_testimonials_post_type' ) );

		add_action( 'add_meta_boxes_'.self::$post_type_name, array( $this, 'add_testimonials_metabox' ) );
	}

	//*
	public function register_testimonials_post_type() 
	{
		include( EJOpack::get_module_path( self::$slug ) . 'register_post_type.php' );
	}

	//*
	public function add_testimonials_metabox() 
	{
		//add_meta_box( 'ejo_dynamic_sidebar_metabox', 'Kies de zijbalk', 'ejo_render_dynamic_sidebar_metabox', 'page', 'normal', 'default' );
		wp_die( 'test' );
	}

	//* Returns the instance.
	public static function init() 
	{
		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

Testimonials_Heavy::init();

wp_die( Testimonials_Heavy::init()->$version );