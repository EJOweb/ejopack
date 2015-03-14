<?php
/**
 * Last Post widget class.
 *
 * @since 0.1.8
 *
 * @package Genesis\Widgets
 */
class Feature_Last_Post extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 *
	 * @since 0.1.8
	 */
	function __construct() {

		$this->defaults = array(
			'title'                   => 'Laatste nieuws',
		);

		$widget_ops = array(
			'classname'   => 'feature-last-post',
			'description' => __( 'Features latest post', 'ejo' ),
		);

		$control_ops = array(
			'id_base' => 'feature-last-post',
			'width'   => 505,
			'height'  => 350,
		);

		parent::__construct( 'feature-last-post', __( 'Laatste bericht uitgelicht', 'ejo' ), $widget_ops, $control_ops );

	}
	
	/**
	 * Echo the widget content.
	 *
	 * @since 0.1.8
	 *
	 * @global WP_Query $wp_query               Query object.
	 * @global $integer $more
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {

		global $wp_query;

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $args['before_widget'];

		$category = 1;

		$query_args = array(
			'post_type' => 'post',
			'cat'       => $category,
			'showposts' => 1,
			'orderby'   => 'date',
			'order'     => 'DESC',
		);

		$wp_query = new WP_Query( $query_args );

		if ( have_posts() ) : while ( have_posts() ) : the_post();

			echo '<article class="entry">';

				$image = genesis_get_image( array(
					'format'  => 'html',
					'size'    => 'medium',
					'context' => 'feature-last=post-widget',
					'attr'    => genesis_parse_attr( 'entry-image-widget' ),
				) );

				printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $image );

				echo '<header class="entry-header">';

					printf( '<h2 class="entry-title"><a href="%s">%s</a></h2>', esc_url( get_category_link( $category ) ), esc_html( $instance['title'] ) );

				echo '</header>';

				echo '<div class="entry-content">';

					$title = get_the_title() ? get_the_title() : __( '(no title)', 'genesis' );

					printf( '<p>%s</p>', esc_html( $title ) );

					echo '<a href="'. get_permalink() . '">Lees verder</a>';

				echo '</div>';

			echo '</article>';

		endwhile;

		else :

			echo '<p>Geen artikel gevonden</p>';

		endif;

		//* Restore original query
		wp_reset_query();

		// printf(
		// 	'<p class="more-from-category"><a href="%1$s" title="%2$s">%3$s</a></p>',
		// 	esc_url( get_category_link( $instance['posts_cat'] ) ),
		// 	esc_attr( get_cat_name( $instance['posts_cat'] ) ),
		// 	esc_html( $instance['more_from_category_text'] )
		// );

		echo $args['after_widget'];

	}

	/**
	 * Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @since 0.1.8
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['title']     = strip_tags( $new_instance['title'] );
		return $new_instance;

	}

	/**
	 * Echo the settings update form.
	 *
	 * @since 0.1.8
	 *
	 * @param array $instance Current settings
	 */
	function form( $instance ) {

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'genesis' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>
		<?php

	}

}
