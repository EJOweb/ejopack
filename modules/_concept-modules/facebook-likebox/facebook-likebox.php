<?php
/**
 * Facebook Likebox
 *
 * @since 0.1.8
 *
 * @package Genesis\Widgets
 */
class Facebook_Likebox extends WP_Widget {

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
			'title'                   => 'Muziekcentrum Zwartewaterland',
		);

		$widget_ops = array(
			'classname'   => 'facebook-likebox',
			'description' => __( 'Facebook likebox', 'mcz' ),
		);

		$control_ops = array(
			'id_base' => 'facebook-likebox',
			'width'   => 505,
			'height'  => 350,
		);

		parent::__construct( 'facebook-likebox', __( 'Facebook Likebox Widget', 'ejo' ), $widget_ops, $control_ops );

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

		?>
		<h4 class="widget-title"><a href="https://www.facebook.com/mczwartewaterland" title="facebook profile" target="_blank">Muziekcentrum Zwartewaterland</a></h4>

		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1&appId=616166881745571&version=v2.0";
			// js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1&appId=395202813876688";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

		<div class="fb-like-box" responsive="false" data-href="https://www.facebook.com/mczwartewaterland" data-width="284" data-height="304" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
		<?php

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
		<p>Plaats deze widget waar je wilt</p>
		<?php

	}

}
