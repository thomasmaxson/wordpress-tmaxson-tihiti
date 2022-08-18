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

// https://premium.wpmudev.org/forums/topic/advanced-color-manipulation-using-the-customizer

if( ! function_exists( 'maxson_customize_register_portfolio_project' ) )
{ 
	/**
	 * Contains methods for customizing the theme customization screen
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_customize_register_portfolio_project( $wp_customize )
	{ 
		if( ! post_type_exists( 'portfolio_project' ) )
		{ 
			return;

		} // endif

		$panel    = 'maxson_portfolio';
		$section  = 'archive';

		$section_priority = 999;

		if( class_exists( 'Maxson_Customize_Checkbox_Toggle_Control' ) )
		{ 
			$plugin_control = 'maxson_portfolio_customizer_archive_thumbnail';
				$priority = $wp_customize->get_control( $plugin_control )->priority;
				$label    = $wp_customize->get_control( $plugin_control )->label;

			$wp_customize->remove_control( $plugin_control );

			$wp_customize->add_control( new Maxson_Customize_Checkbox_Toggle_Control( $wp_customize, 'maxson_portfolio_archive_thumbnail', array( 
				'section'  => "{$panel}_{$section}", 
				'priority' => $priority, 
				'label'    => $label, 
				'active_callback' => ( function_exists( 'maxson_portfolio_has_archive_page_id' ) ) ? 'maxson_portfolio_has_archive_page_id' : true
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Arbitrary_Control' ) )
		{ 
			$section_priority = ( $section_priority + 10 );

			$wp_customize->add_setting( 'maxson_project_archive_divider', array() );

			$wp_customize->add_control( new Maxson_Customize_Arbitrary_Control( $wp_customize, 'maxson_project_archive_divider', array( 
				'section'  => "{$panel}_{$section}", 
				'priority' => $section_priority, 
				'type'     => 'divider'
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Checkbox_Toggle_Control' ) )
		{ 
			$section_priority = ( $section_priority + 10 );

			$wp_customize->add_setting( 'maxson_project_archive_filter', array( 
				'transport' => 'refresh', 
				'default'   => '1', 
				'sanitize_callback' => 'maxson_sanitize_checkbox_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Checkbox_Toggle_Control( $wp_customize, 'maxson_project_archive_filter', array( 
				'section'  => "{$panel}_{$section}", 
				'priority' => $section_priority, 
				'label'    => _x( 'Show portfolio filters', 'Customizer control label', 'maxson' ), 
				'active_callback' => ( function_exists( 'is_portfolio_archive' ) ) ? 'is_portfolio_archive' : true
			) ) );

			if( isset( $wp_customize->selective_refresh ) )
			{ 
				$wp_customize->selective_refresh->add_partial( 'maxson_project_archive_filter', array( 
					'selector' => '#portfolio-filters li:first-child'
				) );

			} // endif
		} // endif


		if( class_exists( 'Maxson_Customize_Radio_Image_Control' ) )
		{ 
			$section_priority = ( $section_priority + 10 );

			$wp_customize->add_setting( 'maxson_project_teaser_column_count', array( 
				'transport' => 'refresh', 
				'default'   => '3', 
				'sanitize_callback' => 'maxson_sanitize_customize_select_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Radio_Image_Control( $wp_customize, 'maxson_project_teaser_column_count', array( 
				'section'     => "{$panel}_{$section}", 
				'priority'    => $section_priority, 
				'label'       => _x( 'Column Count', 'Customizer control label', 'maxson' ), 
				'description' => __( 'Choose the number of columns for your portfolio project teasers', 'maxson' ), 
				'choices'     => array( 
					'1' => array( 
						'label' => __( 'One column', 'maxson' ), 
						'image' => '%s/assets/images/customizer/controls/portfolio-col-1.png'
					), 
					'2' => array( 
						'label' => __( 'Two columns', 'maxson' ), 
						'image' => '%s/assets/images/customizer/controls/portfolio-col-2.png'
					), 
					'3' => array( 
						'label' => __( 'Three columns', 'maxson' ), 
						'image' => '%s/assets/images/customizer/controls/portfolio-col-3.png'
					), 
					'4' => array( 
						'label' => __( 'Four columns', 'maxson' ), 
						'image' => '%s/assets/images/customizer/controls/portfolio-col-4.png'
					), 
					'6' => array( 
						'label' => __( 'Six columns', 'maxson' ), 
						'image' => '%s/assets/images/customizer/controls/portfolio-col-6.png'
					)
				), 
				'active_callback' => ( function_exists( 'maxson_portfolio_has_archive_page_id' ) ) ? 'maxson_portfolio_has_archive_page_id' : true
			) ) );

			if( isset( $wp_customize->selective_refresh ) )
			{ 
				$wp_customize->selective_refresh->add_partial( 'maxson_project_teaser_column_count', array( 
					'selector' => '#portfolio-teasers'
				) );

			} // endif
		} // endif


		$section = 'project';

		$wp_customize->add_section( "{$panel}_{$section}", array( 
			'title' => _x( 'Projects', 'Customizer section title', 'maxson' ), 
			'panel' => $panel, 
			'active_callback' => ( function_exists( 'is_project' ) ) ? 'is_project' : true
		) );


		if( class_exists( 'Maxson_Customize_Checkbox_Toggle_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_project_gallery_lightbox', array( 
				'transport' => 'refresh', 
				'type'      => 'option', 
				'default'   => true, 
				'sanitize_callback' => 'maxson_sanitize_checkbox_field'
			) );


			$wp_customize->add_control( new Maxson_Customize_Checkbox_Toggle_Control( $wp_customize, 'maxson_project_gallery_lightbox', array( 
				'section' => "{$panel}_{$section}", 
				'label'   => _x( 'Open project gallery images in lightbox', 'Customizer control label', 'maxson' )
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Checkbox_Toggle_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_project_show_navigation', array( 
				'transport' => 'refresh', 
				'default'   => '1', 
				'sanitize_callback' => 'maxson_sanitize_checkbox_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Checkbox_Toggle_Control( $wp_customize, 'maxson_project_show_navigation', array( 
				'section'  => "{$panel}_{$section}", 
				'label'    => _x( 'Display project navigation', 'Customizer control label', 'maxson' )
			) ) );

			if( isset( $wp_customize->selective_refresh ) )
			{ 
				$wp_customize->selective_refresh->add_partial( 'maxson_project_show_navigation', array( 
					'selector' => '#project-pagination'
				) );

			} // endif

		} // endif


		$wp_customize->add_setting( 'maxson_project_nav_third_link', array( 
			'transport' => 'refresh', 
			'default'   => 'back', 
			'sanitize_callback' => 'maxson_sanitize_customize_select_field'
		) );

		$wp_customize->add_control( 'maxson_project_nav_third_link', array( 
			'section'  => "{$panel}_{$section}", 
			'type'     => 'radio', 
			'label'    => _x( 'Project Navigation', 'Customizer control label', 'maxson' ), 
			'choices'  => array( 
				'top'  => __( 'To the Top', 'maxson' ), 
				'back' => __( 'Back to Portfolio', 'maxson' )
			), 
			'active_callback' => 'maxson_customize_callback_show_project_navigation'
		) );

		if( isset( $wp_customize->selective_refresh ) )
		{ 
			$wp_customize->selective_refresh->add_partial( 'maxson_project_nav_third_link', array( 
				'selector' => '#project-pagination .nav-back'
			) );

		} // endif
	}
} // endif
add_action( 'customize_register', 'maxson_customize_register_portfolio_project', 9999 );


if( ! function_exists( 'maxson_customize_callback_show_project_navigation' ) )
{ 
	/**
	 * Adds a callback function to retrieve if site shows project navigation or not
	 * 
	 * @param       object $control / Instance of the Customizer Control
	 * @return      bool
	 */

	function maxson_customize_callback_show_project_navigation( $control )
	{ 
		$value = $control->manager->get_setting( 'maxson_project_show_navigation' )->value();

		return ( '1' == $value ) ? true : false;
	}
} // endif

?>