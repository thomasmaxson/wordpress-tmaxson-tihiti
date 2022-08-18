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


// https://premium.wpmudev.org/forums/topic/advanced-color-manipulation-using-the-customizer

if( ! function_exists( 'maxson_enqueue_customize_styles_scripts' ) )
{ 
	/**
	 * Bind JS handlers to instantly live-preview changes
	 * 
	 * @return      void
	 */

	function maxson_enqueue_customize_styles_scripts()
	{ 
		$theme = ( function_exists( 'wp_get_theme' ) ) ? wp_get_theme() : get_current_theme();
			$version = $theme->get( 'Version' );

		wp_register_style( 'maxson-customizer-preview', get_theme_file_uri( '/assets/css/admin/customizer-preview.css' ), array( 'customize-preview' ), $version );

		wp_enqueue_style( 'maxson-customizer-preview' );


		wp_register_script( 'maxson-customizer-preview', get_theme_file_uri( '/assets/js/admin/customizer-preview.js' ), array( 'customize-preview' ), $version, true );

		wp_enqueue_script( 'maxson-customizer-preview' );

		$args = array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ), 
			'nonce'   => wp_create_nonce( 'customizer-nonce' )
		);

		wp_localize_script( 'maxson-customizer-preview', 'maxson_customizer', $args );


		if( current_theme_supports( 'maxson-content-options' ) )
		{ 
			$support = get_theme_support( 'maxson-content-options' );
			$option  = $support[0];

			wp_register_script( 'maxson-content-options-customizer', get_theme_file_uri( '/assets/js/admin/customizer-content-options.js' ), array( 'customize-preview' ), $version, true );

			wp_enqueue_script( 'maxson-content-options-customizer' );

			// Supports
			// Posts
			$post_details = ( ! empty( $option['post_details'] ) ) ? $option['post_details'] : array();
				unset( $post_details['stylesheet'] );

			wp_localize_script( 'maxson-content-options-customizer', 'maxsonDetailsPost', $post_details );


			// Projects
			$project_details = ( ! empty( $option['project_details'] ) ) ? $option['project_details'] : array();
				unset( $project_details['stylesheet'] );

			wp_localize_script( 'maxson-content-options-customizer', 'maxsonDetailsProject', $project_details );

		} // endif
	}
} // endif
add_action( 'customize_preview_init', 'maxson_enqueue_customize_styles_scripts' );


if( ! function_exists( 'maxson_customizer_controls_styles_scripts' ) )
{ 
	/**
	 * Add customizer styles
	 * 
	 * @return      void
	 */

	function maxson_customizer_controls_styles_scripts()
	{ 
		$theme = ( function_exists( 'wp_get_theme' ) ) ? wp_get_theme() : get_current_theme();
			$version = $theme->get( 'Version' );

		wp_register_style( 'maxson-customizer-controls', get_theme_file_uri( "/assets/css/admin/customizer-controls.css" ), array(), $version );

		wp_enqueue_style( 'maxson-customizer-controls' );
	}
} // endif
add_action( 'customize_controls_print_styles', 'maxson_customizer_controls_styles_scripts' );


if( ! function_exists( 'maxson_register_override_defaults_customize' ) )
{ 
	/**
	 * Register theme specific general customize options
	 * Add postMessage support for site title and description
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_register_override_defaults_customize( $wp_customize )
	{ 
	//	$wp_customize->remove_panel( 'nav_menus' );
	//	$wp_customize->remove_panel( 'widgets' );

	//	$wp_customize->remove_section( 'title_tagline' );
	//	$wp_customize->remove_section( 'colors' );
	//	$wp_customize->remove_section( 'header_image' );
	//	$wp_customize->remove_section( 'background_image' );
	//	$wp_customize->remove_section( 'static_front_page' );
		$wp_customize->remove_section( 'custom_css' );

		$wp_customize->remove_control( 'site_icon' );

		// PostMessage settings
	//	$wp_customize->get_setting( 'custom_logo' )->transport     = 'refresh';
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		if( isset( $wp_customize->selective_refresh ) )
		{ 
			$wp_customize->selective_refresh->add_partial( 'blogname', array( 
				'selector'            => '.navbar-brand-title', 
				'container_inclusive' => false, 
				'render_callback'     => function()
				{ 
					return get_bloginfo( 'name', 'display' );

				}
			) );

			$wp_customize->selective_refresh->add_partial( 'blogdescription', array( 
				'selector'            => '.navbar-brand-description', 
				'container_inclusive' => false, 
				'render_callback'     => function()
				{ 
					return get_bloginfo( 'description' );

				}
			) );

		} // endif
	
	}
} // endif
add_action( 'customize_register', 'maxson_register_override_defaults_customize', 20 );


if( ! function_exists( 'maxson_customize_register_panel' ) )
{ 
	/**
	 * Register theme specific layout customizer options
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_customize_register_panel( $wp_customize )
	{ 
		$panel_priority = 180;

		$panel = 'maxson_theme';

		$wp_customize->add_panel( $panel, array( 
			'priority'    => $panel_priority, 
			'capability'  => 'edit_theme_options', 
			'title'       => __( 'Theme Options', 'maxson' ), 
			'description' => maxson_customize_theme_description(),
		) );
	}
} // endif
add_action( 'customize_register', 'maxson_customize_register_panel', 999 );


if( ! function_exists( 'maxson_customize_theme_description' ) )
{ 
	/**
	 * Return theme panel description
	 * 
	 * @return      string
	 */

	function maxson_customize_theme_description()
	{ 
		$email_text = get_option( 'admin_email' );
		$email_link = add_query_arg( array( 
			'subject' => 'WordPress Assistance Needed'
		), $email_text );

		$link = sprintf( '<a href="mailto:%1$s">%2$s</a>', $email_link, $email_text );

		ob_start();

		?><span class="customize-control-title"><?php esc_html_e( 'Need To Report an Issue?', 'maxson' ); ?></span>
			<p><?php _e( 'Our experts are here for you to answer any questions you might have about your WordPress theme and plugins.', 'maxson' ); ?></p>
			<p><?php printf( __( 'Contact us at: %1$s', 'maxson' ), $link ); ?></p>

		<?php $content = ob_get_contents();

		ob_end_clean();

		return $content;
	}
} // endif

?>