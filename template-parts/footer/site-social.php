<?php
/**
 * Displays footer site info
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( is_active_sidebar( 'footer_right_sidebar' ) )
{ 
	dynamic_sidebar( 'footer_right_sidebar' );

} else
{ 
	echo '<div class="pull-right col-xs-12 col-md-6">';
		get_template_part( 'template-parts/navigation/social' );
	echo '</div>';

} // endif