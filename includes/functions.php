<?php 
/**
 * Theme Functions
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif



if( ! function_exists( 'maxson_get_version_minimum_wordpress' ) )
{ 
	/** 
	 * Returns the minimum version of WordPress required for this theme
	 * 
	 * @return      string
	 */

	function maxson_get_version_minimum_wordpress()
	{ 
		return apply_filters( 'maxson_version_minimum_wordpress', '5.0' );
	}
} // endif


if( ! function_exists( 'maxson_get_version_font_awesome' ) )
{ 
	/** 
	 * Returns the version of Font Awesome used in this theme
	 * 
	 * @return      string
	 */

	function maxson_get_version_font_awesome()
	{ 
		$option  = 'maxson_version_font_awesome';
		$default = apply_filters( "{$option}_default", '5.15.4' );

		$version = ( defined( 'MAXSON_THEME_FONT_AWESOME_VERSION' ) ) ? 
			MAXSON_THEME_FONT_AWESOME_VERSION : 
			get_theme_mod( $option, $default );

		return apply_filters( $option, $version, $default );
	}
} // endif


if( ! function_exists( 'maxson_get_version_jquery' ) )
{ 
	/** 
	 * Returns the version of jQuery used in this theme
	 * 
	 * @return      string
	 */

	function maxson_get_version_jquery()
	{ 
		$option  = 'maxson_version_jquery';
		$default = apply_filters( "{$option}_default", '3.6.0' );

		$version = ( defined( 'MAXSON_THEME_JQUERY_VERSION' ) ) ? 
			MAXSON_THEME_JQUERY_VERSION : 
			get_theme_mod( $option, $default );

		return apply_filters( $option, $version, $default );
	}
} // endif


if( ! function_exists( 'maxson_get_version_jquery_ui' ) )
{ 
	/** 
	 * Returns the version of jQuery UI used in this theme
	 * 
	 * @return      string
	 */

	function maxson_get_version_jquery_ui()
	{ 
		$option  = 'maxson_version_jquery_ui';
		$default = apply_filters( "{$option}_default", '1.12.1' );

		$version = ( defined( 'MAXSON_THEME_JQUERY_UI_VERSION' ) ) ? 
			MAXSON_THEME_JQUERY_UI_VERSION : 
			get_theme_mod( $option, $default );

		return apply_filters( $option, $version, $default );
	}
} // endif


if( ! function_exists( 'maxson_theme_mode_is_test_environment' ) )
{ 
	/**
	 * Check for test environment
	 * 
	 * @param 		string|int|bool $true  (optional) Value to return if condition is "true"
	 * @param 		string|int|bool $false (optional) Value to return if condition is "false"
	 * @return      bool
	 */

	function maxson_theme_mode_is_test_environment( $true = true, $false = false )
	{ 
	//	$server_name = strtolower( $_SERVER['SERVER_NAME'] );
		$site_url = network_site_url( '/' );

		if( stristr( $site_url, '127.0.0.1' ) !== false || 
			stristr( $site_url, 'localhost' ) !== false || 
			stristr( $site_url, ':8888'     ) !== false )
		{ 
			$is_dev = $true;

		} else
		{ 
			$is_dev = $false;

		} // endif

		return apply_filters( 'maxson_theme_mode_is_test_environment', $is_dev, $true, $false );
	}
} // endif


if( ! function_exists( 'maxson_theme_mode_is_debug' ) )
{ 
	/** 
	 * Determine if site is in debug mode
	 * 
	 * @return      bool
	 */

	function maxson_theme_mode_is_debug( $true = true, $false = false )
	{ 
		$debug = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? $true : $false;

		return apply_filters( 'maxson_theme_mode_is_debug', $debug, $true, $false );
	}
} // endif


if( ! function_exists( 'maxson_theme_mode_is_script_debug' ) )
{ 
	/** 
	 * Determine if site is in site debug mode
	 * 
	 * @return      bool
	 */

	function maxson_theme_mode_is_script_debug( $true = true, $false = false )
	{ 
		$debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? $true : $false;

		return apply_filters( 'maxson_theme_mode_is_script_debug', $debug, $true, $false );
	}
} // endif


if( ! function_exists( 'maxson_get_bootstrap_breakpoints' ) )
{ 
	/** 
	 * Returns the theme Bootstrap breakpoints
	 * 
	 * @return      array
	 */

	function maxson_get_bootstrap_breakpoints()
	{ 
		return apply_filters( 'maxson_theme_bootstrap_breakpoints', array( 
			'xs' => 480, 
			'sm' => 768, 
			'md' => 992, 
			'lg' => 1200
		) );
	}
} // endif


