<?php

add_action('after_setup_theme', 'ejopack_test');
function ejopack_test()
{

	write_log(EJOpack::get_available_modules());
}