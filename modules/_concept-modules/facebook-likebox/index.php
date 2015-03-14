<?php

//* Add widgets
add_action( 'widgets_init', 'ejo_widget_facebook_likebox' );
function ejo_widget_facebook_likebox() 
{
	register_widget( 'Facebook_Likebox' );
}

require_once( 'facebook-likebox.php' );