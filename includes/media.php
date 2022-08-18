<?php
/** 
 * Theme specific media functions
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) )
{ 
	die;

} // endif

// Teaser
// XS = 450w x 9999h
// SM = 355w x 9999h
// MD = 300w x 9999h
// LG = 370w x 9999h

// Gallery
// XS = 375w x 9999h
// SM = 750w x 9999h
// MD = 970w x 9999h
// LG = 1170w x 9999h



if( ! function_exists( 'maxson_theme_get_media_options_data' ) )
{ 
	/**
	 * 
	 * 
	 * @return      array
	 */

	function maxson_theme_get_media_options_data()
	{ 
		return array( 
			array( 
				'title' => _x( 'Project teaser image sizes', 'Media setting group title', 'maxson' ), 
				'desc'  => false, 
				'sizes' => array( 
					array( 
						'label' => _x( 'Thumbnail size', 'Media setting label', 'maxson' ), 
						'size'  => 'project_teaser_th', 
						'crop'  => true

					), array( 
						'label' => _x( 'Small size', 'Media setting label', 'maxson' ), 
						'size'  => 'project_teaser_sm', 
						'crop'  => false

					), array( 
						'label' => _x( 'Medium size', 'Media setting label', 'maxson' ), 
						'size'  => 'project_teaser_md', 
						'crop'  => false

					), array( 
						'label' => _x( 'Large size', 'Media setting label', 'maxson' ), 
						'size'  => 'project_teaser_lg', 
						'crop'  => false

					)
				)
			), 
			array( 
				'title' => _x( 'Project gallery image sizes', 'Media setting group title', 'maxson' ), 
				'desc'  => false, 
				'sizes' => array( 
					array( 
						'label' => _x( 'Thumbnail size', 'Media setting label', 'maxson' ), 
						'size'  => 'project_gallery_th', 
						'crop'  => true

					), array( 
						'label' => _x( 'Small size', 'Media setting label', 'maxson' ), 
						'size'  => 'project_gallery_sm', 
						'crop'  => false

					), array( 
						'label' => _x( 'Medium size', 'Media setting label', 'maxson' ), 
						'size'  => 'project_gallery_md', 
						'crop'  => false

					), array( 
						'label' => _x( 'Large size', 'Media setting label', 'maxson' ), 
						'size'  => 'project_gallery_lg', 
						'crop'  => false
					)
				)
			)
		);
	}
} // endif


if( ! function_exists( 'maxson_theme_set_media_image_sizes' ) )
{ 
	/**
	 * 
	 * 
	 * @return      null
	 */

	function maxson_theme_set_media_image_sizes()
	{ 
		$items = maxson_theme_get_media_options_data();

		foreach( $items as $item )
		{ 
			foreach( $item['sizes'] as $i => $size )
			{ 
				$_size = $size['size'];

				$value_w = get_option( "maxson_media_{$_size}_size_w" );
				$value_h = get_option( "maxson_media_{$_size}_size_h" );
				$value_c = get_option( "maxson_media_{$_size}_size_c" );

				add_image_size( $_size, $value_w, $value_h, $value_c );

			} // endforeach
		} // endforeach
	}
} // endif
add_action( 'after_setup_theme', 'maxson_theme_set_media_image_sizes', 10 );


if( ! function_exists( 'maxson_theme_register_media_option' ) )
{ 
	/**
	 * 
	 * 
	 * @return      null
	 */

	function maxson_theme_register_media_option()
	{ 
		$tab   = 'media';
		$items = maxson_theme_get_media_options_data();

		foreach( $items as $item )
		{ 
			$section = sanitize_title_with_dashes( $item['title'] );
			$section = str_replace( '-', '_', $section );

			add_settings_section( "maxson_theme_{$tab}_{$section}", 
				$item['title'], $item['desc'], $tab );

			foreach( $item['sizes'] as $i => $size )
			{ 
				$_label = $size['label'];
				$_size  = $size['size'];
				$_crop  = $size['crop'];

				register_setting( $tab, "maxson_media_{$_size}_size_w" );
				register_setting( $tab, "maxson_media_{$_size}_size_h" );
				register_setting( $tab, "maxson_media_{$_size}_size_c" );

				add_settings_field( "maxson_theme_setting_{$tab}_{$_size}_image", $_label, 
					'maxson_theme_edit_media_option', $tab, "maxson_theme_{$tab}_{$section}", array( 
						'label' => $size['label'], 
						'size'  => $_size, 
						'crop'  => $_crop
					)
				);

			} // endforeach
		} // endforeach
	}
} // endif
add_action( 'admin_init', 'maxson_theme_register_media_option' );


