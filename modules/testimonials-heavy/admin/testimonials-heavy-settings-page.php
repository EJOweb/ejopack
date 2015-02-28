<div class='wrap' style="max-width:960px;">
	<h2>Referentie Instellingen</h2>

<?php 
	if ( isset( $_GET['settings-updated'] ) )
		echo "<div class='updated'><p>Testimonial settings updated successfully.</p></div>";
	else
		echo "<div class='error'><p>Testimonial settings not updated.</p></div>";
?>

	<form action="<?php echo "{$this->post_type_menu_slug}?page=testimonials-settings"; ?>" method="post">

		<h2 class="nav-tab-wrapper" id="ejo-tabs">
<?php
		$tabs = array( 
			'single-settings' => 'Single View',
			'archive-settings' => 'Archive View',
		);
		foreach( $tabs as $tab => $name ) {
			echo "<a class='nav-tab' href='#{$tab}'>$name</a>";
		}
?>
		</h2>

<?php 
		// add_settings_section('oenology_settings_general_header', 'Header Options', 'oenology_settings_general_header_section_text', 'oenology');

		// // Add Header Navigation Menu Position setting to the Header section
		// add_settings_field('oenology_setting_header_nav_menu_position', 'Header Nav Menu Position', 'oenology_setting_header_nav_menu_position', 'oenology', 'oenology_settings_general_header');

		// // Add Header Navigation Menu Depth setting to the Header section
		// add_settings_field('oenology_setting_header_nav_menu_depth', 'Header Nav Menu Depth', 'oenology_setting_header_nav_menu_depth', 'oenology', 'oenology_settings_general_header');

		// settings_fields('theme_oenology_options');
		// do_settings_sections('oenology');
?>

		<div id="ejo-tabs-wrapper">

			<div class="tab-content" id="single-settings">
				<p>
					Pas hier de zichtbaarheid en volgorde van de referentie-data op de individuele referentie-pagina's aan
				</p>
<?php
					$testimonial_fields = array(
						'title' => 'Titel',
						'content' => 'Referentie Tekst',
						'author' => 'Auteur',
						'company' => 'Bedrijf',
						'url' => 'URL',
						'date' => 'Datum',
					);
?>
				<table class="form-table">
					<tbody>
<?php
						foreach ($testimonial_fields as $testimonial_field_id => $testimonial_field_name) {
?>
							<tr>
								<td>
									<div class="ejo-move dashicons-before dashicons-sort"><br/></div>
								</td>
								<td>
									<?php echo $testimonial_field_name; ?>
								</td>
								<td>
									<input type="checkbox"><label>Inschakelen</label>
								</td>
							</tr>
<?php
						}
?>						
					</tbody>
				</table>
			</div>

			<div class="tab-content" id="archive-settings">
				<table class="form-table">
					<tr>
						<th>General</th>
						<td>
							
						</td>
					</tr>
				</table>
			</div>

		</div>

		<?php submit_button( 'Wijzigingen opslaan' ); ?>
	
	</form>

</div>
