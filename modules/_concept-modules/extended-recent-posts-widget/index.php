<?php

//* Add widgets
add_action( 'widgets_init', 'ejo_widget_extended_recent_posts_widget' );
function ejo_widget_extended_recent_posts_widget() 
{
	register_widget( 'Extended_Recent_Posts_Widget' );
}

require_once( 'extended-recent-posts-widget.php' );