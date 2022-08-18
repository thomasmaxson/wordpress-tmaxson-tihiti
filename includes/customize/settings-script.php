<?php
/** 
 * Theme Customize Styles and Scripts
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) )
{ 
	die;

} // endif


if( ! function_exists( 'maxson_register_script_customize' ) )
{ 
	/**
	 * Register theme specific layout customizer options
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_register_script_customize( $wp_customize )
	{ 
		$panel_priority   = 9999;
		$section_priority = 0;

		$panel = 'maxson_styles_scripts';

		$wp_customize->add_panel( 'maxson_styles_scripts', array( 
			'capability'  => 'edit_theme_options', 
			'title'       => _x( 'Styles & Scripts', 'Customize panel title', 'maxson' ), 
			'priority'    => $panel_priority, 
			'description' => __( 'This panel allows you to manage style and script settings.', 'maxson' ), 
		) );


		/**
		 * Styles
		 */

		$section = 'style';

		$wp_customize->add_section( "maxson_styles_scripts_{$section}", array( 
			'title'    => __( 'Site Styles', 'maxson' ), 
			'priority' => ( $section_priority + 10 ), 
			'panel'    => $panel
		) );


	//	$wp_customize->add_setting( 'maxson_version_font_awesome', array( 
	//		'transport' => 'postMessage', 
	//		'default'   => '5.10.2', 
	//		'sanitize_callback' => 'sanitize_text_field'
	//	) );

	//	if( ! defined( 'MAXSON_THEME_FONT_AWESOME_VERSION' ) &&
	//		! has_filter( 'maxson_version_font_awesome' ) )
	//	{ 
	//		$wp_customize->add_control( 'maxson_version_font_awesome', array( 
	//			'section' => "maxson_styles_scripts_{$section}", 
	//			'type'    => 'text', 
	//			'label'   => _x( 'Font Awesome Version', 'Customizer control label', 'maxson' )
	//		) );

	//	} else
	//	{ 
	//		$version     = maxson_get_version_font_awesome();
	//		$description = maxson_customize_set_third_party_description( $version );
	
	//		$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_version_font_awesome', array( 
	//			'section' => "maxson_styles_scripts_{$section}", 
	//			'type'    => 'headline', 
	//			'label'   => _x( 'Font Awesome Version', 'Customizer control label', 'maxson' ), 
	//			'description' => $description
	//		) ) );

	//	} // endif


		if( class_exists( 'Maxson_Customize_Code_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_scripts_header', array( 
				'transport' => 'postMessage', 
				'type'      => 'option', 
				'default'   => '', 
				'sanitize_callback' => 'maxson_sanitize_js_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Code_Control( $wp_customize, 'maxson_scripts_header', array( 
				'section'     => "maxson_styles_scripts_{$section}", 
				'label'       => _x( 'Header Scripts', 'Customizer control label', 'maxson' ), 
				'description' => maxson_customize_style_description(), 
				'input_attrs' => array( 
					'class' => 'code'
				)
			) ) );

		} // endif


		/**
		 * Scripts
		 */

		$section = 'script';

		$wp_customize->add_section( "maxson_styles_scripts_{$section}", array( 
			'title'    => __( 'Site Scripts', 'maxson' ), 
			'priority' => ( $section_priority + 10 ), 
			'panel'    => $panel
		) );


		$wp_customize->add_setting( 'maxson_version_jquery', array( 
			'transport' => 'postMessage', 
			'default'   => '3.3.1', 
			'sanitize_callback' => 'sanitize_text_field'
		) );

		if( ! defined( 'MAXSON_THEME_JQUERY_VERSION' ) &&
			! has_filter( 'maxson_version_jquery' ) )
		{ 
			$wp_customize->add_control( 'maxson_version_jquery', array( 
				'section'     => "maxson_styles_scripts_{$section}", 
				'type'        => 'text', 
				'label'       => _x( 'jQuery Version', 'Customizer control label', 'maxson' )
			) );

		} else
		{ 
			$version     = maxson_get_version_jquery();
			$description = maxson_customize_set_third_party_description( $version );
	
			$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_version_jquery', array( 
				'section' => "maxson_styles_scripts_{$section}", 
				'type'    => 'headline', 
				'label'   => _x( 'jQuery Version', 'Customizer control label', 'maxson' ), 
				'description' => $description
			) ) );

		} // endif


		$wp_customize->add_setting( 'maxson_version_jquery_ui', array( 
			'transport' => 'postMessage', 
			'default'   => '1.12.1', 
			'sanitize_callback' => 'sanitize_text_field'
		) );

		if( ! defined( 'MAXSON_THEME_JQUERY_UI_VERSION' ) &&
			! has_filter( 'maxson_version_jquery_ui' ) )
		{ 
			$wp_customize->add_control( 'maxson_version_jquery_ui', array( 
				'section'     => "maxson_styles_scripts_{$section}", 
				'type'        => 'text', 
				'label'       => _x( 'jQuery UI Version', 'Customizer control label', 'maxson' )
			) );

		} else
		{ 
			$version     = maxson_get_version_jquery_ui();
			$description = maxson_customize_set_third_party_description( $version );
	
			$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_version_jquery_ui', array( 
				'section' => "maxson_styles_scripts_{$section}", 
				'type'    => 'headline', 
				'label'   => _x( 'jQuery UI Version', 'Customizer control label', 'maxson' ), 
				'description' => $description
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Code_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_scripts_footer', array( 
				'transport' => 'postMessage', 
				'type'      => 'option', 
				'default'   => '', 
				'sanitize_callback' => 'maxson_sanitize_js_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Code_Control( $wp_customize, 'maxson_scripts_footer', array( 
				'section'     => "maxson_styles_scripts_{$section}", 
				'label'       => _x( 'Footer Scripts', 'Customizer control label', 'maxson' ), 
				'description' => maxson_customize_script_description(), 
				'input_attrs' => array(
					'class' => 'code'
				)
			) ) );

		} // endif

	}
} // endif
add_action( 'customize_register', 'maxson_register_script_customize' );


if( ! function_exists( 'maxson_customize_style_description' ) )
{ 
	/**
	 * Return theme style section description
	 * 
	 * @return      string
	 */

	function maxson_customize_style_description()
	{ 
		return sprintf( __( 'Header styles and scripts output to %1$swp_head()%2$s. The %1$swp_head()%2$s hook executes immediately before the %1$s&lt;/head>%2$s tag in the document source.', 'maxson' ), '<code>', '</code>' );
	}
} // endif


if( ! function_exists( 'maxson_customize_script_description' ) )
{ 
	/**
	 * Return theme script section description
	 * 
	 * @return      string
	 */

	function maxson_customize_script_description()
	{ 
		return sprintf( __( 'Footer scripts output to %1$swp_footer()%2$s. The %1$swp_footer()%2$s hook executes immediately before the %1$s&lt;/body>%2$s tag in the document source.', 'maxson' ), '<code>', '</code>' );
	}
} // endif


if( ! function_exists( 'maxson_customize_set_third_party_description' ) )
{ 
	/**
	 * Return third party version overridden description
	 * 
	 * @return      string
	 */

	function maxson_customize_set_third_party_description( $version )
	{ 
		$desc = sprintf( __( 'This library is set to %1$sv%3$s%2$s', 'maxson' ), '<code>', '</code>', $version );
		$desc .= '<br>';
		$desc .= __( 'Contact your site administrator to change it.', 'maxson' );

		return $desc;
	}
} // endif

?>