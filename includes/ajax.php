<?php 
/**
 * Theme AJAX
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! function_exists( 'maxson_ajax_get_header_style' ) )
{ 
	/**
	 * Return header style class
	 * 
	 * @return      array
	 */

	function maxson_ajax_get_header_style()
	{ 
		if( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'customizer-nonce' ) )
		{ 
			wp_send_json_success( array( 
				'class'   => maxson_get_header_style_class( $_POST['value'] ), 
				'message' => _x( 'Success!', 'AJAX success message', 'maxson' )
			) );

		} else
		{ 
			wp_send_json_error( array( 
				'message' => __( 'Oops! You do not have permission to do that action.', 'maxson' )
			) );

		} // endif
	}
} // endif
add_action( 'wp_ajax_get_header_style', 'maxson_ajax_get_header_style' );
add_action( 'wp_ajax_nopriv_get_header_style', 'maxson_ajax_get_header_style' );


if( ! function_exists( 'maxson_ajax_get_header_position' ) )
{ 
	/**
	 * Return header position class
	 * 
	 * @return      array
	 */

	function maxson_ajax_get_header_position()
	{ 
		if( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'customizer-nonce' ) )
		{ 
			wp_send_json_success( array( 
				'class'   => maxson_get_header_position_class( $_POST['value'] ), 
				'message' => _x( 'Success!', 'AJAX success message', 'maxson' )
			) );

		} else
		{ 
			wp_send_json_error( array( 
				'message' => __( 'Oops! You do not have permission to do that action.', 'maxson' )
			) );

		} // endif
	}
} // endif
add_action( 'wp_ajax_get_header_position', 'maxson_ajax_get_header_position' );
add_action( 'wp_ajax_nopriv_get_header_position', 'maxson_ajax_get_header_position' );

?>