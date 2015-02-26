<?php

add_shortcode('footer_vsee', 'show_vsee_credits');

// Shortcode Function to show Vsee link
function show_vsee_credits() 
{
	if (is_front_page()) {
		$output = '<a class="footer-credits" href="http://www.vsee.nl" title="Internetbureau Vsee - Google Adwords en SEO specialisten">Vsee</a>';
	}
	else {
		$output = '<span class="footer-credits">Vsee</span>';
	}

	return $output;
}