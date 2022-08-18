<?php
/**
 * The template for portfolio project teasers
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

global $project;

$project_id = $project->get_ID();

$teaser_count = get_theme_mod( 'maxson_project_teaser_column_count', '3' );

$classes = array( 'project-teaser' );

$sizes = array( 
	array( 
		'breakpoint' => maxson_get_media_breakpoint( 0 ), 
		'size'       => 'project_teaser_th'

	), 
	array( 
		'breakpoint' => maxson_get_media_breakpoint( '345px' ), 
		'size'       => 'project_teaser_md'

	)
);

switch( $teaser_count )
{ 
	case '1': 
		$classes[] = 'col-xs-12';

		$sizes[] = array( 
			'breakpoint' => '( min-width: 700px )', 
			'size'       => 'project_teaser_lg'
		);
		break;

	case '2': 
		$classes[] = 'col-xs-12';
		$classes[] = 'col-sm-6';
		break;

	case '4': 
		$classes[] = 'project-teaser-sm';
		$classes[] = 'col-xs-12';
		$classes[] = 'col-sm-4';
		$classes[] = 'col-md-3';

		$sizes[] = array( 
			'breakpoint' => '( min-width: 700px )', 
			'size'       => 'project_teaser_lg'
		);
		break;

	case '6': 
		$classes[] = 'project-teaser-sm';
		$classes[] = 'col-xs-12';
		$classes[] = 'col-sm-4';
		$classes[] = 'col-sm-2';

		$sizes[] = array( 
			'breakpoint' => '( min-width: 700px )', 
			'size'       => 'project_teaser_md'
		);
		break;

	case '3': 
	default: 
		$classes[] = 'project-teaser-sm';
		$classes[] = 'col-xs-12';
		$classes[] = 'col-sm-6';
		$classes[] = 'col-md-4';

		$sizes[] = array( 
			'breakpoint' => '( min-width: 700px )', 
			'size'       => 'project_teaser_md'
		);
		break;

} // endswitch

?>
<article id="<?php echo esc_attr( "post-{$project_id}" ); ?>" <?php post_class( apply_filters( 'maxson_portfolio_project_teaser_classes', $classes, $project_id ) ); ?>>
	<a href="<?php echo $project->get_permalink(); ?>" class="project-link">
		<figure>
			<?php echo $project->get_thumbnail( 'project_thumbnail' ); ?>
			<?php /*maxson_the_post_picture( 'project_teaser_lg', $sizes, $project_id, array( 
				'class' => 'picture-responsive project-thumbnail wp-post-picture'

			) );*/ ?>
			<figcaption>
				<div><?php echo $project->get_title( '<h3 class="h3 project-teaser-title">', '</h3>' ); ?>
					<?php echo $project->get_categories( array( 
						'link'       => false, 
						'separator'  => false, 
						'before'     => '<ul class="list-inline list-inline-narrow list-inline-pipe project-teaser-description">', 
						'after'      => '</ul>', 
						'beforeitem' => '<li>', 
						'afteritem'  => '</li>'
					) ); ?>
				</div>
			</figcaption>
			<?php if( $project->is_promoted() )
			{ 
				printf( '<span class="project-promoted-label">%1$s</span>', $project->get_promoted_label() );

			} // endif ?>
		</figure>
	</a>
</article>