if( ! function_exists( 'maxson_get_bootstrap_breakpoint' ) )
{ 
	/** 
	 * Returns the theme Bootstrap breakpoint size
	 * 
	 * @return      int
	 */

	function maxson_get_bootstrap_breakpoint( $size = 'md' )
	{ 
		$breakpoints = maxson_get_bootstrap_breakpoints();
		$value = false;

		if( is_string( $size ) && in_array( $size, array_keys( $breakpoints ) ) )
		{ 
			$value = $breakpoints[ $size ];

		} // endif

		return $value;
	}
} // endif


if( ! function_exists( 'maxson_get_media_breakpoint' ) )
{ 
	/** 
	 * Returns the theme media breakpoint string
	 * 
	 * @return      int|atring
	 */

	function maxson_get_media_breakpoint( $size = 'md', $query = 'min-width' )
	{ 
		$breakpoint = maxson_get_bootstrap_breakpoint( $size );

		if( $breakpoint )
		{ 
			return sprintf( '( %1$s: %2$s )', $query, $breakpoint );

		} elseif( is_int( $size ) || is_string( $size ) )
		{ 
			return sprintf( '( %1$s: %2$s )', $query, $size );

		}// endif

		return false;
	}
} // endif


if( ! function_exists( 'maxson_get_theme_brand_default_color' ) )
{ 
	/** 
	 * Returns the theme brand default color
	 * 
	 * @return      string
	 */

	function maxson_get_theme_brand_default_color()
	{ 
		return get_theme_mod( 'primary_color' );
	}
} // endif


if( ! function_exists( 'maxson_get_theme_brand_inverse_color' ) )
{ 
	/** 
	 * Returns the theme brand inverse color
	 * 
	 * @return      string
	 */

	function maxson_get_theme_brand_inverse_color()
	{ 
		return get_theme_mod( 'inverse_color' );
	}
} // endif


if( ! function_exists( 'maxson_get_theme_brand_logo' ) )
{ 
	/** 
	 * Retrieve site logo
	 * 
	 * @param       string $type      type of logo (default, inverse)
	 * @param       bool   $image_src encode logo
	 * @return      string
	 */

	function maxson_get_theme_brand_logo( $type = 'default', $image_src = false )
	{ 
		$output = false;

		if( current_theme_supports( 'custom-logo' ) )
		{ 
			$logo_key = ( 'inverse' == $type ) ? 'custom_logo_inverse' : 'custom_logo';

			$logo_id = get_theme_mod( $logo_key );

			if( ! empty( $logo_id ) )
			{ 
				$logo_data = wp_get_attachment_image_src( $logo_id, 'full' );

				if( is_wp_error( $logo_data ) || empty( $logo_data ) || ! is_array( $logo_data ) )
				{ 
					return $output;

				} // endif

				if( true === $image_src )
				{ 
					$output = $logo_data[0];

				} else if( strpos( $logo_data[0], '.svg' ) !== false )
				{ 
					$icon = str_replace( site_url( '/' ), '', $logo_data[0] );

					ob_start();

					include( ABSPATH . $icon );

					$output = ob_get_clean();

				} else
				{ 
					$output = wp_get_attachment_image( $logo_id, 'logo', false, array( 
						'class' => 'brand'
					) );

				} // endif
			} // endif
		} // endif

		return $output;
	}
} // endif


if( ! function_exists( 'maxson_get_theme_brand_default_logo' ) )
{ 
	/** 
	 * Retrieve site default logo
	 * 
	 * @param       bool   $image_src encode logo
	 * @return      string
	 */

	function maxson_get_theme_brand_default_logo( $image_src = false )
	{ 
		return maxson_get_theme_brand_logo( 'default', $image_src );
	}
} // endif


if( ! function_exists( 'maxson_get_theme_brand_inverse_logo' ) )
{ 
	/** 
	 * Retrieve site inverse logo
	 * 
	 * @param       bool   $image_src encode logo
	 * @return      string
	 */

	function maxson_get_theme_brand_inverse_logo( $image_src = false )
	{ 
		return maxson_get_theme_brand_logo( 'inverse', $image_src );
	}
} // endif


if( ! function_exists( 'maxson_get_core_pages' ) )
{ 
	/** 
	 * Return important pages
	 * 
	 * @return      array
	 */

	function maxson_get_core_pages()
	{ 
		return apply_filters( 'maxson_theme_core_pages', array( 
			'about'   => __( 'About Page', 'maxson' ), 
			'blog'    => __( 'Blog Page', 'maxson' ), 
			'contact' => __( 'Contact Page', 'maxson' )
		) );
	}
} // endif


