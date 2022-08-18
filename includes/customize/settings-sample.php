<?php
/** 
 * Theme Customize, Custom Sample Fields
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) )
{ 
	die;

} // endif

if( ! function_exists( 'maxson_customize_register_fields' ) )
{ 
	/**
	 * Contains methods for customizing the theme customization screen
	 * 
	 * @param       $wp_customize Customizer object
	 * @return      void
	 */

	function maxson_customize_register_fields( $wp_customize )
	{ 
		// Bail out if not in test environment
		if( ! maxson_theme_mode_is_test_environment() )
		{ 
			return;

		} // endif

		$panel   = 'maxson_custom';
		$section = 'fields';

		$wp_customize->add_section( "{$panel}_{$section}", array( 
			'title' => _x( 'Sample Custom Fields', 'Customizer section title', 'maxson' )
		) );


		if( class_exists( 'Maxson_Customize_Checkbox_Toggle_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_sample_toggle_checkbox', array( 
				'transport' => 'postMessage', 
				'default'   => 1, 
				'sanitize_callback' => 'maxson_sanitize_checkbox_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Checkbox_Toggle_Control( $wp_customize, 'maxson_sample_toggle_checkbox', array( 
				'section'     => "{$panel}_{$section}", 
				'label'       => _x( 'Toggle Checkbox', 'Customizer control label', 'maxson' ), 
				'description' => __( 'Field description.', 'maxson' )
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Dropdown_Posts_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_sample_dropdown_posts', array( 
				'transport' => 'postMessage', 
				'default'   => '', 
				'sanitize_callback' => 'maxson_sanitize_number_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Dropdown_Posts_Control( $wp_customize, 'maxson_sample_dropdown_posts', array( 
				'section'     => "{$panel}_{$section}", 
				'label'       => _x( 'All Posts Dropdown', 'Customizer control label', 'maxson' ), 
				'description' => __( 'Field description.', 'maxson' )
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Dropdown_Posts_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_sample_dropdown_post', array( 
				'transport' => 'postMessage', 
				'default'   => '', 
				'sanitize_callback' => 'maxson_sanitize_number_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Dropdown_Posts_Control( $wp_customize, 'maxson_sample_dropdown_post', array( 
				'section'     => "{$panel}_{$section}", 
				'label'       => _x( 'Posts Dropdown', 'Customizer control label', 'maxson' ), 
				'description' => __( 'Field description.', 'maxson' )
			), array( 
				'include' => array( 'portfolio_project' )
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Dropdown_Terms_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_sample_dropdown_taxonomy', array( 
				'transport' => 'postMessage', 
				'default'   => '', 
				'sanitize_callback' => 'maxson_sanitize_number_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Dropdown_Terms_Control( $wp_customize, 'maxson_sample_dropdown_taxonomy', array( 
				'section'     => "{$panel}_{$section}", 
				'label'       => _x( 'Taxonomy Dropdown', 'Customizer control label', 'maxson' ), 
				'description' => __( 'Field description.', 'maxson' )
			), array( 
				'taxonomy' => 'portfolio_category'
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Dropdown_Users_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_sample_dropdown_user', array( 
				'transport' => 'postMessage', 
				'default'   => '', 
				'sanitize_callback' => 'maxson_sanitize_number_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Dropdown_Users_Control( $wp_customize, 'maxson_sample_dropdown_user', array( 
				'section'     => "{$panel}_{$section}", 
				'label'       => _x( 'User Dropdown', 'Customizer control label', 'maxson' ), 
				'description' => __( 'Field description.', 'maxson' )
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Checkbox_Sortable_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_sample_sortable_checkboxes', array( 
				'transport' => 'postMessage', 
				'default'   => array( 'apple', 'banana' ), 
				'sanitize_callback' => 'maxson_sanitize_customize_array_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Checkbox_Sortable_Control( $wp_customize, 'maxson_sample_sortable_checkboxes', array( 
				'section'     => "{$panel}_{$section}", 
				'label'       => _x( 'Sortable List', 'Customizer control label', 'maxson' ), 
				'description' => __( 'Field description.', 'maxson' ), 
				'choices'     => array( 
					'apple'      => __( 'Apple', 'maxson' ), 
					'banana'     => __( 'Banana', 'maxson' ), 
					'date'       => __( 'Date', 'maxson' ), 
					'orange'     => __( 'Orange', 'maxson' ), 
					'watermelon' => __( 'Watermelon', 'maxson' )
				)
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Range_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_sample_range', array( 
				'transport' => 'postMessage', 
				'default'   => 50, 
				'sanitize_callback' => 'maxson_sanitize_customize_range_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Range_Control( $wp_customize, 'maxson_sample_range', array( 
				'section'     => "{$panel}_{$section}", 
				'label'       => _x( 'Range Slider', 'Customizer control label', 'maxson' ), 
				'description' => __( 'Field description.', 'maxson' ), 
				'input_attrs' => array( 
					'data-suffix' => '%'
				)
			) ) );

		} // endif


		if( class_exists( 'Maxson_Customize_Radio_Image_Control' ) )
		{ 
			$wp_customize->add_setting( 'maxson_sample_layout', array( 
				'transport' => 'postMessage', 
				'default'   => 'none', 
				'sanitize_callback' => 'maxson_sanitize_customize_select_field'
			) );

			$wp_customize->add_control( new Maxson_Customize_Radio_Image_Control( $wp_customize, 'maxson_sample_layout', array( 
				'section'     => "{$panel}_{$section}", 
				'label'       => _x( 'Radio Image', 'Customizer control label', 'maxson' ), 
				'description' => __( 'Field description.', 'maxson' ), 
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
	}
} // endif
add_action( 'customize_register', 'maxson_customize_register_fields', 9999 );

?>