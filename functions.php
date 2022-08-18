<?php
/**
 * Functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
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
 * Include additional theme files
 * locate_template searches the child theme before searching the parent theme
 * 
 * @return      void
 */

// Meta
// require( get_theme_file_path( 'includes/metaboxes/post-meta.php' ) );
// require( get_theme_file_path( 'includes/metaboxes/taxonomy-meta.php' ) );


// Classes
require( get_theme_file_path( 'includes/classes/class-script-loader.php' ) );
require( get_theme_file_path( 'includes/classes/class-html5-picture-tag.php' ) );


// Functions
require( get_theme_file_path( 'includes/ajax.php' ) );
require( get_theme_file_path( 'includes/featured-images.php' ) );
require( get_theme_file_path( 'includes/functions.php' ) );
require( get_theme_file_path( 'includes/login.php' ) );
require( get_theme_file_path( 'includes/media.php' ) );
require( get_theme_file_path( 'includes/sanitize.php' ) );
require( get_theme_file_path( 'includes/social.php' ) );

require( get_theme_file_path( 'includes/post-details.php' ) );


// Theme Files
require( get_theme_file_path( 'includes/theme-support.php' ) );
require( get_theme_file_path( 'includes/theme-enqueue.php' ) );
require( get_theme_file_path( 'includes/theme-setup.php' ) );


// Customize
if( is_admin() || is_customize_preview() )
{ 
	require( get_theme_file_path( 'includes/customize/customize-controls.php' ) );
	require( get_theme_file_path( 'includes/customize/customize-sanitize.php' ) );
	require( get_theme_file_path( 'includes/customize/customize-setup.php' ) );

	require( get_theme_file_path( 'includes/customize/settings-content.php' ) );
	require( get_theme_file_path( 'includes/customize/settings-portfolio.php' ) );
	require( get_theme_file_path( 'includes/customize/settings-sample.php' ) );
	require( get_theme_file_path( 'includes/customize/settings-script.php' ) );
	require( get_theme_file_path( 'includes/customize/settings-theme.php' ) );

} // endif


// Shortcodes
require( get_theme_file_path( 'includes/shortcodes/bootstrap.php' ) );
require( get_theme_file_path( 'includes/shortcodes/font-awesome.php' ) );
require( get_theme_file_path( 'includes/shortcodes/theme.php' ) );


// Template Parts
require( get_theme_file_path( 'template-parts/template-tags.php' ) );


// Walkers
// require( get_theme_file_path( 'includes/walker/customizer-dropdown-categories.php' ) );
require( get_theme_file_path( 'includes/walker/walker-filter-portfolio.php' ) );
require( get_theme_file_path( 'includes/walker/walker-nav-bootstrap.php' ) );
require( get_theme_file_path( 'includes/walker/walker-nav-font-awesome.php' ) );
require( get_theme_file_path( 'includes/walker/walker-nav-social-media.php' ) );


/**
 * Theme is only compatible with WordPress 4.6 or later
 */

$min_wp_version = maxson_get_version_minimum_wordpress();

if( version_compare( $GLOBALS['wp_version'], "{$min_wp_version}-alpha", '<' ) )
{ 
	require( get_theme_file_path( 'includes/back-compat.php' ) );
	return;

} // endif

?>