<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
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
		the_post();

		the_content();
		// Silence is Golden

	} // endwhile
} else 
{ 
	// Silence is Golden

} // endif

get_footer(); ?>