if( ! function_exists( 'maxson_theme_edit_media_option' ) )
{ 
	/**
	 * 
	 * 
	 * @return      null
	 */

	function maxson_theme_edit_media_option( $args )
	{ 
		extract( $args );

		$label_w = __( 'Max Width', 'maxson' );
		$label_h = __( 'Max Height', 'maxson' );

		$name_w = "maxson_media_{$size}_size_w";
		$name_h = "maxson_media_{$size}_size_h";
		$name_c = "maxson_media_{$size}_size_c";

		$value = array( 
			'width'  => get_option( $name_w ), 
			'height' => get_option( $name_h ), 
			'crop'   => get_option( $name_c )
		);

		$value_w = ( isset( $value['width'] ) )  ? $value['width']  : false;
		$value_h = ( isset( $value['height'] ) ) ? $value['height'] : false;

		echo '<fieldset>';
		printf( '<legend class="screen-reader-text"><span>%1$s</span></legend>', $label );

		printf( '<label for="%1$s">%2$s</label>', esc_attr( $name_w ), $label_w );
		printf( '<input type="number" name="%1$s" id="%1$s" class="small-text" value="%2$s" step="1" min="0">', esc_attr( $name_w ), esc_attr( $value_w ) );

		echo '<br>';

		printf( '<label for="%1$s">%2$s</label>', esc_attr( $name_h ), $label_h );
		printf( '<input type="number" name="%1$s" id="%1$s" class="small-text" value="%2$s" step="1" min="0">', esc_attr( $name_h ), esc_attr( $value_h ) );

		echo '</fieldset>';

		if( $crop )
		{ 
			$value_c = ( isset( $value['crop'] ) ) ? $value['crop'] : false;

			$is_checked = checked( 1, $value_c, false );

			printf( '<input type="checkbox" name="%1$s" id="%1$s" value="1"%2$s>', esc_attr( $name_c ), $is_checked );
			printf( '<label for="%1$s">%2$s</label>', esc_attr( $name_c ), __( 'Crop image to exact dimensions (normally images are proportional)', 'maxson' ) );

		} // endif

	}
} // endif


if( ! function_exists( 'maxson_the_post_picture' ) )
{ 
	/**
	 * Global alternative to the_post_thumbnail()
	 * 
	 * @param       string $default_image_size
	 * @param       array  $sizes
	 * @param       int    $post_id
	 * @return      null
	 */

	function maxson_the_post_picture( $default_image_size = 'thumbnail', $sizes = false, $post_id = '', $pic_attrs = array(), $img_attrs = array() )
	{ 
		echo maxson_get_the_post_picture( $default_image_size, $sizes, $post_id, $pic_attrs, $img_attrs );
	}
} // endif


if( ! function_exists( 'maxson_get_the_post_picture' ) )
{ 
	/**
	 * Global alternative to get_the_post_thumbnail
	 * 
	 * @param      string $default_image_size
	 * @param      array  $sizes
	 * @param      int    $post_id
	 * @param      array  $attr
	 * @return     string
	 */

	function maxson_get_the_post_picture( $default_image_size = 'thumbnail', $sizes = false, $post_id = '', $pic_attrs = array(), $img_attrs = array() )
	{ 
		if( $post_id == '' )
		{ 
			global $post;

			$post_id = $post->ID;

		} // endif

		return Maxson_Picture_Element::get_post_picture_element( $default_image_size, $sizes, $post_id, $pic_attrs, $img_attrs );
	}
} // endif


if( ! function_exists( 'maxson_get_the_attachment_picture' ) )
{ 
	/**
	 * Global alternative to wp_get_attachment_image
	 * 
	 * @param      string $default_image_size
	 * @param      array  $sizes
	 * @param      int    $attachment_id
	 * @param      array  $attr
	 * @return     string on success, false on failure
	 */

	function maxson_get_the_attachment_picture( $default_image_size = 'thumbnail', $sizes = false, $attachment_id = '', $pic_attrs = array(), $img_attrs = array() )
	{ 
		return Maxson_Picture_Element::get_picture_element( $default_image_size, $sizes, $attachment_id, $pic_attrs, $img_attrs );

	}
} // endif

?>