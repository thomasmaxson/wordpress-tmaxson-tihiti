<?php
/**
 * The template for portfolio project testimonial
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

global $project;

$testimonials = get_post_meta( $project->get_ID(), '_testimonials', true );

if( $testimonials && is_array( $testimonials ) )
{ 
	$testimonial_item = array_rand( $testimonials, 1 );

	$testimonial_id = $testimonials[ $testimonial_item ];

	$testimonial_author  = get_the_title( $testimonial_id );
	$testimonial_byline  = get_post_meta( $testimonial_id, '_byline', true );
	$testimonial_content = get_post_field( 'post_content', $testimonial_id );

	?><section class="portfolio-project-testimonial" id="testimonial">
		<div class="container">
			<?php maxson_the_section_title( array( 
				'href'   => '#testimonial', 
				'text'   => __( 'Testimonials', 'maxson' ), 
				'hidden' => true
			) ); ?>

			<div class="row row-centered">
				<div class="col-xs-12 col-md-10 col-lg-8">
					<div class="testimonial">
						<?php echo apply_filters( 'the_content', $testimonial_content ); ?>
						<div class="client-info">
							<?php printf( '<h4 class="h2 testimonial-title">%1$s</h4>', $testimonial_author ); ?>
							<?php if( ! empty( $testimonial_byline ) )
							{ 
								printf( '<cite class="testimonial-byline">%1$s</cite>', $testimonial_byline );

							} // endif ?>
						</div><!-- .client-info -->
					</div><!-- .testimonial -->
				</div>
			</div><!-- .row -->
		</div><!-- .testimonial -->
	</section>

<?php } // endif ?>