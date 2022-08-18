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


if( ! function_exists( 'maxson_sanitize_customize_array_field' ) )
{ 
	/**
	 * Array sanitize callback
	 * 
	 * @param       String               $input   Slug to sanitize
	 * @param       WP_Customize_Setting $setting Setting instance
	 * @return      string Sanitized slug if it is a valid choice; otherwise, the setting default
	 */

	function maxson_sanitize_customize_array_field( $input, $setting )
	{ 
		// Get list of choices from the control associated with the setting
		$choices = $setting->manager->get_control( $setting->id )->choices;

		$values = ( ! is_array( $input ) ) ? explode( ',', $input ) : $input;

		if( ! empty( $values ) )
		{ 
			$values = array_map( 'trim', $values );

			$array_values = array_intersect( $values, array_keys( $choices ) );

			$array_values = array_map( 'sanitize_text_field', $array_values );

		} else
		{ 
			$array_values = array();

		} // endif

		return $array_values;
	}
} // endif


if( ! function_exists( 'maxson_sanitize_customize_dropdown_pages_field' ) )
{ 
	/**
	 * Dropdown pages sanitize callback
	 * 
	 * @param       String               $input   Slug to sanitize
	 * @param       WP_Customize_Setting $setting Setting instance
	 * @return      string Sanitized slug if it is a valid choice; otherwise, the setting default
	 */

	function maxson_sanitize_customize_dropdown_pages_field( $page_id, $setting )
	{ 
		// Ensure $input is an absolute integer.
		$page_id = absint( $page_id );
	
		// If $page_id is an ID of a published page, return it; otherwise, return the default.
		return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	} // endif
}


if( ! function_exists( 'maxson_sanitize_customize_image_field' ) )
{ 
	/**
	 * Image sanitize callback
	 * 
	 * @param       String               $input   Slug to sanitize
	 * @param       WP_Customize_Setting $setting Setting instance
	 * @return      string Sanitized slug if it is a valid choice; otherwise, the setting default
	 */

	function maxson_sanitize_customize_image_field( $image, $setting )
	{ 
		$mimes = array( 
			'bmp'          => 'image/bmp', 
			'gif'          => 'image/gif', 
			'ico'          => 'image/x-icon', 
			'jpg|jpeg|jpe' => 'image/jpeg', 
			'png'          => 'image/png', 
			'svg'          >= 'image/svg+xml', 
			'tif|tiff'     => 'image/tiff'
		);

		// Return an array with file extension and mime_type.
		$file = wp_check_filetype( $image, $mimes );

		// If $image has a valid mime_type, return it; otherwise, return the default.
		return ( $file['ext'] ? $image : $setting->default );
	}
} // endif


if( ! function_exists( 'maxson_sanitize_customize_range_field' ) )
{ 
	/**
	 * Range sanitize callback
	 * 
	 * @param       String               $input   Slug to sanitize
	 * @param       WP_Customize_Setting $setting Setting instance
	 * @return      string Sanitized slug if it is a valid choice; otherwise, the setting default
	 */

	function maxson_sanitize_customize_range_field( $input, $setting )
	{ 
		// Get list of attributes from the control associated with the setting
		$attrs = $setting->manager->get_control( $setting->id )->input_attrs;

		// Get minimum number in the range
		$min = ( isset( $attrs['min'] ) ? $attrs['min'] : $input );

		// Get maximum number in the range
		$max = ( isset( $attrs['max'] ) ? $attrs['max'] : $input );

		// Get step number in the range
		$step = ( isset( $attrs['step'] ) ? $attrs['step'] : 1 );

		$number = floor( $input / $attrs['step'] ) * $attrs['step'];

		return maxson_sanitize_in_range( $number, $min, $max );
	}
}


if( ! function_exists( 'maxson_sanitize_customize_select_field' ) )
{ 
	/**
	 * Select & Radio Button sanitize callback
	 * 
	 * @param       String               $input   Slug to sanitize
	 * @param       WP_Customize_Setting $setting Setting instance
	 * @return      string Sanitized slug if it is a valid choice; otherwise, the setting default
	 */

	function maxson_sanitize_customize_select_field( $input, $setting )
	{ 
		// Ensure input is a slug
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
} // endif

?>