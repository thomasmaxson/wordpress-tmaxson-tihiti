<?php
/**
 * The template for portfolio project content
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

// get_the_date()
// get_the_modified_date()
// get_the_time()
// get_the_modified_time()

global $project;

if( $project->get_time( 'U' ) !== $project->get_modified_time( 'U' ) )
{ 
	$time_string = '<del><time class="entry-date published sr-only" datetime="%1$s" itemprop="datePublished">%2$s</time></del><time class="updated" datetime="%3$s">%4$s</time>';

} else
{ 
	$time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';

} // endif

$time_string = sprintf( $time_string, esc_attr( $project->get_date( 'c' ) ), $project->get_date(), esc_attr( $project->get_modified_date( 'c' ) ), $project->get_modified_date() );

$project_client = $project->get_client();

$project_dates = $project->get_start_end_date_html( array( 
	'separator' => '&nbsp;&ndash; <br>'
) );

$project_categories = $project->get_categories( array( 
	'link'      => false, 
	'separator' => ', '
) );

$project_tags = $project->get_tags( array( 
	'link'      => false, 
	'separator' => ', '
) );

$project_link = $project->get_url();

$do_show_overview = ( empty( get_the_content() ) && ! is_customize_preview() ) ? 'sr-only' : '';

?>
<section class="<?php echo $do_show_overview; ?> portfolio-project-overview" id="overview">
	<div class="container">
		<?php maxson_the_section_title( array( 
			'href'   => '#overview', 
			'text'   => _x( 'Project Overview', 'Section title', 'maxson' ), 
			'hidden' => true
		) ); ?>

		<div class="row row-narrow">
			<div class="col-xs-12 col-md-8">
				<div class="project-overview" itemprop="about">
					<?php the_content(); ?>
				</div><!-- .project-overview -->
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="project-details">
					<div class="project-date">
						<div class="row">
							<div class="col-xs-4">
								<span class="project-detail-label"><?php _e( 'Date', 'maxson' ); ?></span>
							</div>
							<div class="col-xs-8">
								<?php printf( '<p class="posted-on">%1$s <a href="%2$s" rel="bookmark" itemprop="url">%3$s</a></p>', _x( 'Posted on', 'Used before publish date.', 'maxson' ), esc_url( $project->get_permalink() ), $time_string ); ?>
							</div>
						</div><!-- .row -->
					</div><!-- .project-date -->

					<div class="project-author">
						<div class="row">
							<div class="col-xs-4">
								<span class="project-detail-label"><?php _e( 'Author', 'maxson' ); ?></span>
							</div>
							<div class="col-xs-8" itemprop="author" itemscope itemtype="http://schema.org/Person">
								<p class="author-title" itemprop="name"><?php printf( esc_html__( 'Published by %s', 'maxson' ), '<span class="author-name">' . get_the_author() . '</span>' ); ?></p>
							</div>
						</div><!-- .row -->
					</div><!-- .project-author -->

					<?php if( ! empty( $project_client ) )
					{ ?>
						<div class="project-client">
							<div class="row">
								<div class="col-xs-4">
									<span class="project-detail-label"><?php _e( 'Client', 'maxson' ); ?></span>
								</div>
								<div class="col-xs-8">
									<?php echo apply_filters( 'the_content', $project_client ); ?>
								</div>
							</div><!-- .row -->
						</div><!-- .project-client -->

					<?php } // endif

					if( ! empty( $project_dates ) )
					{ ?>
						<div class="project-start-end-dates">
							<div class="row">
								<div class="col-xs-4">
									<span class="project-detail-label"><?php _e( 'Start/End Dates', 'maxson' ); ?></span>
								</div>
								<div class="col-xs-8">
									<?php echo apply_filters( 'the_content', $project_dates ); ?>
								</div>
							</div><!-- .row -->
						</div><!-- .project-dates -->

					<?php } // endif


					if( ! empty( $project_categories ) )
					{ ?>
						<div class="project-cats">
							<div class="row">
								<div class="col-xs-4">
									<span class="project-detail-label"><?php _e( 'Categorized', 'maxson' ); ?></span>
								</div>
								<div class="col-xs-8" itemprop="genre">
									<?php echo apply_filters( 'the_content', $project_categories ); ?>
								</div>
							</div><!-- .row -->
						</div><!-- .project-cats -->

					<?php } // endif


					if( ! empty( $project_tags ) )
					{ ?>
						<div class="project-tags">
							<div class="row">
								<div class="col-xs-4">
									<span class="project-detail-label"><?php _e( 'Tagged', 'maxson' ); ?></span>
								</div>
								<div class="col-xs-8">
									<?php echo apply_filters( 'the_content', $project_tags ); ?>
								</div>
							</div><!-- .row -->
						</div><!-- .project-tags -->

					<?php } // endif


					if( ! empty( $project_link ) )
					{ ?>
						<p><a href="<?php echo esc_url( $project_link ); ?>" target="_blank" class="btn btn-lg btn-block btn-primary btn-outline"><?php _e( 'Visit Website', 'maxson' ); ?></a></p>

					<?php } // endif ?>
				</div><!-- .project-details -->
			</div>

		</div><!-- .row -->
	</div><!-- .container -->
</section><!-- .portfolio-project-overview -->