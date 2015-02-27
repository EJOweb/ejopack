<?php

final class Testimonials_Heavy extends EJOpack_Module 
{
	//* Holds the instance of this class.
	protected static $instance;

	//* Version number of this module
	public $version = '1.0.0';

	//* Store the slug of this module
	public $slug;

	//* Stores the directory path for this module.
	public $dir;

	//* Stores the directory URI for this module.
	public $uri;

	//* Store the post_type of this module
	public $post_type = 'ejo_testimonials';

	//* Plugin setup.
	protected function __construct() 
	{
		add_action( 'plugins_loaded', array( $this, 'setup' ) );

		//* Register Post Type
		add_action( 'init', array( $this, 'register_testimonials_post_type' ) );

		//* Add Referentie Metabox
		add_action( "add_meta_boxes_{$this->post_type}", array( $this, 'add_testimonials_metabox' ) );

		//* Save Referentie Metadata
		add_action( 'save_post', array( $this, 'save_testimonial_metadata' ) );

		//* Add Settings Page
		add_action( 'admin_menu', array( $this, 'add_testimonials_setting_menu' ) );
	}

	//*
	public function setup() 
	{
		$this->slug = self::get_slug( __FILE__ );
		$this->dir = EJOpack::get_module_path( $this->slug );
		$this->uri = EJOpack::get_module_uri( $this->slug );
	}

	//*
	public function register_testimonials_post_type() 
	{
		include( $this->dir . 'register-post-type.php' );
	}

	//*
	public function add_testimonials_metabox() 
	{
		add_meta_box( 
			"{$this->post_type}_metabox", 
			'Referentie Informatie', 
			array( $this, 'render_testimonials_metabox' ), 
			$this->post_type, 
			'normal', 
			'high' 
		);
	}

	//*
	public function render_testimonials_metabox( $post )
	{
		// Noncename needed to verify where the data originated
		wp_nonce_field( "{$this->slug}-metabox-" . $post->ID, "{$this->slug}-meta-nonce" );

		$default_testimonial = array(
			'author'  => '',
			'company' => '',
			'url'     => '',
			'date'    => '',
		);
		$testimonial = get_post_meta( $post->ID, $this->slug, true );
		$testimonial = wp_parse_args( $testimonial, $default_testimonial );
?>
		<table class="form-table">
			<tr>
				<th scope="row" style="width: 140px">
					<label for="testimonial-author">Auteur</label>
				</th>
				<td>
					<input
						id="testimonial-author"
						value="<?php echo $testimonial['author']; ?>"
						type="text"
						name="<?php echo $this->slug; ?>[author]"
						class="text large-text "
					/>
					<span class="description">Wanneer de referentie-titel niet de auteur is.</span>
				</td>
			</tr>
			<tr>
				<th scope="row" style="width: 140px">
					<label for="testimonial-company">Bedrijf</label>
				</th>
				<td>
					<input
						id="testimonial-company"
						value="<?php echo $testimonial['company']; ?>"
						type="text"
						name="<?php echo $this->slug; ?>[company]"
						class="text large-text "
					/>
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th scope="row" style="width: 140px">
					<label for="testimonial-url">Link / URL</label>
				</th>
				<td>
					<input
						id="testimonial-url"
						value="<?php echo $testimonial['url']; ?>"
						type="text"
						name="<?php echo $this->slug; ?>[url]"
						class="text large-text "
					/>
					<span class="description"></span>
				</td>
			</tr>
			<tr>
				<th scope="row" style="width: 140px">
					<label for="testimonial-date">Datum</label>
				</th>
				<td>
					<input
						id="testimonial-date"
						value="<?php echo $testimonial['date']; ?>"
						type="text"
						name="<?php echo $this->slug; ?>[date]"
						class="text large-text "
					/>
					<span class="description"></span>
				</td>
			</tr>
		</table>
<?php
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
		if ( !isset($_POST["{$this->slug}-meta-nonce"]) || !wp_verify_nonce( $_POST["{$this->slug}-meta-nonce"], "{$this->slug}-metabox-" . $post_id ) )
			return;

		$meta_key = $this->slug;

		write_log( $_POST[$this->slug] );

		if ( isset( $_POST[$this->slug] ) )
			update_post_meta( $post_id, $meta_key, $_POST[$this->slug] );
	}

	//*
	public function add_testimonials_setting_menu()
	{
		add_submenu_page( 
			"edit.php?post_type={$this->post_type}", 
			'Referentie Instellingen', 
			'Instellingen', 
			'edit_theme_options', 
			'testimonials-settings', 
			array( $this, 'testimonials_settings' ) 
		);
	}

	//*
	public function testimonials_settings()
	{
		include( $this->dir . 'testimonials-heavy-settings-page.php' );
	}

}

Testimonials_Heavy::get_instance();