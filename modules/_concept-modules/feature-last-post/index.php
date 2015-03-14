<?php

//* Add widgets
add_action( 'widgets_init', 'ejo_widget_feature_last_post' );
function ejo_widget_feature_last_post() 
{
	register_widget( 'Feature_Last_Post' );
}

require_once( 'featured-last-post.php' );