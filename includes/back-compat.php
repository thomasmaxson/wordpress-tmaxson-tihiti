<?php
/**
 * Theme backwards compatibility functionality
 * 
 * Prevents WordPress theme from running on previous versions of WordPress,
 * since this theme is not meant to be backward compatible and relies on many 
 * new functions and markup changes introduced in newer versions of WordPress.
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


/**
 * Backwards compatibility notification message
 * 
 * @return      string
 */

function maxson_back_compat_notice()
{ 
	$min_wp_version = maxson_get_version_minimum_wordpress();
	$wp_version     = $GLOBALS['wp_version'];

	return sprintf( __( 'This theme requires at least WordPress version %1$s. You are running version %2$s. Please upgrade and try again.', 'maxson' ), $min_wp_version, $wp_version );
}


/**
 * Prevent switching to default theme on old versions of WordPress
 * Switches to the default theme
 * 
 * @return      void
 */

function maxson_back_compat_switch_theme()
{ 
	switch_theme( WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'maxson_back_compat_upgrade_notice' );
}
add_action( 'after_switch_theme', 'maxson_back_compat_switch_theme' );


/**
 * Add message for unsuccessful theme switch
 * Prints an update nag after an unsuccessful attempt to switch to default theme
 * 
 * @return      void
 */

function maxson_back_compat_upgrade_notice()
{ 
	$notice = maxson_back_compat_notice();

	printf( '<div class="error"><p>%1$s</p></div>', $notice );
}


/**
 * Prevent theme customizer from being loaded
 * 
 * @return      void
 */

function maxson_back_compat_customize()
{ 
	$notice = maxson_back_compat_notice();

	wp_die( $notice, '', array(
		'back_link' => true
	) );
}
add_action( 'load-customize.php', 'maxson_back_compat_customize' );


/**
 * Prevent theme preview from being loaded
 * 
 * @return      void
 */

function maxson_back_compat_preview()
{ 
	if( isset( $_GET['preview'] ) )
	{ 
		$notice = maxson_back_compat_notice();

		wp_die( $notice );

	} // endif
}
add_action( 'template_redirect', 'maxson_back_compat_preview' );

?>