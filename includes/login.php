<?php
/** 
 * Theme specific login functions
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) )
{ 
	die;

} // endif


if( ! function_exists( 'maxson_custom_login_message' ) )
{ 
	/**
	 * Hide login screen errors
	 * 
	 * @return     string
	 */

	function maxson_custom_login_message( $message )
	{ 
		return _x( 'The login information you entered is incorrect.', 'Generic login error message', 'maxson' );
	}
} // endif
add_filter( 'login_errors', 'maxson_custom_login_message' );


if( ! function_exists( 'maxson_login_header' ) )
{ 
	/**
	 * Modify login head
	 * 
	 * @return     string
	 */

	function maxson_login_header()
	{ 
		$default_height = 80;
		$default_width  = 80;

		$height = apply_filters( 'maxson_login_logo_height', $default_height );
		$width  = apply_filters( 'maxson_login_logo_width', $default_width );

		$height = ( empty( $height ) || ! is_numeric( $height ) ) ? $default_height : $height;
		$width  = ( empty( $width ) || ! is_numeric( $width ) )   ? $default_width  : $width;

?><style type="text/css">
.login h1 a { 
	margin-bottom: 15px;
	height: <?php echo "{$height}px"; ?>;
	width: <?php echo "{$width}px"; ?>;
	background-image: none, url( '<?php echo maxson_get_theme_brand_default_logo( true ); ?>' );
	background-position: center center;
	background-size: auto;
	background-repeat: no-repeat;
	background-size: <?php echo "{$width}px {$height}px"; ?>;
}
	.login h1 a:focus { outline: 1px dotted #ccc;}
</style>

		<?php 
	}
} // endif
add_action( 'login_head', 'maxson_login_header' );


if( ! function_exists( 'maxson_custom_login_title_tag' ) )
{ 
	/**
	 * Modify login <title> tag text
	 * 
	 * @return     string
	 */

	function maxson_custom_login_title_tag()
	{ 
		$name    = get_bloginfo( 'name', 'display' );
		$tagline = get_bloginfo( 'description', 'display' );

		$separator = '|';

	//	if( is_plugin_active( 'wordpress-seo/wp-seo.php' ) )
	//	{ 
	//		$titles = get_option( 'wpseo_titles', array() );

	//		$separator = ( in_array( 'separator', $titles ) ) ? $titles['separator'] : $separator;

	//	} // endif

		return "{$name} {$separator} {$tagline}";
	}
} // endif
add_filter( 'login_title', 'maxson_custom_login_title_tag' );


if( ! function_exists( 'maxson_custom_login_logo_url' ) )
{ 
	/**
	 * Modify login screen logo URL
	 * NOTE: Escaping via esc_url() is done in wp-login.php
	 * 
	 * @return     string
	 */

	function maxson_custom_login_logo_url()
	{ 
		return home_url( '/' );
	}
} // endif
add_filter( 'login_headerurl', 'maxson_custom_login_logo_url' );


if( ! function_exists( 'maxson_custom_login_logo_text' ) )
{ 
	/**
	 * Modify login logo text
	 * 
	 * @return     string
	 */

	function maxson_custom_login_logo_text()
	{ 
		return get_bloginfo( 'name', 'display' );
	}
} // endif
// add_filter( 'login_headertitle', 'maxson_custom_login_logo_text' );
add_filter( 'login_headertext', 'maxson_custom_login_logo_text' );

?>