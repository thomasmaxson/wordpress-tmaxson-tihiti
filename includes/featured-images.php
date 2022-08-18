<?php 
/**
 * Theme Extras
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! function_exists( 'maxson_featured_images_get_settings' ) )
{ 
	function maxson_featured_images_get_settings()
	{ 
		$option = get_theme_support( 'maxson-content-options' );
	//	$option  = $support[0];

		$feat_images = ( ! empty( $option['featured_images'] ) ) ? $option['featured_images'] : null;

		$settings = array(
			'archive' => ( ! empty( $feat_images['archive'] ) ) ? $feat_images['archive'] : null, 
			'post'    => ( ! empty( $feat_images['post'] ) )    ? $feat_images['post']    : null, 
			'page'    => ( ! empty( $feat_images['page'] ) )    ? $feat_images['page']    : null, 

			'opt_archive' => get_option( 'maxson_content_featured_images_archive', true ), 
			'opt_post'    => get_option( 'maxson_content_featured_images_post', true ),
			'opt_page'    => get_option( 'maxson_content_featured_images_page', true )
		);

		if( post_type_exists( 'portfolio_project' ) )
		{ 
			$settings['portfolio']     = ( ! empty( $feat_images['portfolio'] ) ) ? $feat_images['portfolio'] : null;
			$settings['opt_portfolio'] = get_option( 'maxson_content_featured_images_portfolio', true );

		} // endif

		return $settings;
	}
} // endif


if( ! function_exists( 'maxson_featured_images_remove_post_thumbnail' ) )
{ 
	/**
	 * The function to prevent for Featured Images to be displayed in a theme.
	 */

	function maxson_featured_images_remove_post_thumbnail( $metadata, $object_id, $meta_key, $single )
	{ 
		$opts = maxson_featured_images_get_settings();

		if( ( isset( $meta_key ) && '_thumbnail_id' === $meta_key ) && in_the_loop() )
		{ 
			if( ( true == $opts['archive'] && ! $opts['opt_archive'] && ( is_home() || is_archive() || is_search() ) )
				|| ( true == $opts['post'] && ! $opts['opt_post'] && is_single() )
				|| ( true == $opts['page'] && ! $opts['opt_page'] && is_singular() && is_page() )
				|| ( true == $opts['portfolio'] && ! $opts['opt_portfolio'] && post_type_exists( 'portfolio_project' ) && is_singular( 'portfolio_project' ) )
			)
			{ 
				return false;

			} // endif
		} // endif

		return $metadata;
	}
} // endif
add_filter( 'get_post_metadata', 'maxson_featured_images_remove_post_thumbnail', true, 4 );

?>