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

		echo $args['after_widget'];
	}

	//* Update a particular instance.
	function update( $new_instance, $old_instance ) {

		$new_instance['title'] = strip_tags( $new_instance['title'] );

		write_log($new_instance);

		// if ( ! empty( $new_instance['nav_menu'] ) ) {
		// 	$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		// }

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
			// echo "<pre>";print_r($view_settings);echo "</pre>";

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
							echo 
								"<input".
								" type='checkbox'".
								" name='{$this->get_field_name('view_settings')}[{$id}][show]'".
								" id='view-settings-{$id}-show'".
								  checked($field['show'], true, false) .
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
				<li>Volgorde en Visibility</li>
				<li>Aantal testimonials</li>
				<li>Sortering van testimonials [random, datum]</li>
				<li></li>
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
