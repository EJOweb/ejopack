<?php
if(!function_exists('show_testimonials_template_settings')) {
    function show_testimonials_template_settings($template_type) 
    {
		$template_settings_default = array(
			'title' => array(
				'name' => 'Titel',
				'show' => true,
			),
			'image' => array(
				'name' => 'Afbeelding',
				'show' => true,
			),
			'content' => array(
				'name' => 'Referentie',
				'show' => true,
			),
			'author' => array(
				'name' => 'Auteur',
				'show' => true,
			),
			'info' => array(
				'name' => 'Extra Info',
				'show' => true,
			),
			'date' => array(
				'name' => 'Datum',
				'show' => true,
			),
		);

		$template_settings = get_option("testimonials_{$template_type}_settings");

		if ($template_settings === false)
			$template_settings = $template_settings_default;

		// echo "<pre>";print_r($template_settings);echo "</pre>";
?>
		<table class="form-table">
		<tbody>
<?php
			foreach ($template_settings as $id => $field) {
?>
				<tr>
					<td>
						<div class="ejo-move dashicons-before dashicons-sort"><br/></div>
					</td>
					<td>
						<?php 
							echo $field['name'];
							echo 
								"<input".
								" type='hidden'".
								" name='testimonials-{$template_type}-settings[{$id}][name]'".
								" value='$field[name]'".
								">";
						?>
					</td>
					<td>
						<?php
							echo 
								"<input".
								" type='checkbox'".
								" name='testimonials-{$template_type}-settings[{$id}][show]'".
								" id='testimonials-{$template_type}-settings-{$id}-show'".
								  checked($field['show'], true, false) .
								">";
							echo "<label for='testimonials-{$template_type}-settings-{$id}-show'>Tonen</label>";
						?>
					</td>
				</tr>
<?php
			}
?>						
		</tbody>
		</table>
<?php
	}
}

//* Save clicked checkbox as true and not-clicked checkbox as false
if(!function_exists('testimonials_template_settings_checkbox_fix')) {
    function testimonials_template_settings_checkbox_fix($template_settings) 
    {
		foreach ($template_settings as $id => $field) {
			$template_settings[$id]['show'] = (isset($field['show'])) ? true : false;
		}

		return $template_settings;
	}
}