if( ! function_exists( 'maxson_get_core_page_id' ) )
{ 
	/** 
	 * Return page ID
	 * 
	 * @return      bool|int
	 */

	function maxson_get_core_page_id( $page = null )
	{ 
		$page_id = false;

		if( is_null( $page ) )
		{ 
			return $page_id;

		} // endif

		switch( strtolower( $page ) )
		{ 
			case 'home': 
				if( 'page' == get_option( 'show_on_front' ) )
				{ 
					$page_id = get_option( 'page_on_front' );

				} // endif
				break;

			case 'portfolio': 
			case 'portfolio_project': 
				if( function_exists( 'maxson_portfolio_get_archive_page_id' ) )
				{ 
					$page_id = maxson_portfolio_get_archive_page_id();

				} // endif
				break;

			case 'testimonials': 
				if( function_exists( 'maxson_testimonials_get_archive_page_id' ) )
				{ 
					$page_id = maxson_testimonials_get_archive_page_id();

				} // endif
				break;

			default: 
				$options = get_theme_mod( 'maxson_pages', array() );

				if( is_array( $options ) && array_key_exists( $page, $options ) )
				{ 
					if( ! empty( $options[ $page ] ) && 0 !== $options[ $page ] )
					{ 
						$page_id = absint( $options[ $page ] );

					} // endif
				} // endif
				break;

		} // endswitch

		return $page_id;
	}
} // endif


if( ! function_exists( 'maxson_is_core_page' ) )
{ 
	/** 
	 * Determine if is page
	 * 
	 * @return      bool|int
	 */

	function maxson_is_core_page( $page = null )
	{ 
		$page_id = maxson_get_core_page_id( $page );

		return ( ( false !== $page_id ) && is_page( $page_id ) ) ? true : false;
	}
} // endif


if( ! function_exists( 'maxson_get_header_style_options' ) )
{ 
	/** 
	 * Returns header style options
	 * 
	 * @return      string
	 */

	function maxson_get_header_style_options()
	{ 
		return apply_filters( 'maxson_theme_header_style_options', array( 
			'default' => _x( 'Default', 'Header style type', 'maxson' ), 
			'inverse' => _x( 'Inverse', 'Header style type', 'maxson' )
		) );
	}
} // endif


if( ! function_exists( 'maxson_get_header_style' ) )
{ 
	/** 
	 * Returns header style
	 * 
	 * @return      string
	 */

	function maxson_get_header_style( $default = 'default' )
	{ 
		$value   = get_theme_mod( 'maxson_header_style', $default );
		$options = maxson_get_header_style_options();

		if( empty( $value ) )
		{ 
			$value = $default;

		} // endif

		if( ! in_array( $value, array_keys( $options ) ) )
		{ 
			$value = key( $options );

		} // endif

		return strtolower( $value );
	}
} // endif


if( ! function_exists( 'maxson_get_header_style_class' ) )
{ 
	/** 
	 * Returns header class
	 * 
	 * @return      string
	 */

	function maxson_get_header_style_class( $style = 'default' )
	{ 
		if( empty( $style ) || is_null( $style ) )
		{ 
			$style = maxson_get_header_style();

		} // endif

		return "navbar-{$style}";
	}
} // endif


if( ! function_exists( 'maxson_get_header_position_options' ) )
{ 
	/** 
	 * Returns header position options
	 * 
	 * @return      string
	 */

	function maxson_get_header_position_options()
	{ 
		return apply_filters( 'maxson_theme_header_position_options', array( 
			'static'       => _x( 'Static on page',          'Header placement on page', 'maxson' ), 
			'fixed_top'    => _x( 'Fixed to top of page',    'Header placement on page', 'maxson' ), 
		//	'fixed_bottom' => _x( 'Fixed to bottom of page', 'Header placement on page', 'maxson' )
		) );
	}
} // endif


if( ! function_exists( 'maxson_get_header_position' ) )
{ 
	/** 
	 * Returns header position
	 * 
	 * @return      string
	 */

	function maxson_get_header_position( $default = 'static' )
	{ 
		$value   = get_theme_mod( 'maxson_header_position', $default );
		$options = maxson_get_header_position_options();

		if( empty( $value ) )
		{ 
			$value = $default;

		} // endif

		if( ! in_array( $value, array_keys( $options ) ) )
		{ 
			$value = $default;

		} // endif

		return strtolower( $value );
	}
} // endif


if( ! function_exists( 'maxson_get_header_position_class' ) )
{ 
	/** 
	 * Returns header class
	 * 
	 * @return      string
	 */

	function maxson_get_header_position_class( $position = 'static' )
	{ 
		if( empty( $position ) || is_null( $position ) )
		{ 
			$position = maxson_get_header_position();

		} // endif

		switch( $position )
		{ 
			case 'fixed_bottom': 
				$style = 'fixed-bottom';
				break;

			case 'fixed_top': 
				$style = 'fixed-top';
				break;

			case 'static': 
			default: 
				$style = 'static-top';
				break;

		} // endswitch

		return "navbar-{$style}";
	}
} // endif


