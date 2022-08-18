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
	$post_id = get_the_ID();

	?><div class="site-content" id="post-<?php the_ID(); ?>">
		<?php maxson_the_intro_section();

		while( have_posts() )
		{ 
			the_post();

			the_content();

		} // endwhile ?>

	</div><!-- .container -->

<?php } // endif

get_footer(); ?>