<div class='wrap' style="max-width:960px;">
	<h2>Referentie Instellingen</h2>

	<form action="admin.php?page=keurmerken" method="post">


<?php
		$current = isset ( $_GET['tab'] ) ? $_GET['tab'] : 'homepage';

		$tabs = array( 
			'homepage' => 'Home Settings',
			'general' => 'General',
			'footer' => 'Footer' 
		);

		echo '<h2 class="nav-tab-wrapper">';	
		foreach( $tabs as $tab => $name ) {
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab{$class}' href='#{$tab}'>$name</a>";
		}
		echo '</h2>';

		// jquery Onclick class -> nav-tab-active;
		// Momenteel tabbing nog op basis van php...

?>
		<div class="tabwrapper">

			<div id="homepage">
				<table class="form-table">
					<tr>
						<th>Homepage</th>
						<td>
							
						</td>
					</tr>
				</table>
			</div>

			<div id="general">
				<table class="form-table">
					<tr>
						<th>General</th>
						<td>
							
						</td>
					</tr>
				</table>
			</div>

			<div id="footer">
				<table class="form-table">
					<tr>
						<th>Footer</th>
						<td>
							
						</td>
					</tr>
				</table>
			</div>

		</div>

		<?php submit_button( 'Wijzigingen opslaan' ); ?>
	
	</form>

</div>
