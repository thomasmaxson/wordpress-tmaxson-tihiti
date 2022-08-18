<?php
/**
 * The template for displaying the 404 page
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

$bullets = array();

$contact_id = maxson_get_core_page_id( 'contact' );

if( $contact_id )
{ 
	$bullets[] = sprintf( 'If you think this is an error on my part, please <a href="%s">let me know</a>.', get_permalink( $contact_id ) );

} // endif

$bullets[] = sprintf( 'If you would like to just browse, head over to the <a href="%s">home page</a>.', home_url( '/' ) );

get_header(); ?>

<div <?php post_class( 'site-content' ); ?> id="post-0">
	<?php maxson_the_intro_section(); ?>

	<section class="message" id="error-message">
		<div class="container">
			<p><?php _e( "Sorry, I can’t seem to find what you’re looking for. This might be because you have typed the web address incorrectly, had its name changed, or the page is unavailable.", 'maxson' ); ?></p>
			<p><?php _e( "Here's some options:", 'maxson' ); ?></p>
			<?php if( ! empty( $bullets ) )
			{ 
				echo '<ul>';

				foreach( $bullets as $bullet )
				{ 
					printf( '<li>%1$s</li>', $bullet );

				} // endforeach

				echo '</ul>';

			} // endif ?>
		</div><!-- .container -->
	</section>
</div>

<?php get_footer(); ?>