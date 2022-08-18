<?php
/** 
 * Theme Customize, Content Option Fields
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) )
{ 
	die;

} // endif

if( ! function_exists( 'maxson_customize_register_posts' ) )
{ 
	/**
	 * Contains methods for customizing the theme customization screen
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_customize_register_posts( $wp_customize )
	{ 
		$panel   = 'maxson_content';
		$section = 'posts';

		// Ensure theme supports content options
	//	if( ! current_theme_supports( 'maxson-content-options' ) )
	//	{ 
	//		return false;

	//	} // endif


		$option = get_theme_support( 'maxson-content-options' );
	//	$option  = $support[0];

		// Supports
		$excerpt_type = ( ! empty( $option['excerpt_type'] ) ) ? $option['excerpt_type'] : null;
		$author_bio   = ( ! empty( $option['author_bio'] ) )   ? $option['author_bio']   : null;

		// Details, Post
		$post_details = ( ! empty( $option['post_details'] ) ) ? $option['post_details'] : null;

		// Details, Project
		$project_details = ( ! empty( $option['project_details'] ) ) ? $option['project_details'] : null;

		// Thumbnails
		$feat_images  = ( ! empty( $option['featured_images'] ) ) ? $option['featured_images'] : null;
			$fi_archive   = ( ! empty( $feat_images['archive'] ) )   ? $feat_images['archive']   : null;
			$fi_post      = ( ! empty( $feat_images['post'] ) )      ? $feat_images['post']      : null;
			$fi_page      = ( ! empty( $feat_images['page'] ) )      ? $feat_images['page']      : null;
			$fi_portfolio = ( ! empty( $feat_images['portfolio'] ) ) ? $feat_images['portfolio'] : null;


		$wp_customize->add_section( "{$panel}_{$section}", array( 
			'title' => _x( 'Content Options', 'Customizer section title', 'maxson' )
		) );


		/**
		 * Excerpt
		 */

		$excerpt_type_choices = array( 
			'content' => __( 'Full post', 'maxson' ), 
			'excerpt' => __( 'Post excerpt', 'maxson' )
		);

		if( array_key_exists( $excerpt_type, $excerpt_type_choices ) )
		{ 
			$wp_customize->add_setting( 'maxson_excerpt_type', array( 
				'transport' => 'refresh', 
				'type'      => 'option', 
				'default'   => 'excerpt', 
				'sanitize_callback' => 'maxson_sanitize_customize_select_field'
			) );

			$wp_customize->add_control( 'maxson_excerpt_type', array( 
				'section' => "{$panel}_{$section}", 
				'type'    => 'radio', 
				'label'   => _x( 'Post length on archives', 'Customizer control label', 'maxson' ), 
				'choices' => $excerpt_type_choices, 
				'description' => esc_html__( 'Choose between a full post or an excerpt for the blog and archive pages.', 'maxson' )
			) );


			$wp_customize->add_setting( 'maxson_excerpt_length', array( 
				'transport' => 'refresh', 
				'type'      => 'option', 
				'default'   => 55, 
				'sanitize_callback' => 'maxson_sanitize_number_field'
			) );

			$wp_customize->add_control( 'maxson_excerpt_length', array( 
				'section' => "{$panel}_{$section}", 
				'type'    => 'number', 
				'label'   => _x( 'Excerpt Length', 'Customizer control label', 'maxson' ), 
				'description' => esc_html__( 'Maximum number of words to display.', 'maxson' ), 
				'active_callback' => 'maxson_customize_callback_excerpt_type'
			) );


			$wp_customize->add_setting( 'maxson_excerpt_more', array( 
				'transport' => 'refresh', 
				'type'      => 'option', 
				'default'   => '[...]', 
				'sanitize_callback' => 'sanitize_text_field'
			) );

			$wp_customize->add_control( 'maxson_excerpt_more', array( 
				'section' => "{$panel}_{$section}", 
				'type'    => 'text', 
				'label'   => _x( 'Excerpt More Text', 'Customizer control label', 'maxson' )
			) );

		} // endif


		/**
		 * Post Details
		 */

		if( ! is_null( $post_details ) )
		{ 
			if( class_exists( 'Maxson_Customize_Arbitrary_Control' ) )
			{ 
				$wp_customize->add_setting( 'maxson_content_post_details_headline' );

				$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_content_post_details_headline', array( 
					'section' => "{$panel}_{$section}", 
					'type'    => 'headline', 
					'label'   => _x( 'Post Details', 'Customizer control label', 'maxson' )
				) ) );

			} // endif

			if( class_exists( 'Maxson_Customize_Arbitrary_Control' ) )
			{ 
				$wp_customize->add_setting( 'maxson_content_post_details_message_go_to_singular', array() );

				$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_content_post_details_message_go_to_singular', array( 
					'section'     => "{$panel}_{$section}", 
					'type'        => 'description', 
					'description' => esc_html__( 'Please visit a post view to reveal the customization options.', 'maxson' ), 
					'active_callback' => 'maxson_customize_callback_is_not_singular'
				) ) );

			} // endif

			foreach( $post_details as $key => $css_classes )
			{ 
				if( $key == 'stylesheet' )
				{ 
					continue;

				} // endif

				$wp_customize->add_setting( "maxson_layout_post_details[{$key}]", array( 
					'transport' => 'postMessage', 
					'default'   => true, 
					'type'      => 'option', 
					'sanitize_callback' => 'maxson_sanitize_checkbox_field'
				) );

				$wp_customize->add_control( "maxson_customizer_post_details_{$key}", array( 
					'section' => "{$panel}_{$section}", 
					'settings' => "maxson_layout_post_details[{$key}]", 
					'type'    => 'checkbox', 
					'label'   => sprintf( _x( 'Display post %1$s', 'Customizer control label', 'maxson' ), $key ), 
					'active_callback' => 'maxson_customize_callback_is_singular'
				) );

			} // endforeach
		} // endif


		/**
		 * Project Details
		 */

		if( post_type_exists( 'portfolio_project' )
			&& ! empty( $project_details ) )
		{ 
			if( class_exists( 'Maxson_Customize_Arbitrary_Control' ) )
			{ 
				$wp_customize->add_setting( 'maxson_content_project_details_headline' );

				$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_content_project_details_headline', array( 
					'section' => "{$panel}_{$section}", 
					'type'    => 'headline', 
					'label'   => _x( 'Project Details', 'Customizer control label', 'maxson' )
				) ) );

			} // endif


			if( class_exists( 'Maxson_Customize_Arbitrary_Control' ) )
			{ 
				$wp_customize->add_setting( 'maxson_content_project_details_message_go_to_singular', array() );

				$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_content_project_details_message_go_to_singular', array( 
					'section'     => "{$panel}_{$section}", 
					'type'        => 'description', 
					'description' => esc_html__( 'Please visit a project page to reveal the customization options.', 'maxson' ), 
					'active_callback' => 'maxson_customize_callback_is_not_project'
				) ) );

			} // endif


			foreach( $project_details as $key => $css_classes )
			{ 
				if( $key == 'stylesheet' )
				{ 
					continue;

				} // endif

				$wp_customize->add_setting( "maxson_layout_project_details[{$key}]", array( 
					'transport' => 'postMessage', 
					'default'   => true, 
					'type'      => 'option', 
					'sanitize_callback' => 'maxson_sanitize_checkbox_field'
				) );

				$wp_customize->add_control( "maxson_customizer_project_details_{$key}", array( 
					'section' => "{$panel}_{$section}", 
					'settings' => "maxson_layout_project_details[{$key}]", 
					'type'    => 'checkbox', 
					'label'   => sprintf( _x( 'Display project %1$s', 'Customizer control label', 'maxson' ), $key ), 
					'active_callback' => 'maxson_customize_callback_is_project'
				) );

			} // endforeach
		} // endif


		/**
		 * Author Bio
		 */

		if( true === $author_bio )
		{ 
			if( class_exists( 'Maxson_Customize_Arbitrary_Control' ) )
			{ 
				$wp_customize->add_setting( 'maxson_content_author_bio_headline' );

				$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_content_author_bio_headline', array( 
					'section' => "{$panel}_{$section}", 
					'type'    => 'headline', 
					'label'   => _x( 'Author Bio', 'Customizer control label', 'maxson' )
				) ) );

			} // endif

			$wp_customize->add_setting( 'maxson_content_author_bio', array( 
			//	'capability' => 'edit_theme_options', 
				'transport'  => 'refresh', 
				'type'       => 'option', 
				'sanitize_callback' => 'maxson_sanitize_checkbox_field'
			) );

			$wp_customize->add_control( 'maxson_content_author_bio', array( 
				'section' => "{$panel}_{$section}", 
				'type'    => 'checkbox', 
				'label'   => _x( 'Display on single posts', 'Customizer control label', 'maxson' )
			) );

		} // endif


		/**
		 * Featured Image (Thumbnail)
		 */

		if( true === $fi_archive || 
			true === $fi_post || 
			true === $fi_page || 
			true === $fi_portfolio
		)
		{ 
			if( class_exists( 'Maxson_Customize_Arbitrary_Control' ) )
			{ 
				$wp_customize->add_setting( 'maxson_content_featured_images_headline' );

				$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_content_featured_images_headline', array( 
					'section' => "{$panel}_{$section}", 
					'type'    => 'headline', 
					'label'   => esc_html__( 'Featured Images', 'maxson' ) . sprintf( '<a href="https://en.support.wordpress.com/featured-images/" class="customize-help-toggle dashicons dashicons-editor-help" title="%1$s" target="_blank"><span class="screen-reader-text">%1$s</span></a>', esc_html__( 'Learn more about Featured Images', 'maxson' ) ),
					'active_callback' => 'maxson_customize_callback_supports_thumbnails'
				) ) );

			} // endif


			// Featured Images: Archive
			if( true === $fi_archive )
			{ 
				$wp_customize->add_setting( 'maxson_content_featured_images_archive', array( 
					'transport' => 'refresh', 
					'type'      => 'option', 
					'sanitize_callback' => 'maxson_sanitize_checkbox_field'
				) );

				$wp_customize->add_control( 'maxson_content_featured_images_archive', array( 
					'section' => "{$panel}_{$section}", 
					'type'    => 'checkbox', 
					'label'   => _x( 'Display on blog and archives', 'Customizer control label', 'maxson' ),
					'active_callback' => 'maxson_customize_callback_supports_thumbnails'
				) );

			} // endif

			// Featured Images: Post
			if( true === $fi_post )
			{ 
				$wp_customize->add_setting( 'maxson_content_featured_images_post', array(
					'transport' => 'refresh', 
					'type'      => 'option', 
					'sanitize_callback' => 'maxson_sanitize_checkbox_field'
				) );

				$wp_customize->add_control( 'maxson_content_featured_images_post', array(
					'section' => "{$panel}_{$section}", 
					'type'    => 'checkbox',
					'label'   => _x( 'Display on single posts', 'Customizer control label', 'maxson' ),
					'active_callback' => 'maxson_customize_callback_supports_thumbnails'
				) );

			} // endif

			// Featured Images: Page
			if( true === $fi_page )
			{ 
				$wp_customize->add_setting( 'maxson_content_featured_images_page', array( 
					'transport' => 'refresh', 
					'type'      => 'option', 
					'sanitize_callback' => 'maxson_sanitize_checkbox_field'
				) );

				$wp_customize->add_control( 'maxson_content_featured_images_page', array( 
					'section' => "{$panel}_{$section}", 
					'type'    => 'checkbox', 
					'label'   => _x( 'Display on pages', 'Customizer control label', 'maxson' ), 
					'active_callback' => 'maxson_customize_callback_supports_thumbnails'
				) );

			} // endif
			
			// Featured Images: Portfolio
			if( true === $fi_portfolio && post_type_exists( 'portfolio_project' ) )
			{ 
				$wp_customize->add_setting( 'maxson_content_featured_images_portfolio', array( 
					'transport' => 'refresh', 
					'type'      => 'option', 
					'sanitize_callback' => 'maxson_sanitize_checkbox_field'
				) );

				$wp_customize->add_control( 'maxson_content_featured_images_portfolio', array( 
					'section' => "{$panel}_{$section}", 
					'type'    => 'checkbox', 
					'label'   => _x( 'Display on portfolio projects', 'Customizer control label', 'maxson' ), 
					'active_callback' => 'maxson_customize_callback_supports_thumbnails'
				) );

			} // endif
		} // endif
	}
} // endif
add_action( 'customize_register', 'maxson_customize_register_posts' );


