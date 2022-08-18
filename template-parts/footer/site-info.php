<?php
/**
 * Displays footer site info
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( is_active_sidebar( 'footer_left_sidebar' ) )
{ 
	dynamic_sidebar( 'footer_left_sidebar' );

} else
{ 
	$policy_page_link = get_the_privacy_policy_link();
	$footer_text      = sprintf( __( '&copy; %s %s. All rights reserved.' ), date( 'Y' ), get_bloginfo( 'name', 'display' ) );

	if( ! empty( $policy_page_link ) )
	{ 
		$footer_text .= ' ';
		$footer_text .= $policy_page_link;

	} // endif

	echo '<div class="col-xs-12 col-md-6">';
	echo '<div class="copyright">';
	echo apply_filters( 'the_content', $footer_text );
	echo '</div>';
	echo '</div>';

} // endif