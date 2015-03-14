<?php

//* Add styles and scripts ; Remove styles and scripts to head
add_action( 'wp_enqueue_scripts', 'ejo_add_scripts_fancybox', 97 );
function ejo_add_scripts_fancybox()
{
	//* CDN cloudflare
	wp_enqueue_style( 'fancybox', '//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css', '', null );
	wp_enqueue_script( 'fancybox', '//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js', array( 'jquery' ), null, true );
}
