<?php
/**
 * The template for portfolio project gallery
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

global $project;

?><section class="portfolio-project-video" id="video">
	<?php maxson_the_section_title( array( 
		'href'   => '#video', 
		'text'   => _x( 'Project Video', 'Section title', 'maxson' ), 
		'hidden' => true
	) ); ?>

	<div class="row row-centered">
		<div class="col-xs-12 col-md-8">
			<?php echo $project->get_media(); ?>
		</div>
	</div><!-- .row -->
</section>