<?php
/**
 * The Template for displaying all single portfolio projects
 * 
 * @link http://codex.wordpress.org/Template_Hierarchy
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

get_header();

if( have_posts() )
{ 
	while( have_posts() )
	{ 
		global $project;

		the_post();

		$type = $project->get_type( 'meta' );

		?>
		<div <?php post_class( 'site-content' ); ?> id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/CreativeWork">
			<?php 
				maxson_the_intro_section();

				get_template_part( 'template-parts/project/overview' );

				get_template_part( 'template-parts/project/media', $type );

				get_template_part( 'template-parts/project/testimonial' );

				get_template_part( 'template-parts/project/navigation' );

				get_template_part( 'template-parts/project/related' );
			?>
		</div><!-- .site-content -->
	<?php } // endwhile
} // endif

get_footer(); ?>