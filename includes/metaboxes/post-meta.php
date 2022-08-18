<?php 
/**
 * Theme Meta Boxes
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! function_exists( 'maxson_register_post_meta_boxes' ) )
{ 
	/**
	 * Register post meta boxes
	 * 
	 * @return      void
	 */

	function maxson_register_post_meta_boxes()
	{ 
		register_meta( 'post', '_tagline', array( 
			'type'         => 'string', 
			'default'      => '', 
			'single'       => true, 
			'show_in_rest' => true, 
			'description'  => __( 'Post tagline', 'maxson' ), 
			'sanitize_callback' => 'maxson_sanitize_html_field', 
			'auth_callback'     => '__return_true'
		) );
	}
} // endif
// add_action( 'init', 'maxson_register_post_meta_boxes', 5 );


if( ! function_exists( 'maxson_add_post_meta_boxes' ) )
{ 
	/**
	 * Add post meta boxes
	 * 
	 * @return      void
	 */

	function maxson_add_post_meta_boxes( $post_type, $post )
	{ 
		if( in_array( $post_type, array( 'post', 'page', 'portfolio_project' ) ) )
		{ 
			add_meta_box( 'meta_box_tagline', __( 'Tagline', 'maxson' ), 'maxson_tagline_post_meta_box', $post_type, 'normal' );

		} // endif
	}
} // endif
add_action( 'add_meta_boxes', 'maxson_add_post_meta_boxes', 11, 2 );


if( ! function_exists( 'maxson_tagline_post_meta_box' ) )
{ 
	/**
	 * Output tagline meta box field
	 * 
	 * @return      void
	 */

	function maxson_tagline_post_meta_box( $post )
	{ 
		$post_id = ( $post ) ? $post->ID : 0;

		$name    = 'maxson_tagline';
		$tagline = get_post_meta( $post_id, '_tagline', true );

		$settings = array( 
			'media_buttons' => false, 
			'teeny'         => false, 
			'textarea_name' => 'maxson_tagline', 
			'editor_css'    => '<style>#wp-maxson_tagline-editor-container .wp-editor-area { height: 100px; width: 100%;}</style>'
		);

		?><table class="form-table"><tbody>
			<tr valign="top">
				<th scope="row" valign="top" class="hidden">
					<label for="maxson_tagline" class="sr-only"><?php _e( 'Tagline', 'maxson' ); ?></label></th>
				<td><?php wp_editor( $tagline, $name, $settings ); ?></td>
			</tr>
		</tbody></table>

		<?php wp_nonce_field( basename( __FILE__ ), 'maxson_post_meta_tagline_nonce' );
	}
}


/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */


if( ! function_exists( 'maxson_save_post_meta_box' ) )
{ 
	/**
	 * Save post meta boxes
	 * 
	 * @param       int    $post_id The ID of the post
	 * @param       object $post    Containing the current post (as a $post object)
	 * @return      void
	 */

	function maxson_save_post_meta_box( $post_id, $post )
	{ 
		if( wp_is_post_autosave( $post_id ) || defined( 'DOING_AJAX' ) && DOING_AJAX )
		{ 
			return $post_id;

		} // endif

		if( isset( $_GET['post_type'] ) && 'page' == $_GET['post_type'] )
		{ 
			if ( ! current_user_can( 'edit_page', $post_id ) )
			{ 
				return $post_id;

			} // endif
		} else
		{ 
			if( ! current_user_can( 'edit_post', $post_id ) )
			{ 
				return $post_id;

			} // endif
		} // endif


		if( isset( $_POST['maxson_post_meta_tagline_nonce'] ) )
		{ 
			if( ! wp_verify_nonce( $_POST['maxson_post_meta_tagline_nonce'], basename( __FILE__ ) ) )
			{ 
				return;

			} // endif

			if( isset( $_POST['maxson_tagline'] ) )
			{ 
				update_post_meta( $post_id, '_tagline', trim( $_POST['maxson_tagline'] ) );

			} else
			{ 
				delete_post_meta( $post_id, '_tagline' );

			} // endif
		} // endif
	}
} // endif
add_action( 'save_post', 'maxson_save_post_meta_box', 10, 2 );

?>