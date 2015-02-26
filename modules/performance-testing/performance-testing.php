<?php
/*
	Helper functions to analyze performance
*/
add_action( 'genesis_after', 'ejo_query_analysis' );

//* Query analysis
function ejo_query_analysis()
{
	echo '<div class="timer">';
	echo get_num_queries() . ' queries in ' . timer_stop(0) . ' seconds';
	echo '</div>';
}

?>