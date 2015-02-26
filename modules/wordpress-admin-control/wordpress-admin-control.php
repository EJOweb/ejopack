<?php

class Wordpress_Admin_Control
{
	//* Holds the instance of this class.
	private static $instance;

	//* Store the slug of this module
	public static $slug = 'wordpress-admin-control';

	//* Version number of this module
	public static $version = '1.0.0';

	//* Plugin setup.
	public function __construct() 
	{
		add_action( 'admin_menu', array( $this, 'editor_add_widget_power' ) );
		add_action( 'admin_menu', array( $this, 'cleanup_menu' ) );

		//* Remove Widget power
		// add_action( 'admin_menu', array( $this, 'editor_remove_widget_power' ) );
		// $role->remove_cap( 'edit_theme_options' ); 
	}

	//* Give editor powers to manage Widgets
	public function editor_add_widget_power() 
	{
		// Get Editor role
		$editor = get_role( 'editor' );

		//* Give Editor 'appearence' powers
		if ( empty($editor->capabilities['edit_theme_options']) ) {
			$editor -> add_cap( 'edit_theme_options' ); 
		}
	}

	//*
	public function cleanup_menu() 
	{
		// Check if user is administrator
		$user_is_not_administrator =  !current_user_can( 'administrator' );

		if ( $user_is_not_administrator ) {
			//* Menus
			// remove_menu_page( 'index.php' );					// Dashboard
			// remove_menu_page( 'edit.php' );					// Posts
			// remove_menu_page( 'edit.php?post_type=custom_post_type' );	// CPT
			// remove_submenu_page( 'edit.php?post_type=custom_post_type', 'post-new.php?post_type=custom_post_type' );		// CPT SUB MENU
			// remove_menu_page( 'upload.php' );				// Media
			// remove_menu_page( 'edit.php?post_type=page' );	// Pages
			// remove_menu_page( 'edit-comments.php' );			// Comments
			// remove_menu_page( 'themes.php' );				// Appearance
			// remove_menu_page( 'plugins.php' );				// Plugins
			// remove_menu_page( 'users.php' );					// Users
			remove_menu_page( 'tools.php' );					// Tools
			// remove_menu_page( 'options-general.php' );		// Settings

			//* Submenus
			remove_submenu_page( 'themes.php', 'themes.php' );						//Appearance > Themes
			remove_submenu_page( 'themes.php', 'customize.php' );					//Appearance > Aanpassen
			remove_submenu_page( 'themes.php', 'customize.php?return=/wp-admin/' );	//Appearance > Aanpassen
			remove_submenu_page( 'themes.php', 'theme-editor.php' );				//Appearance > Aanpassen

			//* Appearance > Aanpassen
			global $submenu;
			unset($submenu['themes.php'][6]); // remove customize link

			//* Genesis
			remove_menu_page( 'genesis' );
			remove_theme_support( 'genesis-admin-menu' );

			//* Plugins
			remove_submenu_page( 'themes.php', 'cleaner-gallery' );					//Appearance > Cleaner Gallery
			remove_action( 'admin_bar_menu', 'wpseo_admin_bar_menu', 95);
	    	remove_menu_page('wpseo_dashboard');
		}
	}

	//* Returns the instance.
	public static function init() 
	{
		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

Wordpress_Admin_Control::init();