<?php
/**
 * Add functions for using the <picture> element for WP featured images
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if ( ! class_exists( 'Maxson_Picture_Element' ) )
{ 
	// https://github.com/ethanclevenger91/Picture-Element-Thumbnails

	class Maxson_Picture_Element { 

		/**
		 * Grab the image's alt text meta
		 * 
		 * @param       int $attachment_id
		 * @return      string
		 */

		public static function get_img_alt( $attachment_id )
		{ 
			$img_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

			return trim( strip_tags( $img_alt ) );
		}


		/**
		 * Get the actual src tag markup
		 * 
		 * @param       int   $attachment_id
		 * @param       array $sizes
		 * @return      string
		 */

		public static function get_picture_srcs( $attachment_id, $sizes )
		{ 
			global $_wp_additional_image_sizes;

			$srcSizes = array();

			// Create the full array with sizes and crop info
			foreach( $sizes as $meta )
			{ 
				$_size       = $meta['size'];
				$_breakpoint = $meta['breakpoint'];

				// if it's a default image size
				if( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) )
				{ 
					$srcSizes[] = array( 
						'breakpoint' => $_breakpoint, 
						'size'       => $_size, 
						'width'      => get_option( "{$_size}_size_w" ), 
						'height'     => get_option( "{$_size}_size_h" ), 
						'crop'       => (bool) get_option( "{$_size}_crop" )
					);

				} elseif( isset( $_wp_additional_image_sizes[ $_size ] ) )
				{ 
					$srcSizes[] = array( 
						'breakpoint' => $_breakpoint, 
						'size'       => $_size, 
						'width'      => $_wp_additional_image_sizes[ $_size ][ 'width' ], 
						'height'     => $_wp_additional_image_sizes[ $_size ][ 'height' ], 
						'crop'       => $_wp_additional_image_sizes[ $_size ][ 'crop' ]
					);

				} elseif( $_size == 'full' )
				{ 
					$srcSizes[] = array( 
						'breakpoint' => $_breakpoint, 
						'size'       => $_size, 
						'width'      => 'auto', 
						'height'     => 'auto', 
						'crop'       => false
					);

				} // endif
			} // endforeach

			$output = array();

			foreach( $srcSizes as $details )
			{ 
				$image_src = wp_get_attachment_image_src( $attachment_id, $details['size'] );

			//	$output[] = sprintf( '<source srcset="%1$s" media="%2$s">', esc_attr( $image_src[0] ), esc_attr( $details['breakpoint'] ) );

				$output[] = maxson_build_html_output( 'source', '', array( 
					'srcset' => $image_src[0], 
					'media'  => $details['breakpoint']
				) );

			} // endforeach

			return join( array_reverse( $output ) );
		}


		/**
		 * Get the picture element for post thumbnails
		 * 
		 * @param       string $default_image_size
		 * @param       array  $sizes
		 * @param       int    $post_id
		 * @param       array  $pic_attrs
		 * @param       array  $img_attrs
		 * @return      string
		 */

		public static function get_post_picture_element( $default_image_size = 'thumbnail', $sizes = false, $post_id, $pic_attrs = array(), $img_attrs = array() )
		{
			if( ! has_post_thumbnail( $post_id ) )
			{ 
				return '';

			} // endif

			$attachment_id = get_post_thumbnail_id( $post_id );

			return self::get_picture_element( $default_image_size, $sizes, $attachment_id, $pic_attrs, $img_attrs );
		}


		/**
		 * 
		 * 
		 * @param       string $default_image_size
		 * @param       array  $sizes
		 * @param       int    $post_id
		 * @param       array  $pic_attrs
		 * @param       array  $img_attrs
		 * @return      string
		 */

		public static function get_picture_element( $default_image_size = 'thumbnail', $sizes = false, $attachment_id, $pic_attrs = array(), $img_attrs = array() )
		{ 
			if( ! $sizes || ! is_array( $sizes ) )
			{ 
				return wp_get_attachment_image( $attachment_id, $default_image_size, false, $pic_attrs );

			} else
			{ 
				$fallback = wp_get_attachment_image( $attachment_id, $default_image_size, false, $img_attrs );

				// Remove default dimensions
				$fallback = preg_replace( array( '/width="[^"]*"/', '/height="[^"]*"/' ), '', $fallback );
				$fallback = preg_replace( array( '/srcset="[^"]*"/', '/sizes="[^"]*"/' ), '', $fallback );

				$content  = '<!--[if IE 9]><video style="display: none;"><![endif]-->';
				$content .= self::get_picture_srcs( $attachment_id, $sizes );
				$content .= '<!--[if IE 9]></video><![endif]-->';
				$content .= $fallback;

				$picture = maxson_build_html_output( 'picture', $content, $pic_attrs );

				return $picture;

			} // endif
		}

	} // endclass
} // endif

$maxsonPictureElement = new Maxson_Picture_Element();

?>