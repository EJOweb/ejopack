<?php

class EJO_Testimonials_Settings 
{
	//* Store the post_type of this module
	public static $post_type;

	//* Store the slug of this module
	public static $module_slug;

	//* Stores the directory path for this module.
	public static $module_dir;

	//* Stores the directory URI for this module.
	public static $module_uri;

	//* Plugin setup.
	public function __construct($post_type, $slug, $dir, $uri) 
	{
		//* Store the post_type of this module
		self::$post_type = $post_type;
		self::$module_slug = $slug;
		self::$module_dir = $dir;
		self::$module_uri = $uri;

		//* Register Settings for Settings Page
		add_action( 'admin_init', array( $this, 'initialize_testimonials_settings' ) );

		//* Add Settings Page
		add_action( 'admin_menu', array( $this, 'add_testimonials_setting_menu' ) );

		//* Add scripts to settings page
		add_action( 'admin_enqueue_scripts', array( $this, 'add_testimonials_settings_scripts_and_styles' ) ); 
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
	?>
		<div class='wrap' style="max-width:960px;">
			<h2>Referentie Instellingen</h2>

			<?php 
				// Save testimonials data
				if (isset($_POST['submit']) ) {

					if (!empty($_POST['testimonials-single-settings'])) {
						self::save_testimonials_settings("testimonials_single_settings", self::testimonials_template_settings_checkbox_fix($_POST['testimonials-single-settings'])); 
					}

					if (!empty($_POST['testimonials-archive-settings'])) {
						self::save_testimonials_settings("testimonials_archive_settings", self::testimonials_template_settings_checkbox_fix($_POST['testimonials-archive-settings'])); 
					}

					echo "<div class='updated'><p>Testimonial settings updated successfully.</p></div>";
					// echo "<pre>";print_r($_POST['testimonials-single-settings']);echo "</pre>";
				}
			?>

			<form action="<?php echo esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ) ); ?>" method="post">
				<?php wp_nonce_field('testimonials-settings', 'testimonials-settings-nonce'); ?>

				<h2 class="nav-tab-wrapper" id="ejo-tabs">
					<a class='nav-tab' href='#single'>Single</a>
					<a class='nav-tab' href='#archive'>Archive</a>
				</h2>

				<div id="ejo-tabs-wrapper">
					<div class="tab-content" id="single">
						<?php self::show_testimonials_template_settings('single'); ?>
					</div>
					<div class="tab-content" id="archive">
						<?php self::show_testimonials_template_settings('archive'); ?>
					</div>
				</div>

				<?php 
					submit_button( 'Wijzigingen opslaan' );
					// submit_button( 'Standaard Instellingen', 'secondary', 'reset' ); 
				?>
			
			</form>

		</div>
	<?php
	}

	public function show_testimonials_template_settings($template_type = '') 
    {
		$template_settings_default = array(
			'title' => array(
				'name' => 'Titel',
				'show' => true,
			),
			'image' => array(
				'name' => 'Afbeelding',
				'show' => true,
			),
			'content' => array(
				'name' => 'Referentie',
				'show' => true,
			),
			'author' => array(
				'name' => 'Auteur',
				'show' => true,
			),
			'info' => array(
				'name' => 'Extra Info',
				'show' => true,
			),
			'date' => array(
				'name' => 'Datum',
				'show' => true,
			),
		);

		$template_settings = (empty($template_type)) ? false: get_option("testimonials_{$template_type}_settings");

		if ($template_settings === false)
			$template_settings = $template_settings_default;

		// echo "<pre>";print_r($template_settings);echo "</pre>";
	?>
		<table class="form-table">
		<tbody>
	<?php
			foreach ($template_settings as $id => $field) {
	?>
				<tr>
					<td>
						<div class="ejo-move dashicons-before dashicons-sort"><br/></div>
					</td>
					<td>
						<?php 
							echo $field['name'];
							echo 
								"<input".
								" type='hidden'".
								" name='testimonials-{$template_type}-settings[{$id}][name]'".
								" value='$field[name]'".
								">";
						?>
					</td>
					<td>
						<?php
							echo 
								"<input".
								" type='checkbox'".
								" name='testimonials-{$template_type}-settings[{$id}][show]'".
								" id='testimonials-{$template_type}-settings-{$id}-show'".
								  checked($field['show'], true, false) .
								">";
							echo "<label for='testimonials-{$template_type}-settings-{$id}-show'>Tonen</label>";
						?>
					</td>
				</tr>
	<?php
			}
	?>						
		</tbody>
		</table>
	<?php
    }

	public function testimonials_template_settings_checkbox_fix($template_settings) 
    {
		foreach ($template_settings as $id => $field) {
			$template_settings[$id]['show'] = (isset($field['show'])) ? true : false;
		}

		return $template_settings;
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
		// if ( !isset($_POST[self::$module_slug."-meta-nonce"]) || !wp_verify_nonce( $_POST[self::$module_slug."-meta-nonce"], self::$module_slug."-metabox-" . $post_id ) ) {
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
			wp_enqueue_script(self::$module_slug."-admin-settings-page-js", self::$module_uri ."js/admin-settings-page.js", array('jquery'));

			//* Settings page stylesheet
			wp_enqueue_style( self::$module_slug."-admin-settings-page-css", self::$module_uri ."css/admin-settings-page.css" );
		}
	}
}