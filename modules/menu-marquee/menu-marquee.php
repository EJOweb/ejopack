<?php

final class Menu_Marquee 
{
	//* Holds the instance of this class.
	private static $instance;

	//* Store the slug of this module
	public $slug = 'menu-marquee';

	//* Version number of this module
	public $version = '1.0.0';

	//* Plugin setup.
	private function __construct() 
	{
		add_action( 'plugins_loaded', array( $this, 'includes' ) );
		add_action( 'widgets_init', array( $this, 'register_widget' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_script') );
	}

	//*
	public function includes() 
	{
		require_once( EJOpack::get_module_path( $this->slug ) . 'menu-marquee-widget.php' );
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
		wp_enqueue_script( 'jquery-marquee', EJOpack::get_module_uri( $this->slug ) . 'js/jquery.marquee.min.js', array( 'jquery' ), $this->version, true );
	}

	//* Returns the instance.
	public static function get_instance() 
	{
		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

Menu_Marquee::get_instance();