<?php
/**
 * Theme Sanitize
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! function_exists( 'maxson_sanitize_in_range' ) )
{ 
	/**
	 * Only allow values between a certain minimum & maxmium range
	 * 
	 * @param  number	Input to be sanitized
	 * @return number	Sanitized input
	 */

	function maxson_sanitize_in_range( $input, $min = 1, $max = 100 )
	{ 
		if( $input < $min )
		{ 
			$input = $min;

		} // endif

		if( $input > $max )
		{ 
			$input = $max;

		} // endif

		return $input;
	}
} // endif


if( ! function_exists( 'maxson_sanitize_analytics_field' ) )
{ 
	/**
	 * Sanitize (Google) analytics for WordPress
	 */

	function maxson_sanitize_analytics_field( $input )
	{ 
		return preg_match( '/^ua-\d{4,9}-\d{1,4}$/i', strval( $input ) );
	}
} // endif


if( ! function_exists( 'maxson_sanitize_checkbox_field' ) )
{ 
	/**
	 * Sanitize checkbox for WordPress
	 */

	function maxson_sanitize_checkbox_field( $input )
	{ 
	//	return ( '1' == $input ) ? 1 : 0;
		return ( ( '1' == $input ) ? true : false );
	//	return ( 1 === absint( $input ) ) ? 1 : 0;
	}
} // endif


if( ! function_exists( 'maxson_sanitize_css_field' ) )
{ 
	/**
	 * Sanitize CSS for WordPress
	 */

	function maxson_sanitize_css_field( $input )
	{ 
		return wp_strip_all_tags( $input );
	}
} // endif


if( ! function_exists( 'maxson_sanitize_email_field' ) )
{ 
	/**
	 * Sanitize email for WordPress
	 */

	function maxson_sanitize_email_field( $input )
	{ 
		return sanitize_email( $input );
	}
} // endif


if( ! function_exists( 'maxson_sanitize_hexcolor_field' ) )
{ 
	/**
	 * Sanitize color for WordPress
	 */

	function maxson_sanitize_hexcolor_field( $input, $with_hash = true )
	{ 
		if( false === $with_hash )
		{ 
			return sanitize_hex_color_no_hash( $input );

		} // endif

		return sanitize_hex_color( $input );
	}
} // endif


if( ! function_exists( 'maxson_sanitize_html_field' ) )
{ 
	/**
	* Sanitize HTML for WordPress
	*/

	function maxson_sanitize_html_field( $input )
	{ 
		return wp_filter_post_kses( $input );
	}
} // endif


if( ! function_exists( 'maxson_sanitize_nohtml_field' ) )
{ 
	/**
	 * Sanitize no HTML for WordPress
	*/

	function maxson_sanitize_nohtml_field( $input )
	{ 
		return wp_filter_nohtml_kses( $input );
	}
} // endif


if( ! function_exists( 'maxson_sanitize_js_field' ) )
{ 
	/**
	 * Sanitize JavaScript for WordPress
	 */

	function maxson_sanitize_js_field( $input )
	{ 
		return base64_decode( $input );
	}
} // endif


if( ! function_exists( 'maxson_sanitize_multicheckbox_field' ) )
{ 
	/**
	 * Sanitize multiple checkboxes for WordPress
	 */

	function maxson_sanitize_multicheckbox_field( $input )
	{ 
		$multi_values = ( ! is_array( $input ) ) ? explode( ',', $input ) : $input;

		return ( ! empty( $multi_values ) ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
	}
} // endif


if( ! function_exists( 'maxson_sanitize_number_field' ) )
{ 
	/**
	* Sanitize number for WordPress
	*/

	function maxson_sanitize_number_field( $input )
	{ 
		return ( isset( $input ) && is_numeric( $input ) ) ? $input : false;
	}
} // endif


if( ! function_exists( 'maxson_sanitize_unfiltered_field' ) )
{ 
	/**
	 * DOES NOT SANITIZE ANYTHING
	 */

	function maxson_sanitize_unfiltered_field( $input )
	{ 
		return $input;
	}
} // endif


if( ! function_exists( 'maxson_sanitize_url_field' ) )
{ 
	/**
	 * Sanitize URL for WordPress
	*/

	function maxson_sanitize_url_field( $input )
	{ 
		return esc_url_raw( $input );
	}
} // endif

?>