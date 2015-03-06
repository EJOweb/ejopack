<?php

class EJO_Testimonials_Widget extends WP_Widget {

	//* Constructor. Set the default widget options and create widget.
	function __construct() 
	{
		$widget_title = 'EJO Testimonials Widget';

		$widget_info = array(
			'description' => 'Show Testimonials',
		);

		parent::__construct( 'ejo-testimonials-widget', $widget_title, $widget_info );

		//* Add scripts to settings page
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_testimonials_widget_scripts_and_styles' ) ); 
	}
	
	//* Echo the widget content.
	function widget( $args, $instance ) 
	{
		/** This filter is documented in wp-includes/default-widgets.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];

		$query_args = array(
			'orderby' => $instance['sort'],
			'posts_per_page' => $instance['count'],
			'post_type' => EJO_Testimonials::$post_type,
		);
		$testimonials = new WP_Query($query_args);
		if ( $testimonials->have_posts() ) {		

			echo '<div class="testimonials-container">';

			while ( $testimonials->have_posts() ) { 
				$testimonials->the_post();

				$testimonial = self::get_testimonial( get_the_ID(), $instance['view_settings'] );

				echo '<div class="testimonial">';
				foreach ($testimonial as $testimonial_part) {
					echo $testimonial_part;
				}
				echo '</div>';
				
			}

			echo '</div>';

		} else {
			/* No testimonials */
		}
		/* Restore original Post Data */
		wp_reset_postdata();

		echo $args['after_widget'];
	}

	function get_testimonial($post_id, $testimonials_settings)
	{
		//* Get testimonial meta data
		$testimonial_data = get_post_meta( $post_id, 'testimonials-heavy', true );

		//* Keeper of the testimonial output
		$testimonial = array();

		//* Get testimonials info in right order
		foreach ($testimonials_settings as $id => $field) {

			//* Skip the fields which are to be hidden
			if ($field['show'] === false)
				continue;

			switch ($id) {
				case 'title':
					$title = get_the_title( $post_id );
					$heading = 'h2';
					$title = sprintf( '<a href="%s" rel="bookmark">%s</a>', get_permalink( $post_id ), $title );
					$title = sprintf( "<{$heading} class='%s' itemprop='%s'>%s</{$heading}>", 'entry-title', 'headline', $title );
					$testimonial['title'] = $title;
					break;

				case 'image':
					$align = 'alignleft';
					$image = get_the_post_thumbnail( $post_id, 'medium', array( 'class' => $align ) );
					$testimonial['image'] = $image;
					break;
				
				case 'content':
					$quote = get_the_excerpt();
					$content = sprintf( '<blockquote>%s</blockquote>', $quote );
					$content .= sprintf( '<p><a class="%s" href="%s">%s</a></p>', 'button', get_permalink( $post_id ), 'Lees meer' );
					$testimonial['content'] = $content;
					break;
				
				case 'author':
					if ( isset($testimonial_data['author']) ) {
						$testimonial['author'] = '<span class="author">' . $testimonial_data['author'] . '</span>';
					}
					break;
				
				case 'info':
					if ( isset($testimonial_data['info']) ) {
						$info = $testimonial_data['info'];
						$testimonial['info'] = '<span class="info">' . $info . '</span>';
					}
					break;
				
				case 'date':
					if ( isset($testimonial_data['date']) ) {
						$testimonial['date'] = '<span class="date">' . $testimonial_data['date'] . '</span>';
					}
					break;						
			}
		}

		return $testimonial;
	}

	//* Update a particular instance.
	function update( $new_instance, $old_instance ) {

		$new_instance['title'] = strip_tags( $new_instance['title'] );

		if(!empty($new_instance['view_settings']))
			$new_instance['view_settings'] = EJO_Testimonials_Settings::testimonials_template_settings_checkbox_fix($new_instance['view_settings']);
	
		write_log($new_instance);

		return $new_instance;
	}

	//* Echo the settings update form.
	function form( $instance ) 
	{
		$title = isset( $instance['title'] ) ? $instance['title'] : '';

		?>		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>

		<?php
			$view_settings_default = array(
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

			$view_settings = ( isset($instance['view_settings']) ) ? $instance['view_settings']: $view_settings_default;

		?>
			<table class="form-table view_settings">
			<tbody>
		<?php
			foreach ($view_settings as $id => $field) {
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
								" name='{$this->get_field_name('view_settings')}[{$id}][name]'".
								" value='$field[name]'".
								">";
						?>
					</td>
					<td>
						<?php
							$checked = (isset($field['show'])) ? checked($field['show'], true, false): '';
							echo 
								"<input".
								" type='checkbox'".
								" name='{$this->get_field_name('view_settings')}[{$id}][show]'".
								" id='view-settings-{$id}-show'".
								  $checked .
								">";
							echo "<label for='view-settings-{$id}-show'>Tonen</label>";
						?>
					</td>
				</tr>
		<?php
			}
		?>						
			</tbody>
			</table>

			<ul>
				<li>
					<label for="testimonials-number">Aantal referenties: </label>
					<select id="testimonials-number" name="<?php echo $this->get_field_name('count'); ?>">
						<?php 
							for ( $i=1; $i<=10; $i++ ){
								$selected = ( isset($instance['count']) && $i == $instance['count'] ) ? 'selected="selected"': '';
								echo "<option value='{$i}' {$selected}>{$i}</option>";
							}
						?>
					</select>
				</li>
				<li>
					<?php

					?>
					<label for="testimonials-sort">Sortering: </label>
					<select id="testimonials-sort" name="<?php echo $this->get_field_name('sort'); ?>">
						<?php 
							$sort_options = array(
								'rand' => 'Random',
								'date' => 'Nieuw - Oud',
							);
							foreach ( $sort_options as $key => $label ){
								$selected = ( isset($instance['sort']) && $key == $instance['sort'] ) ? 'selected="selected"': '';
								echo "<option value='{$key}' {$selected}>{$label}</option>";
							}
						?>
					</select>
				</li>
			</ul>
		<?php
		
	}

	public function admin_testimonials_widget_scripts_and_styles($hook)
	{
		if( $hook != 'widgets.php' ) 
			return;

		//* Settings page javascript
		wp_enqueue_script( EJO_Testimonials::$slug."-admin-widget-js", EJO_Testimonials::$uri ."js/admin-widget.js", array('jquery') );

		//* Settings page stylesheet
		wp_enqueue_style( EJO_Testimonials::$slug."-admin-widget-css", EJO_Testimonials::$uri ."css/admin-widget.css" );
	}

	/**
     * Tell WP we want to use this widget.
     *
     * @wp-hook widgets_init
     * @return void
     */
    public static function register()
    {
        register_widget( __CLASS__ );
    }
}
