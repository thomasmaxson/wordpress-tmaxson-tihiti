<?php
/**
 * The template for portfolio project navigation
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

$show_project_nav = get_theme_mod( 'maxson_project_show_navigtion', '1' );

if( '1' == $show_project_nav )
{ 
	$prev_post = get_adjacent_post( false, '', true );
	$next_post = get_adjacent_post( false, '', false );

	$third_link = get_theme_mod( 'maxson_project_nav_third_link', 'back' );

	switch( $third_link )
	{ 
		case 'top': 
			$title = _x( 'To the top', 'Project pagination label', 'maxson' );
			$label = '<i class="fa fa-fw fa-2x fa-angle-up" aria-hidden="true"></i>';

			$topLink = sprintf( '<a href="#top" title="%1$s">%2$s <span class="sr-only">%1$s</span></a>', $title, $label );
			break;

		case 'back': 
		default: 
			$url   = maxson_portfolio_get_archive_page_url( home_url( '/' ) );
			$title = _x( 'View portfolio', 'Project pagination label', 'maxson' );
			$label = '<i class="fa fa-fw fa-lg fa-th-large" aria-hidden="true"></i>';

			$topLink = sprintf( '<a href="%1$s" title="%2$s">%3$s <span class="sr-only">%2$s</span></a>', $url, $title, $label );
			break;

	} // endswitch

?>
	<section class="portfolio-project-pagination" id="project-pagination">
		<nav class="pagination">
			<ul class="list-unstyled list-inline list-inline-collapse pagination-list">
				<li class="page-prev">
					<?php if( ! empty( $prev_post ) )
					{ 
						$prev_id = $prev_post->ID;

						$title      = _x( 'Previous Project', 'Project pagination label', 'maxson' );
						$title_attr = the_title_attribute( array( 
							'before' => 'View ', 
							'post'   => $prev_id, 
							'echo'   => false
						) );

						printf( '<a href="%1$s" title="%2$s" rel="prev"><i class="fa fa-angle-left"></i> %3$s</a>', get_permalink( $prev_id ), $title_attr, $title );

					} // endif ?>
				</li>
				<li class="nav-back">
					<?php echo $topLink; ?>
				</li>
				<li class="page-next">
					<?php if( ! empty( $next_post ) )
					{ 
						$next_id = $next_post->ID;

						$title      = _x( 'Next Project', 'Project pagination label', 'maxson' );
						$title_attr = the_title_attribute( array( 
							'before' => 'View ', 
							'post'   => $next_id, 
							'echo'   => false
						) );

						printf( '<a href="%1$s" title="%2$s" rel="prev">%3$s <i class="fa fa-angle-right"></i></a>', get_permalink( $next_id ), $title_attr, $title );

					} // endif ?>
				</li>
			</ul>
		</nav><!-- .pagination -->
	</section>

<?php } // endif ?>