<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
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
	?><div class="site-content">
		<?php maxson_the_intro_section(); ?>

		<?php if( is_post_type_archive( 'portfolio_project' ) )
		{ ?>
			<section class="project-teasers" id="teasers">
				<div class="container">
					<?php maxson_the_section_title( array( 
						'href'   => '#teasers', 
						'text'   => __( 'Project Teasers', 'maxson' ), 
						'hidden' => true
					) ); ?>

					<?php get_template_part( 'template-parts/portfolio/filter' ); ?>

					<div class="row row-thin" id="portfolio-teasers">
					<?php while( have_posts() )
					{ 
						the_post();

						get_template_part( 'template-parts/portfolio/excerpt' );

					} // endwhile ?>

					</div><!-- .row -->
				</div><!-- .container -->
			</section>

		<?php } else
		{ 
			while( have_posts() )
			{ 
				the_post();

				echo get_the_title( '<h1 class="entry-title">', '</h1>' );

			} // endwhile
		} // endif ?>

	</div><!-- .site-content -->

<?php } // endif

get_footer(); ?>