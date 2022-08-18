<?php
/**
 * The template for portfolio project gallery
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

global $project;

$gallery_args = array( 
	'exclude' => get_post_thumbnail_id( $project->get_ID() )
);

$gallery = $project->get_gallery( 'project_large', array( 
	'link'        => get_option( 'maxson_project_gallery_lightbox', false ), 
	'image_class' => 'img-responsive img-centered'
) );

if( ! empty( $gallery ) )
{ ?>
	<section class="portfolio-project-gallery-images" id="gallery-images">
		<?php echo $gallery; ?>

	</section>

<?php } // endif ?>