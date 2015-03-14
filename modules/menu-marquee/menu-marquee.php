<?php

//* Nog gelijktrekken met EOO EJOpack?

final class Menu_Marquee extends EJOpack_Module 
{
	//* Holds the instance of this class.
	protected static $instance;

	//* Version number of this module
	public $version = '1.1.0';

	//* Store the slug of this module
	public $slug = 'menu-marquee';

	//* Stores the directory path for this module.
	public $dir;

	//* Stores the directory URI for this module.
	public $uri;

	//* Plugin setup.
	protected function __construct() 
	{
		//* Setup data
		$this->setup();

		add_action( 'plugins_loaded', array( $this, 'includes' ) );
		add_action( 'widgets_init', array( $this, 'register_widget' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_script') );
	}

	//* Setup
	public function setup() 
	{
		//* Slug
		$this->slug = $this->get_slug( __FILE__ );

		//* Path & Url
		$this->dir = EJOpack::get_module_path( $this->slug );
		$this->uri = EJOpack::get_module_uri( $this->slug );
	}

	//*
	public function includes() 
	{
		require_once( $this->dir . 'menu-marquee-widget.php' );
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
		if (is_front_page())
			wp_enqueue_script( 'jquery-marquee', $this->uri . 'js/jquery.marquee.min.js', array( 'jquery' ), $this->version, true );
	}
}

Menu_Marquee::init();