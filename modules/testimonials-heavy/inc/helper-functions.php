<?php
function ejo_testimonials_loop()
{
	//* Get testimonials settings (order, visibility)
	if (is_singular())
		$testimonials_view_settings = get_option('testimonials_single_settings');		
	else 
		$testimonials_view_settings = get_option('testimonials_archive_settings');

	//* Check if Genesis
	$theme = wp_get_theme();
	$genesis = ($theme->get( 'Template' ) == 'genesis') ? true : false;
	
	//* if no posts exist
	if ( !have_posts() ) {
		if ($genesis) { do_action( 'genesis_loop_else' ); }
		return;
	}

	// Start loop
	if ($genesis) { do_action( 'genesis_before_while' ); }

	while ( have_posts() ) : the_post();

		if ($genesis) { do_action( 'genesis_before_entry' ); }

		printf( '<article %s>', genesis_attr( 'entry' ) );

			$testimonial = ejo_get_testimonial( get_the_ID(), $testimonials_view_settings );

			foreach ($testimonial as $testimonial_part) {
				echo $testimonial_part;
			}

		echo '</article>';

		if ($genesis) { do_action( 'genesis_after_entry' ); }

	endwhile; //* end of one post

	if ($genesis) { do_action( 'genesis_after_endwhile' ); }
}

//* Get testimonial
function ejo_get_testimonial($post_id, $testimonials_settings)
{
	//* Get testimonial meta data
	$testimonial_data = get_post_meta( $post_id, 'testimonials-heavy', true );

	//* Keeper of the testimonial output
	$testimonial = array();

	//* Get testimonials info in right order
	foreach ($testimonials_settings as $id => $field) {

		//* Skip the fields which are to be hidden
		if ($field['show'] === false)
			continue;

		switch ($id) {
			case 'title':
				$title_link = sprintf( '<a href="%s" rel="bookmark">%s</a>', get_permalink( $post_id ), get_the_title( $post_id ) );
				$title = sprintf( '<h2 class="%s" itemprop="%s">%s</h2>', 'entry-title', 'headline', $title_link );
				$testimonial['title'] = $title;
				break;

			case 'image':
				$image = get_the_post_thumbnail( $post_id, 'medium', array( 'class' => 'alignleft' ) );
				$testimonial['image'] = $image;
				break;
			
			case 'content':
				$content = sprintf( '<blockquote>%s</blockquote>', get_the_excerpt() );
				$content .= sprintf( '<p><a class="%s" href="%s">%s</a></p>', 'button', get_permalink( $post_id ), 'Lees meer' );
				$testimonial['content'] = $content;
				break;
			
			case 'author':
				if ( isset($testimonial_data['author']) ) {
					$testimonial['author'] = '<span class="author">' . $testimonial_data['author'] . '</span>';
				}
				break;
			
			case 'info':
				if ( isset($testimonial_data['info']) ) {
					$testimonial['info'] = '<span class="info">' . $testimonial_data['info'] . '</span>';
				}
				break;
			
			case 'date':
				if ( isset($testimonial_data['date']) ) {
					$testimonial['date'] = '<span class="date">' . $testimonial_data['date'] . '</span>';
				}
				break;						
		}
	}

	return $testimonial;
}