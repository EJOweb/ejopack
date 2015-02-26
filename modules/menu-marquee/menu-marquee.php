<?php

class Menu_Marquee 
{
	//* Holds the instance of this class.
	private static $instance;

	//* Store the slug of this module
	public static $slug = 'menu-marquee';

	//* Version number of this module
	public static $version = '1.0.0';

	//* Plugin setup.
	public function __construct() 
	{
		add_action( 'plugins_loaded', array( $this, 'includes' ) );
		add_action( 'widgets_init', array( $this, 'register_widget' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_script') );
	}

	//*
	public function includes() 
	{
		require_once( EJOpack::get_module_path( self::$slug ) . 'menu-marquee-widget.php' );
	}

	//*
	public function register_widget() 
	{
		register_widget( 'Menu_Marquee_Widget' );
	}

	//*
	public function add_script()
	{
		//* Menu Marquee
		//* filter toevoegen zodat ik op laag niveau conditionals kan toepassen
		wp_enqueue_script( 'jquery-marquee', EJOpack::get_module_uri( self::$slug ) . 'js/jquery.marquee.min.js', array( 'jquery' ), self::$version, true );
	}

	//* Returns the instance.
	public static function init() 
	{
		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

Menu_Marquee::init();