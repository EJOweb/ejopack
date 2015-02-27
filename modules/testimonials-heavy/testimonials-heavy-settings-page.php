<div class='wrap' style="max-width:960px;">
	<h2>Referentie Instellingen</h2>

	<?php

		//* options record met een lijst attachment id's en bijbehorende urls

		//* Nonces shizzle

		if ( isset($_POST['submit']) ) {

		}

	$tabs = array( 'general' => 'General', 'layout' => 'Layout', 'advanced' => 'Advanced' );
	$current = 'general';
	$links = array();
	foreach( $tabs as $tab => $name ) :
		if ( $tab == $current ) :
			$links[] = "<a class='nav-tab nav-tab-active' href='?page=mytheme_options&tab=$tab'>$name</a>";
		else :
			$links[] = "<a class='nav-tab' href='?page=mytheme_options&tab=$tab'>$name</a>";
		endif;
	endforeach;
	echo '<h2>';
	foreach ( $links as $link )
		echo $link;
	echo '</h2>';

	?>

	<form action="admin.php?page=keurmerken" method="post">
		<?php submit_button( 'Wijzigingen opslaan' ); ?>
	</form>

</div>
