<?php
/**
 * Extended version of Recent Post Widget
 *
 * By Erik Joling <erik@ejoweb.nl>
 * Thanks to Prasanna SP's Custom Recent Post Widget <http://www.prasannasp.net/>
 * (Prasanna extended the boxed recent-postswidget)
 */
class Extended_Recent_Posts_Widget extends WP_Widget 
{			
	/**
	 * Holds widget settings defaults, populated in constructor.
	 */
	protected $defaults;

	/**
	 * Constructor. Set the default widget options and create widget.
	 */
	function __construct() 
	{
		$this->defaults = array(
			'title'			=> 'Laatste nieuws',
			'show_date'		=> false,
			'number'		=> 5,
			'categories'	=> array(),
		);

		$widget_ops = array(
			'classname'   => 'extended-recent-posts',
			'description' => __( 'Display a list of recent post entries from one or more categories. You can choose the number of posts to show.', 'ejo' ),
		);

		$control_ops = array(
			'id_base' => 'extended-recent-posts',
			'width'   => 505,
			'height'  => 350,
		);

		parent::__construct( 'extended-recent-posts', __( 'Recent Posts', 'ejo' ), $widget_ops, $control_ops );
	}

	/**
	 * Echo the widget content.
	 */
	function widget( $args, $instance ) {

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title = $instance['title'];
		$show_date = $instance['show_date'];
		$number = $instance['number'];
		$categories = $instance['categories'];

		echo $args['before_widget'];

		if ( !empty($title) )
			echo $args['before_title'] . $title . $args['after_title'];

		$query_args = array(
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page' => $number,
			'category__in' => $categories,
		);

		$recent_posts = new WP_Query( $query_args );

		if ( $recent_posts->have_posts() ) {

			echo "<ul>";

			while ( $recent_posts->have_posts() ) { 
				$recent_posts->the_post();

				?>
				<li>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					<?php if ( $show_date ) : ?>
					<span class="post-date"><?php echo get_the_date(); ?></span>
					<?php endif; ?>				
				</li>
				<?php

			}

			echo "</ul>";
		}
		else {
			echo '<p>Geen artikel gevonden</p>';
		}

		//* Restore original query
		wp_reset_query();

		echo $args['after_widget'];

	}	
	
	function update( $new_instance, $old_instance ) 
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        $instance['categories'] = !empty( $new_instance['categories'] ) ? $new_instance['categories'] : array();
	     
        return $instance;
	}
	
	function form( $instance ) 
	{
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title = $instance['title'];
		$show_date = $instance['show_date'];
		$number = $instance['number'];
		$selected_categories = $instance['categories'];
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
                        
        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
        
        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
        
        <p>
           <label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Include categories:', 'ejo');?> 
            
<?php
			$all_categories = get_categories('hide_empty=0');
			echo "<br/>";
			foreach ($all_categories as $category) {
				$category_id = $this->get_field_id( 'categories' ) . '-' . $category->term_id;
				$category_name = $this->get_field_name( 'categories' ) . '[]';
				$category_check = checked(in_array($category->term_id, $selected_categories), true, false);
?>
				<input type="checkbox" id="<?php echo $category_id; ?>" name="<?php echo $category_name; ?>" value="<?php echo $category->term_id; ?>" <?php echo $category_check; ?>>
				<label for="<?php echo $category_id; ?>"><?php echo $category->cat_name; ?></label>
				<br />
<?php
			}
?>
            </label>
        </p>
        
<?php
	}
}
?>
