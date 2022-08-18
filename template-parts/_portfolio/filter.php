<?php
/**
 * The template for portfolio project filter
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

$show_portfolio_filter = get_theme_mod( 'maxson_project_archive_filter', true );

if( true === $show_portfolio_filter )
{ 
	$taxonomy = 'portfolio_category';

	echo '</div>';
	echo '<div class="container-fluid">';

	maxson_portfolio_filter( array( 
		'taxonomy'   => $taxonomy, 
		'class'      => 'list-inline list-inline-narrow list-inline-pipe portfolio-filters', 
		'id'         => 'portfolio-filters', 
		'attributes' => array( 
			'data-taxonomy' => $taxonomy
		)
	) );

	echo '</div>';
	echo '<div class="container">';

} // endif