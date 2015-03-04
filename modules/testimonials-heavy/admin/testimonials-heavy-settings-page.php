<?php
	//* Helpers
	include( $this->dir . 'admin/testimonials-heavy-settings-page-helpers.php' );
?>

<div class='wrap' style="max-width:960px;">
	<h2>Referentie Instellingen</h2>

	<?php 
		// Save testimonials data
		if (isset($_POST['submit']) ) {

			if (!empty($_POST['testimonials-single-settings'])) {
				self::save_testimonials_settings("testimonials_single_settings", testimonials_template_settings_checkbox_fix($_POST['testimonials-single-settings'])); 
			}

			if (!empty($_POST['testimonials-archive-settings'])) {
				self::save_testimonials_settings("testimonials_archive_settings", testimonials_template_settings_checkbox_fix($_POST['testimonials-archive-settings'])); 
			}

			echo "<div class='updated'><p>Testimonial settings updated successfully.</p></div>";
			// echo "<pre>";print_r($_POST['testimonials-single-settings']);echo "</pre>";
		}
	?>

	<form action="<?php echo esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ) ); ?>" method="post">
		<?php wp_nonce_field('testimonials-settings', 'testimonials-settings-nonce'); ?>

		<h2 class="nav-tab-wrapper" id="ejo-tabs">
			<a class='nav-tab' href='#single'>Single</a>
			<a class='nav-tab' href='#archive'>Archive</a>
		</h2>

		<div id="ejo-tabs-wrapper">
			<div class="tab-content" id="single">
				<?php show_testimonials_template_settings('single'); ?>
			</div>
			<div class="tab-content" id="archive">
				<?php show_testimonials_template_settings('archive'); ?>
			</div>
		</div>

		<?php 
			submit_button( 'Wijzigingen opslaan' );
			// submit_button( 'Standaard Instellingen', 'secondary', 'reset' ); 
		?>
	
	</form>

</div>

