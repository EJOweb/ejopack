<?php

class EJO_Testimonials_Metabox 
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

		//* Add Referentie Metabox
		add_action( "add_meta_boxes_".self::$post_type, array( $this, 'add_testimonials_metabox' ) );

		//* Save Referentie Metadata
		add_action( 'save_post', array( $this, 'save_testimonial_metadata' ) );
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
		// Noncename needed to verify where the data originated
		wp_nonce_field( self::$module_slug.'-metabox-' . $post->ID, self::$module_slug.'-meta-nonce' );

		$default_testimonial = array(
			'author' => '',
			'info' 	 => '',
			'url'    => '',
			'date'   => '',
		);
		$testimonial = get_post_meta( $post->ID, self::$module_slug, true );
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
						name="<?php echo self::$module_slug; ?>[author]"
						class="text large-text"
					>
					<span class="description">Wanneer de referentie-titel niet de auteur is.</span>
				</td>
			</tr>
			<tr>
				<th scope="row" style="width: 140px">
					<label for="testimonial-info">Extra info</label>
				</th>
				<td>
					<input
						id="testimonial-info"
						value="<?php echo $testimonial['info']; ?>"
						type="text"
						name="<?php echo self::$module_slug; ?>[info]"
						class="text large-text"
					>
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
						name="<?php echo self::$module_slug; ?>[url]"
						class="text large-text"
					>
					<span class="description">Externe link naar de schrijver van de referentie</span>
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
						name="<?php echo self::$module_slug; ?>[date]"
						class="text large-text"
					>
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
		if ( !isset($_POST[self::$module_slug."-meta-nonce"]) || !wp_verify_nonce( $_POST[self::$module_slug."-meta-nonce"], self::$module_slug."-metabox-" . $post_id ) )
			return;

		$meta_key = self::$module_slug;

		if ( isset( $_POST[self::$module_slug] ) )
			update_post_meta( $post_id, $meta_key, $_POST[self::$module_slug] );
	}
}