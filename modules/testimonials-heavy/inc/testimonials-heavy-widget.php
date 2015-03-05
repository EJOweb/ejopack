<?php

/**
 * Menu Marquee widget class.
 */
class Testimonials_Heavy_Widget extends WP_Widget {

	//* Constructor. Set the default widget options and create widget.
	function __construct() 
	{
		$widget_title = 'Testimonials Widget';

		$widget_info = array(
			'description' => 'Show Testimonials',
		);

		parent::__construct( 'testimonials-widget', $widget_title, $widget_info );
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
		<ul>
			<li>Volgorde en Visibility</li>
			<li>Aantal testimonials</li>
			<li>Sortering van testimonials [random, datum]</li>
			<li></li>
		</ul>
		<?php
		
	}
}
