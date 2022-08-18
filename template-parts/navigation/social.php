<?php
/**
 * Displays primary navigation
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( has_nav_menu( 'social' ) )
{ 
	$menu_args = array( 
		'theme_location'  => 'social', 
		'container_class' => 'social-media', 
		'link_before'     => '<span class="sr-only">', 
		'link_after'      => '</span>', 
		'menu_class'      => 'list-inline list-inline-thin social-icons', 
		'menu_id'         => false
	);

	if( class_exists( 'WP_Nav_Walker_Social_Media' ) )
	{ 
		$menu_args['walker'] = new WP_Nav_Walker_Social_Media();

	} // endif


	echo '<nav class="social-navigation" role="navigation">';
		wp_nav_menu( $menu_args );
	echo '</nav>';

} // endif

?>