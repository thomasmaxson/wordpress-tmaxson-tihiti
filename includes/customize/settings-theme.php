<?php
/** 
 * Theme Customize
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) )
{ 
	die;

} // endif


if( ! function_exists( 'maxson_register_site_identity_customize' ) )
{ 
	/**
	 * Register theme specific layout customizer options
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_register_site_identity_customize( $wp_customize )
	{ 
		$section = 'title_tagline';

		$logo_labels = $wp_customize->get_control( 'custom_logo' )->button_labels;

		$control_args = array( 
			'section'         => $section, 
			'height'          => get_theme_support( 'custom-logo', 'height' ), 
			'width'           => get_theme_support( 'custom-logo', 'width' ), 
			'flex_height'     => get_theme_support( 'custom-logo', 'flex-height' ), 
			'flex_width'      => get_theme_support( 'custom-logo', 'flex-width' ), 
			'button_labels'   => $logo_labels, 
			'active_callback' => 'maxson_customize_callback_supports_custom_logo'
		);

		$logo_default_args = array_merge( $control_args, array( 
			'priority' => 8, 
			'label'    => _x( 'Logo, Default', 'Customizer control label', 'maxson' )
		) );

		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'custom_logo', $logo_default_args ) );

		if( isset( $wp_customize->selective_refresh ) )
		{ 
			$wp_customize->selective_refresh->add_partial( 'custom_logo', array( 
				'settings'            => array( 'custom_logo' ), 
				'container_inclusive' => false, 
				'render_callback'     => 'maxson_get_theme_brand_default_logo'
			) );

		} // endif


		$logo_inverse_args = array_merge( $control_args, array( 
			'priority' => 9, 
			'label'    => _x( 'Logo, Inverse', 'Customizer control label', 'maxson' )
		) );

		$wp_customize->add_setting( 'custom_logo_inverse', array( 
			'theme_supports' => array( 'custom-logo' ), 
			'transport'      => 'refresh'
		) );

		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'custom_logo_inverse', $logo_inverse_args ) );

		if( isset( $wp_customize->selective_refresh ) )
		{ 
			$wp_customize->selective_refresh->add_partial( 'custom_logo_inverse', array( 
				'settings'            => array( 'custom_logo_inverse' ), 
				'container_inclusive' => false, 
				'render_callback'     => 'maxson_get_theme_brand_inverse_logo'
			) );

		} // endif


		$schema_priority = 990;

		if( class_exists( 'Maxson_Customize_Arbitrary_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_schema_headline', array() );

			$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_schema_headline', array( 
				'section'  => $section, 
				'priority' => ( $schema_priority + 1 ), 
			//	'settings' => 'maxson_schema_headline', 
				'type'     => 'headline', 
				'label'    => _x( 'Schema', 'Customizer control label', 'maxson' )
			) ) );

		} // endif


		$wp_customize->add_setting( 'maxson_schema_name', array( 
			'transport' => 'postMessage', 
			'default'   => get_bloginfo( 'name', 'display' ), 
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_control( 'maxson_schema_name', array( 
			'section'     => $section, 
			'priority'    => $schema_priority++, 
		//	'settings'    => 'maxson_schema_name', 
			'type'        => 'text', 
			'label'       => _x( 'Legal Name', 'Customizer control label', 'maxson' ), 
			'description' => sprintf( __( 'The official registered name of your organization. %1$sSchema legal name reference%2$s', 'maxson' ), '<a href="http://schema.org/legalName" target="_blank">', '</a>' )
		) );


		$wp_customize->add_setting( 'maxson_schema_logo_path', array( 
			'transport' => 'postMessage', 
			'default'   => '', 
			'sanitize_callback' => 'maxson_sanitize_customize_image_field'
		) );

		$wp_customize->add_control( 'maxson_schema_logo_path', array( 
			'section'     => $section, 
			'priority'    => $schema_priority++, 
		//	'settings'    => 'maxson_schema_logo_path', 
			'type'        => 'url', 
			'label'       => _x( 'Logo Path', 'Customizer control label', 'maxson' ), 
			'description' => sprintf( __( 'The official registered image (logo) path of your organization. %1$sSchema logo reference%2$s', 'maxson' ), '<a href="http://schema.org/logo" target="_blank">', '</a>' )
		) );


		$webapp_priority = 995;

		if( class_exists( 'Maxson_Customize_Arbitrary_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_web_app_headline', array() );

			$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_web_app_headline', array( 
				'section'  => $section, 
				'priority' => $webapp_priority++,
				'type'     => 'headline', 
				'label'    => _x( 'Web Application', 'Customizer control label', 'maxson' ), 
				'description' => sprintf( __( '%1$sApple web application reference%2$s', 'maxson' ), '<a href="https://developer.apple.com/library/content/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html" target="_blank">', '</a>' )
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Checkbox_Toggle_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_web_app_capable', array( 
				'default' => true, 
				'sanitize_callback' => 'maxson_sanitize_checkbox_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Checkbox_Toggle_Control( $wp_customize, 'maxson_web_app_capable', array( 
				'section'  => $section, 
				'priority' => $webapp_priority++, 
				'label'    => _x( 'Site is web app capable', 'Customizer control label', 'maxson' )
			) ) );

		} // endif


		$wp_customize->add_setting( 'maxson_web_app_icon_title', array( 
			'transport' => 'postMessage', 
			'default'   => get_bloginfo( 'name', 'display' ), 
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_control( 'maxson_web_app_icon_title', array( 
			'section'  => $section, 
			'priority' => $webapp_priority++, 
			'type'     => 'text', 
			'label'    => _x( 'Launch Icon Title', 'Customizer control label', 'maxson' ), 
			'description' => __( 'The web application launch icon title.', 'maxson' ), 
			'active_callback' => 'maxson_customize_callback_web_app_capable'
		) );


		$wp_customize->add_setting( 'maxson_web_app_status_bar', array( 
			'transport' => 'postMessage', 
			'default'   => '', 
			'sanitize_callback' => 'maxson_sanitize_customize_select_field'
		) );

		$wp_customize->add_control( 'maxson_web_app_status_bar', array( 
			'section'  => $section, 
			'priority' => $webapp_priority++, 
			'type'     => 'radio', 
			'label'    => _x( 'Status Bar Appearance', 'Customizer control label', 'maxson' ), 
			'choices'  => array( 
				'' => _x( 'Default', 'Status bar appearance option', 'maxson' ), 
				'black' => _x( 'Black', 'Status bar appearance option', 'maxson' ), 
				'black-translucent' => _x( 'Black Translucent', 'Status bar appearance option', 'maxson' )
			), 
			'description' => __( 'The web application status bar style.', 'maxson' ), 
			'active_callback' => 'maxson_customize_callback_web_app_capable'
		) );
	}
} // endif
add_action( 'customize_register', 'maxson_register_site_identity_customize' );


if( ! function_exists( 'maxson_register_general_customize' ) )
{ 
	/**
	 * Register theme specific layout customizer options
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_register_general_customize( $wp_customize )
	{ 
		$panel   = 'maxson_theme';
		$section = 'general';

		$wp_customize->add_section( "{$panel}_{$section}", array( 
			'title' => _x( 'General', 'Customizer section title', 'maxson' ), 
			'panel' => $panel
		) );


		$wp_customize->add_setting( 'maxson_analytics', array( 
			'transport' => 'postMessage', 
			'default'   => false, 
			'sanitize_callback' => ( function_exists( 'maxson_sanitize_analytics_field' ) ) ? 'maxson_sanitize_analytics_field' : 'sanitize_text_field'
		) );

		$wp_customize->add_control( 'maxson_analytics', array( 
			'section'     => "{$panel}_{$section}", 
		//	'settings'    => 'maxson_analytics', 
			'type'        => 'text', 
			'label'       => _x( 'Analytics Code', 'Customizer control label', 'maxson' ), 
			'description' => __( 'Track website statistics with Google Analytics for a deeper understanding of your website visitors and customers.', 'maxson' )
		) );
	}
} // endif
// add_action( 'customize_register', 'maxson_register_general_customize' );


if( ! function_exists( 'maxson_customize_register_layout' ) )
{ 
	/**
	 * Contains methods for customizing the theme customization screen
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_customize_register_layout( $wp_customize )
	{ 
		$panel   = 'maxson_theme';
		$section = 'layout';

		$wp_customize->add_section( "{$panel}_{$section}", array( 
			'title' => _x( 'Layout', 'Customizer section title', 'maxson' ), 
			'panel' => $panel
		) );


		if( class_exists( 'Maxson_Customize_Radio_Image_Control' ) )
		{ 
			$default_sidebar_position = apply_filters( 'maxson_default_sidebar_position', ( ( is_rtl() ) ? 'left' : 'right' ) );

			$wp_customize->add_setting( 'maxson_layout', array( 
				'transport' => 'refresh', 
				'default'   => $default_sidebar_position, 
				'sanitize_callback' => 'maxson_sanitize_customize_select_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Radio_Image_Control( $wp_customize, 'maxson_layout', array( 
				'section'     => "{$panel}_{$section}", 
			//	'settings'    => 'maxson_layout', 
				'label'       => _x( 'Layout', 'Customizer control label', 'maxson' ), 
				'description' => __( 'Choose a layout for your website', 'maxson' ), 
				'choices'     => array( 
					'left'  => array( 
						'label' => __( 'Two columns - sidebar on left', 'maxson' ), 
						'image' => '%s/assets/images/customizer/controls/col-2-l.png'
					), 
					'none'  => array( 
						'label' => __( 'One column - no sidebar', 'maxson' ), 
						'image' => '%s/assets/images/customizer/controls/col-1.png'
					), 
					'right' => array( 
						'label' => __( 'Two columns - sidebar on right', 'maxson' ), 
						'image' => '%s/assets/images/customizer/controls/col-2-r.png'
					)
				)
			) ) );

		} // endif


		$wp_customize->add_setting( 'maxson_header_style', array( 
			'transport' => 'postMessage', 
			'default'   => 'default', 
			'sanitize_callback' => 'maxson_sanitize_customize_select_field'
		) );

		$wp_customize->add_control( 'maxson_header_style', array( 
			'section'  => "{$panel}_{$section}", 
		//	'settings' => 'maxson_header_style', 
			'type'     => 'radio', 
			'label'    => _x( 'Header Style', 'Customizer control label', 'maxson' ), 
			'choices'  => maxson_get_header_style_options()
		) );


		$wp_customize->add_setting( 'maxson_header_position', array( 
			'transport' => 'postMessage', 
			'default'   => 'static', 
			'sanitize_callback' => 'maxson_sanitize_customize_select_field'
		) );

		$wp_customize->add_control( 'maxson_header_position', array( 
			'section'  => "{$panel}_{$section}", 
		//	'settings' => 'maxson_header_position', 
			'type'     => 'radio', 
			'label'    => _x( 'Header Position', 'Customizer control label', 'maxson' ), 
			'choices'  => maxson_get_header_position_options()
		) );


		if( class_exists( 'Maxson_Customize_Checkbox_Toggle_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_footer_fixed', array( 
				'transport' => 'postMessage', 
				'default'   => true, 
				'sanitize_callback' => 'maxson_sanitize_checkbox_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Checkbox_Toggle_Control( $wp_customize, 'maxson_footer_fixed', array( 
				'section'  => "{$panel}_{$section}", 
			//	'settings' => 'maxson_footer_fixed', 
				'label'    => _x( 'Fixed footer behind content', 'Customizer control label', 'maxson' )
			) ) );

		} // endif
	}
} // endif
add_action( 'customize_register', 'maxson_customize_register_layout' );


if( ! function_exists( 'maxson_customize_register_pages' ) )
{ 
	/**
	 * Contains methods for customizing the theme customization screen
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_customize_register_pages( $wp_customize )
	{ 
		$core_pages = maxson_get_core_pages();

		if( ! empty( $core_pages ) && is_array( $core_pages ) )
		{ 
			$panel   = 'maxson_theme';
			$section = 'pages';

			$wp_customize->add_section( "{$panel}_{$section}", array( 
				'title' => _x( 'Pages', 'Customizer section title', 'maxson' ), 
				'panel' => $panel
			) );

			foreach( $core_pages as $page_key => $page_label )
			{ 
				$wp_customize->add_setting( "maxson_pages[{$page_key}]", array( 
					'transport' => 'postMessage', 
					'default'   => '', 
					'sanitize_callback' => 'maxson_sanitize_customize_dropdown_pages_field'
				) );

				$wp_customize->add_control( "maxson_customizer_pages_{$page_key}", array( 
					'section'  => "{$panel}_{$section}", 
					'settings' => "maxson_pages[{$page_key}]", 
					'type'     => 'dropdown-pages', 
					'label'    => $page_label, 
					'allow_addition' => true
				) );

			} // endforeach
		} // endif
	}
} // endif
add_action( 'customize_register', 'maxson_customize_register_pages' );


if( ! function_exists( 'maxson_customize_register_skills' ) )
{ 
	/**
	 * Contains methods for customizing the theme customization screen
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_customize_register_skills( $wp_customize )
	{ 
		$skills = maxson_get_skills();

		if( ! empty( $skills ) && is_array( $skills ) && class_exists( 'Maxson_Customize_Range_Control' ) )
		{ 
			$panel   = 'maxson_theme';
			$section = 'skills';

			$wp_customize->add_section( "{$panel}_{$section}", array( 
				'title' => _x( 'Skills', 'Customizer section title', 'maxson' ), 
				'panel' => $panel
			) );

			foreach( $skills as $skill_key => $skill_label )
			{ 
				$the_label = sprintf( '%1$s (%%)', $skill_label );

				$wp_customize->add_setting( "maxson_skills[{$skill_key}]", array( 
					'transport' => 'postMessage', 
				//	'default'   => '100', 
					'sanitize_callback' => 'maxson_sanitize_customize_range_field'
				) );

				$wp_customize->add_control( new Maxson_Customize_Range_Control( $wp_customize, "maxson_customizer_skills_{$skill_key}", array( 
					'section'  => "{$panel}_{$section}", 
					'settings' => "maxson_skills[{$skill_key}]", 
					'label'    => $the_label, 
					'input_attrs' => array( 
						'min'   => 1, 
						'max'   => 100, 
						'step'  => 1, 
						'data-suffix' => '%'
					)
				) ) );

				if( isset( $wp_customize->selective_refresh ) )
				{ 
					$wp_customize->selective_refresh->add_partial( "maxson_skills[{$skill_key}]", array( 
						'selector' => "#skill-{$skill_key}"
					) );

				} // endif

			} // endforeach
		} // endif

	}
} // endif
add_action( 'customize_register', 'maxson_customize_register_skills' );


if( ! function_exists( 'maxson_customize_register_call_to_action' ) )
{ 
	/**
	 * Contains methods for customizing the theme customization screen
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_customize_register_call_to_action( $wp_customize )
	{ 
		$panel   = 'maxson_theme';
		$section = 'call_to_action';

		$wp_customize->add_section( "{$panel}_{$section}", array( 
			'title' => _x( 'Call to Action', 'Customizer section title', 'maxson' ), 
			'panel' => $panel
		) );


		if( class_exists( 'Maxson_Customize_Checkbox_Toggle_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_call_to_action[show]', array( 
				'default' => true, 
				'sanitize_callback' => 'maxson_sanitize_checkbox_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Checkbox_Toggle_Control( $wp_customize, 'maxson_call_to_action_show', array( 
				'section'  => "{$panel}_{$section}", 
				'settings' => 'maxson_call_to_action[show]', 
				'label'    => _x( 'Show Call to Action', 'Customizer control label', 'maxson' )
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Arbitrary_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_call_to_action_divider', array() );

			$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_call_to_action_divider', array( 
				'section'  => "{$panel}_{$section}", 
				'type'     => 'divider', 
				'active_callback' => 'maxson_customize_callback_show_call_to_action'
			) ) );

		} // endif


		$wp_customize->add_setting( 'maxson_call_to_action[label]', array( 
			'transport' => 'postMessage', 
			'default'   => ''
		) );

		$wp_customize->add_control( 'maxson_call_to_action_labels', array( 
			'section'     => "{$panel}_{$section}", 
			'settings'    => 'maxson_call_to_action[label]', 
			'type'        => 'text', 
			'label'       => _x( 'Label', 'Customizer control label', 'maxson' ), 
			'active_callback' => 'maxson_customize_callback_show_call_to_action'
		) );


		if( class_exists( 'Maxson_Customize_Dropdown_Posts_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_call_to_action[attr][id]', array( 
				'transport' => 'postMessage', 
				'default'   => false, 
				'sanitize_callback' => 'maxson_sanitize_number_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Dropdown_Posts_Control( $wp_customize, 'maxson_call_to_action_attr_id', array( 
				'section'  => "{$panel}_{$section}", 
				'settings' => 'maxson_call_to_action[attr][id]', 
				'label'    => _x( 'Link To', 'Customizer control label', 'maxson' ), 
				'active_callback' => 'maxson_customize_callback_show_call_to_action'
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Checkbox_Toggle_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_call_to_action[attr][target]', array( 
				'transport' => 'postMessage', 
				'default'   => false, 
				'sanitize_callback' => 'maxson_sanitize_checkbox_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Checkbox_Toggle_Control( $wp_customize, 'maxson_call_to_action_attr_target', array( 
				'section'  => "{$panel}_{$section}", 
				'settings' => 'maxson_call_to_action[attr][target]', 
				'label'    => _x( 'Open link in new tab', 'Customizer control label', 'maxson' ), 
				'active_callback' => 'maxson_customize_callback_show_call_to_action'
			) ) );

		} // endif


		if( ! function_exists( 'Maxson_Customize_Checkbox_Toggle_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_call_to_action[attr][rel]', array( 
				'transport' => 'postMessage', 
				'default'   => false, 
				'sanitize_callback' => 'maxson_sanitize_checkbox_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Checkbox_Toggle_Control( $wp_customize, 'maxson_call_to_action_attr_rel', array( 
				'section'  => "{$panel}_{$section}", 
				'settings' => 'maxson_call_to_action[attr][rel]', 
				'label'    => sprintf( _x( 'Add %1$srel="nofollow"%2$s to link', 'Customizer control label', 'maxson' ), '<code>', '</code>' ), 
				'active_callback' => 'maxson_customize_callback_show_call_to_action'
			) ) );

		} // endif
	}
} // endif
add_action( 'customize_register', 'maxson_customize_register_call_to_action' );


if( ! function_exists( 'maxson_customize_register_more' ) )
{ 
	/**
	 * Contains methods for customizing the theme customization screen
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_customize_register_more( $wp_customize )
	{ 
		if( apply_filters( 'maxson_customizer_more', false ) 
			&& class_exists( 'Maxson_Customize_More_Control' ) )
		{ 
			$section = 'maxson_more';

			$wp_customize->add_section( $section , array( 
				'title'    => _x( 'More', 'Customizer section title', 'maxson' ), 
				'priority' => 9999
			) );

			$wp_customize->add_setting( 'maxson_more', array( 
				'default' => null, 
				'sanitize_callback' => 'sanitize_text_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_More_Control( $wp_customize, 'maxson_more', array( 
				'label'    => _x( 'Looking for help?', 'maxson' ), 
				'section'  => $section, 
				'priority' => 1
			) ) );

		} // endif
	}
} // endif
add_action( 'customize_register', 'maxson_customize_register_more', 9999 );


if( ! function_exists( 'maxson_customize_callback_supports_custom_logo' ) )
{ 
	/**
	 * Callback function for to retrieve if the theme supports custom logos
	 * 
	 * @param       object $control / Instance of the Customizer Control
	 * @return      bool
	 */

	function maxson_customize_callback_supports_custom_logo( $control )
	{ 
		return ( current_theme_supports( 'custom-logo' ) );
	}
} // endif


if( ! function_exists( 'maxson_customize_callback_web_app_capable' ) )
{ 
	/**
	 * Callback function to retrieve if site is web app capable or not
	 * 
	 * @param       object $control / Instance of the Customizer Control
	 * @return      bool
	 */

	function maxson_customize_callback_web_app_capable( $control )
	{ 
		$value = $control->manager->get_setting( 'maxson_web_app_capable' )->value();

		return ( ( '1' == $value ) ? true : false );
	}
} // endif


if( ! function_exists( 'maxson_customize_callback_show_call_to_action' ) )
{ 
	/**
	 * Callback function to retrieve if call-to-action is shown
	 * 
	 * @param       object $control / Instance of the Customizer Control
	 * @return      bool
	 */

	function maxson_customize_callback_show_call_to_action( $control )
	{ 
		$value = $control->manager->get_setting( 'maxson_call_to_action[show]' )->value();

		return ( ( '1' == $value ) ? true : false );
	}
} // endif

?>