if( ! function_exists( 'maxson_is_footer_fixed' ) )
{ 
	/** 
	 * Returns whether or not footer is trapdoor style
	 * 
	 * @return      bool
	 */

	function maxson_is_footer_fixed()
	{ 
		return get_theme_mod( 'maxson_footer_fixed', true );
	}
} // endif


if( ! function_exists( 'maxson_get_tracking_code' ) )
{ 
	/** 
	 * Returns Google Analytics tracking code
	 * 
	 * @return      string|bool
	 */

	function maxson_get_tracking_code()
	{ 
		$value = get_theme_mod( 'maxson_analytics', false );

		if( ! empty( $value ) && preg_match( '#UA-[\d-]+#', $value, $matches ) )
		{ 
			return $value;

		} // endif

		return false;
	}
} // endif


if( ! function_exists( 'maxson_get_skills' ) )
{ 
	/**
	 * Get available skills
	 * 
	 * @return      array
	 */

	function maxson_get_skills()
	{ 
		return apply_filters( 'maxson_skills', array( 
			'html_css'   => __( 'HTML5 & CSS3', 'maxson' ), 
		//	'html5'      => __( 'HTML5', 'maxson' ), 
		//	'css3'       => __( 'CSS3', 'maxson' ), 
			'wordpress'  => __( 'WordPress', 'maxson' ), 
			'javascript' => __( 'jQuery', 'maxson' ), 
			'react'      => __( 'React', 'maxson' ), 
			'angular'    => __( 'Angular', 'maxson' ), 
			'design'     => __( 'Design', 'maxson' )
		) );
	}
} // endif


if( ! is_admin() && ! function_exists( 'get_field' ) )
{ 
	/** 
	 * Basic fallback if ACF is not loaded
	 * 
	 * @return      bool|string
	 */

	function get_field( $key, $post_id = false, $format_value = true )
	{ 
		if( false === $post_id )
		{ 
			global $post;

			$post_id = $post->ID;

		} // endif

		$meta = false;

		if( is_tax() )
		{ 
			$meta = get_term_meta( $post_id, $key, true );

		} elseif( is_singular() || is_page() )
		{ 
			$meta = get_post_meta( $post_id, $key, true );

		} // endif

		return $meta;
	}
} // endif


if( ! function_exists( 'maxson_build_html_attributes' ) )
{ 
	/** 
	 * Convert array of values to string
	 * 
	 * @return      string
	 */

	function maxson_build_html_attributes( $attrs = array() )
	{ 
		if( empty( $attrs ) || ! is_array( $attrs ) )
		{ 
			return '';

		} // endif

		$attr_output = array();

		foreach( $attrs as $key => $value )
		{ 
			if( is_int( $key ) )
			{ 
				$attr_output[] = esc_attr( $value );

			} else
			{ 
				if( is_array( $value ) )
				{ 
					$value = join( ' ', $value );

				} // endif

				// Known attributes that can contain a URL
				$url_tags = array( 'action', 'cite', 'formaction', 'href', 'icon', 'manifest', 'poster', 'src' );

				$formattedValue = ( in_array( $key, $url_tags ) ) ? esc_url( $value ) : esc_attr( $value );

				$attr_output[] = sprintf( '%1$s="%2$s"', $key, $formattedValue );

			} // endif
		} // endforeach

		return join( ' ', $attr_output );
	}
} // endif


if( ! function_exists( 'maxson_build_html_open_tag' ) )
{ 
	/** 
	 * Construct HTML opening tag
	 * 
	 * @return      string
	 */

	function maxson_build_html_open_tag( $tagName, $attrs = array() )
	{ 
		$attr_string = maxson_build_html_attributes( $attrs );

		if( empty( $attr_string ) )
		{ 
			return "<{$tagName}>";

		} else
		{ 
			return "<{$tagName} {$attr_string}>";

		} // endif
	}
} // endif


if( ! function_exists( 'maxson_build_html_close_tag' ) )
{ 
	/** 
	 * Construct HTML closing tag
	 * 
	 * @return      string
	 */

	function maxson_build_html_close_tag( $tagName )
	{ 
		// Known single-entity/self-closing tags
		$single_tags = array( 'area', 'base', 'basefont', 'br', 'col', 'command', 'embed', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param', 'source' );

		if( in_array( $tagName, $single_tags ) )
		{ 
			return false;

		} // endif

		return "</{$tagName}>";
	}
} // endif


if( ! function_exists( 'maxson_build_html_output' ) )
{ 
	/** 
	 * Construct HTML tag with content
	 * 
	 * @return      string
	 */

	function maxson_build_html_output( $tagName, $content, $attrs = array() )
	{ 
		$output  = maxson_build_html_open_tag( $tagName, $attrs );
		$output .= $content;
		$output .= maxson_build_html_close_tag( $tagName );

		return $output;
	}
} // endif

?>