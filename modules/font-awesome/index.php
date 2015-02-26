<?php

//* Add styles and scripts 
add_action( 'wp_enqueue_scripts', 'ejo_add_scripts_font_awesome', 97 );
function ejo_add_scripts_font_awesome()
{
	//* Font Awesome
	wp_enqueue_style( 'font-awesome', EJO_EXT_URL . '/font-awesome/css/font-awesome.min.css', '', null );
}