<?php
/**
 * Displays primary navigation
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

printf( '<nav class="collapse navbar-collapse navbar-right" id="primary-menu" itemscope itemtype="http://schema.org/SiteNavigationElement" aria-label="%1$s">', esc_attr__( 'Top Menu', 'maxson' ) );

if( has_nav_menu( 'primary' ) )
{ 
	$menu_args = array( 
		'theme_location' => 'primary', 
		'container'      => false, 
		'menu_class'     => 'nav navbar-nav', 
		'menu_id'        => false
	);

	if( class_exists( 'WP_Nav_Walker_Bootstrap' ) )
	{ 
		$menu_args['walker'] = new WP_Nav_Walker_Bootstrap();

	} // endif

	wp_nav_menu( $menu_args );

} // endif

echo '</nav>';

?>