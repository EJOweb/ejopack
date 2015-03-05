<?php

final class Testimonials_Heavy extends EJOpack_Module 
{
	//* Holds the instance of this class.
	protected static $instance;

	//* Version number of this module
	public static $version = '0.8.0';

	//* Store the post_type of this module
	public static $post_type = 'ejo_testimonials';

	//* Store the slug of this module
	public static $slug;

	//* Stores the directory path for this module.
	public static $dir;

	//* Stores the directory URI for this module.
	public static $uri;
	public static $test;

	//* Plugin setup.
	protected function __construct() 
	{
		/* SETUP */

		//* Setup data
		$this->setup();
		
		//* Register Post Type
		add_action( 'init', array( $this, 'register_testimonials_post_type' ) );

		//* Load includes
		add_action( 'plugins_loaded', array( $this, 'includes' ) );


		/* METABOX */

		//* Add Referentie Metabox
		add_action( "add_meta_boxes_".self::$post_type, array( $this, 'add_testimonials_metabox' ) );

		//* Save Referentie Metadata
		add_action( 'save_post', array( $this, 'save_testimonial_metadata' ) );


		/* WIDGET */
		add_action( 'widgets_init', array( $this, 'register_widget' ) );


		/* SETTINGS PAGE */

		//* Register Settings for Settings Page
		add_action( 'admin_init', array( $this, 'initialize_testimonials_settings' ) );

		//* Add Settings Page
		add_action( 'admin_menu', array( $this, 'add_testimonials_setting_menu' ) );

		//* Add scripts to settings page
		add_action( 'admin_enqueue_scripts', array( $this, 'add_testimonials_settings_scripts_and_styles' ) ); 
	}

	//* Setup
	private static function setup() 
	{
		//* Slug
		self::$slug = self::get_slug( __FILE__ );

		//* Path & Url
		self::$dir = EJOpack::get_module_path( self::$slug );
		self::$uri = EJOpack::get_module_uri( self::$slug );

		self::$test = 'test2';
		self::$test = 'test3';
	}

	//* Register Post Type
	public function register_testimonials_post_type() 
	{
		include( self::$dir . 'inc/register-post-type.php' );
	}

	//* Load includes
	public function includes() 
	{
		require_once( self::$dir . 'inc/testimonials-heavy-widget.php' );
	}

	//*
	public function add_testimonials_metabox() 
	{
		add_meta_box( 
			self::$post_type. '_metabox', 
			'Referentie Informatie', 
			array( $this, 'render_testimonials_metabox' ), 
			self::$post_type, 
			'normal', 
			'high' 
		);
	}

	//*
	public function render_testimonials_metabox( $post )
	{
		include( self::$dir . 'admin/testimonials-metabox.php' );		
	}

	// Manage saving Metabox Data
	public function save_testimonial_metadata($post_id) 
	{
		//* Don't try to save the data under autosave, ajax, or future post.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
			return;
		if ( defined( 'DOING_CRON' ) && DOING_CRON )
			return;

		//* Don't save if WP is creating a revision (same as DOING_AUTOSAVE?)
		if ( wp_is_post_revision( $post_id ) )
			return;

		//* Check that the user is allowed to edit the post
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Verify where the data originated
		if ( !isset($_POST[self::$slug."-meta-nonce"]) || !wp_verify_nonce( $_POST[self::$slug."-meta-nonce"], self::$slug."-metabox-" . $post_id ) )
			return;

		$meta_key = self::$slug;

		if ( isset( $_POST[self::$slug] ) )
			update_post_meta( $post_id, $meta_key, $_POST[self::$slug] );
	}


	/***********************
	 * Widget
	 ***********************/
	public function register_widget() 
	{
		register_widget( 'Testimonials_Heavy_Widget' );
	}

	/***********************
	 * Settings Page
	 ***********************/

	//*
	public function add_testimonials_setting_menu()
	{
		add_submenu_page( 
			"edit.php?post_type=".self::$post_type, 
			'Referentie Instellingen', 
			'Instellingen', 
			'edit_theme_options', 
			'testimonials-settings', 
			array( $this, 'testimonials_settings' ) 
		);
	}

	//* Register settings
	public function initialize_testimonials_settings() 
	{
		// Add option if not already available
		if( false == get_option( 'testimonials_settings' ) ) {  
			add_option( 'testimonials_settings' );
		} 
	}

	//*
	public function testimonials_settings()
	{
		include_once( self::$dir . 'admin/testimonials-heavy-settings-page.php' );
	}

	//* Save testimonials settings
	public function save_testimonials_settings($option_name, $testimonials_settings)
	{
		// //* Check that the user is allowed to edit the options
		// if ( ! current_user_can( 'manage_options' ) ) {
		// 	echo "<div class='error'><p>Testimonial settings not updated.</p></div>";
		// 	return;
		// }

		// // Verify where the data originated
		// if ( !isset($_POST[self::$slug."-meta-nonce"]) || !wp_verify_nonce( $_POST[self::$slug."-meta-nonce"], self::$slug."-metabox-" . $post_id ) ) {
		// 	echo "<div class='error'><p>Testimonial settings not updated.</p></div>";
		// 	return;
		// }

		update_option( $option_name, $testimonials_settings);
	}

	//* Manage admin scripts and stylesheets
	public function add_testimonials_settings_scripts_and_styles()
	{
		//* Settings Page
		if (isset($_GET['page']) && $_GET['page'] == 'testimonials-settings') {
			//* Settings page javascript
			wp_enqueue_script(self::$slug."-admin-settings-page-js", self::$uri ."js/admin-settings-page.js", array('jquery'));

			//* Settings page stylesheet
			wp_enqueue_style( self::$slug."-admin-settings-page-css", self::$uri ."css/admin-settings-page.css" );
		}
	}

	public static function ejo_testimonials_loop()
	{
		// zie helper functions
	}

	//* Get testimonial
	public static function ejo_get_testimonial($post_id, $testimonials_settings)
	{
		// zie helper functions
	}
}

Testimonials_Heavy::init();

// write_log(Testimonials_Heavy::$test);

include_once( Testimonials_Heavy::$dir . 'inc/helper-functions.php' );