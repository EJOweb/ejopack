<?php
	// Noncename needed to verify where the data originated
	wp_nonce_field( "{$this->slug}-metabox-" . $post->ID, "{$this->slug}-meta-nonce" );

	$default_testimonial = array(
		'author' => '',
		'info' 	 => '',
		'url'    => '',
		'date'   => '',
	);
	$testimonial = get_post_meta( $post->ID, $this->slug, true );
	$testimonial = wp_parse_args( $testimonial, $default_testimonial );
?>
	<table class="form-table">
		<tr>
			<th scope="row" style="width: 140px">
				<label for="testimonial-author">Auteur</label>
			</th>
			<td>
				<input
					id="testimonial-author"
					value="<?php echo $testimonial['author']; ?>"
					type="text"
					name="<?php echo $this->slug; ?>[author]"
					class="text large-text"
				>
				<span class="description">Wanneer de referentie-titel niet de auteur is.</span>
			</td>
		</tr>
		<tr>
			<th scope="row" style="width: 140px">
				<label for="testimonial-info">Extra info</label>
			</th>
			<td>
				<input
					id="testimonial-info"
					value="<?php echo $testimonial['info']; ?>"
					type="text"
					name="<?php echo $this->slug; ?>[info]"
					class="text large-text"
				>
				<span class="description"></span>
			</td>
		</tr>
		<tr>
			<th scope="row" style="width: 140px">
				<label for="testimonial-url">Link / URL</label>
			</th>
			<td>
				<input
					id="testimonial-url"
					value="<?php echo $testimonial['url']; ?>"
					type="text"
					name="<?php echo $this->slug; ?>[url]"
					class="text large-text"
				>
				<span class="description">Externe link naar de schrijver van de referentie</span>
			</td>
		</tr>
		<tr>
			<th scope="row" style="width: 140px">
				<label for="testimonial-date">Datum</label>
			</th>
			<td>
				<input
					id="testimonial-date"
					value="<?php echo $testimonial['date']; ?>"
					type="text"
					name="<?php echo $this->slug; ?>[date]"
					class="text large-text"
				>
				<span class="description"></span>
			</td>
		</tr>
	</table>