if( ! function_exists( 'maxson_customize_callback_excerpt_type' ) )
{ 
	/**
	 * Adds a callback function to retrieve if post content is set to excerpt or not
	 * 
	 * @param       object $control / Instance of the Customizer Control
	 * @return      bool
	 */

	function maxson_customize_callback_excerpt_type( $control )
	{ 
		$value = $control->manager->get_setting( 'maxson_excerpt_type' )->value();

		return ( 'excerpt' === $value ) ? true : false;
	}
} // endif


if( ! function_exists( 'maxson_customize_callback_supports_thumbnails' ) )
{ 
	/**
	 * Return whether the theme supports post thumbnails
	 * 
	 * @param       object $control / Instance of the Customizer Control
	 * @return      bool
	 */

	function maxson_customize_callback_supports_thumbnails( $control )
	{ 
		return ( current_theme_supports( 'post-thumbnails' ) );
	}
} // endif


if( ! function_exists( 'maxson_customize_callback_is_singular' ) )
{ 
	/**
	 * Return whether the current page is a singular, and not a project
	 * 
	 * @return      string|bool
	 */

	function maxson_customize_callback_is_singular()
	{ 
		if( function_exists( 'is_project' ) )
		{ 
			return ( ! is_project() && is_singular() );

		} else
		{ 
			return is_singular();

		} // endif
	}
} // endif


if( ! function_exists( 'maxson_customize_callback_is_not_singular' ) )
{ 
	/**
	 * Return whether the current page is not a singular
	 * 
	 * @return      string|bool
	 */

	function maxson_customize_callback_is_not_singular()
	{ 
		if( function_exists( 'is_project' ) )
		{ 
			return ( is_project() || ! is_singular() );

		} else
		{ 
			return ! is_singular();

		} // endif
	}
} // endif


if( ! function_exists( 'maxson_customize_callback_is_project' ) )
{ 
	/**
	 * Return whether the current page is a project
	 * 
	 * @return      string|bool
	 */

	function maxson_customize_callback_is_project()
	{ 
		return ( function_exists( 'is_project' ) ) ? is_project() : false;
	}
} // endif


if( ! function_exists( 'maxson_customize_callback_is_not_project' ) )
{ 
	/**
	 * Return whether the current page is not a project
	 * 
	 * @return      string|bool
	 */

	function maxson_customize_callback_is_not_project()
	{ 
		return ( function_exists( 'is_project' ) ) ? ( ! is_project() ) : false;
	}
} // endif

?>