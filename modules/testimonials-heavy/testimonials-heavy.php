<?php

final class Testimonials_Heavy extends EJOpack_Module 
{
	//* Holds the instance of this class.
	protected static $instance;

	//* Version number of this module
	public $version = '1.0.0';

	//* Store the slug of this module
	public $slug;

	//* Store the post_type of this module
	public $post_type_name = 'ejo_testimonials';

	//* Plugin setup.
	protected function __construct() 
	{
		add_action( 'plugins_loaded', array( $this, 'setup' ) );
		add_action( 'init', array( $this, 'register_testimonials_post_type' ) );

		add_action( 'add_meta_boxes_'.$this->post_type_name, array( $this, 'add_testimonials_metabox' ) );
	}

	//*
	public function setup() 
	{
		$this->slug = self::get_slug( __FILE__ );
	}

	//*
	public function register_testimonials_post_type() 
	{
		include( EJOpack::get_module_path( $this->slug ) . 'register_post_type.php' );
	}

	//*
	public function add_testimonials_metabox() 
	{
		//add_meta_box( 'ejo_dynamic_sidebar_metabox', 'Kies de zijbalk', 'ejo_render_dynamic_sidebar_metabox', 'page', 'normal', 'default' );
		wp_die( 'test' );
	}
}

Testimonials_Heavy::get_instance();