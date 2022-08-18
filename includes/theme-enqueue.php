<?php
/**
 * Theme Enqueue
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! function_exists( 'maxson_enqueue_theme_styles_scripts' ) )
{ 
	/**
	 * Enqueue theme specific styles and scripts
	 * 
	 * @return      void
	 */

	function maxson_enqueue_theme_styles_scripts()
	{ 
		$theme = ( function_exists( 'wp_get_theme' ) ) ? wp_get_theme() : get_current_theme();
			$theme_version = $theme->get( 'Version' );

		$protocol = ( is_ssl() ) ? 'https' : 'http';
		$suffix   = ( maxson_theme_mode_is_debug() || is_user_logged_in() ) ? '' : '.min';

		$jquery_core_version = maxson_get_version_jquery();
		$jquery_core_url     = "{$protocol}://ajax.googleapis.com/ajax/libs/jquery/{$jquery_core_version}/jquery.min.js";

		$fontawesome_version = maxson_get_version_font_awesome();
	//	$fontawesome_url     = "{$protocol}://pro.fontawesome.com/releases/v{$fontawesome_version}/css/all.css";
		$fontawesome_url     = "{$protocol}://kit.fontawesome.com/63c248405b.js";

		wp_register_style( 'reset', get_theme_file_uri( "/assets/css/reset{$suffix}.css" ), 
			array(), $theme_version, 'all' );
		wp_register_style( 'gentleman', get_theme_file_uri( "/assets/fonts/gentleman/style{$suffix}.css" ), 
			array( 'reset' ), '1.0', 'screen' );
	//	wp_register_style( 'fontawesome', $fontawesome_url, 
	//		array( 'reset' ), $fontawesome_version, 'screen' );
		wp_register_style( 'maxson-styles', get_stylesheet_uri(), 
			array( 'reset', 'gentleman' ), 'all' );

	//	wp_enqueue_style( 'print' );
		wp_enqueue_style( 'reset' );
		wp_enqueue_style( 'gentleman' );
	//	wp_enqueue_style( 'fontawesome' );
		wp_enqueue_style( 'maxson-styles' );

		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', $jquery_core_url, array(), $jquery_core_version, true );
		wp_enqueue_script( 'jquery' );

		wp_register_script( 'fontawesome-kit', $fontawesome_url, array(), null, false );
		wp_enqueue_script( 'fontawesome-kit' );

		wp_register_script( 'maxson-script', get_theme_file_uri( '/assets/js/script.js' ), array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'maxson-script' );
		wp_script_add_data( 'maxson-script', 'async', true );

		$nav_prev_arrow = sprintf( '<span class="fal fa-angle-left" aria-label="%1$s"></span>', _x( 'Previous Slide', 'Navigation label', 'maxson' ) );
		$nav_next_arrow = sprintf( '<span class="fal fa-angle-right" aria-label="%1$s"></span>', _x( 'Next Slide', 'Navigation label', 'maxson' ) );

		$args = array( 
			'gallery_nav_next_label'     => apply_filters( 'maxson_gallery_nav_next_label', $nav_next_arrow ), 
			'gallery_nav_previous_label' => apply_filters( 'maxson_gallery_nav_prev_label', $nav_prev_arrow ), 

			'lightbox_missing_image'      => __( 'Image not found, next image will be loaded', 'maxson' ), 
			'lightbox_nav_next_label'     => apply_filters( 'maxson_lightbox_nav_next_label', $nav_next_arrow ), 
			'lightbox_nav_previous_label' => apply_filters( 'maxson_lightbox_nav_prev_label', $nav_prev_arrow ), 
			'lightbox_nav_close_button'   => apply_filters( 'maxson_lightbox_nav_close_button', '<span aria-hidden="true">&times;</span><span class="sr-only">Close Modal</span>' )
		);

		wp_localize_script( 'maxson-script', 'maxsonParams', $args );


		// Remove Contact Form 7 styles and scripts on non-essential pages
		if( class_exists( 'WPCF7' ) && ! maxson_is_core_page( 'contact' ) )
		{ 
			$_wpcf7_style_tag  = 'contact-form-7';
			$_wpcf7_script_tag = 'contact-form-7';

			if( wp_style_is( $_wpcf7_style_tag, 'enqueued' ) )
			{ 
				wp_dequeue_style( $_wpcf7_style_tag );

			} // endif

			if( wp_script_is( $_wpcf7_script_tag, 'enqueued' ) )
			{ 
				wp_dequeue_script( $_wpcf7_script_tag );

			} // endif
		} // endif
	}
} // endif
add_action( 'wp_enqueue_scripts', 'maxson_enqueue_theme_styles_scripts' );


if( ! function_exists( 'maxson_add_attrs_to_scripts' ) )
{ 
	/**
	 * Add additional tags to WordPress enqueued scripts
	 * 
	 * @return      string
	 */

	function maxson_add_attrs_to_scripts( $tag, $handle, $src )
	{ 
		if( $handle == 'fontawesome-kit' )
		{ 
			return '<script src="' . $src . '" crossorigin="anonymous"></script>' . "\n";

		} // endif

		return $tag;
	}
} // endif
add_filter( 'script_loader_tag', 'maxson_add_attrs_to_scripts', 10, 3 );


if( ! function_exists( 'maxson_remove_jquery_migrate' ) )
{ 
	/**
	 * Remove Jquery migrate
	 * 
	 * @return      void
	 */

	function maxson_remove_jquery_migrate( $scripts )
	{
		if( ! is_admin() && isset( $scripts->registered['jquery'] ) )
		{ 
			$script = $scripts->registered['jquery'];

			// Check whether the script has any dependencies
			if( $script->deps )
			{ 
				$script->deps = array_diff( $script->deps, array(
					'jquery-migrate'
				) );
			} // endif
		} // endif
	}
} // endif
add_action( 'wp_default_scripts', 'maxson_remove_jquery_migrate' );

?>