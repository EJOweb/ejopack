<?php	

final class EJOpack_Settings
{
	//* Holds the instance of this class.
	private static $instance;

	//* Plugin setup.
	private function __construct() 
	{
		//* Add Settings page
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
	}

	//*
	public function add_settings_page()
	{
		add_menu_page(  
			'EJOpack Instellingen', 
			'EJOpack', 
			'manage_options', 
			'ejopack-settings', 
			array( $this, 'settings_page' ),
			'dashicons-screenoptions'
		);
	}

	//*
	public function settings_page()
	{
	?>
		<div class='wrap' style="max-width:960px;">
			<h2>EJOpack Instellingen</h2>
			<p>Lijst maken om modules aan te kunnen vinken en opslaan in options</p>
		</div>
	<?php
	}

	//* Returns the instance.
	public static function init() 
	{
		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}

}