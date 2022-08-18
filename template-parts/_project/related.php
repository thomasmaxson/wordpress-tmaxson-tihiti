<?php
/**
 * The template for portfolio project teasers
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

global $post, $project;

$teaser_count = get_theme_mod( 'maxson_project_teaser_column_count', '3' );

$related_projects = $project->get_related( $teaser_count );

if( ! empty( $related_projects ) )
{ ?>
	<section class="project-teasers related-projects" id="related">
		<div class="container">
			<?php maxson_the_section_title( array( 
				'href'   => '#related', 
				'text'   => __( 'Related Projects', 'maxson' ), 
				'hidden' => true
			) ); ?>

			<div class="row row-thin">
				<?php foreach( $related_projects as $post )
				{ 
					setup_postdata( $post );

					get_template_part( 'template-parts/portfolio/excerpt' );

				} // endforeach

				wp_reset_postdata(); ?>
			</div><!-- .row -->
		</div><!-- .container -->
	</section><!-- .related-projects -->

<?php } // endif