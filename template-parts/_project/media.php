<?php
/**
 * The template for portfolio project gallery
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

global $project;

if( $project->has_thumbnail() )
{ ?>
	<section class="portfolio-project-thumbnail" id="thumbnail">
		<?php maxson_the_section_title( array( 
			'href'   => '#thumbnail', 
			'text'   => _x( 'Project Thumbnail', 'Section title', 'maxson' ), 
			'hidden' => true
		) ); ?>

		<div class="row row-centered">
			<div class="col-xs-10 col-sm-8 col-md-7 col-lg-6">
				<?php echo $project->get_thumbnail( 'project_large', array( 
					'itemprop' => 'image'
				) ); ?>
			</div>
		</div><!-- .row -->
	</section>

<?php } else
{ ?>
	<section class="sr-only portfolio-project-thumbnail" id="thumbnail">
		<?php wpautop( __( 'This project does not have a thumbnail associated with it.', 'maxson' ) ); ?>
	</section>

<?php } // endif ?>