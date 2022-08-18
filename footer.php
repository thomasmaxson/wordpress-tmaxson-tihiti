<?php
/**
 * Template for displaying the footer
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

maxson_the_cta_button(); 

?>
	</div>
</main><!-- .site-body -->

<footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
	<div class="container">
		<div class="row" itemscope itemtype="http://schema.org/WPSideBar">
			<?php get_template_part( 'template-parts/footer/site', 'social' ); ?>
			<?php get_template_part( 'template-parts/footer/site', 'info' ); ?>
		</div><!-- .row -->
	</div><!-- #container -->
</footer>

<?php wp_footer(); // Always have wp_footer() just before the closing </body> tag of your theme. ?>

</body>
</html>