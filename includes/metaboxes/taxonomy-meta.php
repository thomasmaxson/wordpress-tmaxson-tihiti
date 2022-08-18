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


if( ! function_exists( 'maxson_register_term_meta_boxes' ) )
{ 
	/**
	 * Register term meta boxes
	 * 
	 * @return      void
	 */

	function maxson_register_term_meta_boxes()
	{ 
		register_meta( 'term', '_tagline', array( 
			'type'         => 'string', 
			'default'      => '', 
			'single'       => true, 
			'show_in_rest' => true, 
			'description'  => __( 'Term tagline', 'maxson' ), 
			'sanitize_callback' => 'maxson_sanitize_html_field', 
			'auth_callback'     => '__return_true'
		) );
	}
} // endif
// add_action( 'init', 'maxson_register_term_meta_boxes', 5 );


if( ! function_exists( 'maxson_add_taxonomy_meta_boxes' ) )
{ 
	/**
	 * Add term meta boxes
	 * 
	 * @return      void
	 */

	function maxson_add_taxonomy_meta_boxes( $term )
	{ 
		$term_id = ( $term ) ? $term->term_id : 0;

		$name    = 'maxson_tagline';
		$tagline = get_term_meta( $term_id, '_tagline', true );

		$settings = array( 
			'media_buttons' => false, 
			'teeny'         => false, 
			'textarea_name' => 'maxson_tagline', 
			'editor_css'    => '<style>#wp-maxson_tagline-editor-container .wp-editor-area { height: 100px; width: 100%;}</style>' 
		);

		?><tr class="form-field">
			<th scope="row" valign="top">
				<label for="maxson_tagline"><?php _e( 'Tagline', 'maxson' ); ?></label></th>
			<td><?php wp_editor( $tagline, $name, $settings ); ?></td>
		</tr>

		<?php 
	}
} // endif
add_action( 'edit_category_form_fields', 'maxson_add_taxonomy_meta_boxes', 10 );
add_action( 'edit_tag_form_fields',      'maxson_add_taxonomy_meta_boxes', 10 );

// add_action( 'portfolio_category_edit_form_fields', 'maxson_add_taxonomy_meta_boxes', 10 );
// add_action( 'portfolio_tag_edit_form_fields',      'maxson_add_taxonomy_meta_boxes', 10 );
// add_action( 'portfolio_role_edit_form_fields',     'maxson_add_taxonomy_meta_boxes', 10 );
// add_action( 'portfolio_type_edit_form_fields',     'maxson_add_taxonomy_meta_boxes', 10 );


/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */


if( ! function_exists( 'maxson_save_taxonomy_meta_boxes' ) )
{ 
	/**
	 * Save term meta boxes
	 * 
	 * @param       int    $term_id 
	 * @param       object $tt_id
	 * @param       string $taxonomy
	 * @return      void
	 */

	function maxson_save_taxonomy_meta_boxes( $term_id, $tt_id = '', $taxonomy = '' )
	{ 
		if( ! current_user_can( 'edit_term', $post_id ) )
		{ 
			return $term_id;

		} // endif

		if( isset( $_POST['maxson_tagline'] ) && '' !== $_POST['maxson_tagline'] )
		{ 
			$tagline = $_POST['maxson_tagline'];

			update_term_meta( $term_id, '_tagline', trim( $tagline ) );

		} else
		{ 
			delete_term_meta( $term_id, '_tagline' );

		} // endif
	}
} // endif
add_action( 'edit_term', 'maxson_save_taxonomy_meta_boxes', 10, 3 );

?>