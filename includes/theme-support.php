<?php
/**
 * Theme Support
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! function_exists( 'maxson_add_theme_support' ) )
{ 
	/**
	 * WordPress add theme support
	 * 
	 * @return      void
	 */

	function maxson_add_theme_support()
	{ 
		add_theme_support( 'woocomerce' );

		global $content_width;

		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain( 'maxson', get_template_directory() . '/languages' );

		// This theme styles the visual editor to match the theme style
		add_editor_style( get_stylesheet_uri() );

		// Register Navigation Menus
		register_nav_menus( array( 
			'primary' => __( 'Primary Menu', 'maxson' ), 
			'social'  => __( 'Social Links Menu', 'maxson' )
		) );

		// Set up the WordPress core custom header feature
	//	add_theme_support( 'custom-header' );

		// Set up the WordPress core custom background feature
	//	add_theme_support( 'custom-background' );

		// Let WordPress manage the document title
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Add theme support for selective refresh for widgets
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for all available post formats
		add_theme_support( 'post-formats', array( 
			'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'
		) );

		// Switch default core markup to output valid HTML5
		add_theme_support( 'html5', array( 
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		// Custom logo
		$logo_width  = 64;
		$logo_height = 64;

		// If the retina setting is active, double the recommended width and height
		if( get_theme_mod( 'retina_logo', false ) )
		{ 
			$logo_width  = floor( $logo_width * 2 );
			$logo_height = floor( $logo_height * 2 );

		} // endif

	//	add_image_size( 'logo', $logo_width, $logo_height );

		// Set up the WordPress core custom logo feature
		add_theme_support( 'custom-logo', array( 
			'width'           => $logo_width, 
			'height'          => $logo_height, 
			'flex-height'     => true, 
			'flex-width'      => true, 
			'header-selector' => '.navbar-brand img, .navbar-brand svg',
			'header-text'     => false
		) );

		// Add support for responsive-embeds
		add_theme_support( 'responsive-embeds' );

		// Allow WordPress to load in the default Gutenberg block styles
	//	add_theme_support( 'wp-block-styles' );

		// Enable align-wide for Gutenberg blocks
	//	add_theme_support( 'align-wide' );

		// Add support for custom editor font sizes
		add_theme_support( 'editor-font-sizes', maxson_get_theme_font_sizes() );

		// Disable the custom font sizes
	//	add_theme_support( 'disable-custom-font-sizes' );

		// Add support for custom editor colors
		add_theme_support( 'editor-color-palette', maxson_get_theme_colors() );

		// Disable the custom color picker
		add_theme_support( 'disable-custom-colors' );

		// Set "Distraction Free Writing" width
		set_user_setting( 'dfw_width', $content_width );


		// Custom logo
		$logo_width  = 64;
		$logo_height = 64;

		// If the retina setting is active, double the recommended width and height
		if( get_theme_mod( 'retina_logo', false ) )
		{ 
			$logo_width  = floor( $logo_width * 2 );
			$logo_height = floor( $logo_height * 2 );

		} // endif

	//	add_image_size( 'logo', $logo_width, $logo_height );

		// Set up the WordPress core custom logo feature
		add_theme_support( 'custom-logo', array( 
			'width'           => $logo_width, 
			'height'          => $logo_height, 
			'flex-height'     => true, 
			'flex-width'      => true, 
			'header-selector' => '.navbar-brand img, .navbar-brand svg',
			'header-text'     => false
		) );


	//	add_theme_support( 'starter-content', maxson_get_starter_content() );

		// If we have a dark background color then add support for dark editor style
		// We can determine if the background color is dark by checking if the text-color is white
	//	if( '#ffffff' === strtolower( maxson_get_color_for_area( 'content', 'text' ) ) )
	//	{ 
	//		add_theme_support( 'dark-editor-style' );

	//	} // endif

		// If the theme doesn't support 'jetpack-content-options', continue
		if( ! current_theme_supports( 'jetpack-content-options' ) )
		{ 
			// Initialize custom theme options
			add_theme_support( 'maxson-content-options', maxson_get_theme_content_options() );

		} // endif

		// Jetpack support setup
	//	add_theme_support( 'social-links' );
	//	add_theme_support( 'featured-content' );


		if( ! is_customize_preview() && class_exists( 'Maxson_Script_Loader' ) )
		{ 
			/**
			 * Adds `async` and/or `defer` support for scripts registered or enqueued by the theme
			 */

		//	$loader = new Maxson_Script_Loader();

		//	add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

		} // endif
	}
} // endif
add_action( 'after_setup_theme', 'maxson_add_theme_support' );


if( ! function_exists( 'maxson_remove_wp_embed_script' ) )
{ 
	/**
	 * WordPress remove wp-embed script
	 * 
	 * @return      void
	 */

	function maxson_remove_wp_embed_script()
	{ 
		if( ! is_admin() )
		{ 
			wp_deregister_script( 'wp-embed' );

		} // endif
	}
} // endif
// add_action( 'init', 'maxson_remove_wp_embed_script' );


if( ! function_exists( 'maxson_get_theme_content_options' ) )
{ 
	/**
	 * 
	 * 
	 * @return      array
	 */

	function maxson_get_theme_content_options()
	{ 
		return array( 
			'excerpt_type' => 'content', 
			'author_bio'   => true, 
			'post_details' => array( 
				'stylesheet' => 'maxson-styles', 
				'author'     => '.post-author', 
				'categories' => '.post-cats', 
				'date'       => '.post-date', 
				'tags'       => '.post-tags', 
				'comment'    => '.comments'
			), 
			'project_details' => array( 
				'stylesheet' => 'maxson-styles', 
				'author'     => '.project-details .project-author', 
				'categories' => '.project-details .project-cats', 
				'client'     => '.project-details .project-client', 
				'date'       => '.project-details .project-date', 
				'dates'      => '.project-details .project-start-end-dates', 
				'tags'       => '.project-details .project-tags', 
				'link'       => '.project-details .btn'
			), 
			'featured_images' => array( 
				'archive'   => true, // featured image check for archive pages: true or false
				'post'      => true, // featured image check for single posts: true or false
				'page'      => true, // featured image check for pages: true or false
				'portfolio' => false  // featured image check for portfolio projects: true or false
			)
		);
	}
} // endif


if( ! function_exists( 'maxson_get_theme_font_sizes' ) )
{ 
	/**
	 * 
	 * 
	 * @return      array
	 */

	function maxson_get_theme_font_sizes()
	{ 
		return apply_filters( 'maxson_theme_font_sizes', array( 
			array( 
				'name'      => _x( 'smaller', 'Theme font size name', 'maxson' ), 
				'shortName' => _x( 'XS', 'Theme font size abbreviation', 'maxson' ), 
				'size'      => 12, 
				'slug'      => 'smaller'

			), array( 
				'name'      => _x( 'small', 'Theme font size name', 'maxson' ), 
				'shortName' => _x( 'S', 'Theme font size abbreviation', 'maxson' ), 
				'size'      => 14, 
				'slug'      => 'small'

			), array( 
				'name'      => _x( 'regular', 'Theme font size name', 'maxson' ), 
				'shortName' => _x( 'M', 'Theme font size abbreviation', 'maxson' ), 
				'size'      => 16, 
				'slug'      => 'regular'

			), array( 
				'name'      => _x( 'large', 'Theme font size name', 'maxson' ),
				'shortName' => _x( 'L', 'Theme font size abbreviation', 'maxson' ), 
				'size'      => 18, 
				'slug'      => 'large'

			), array( 
				'name'      => _x( 'larger', 'Theme font size name', 'maxson' ),
				'shortName' => _x( 'XL', 'Theme font size abbreviation', 'maxson' ), 
				'size'      => 20, 
				'slug'      => 'larger'

			)
		) );
	}
} // endif


if( ! function_exists( 'maxson_get_theme_colors' ) )
{ 
	/**
	 * 
	 * 
	 * @return      array
	 */

	function maxson_get_theme_colors()
	{ 
		apply_filters( 'maxson_theme_colors', array( 
			array( 
				'name'  => _x( 'Pink', 'Theme color name', 'maxson' ), 
				'slug'  => 'pink', 
				'color' => '#e91e63'

			), array( 
				'name'  => _x( 'Red', 'Theme color name', 'maxson' ), 
				'slug'  => 'red', 
				'color' => '#f44336'

			), array( 
				'name'  => _x( 'Deep Orange', 'Theme color name', 'maxson' ), 
				'slug'  => 'deep-orange', 
				'color' => '#ff5722'

			), array( 
				'name'  => _x( 'Orange', 'Theme color name', 'maxson' ), 
				'slug'  => 'orange', 
				'color' => '#fb8c00'

			), array( 
				'name'  => _x( 'Amber', 'Theme color name', 'maxson' ), 
				'slug'  => 'amber', 
				'color' => '#ffc107'

			), array( 
				'name'  => _x( 'Yellow', 'Theme color name', 'maxson' ), 
				'slug'  => 'yellow', 
				'color' => '#fdd835'

			), array( 
				'name'  => _x( 'Light Green', 'maxson' ), 
				'slug'  => 'light-green', 
				'color' => '#8bc34a'

			), array( 
				'name'  => _x( 'Green', 'Theme color name', 'maxson' ), 
				'slug'  => 'green', 
				'color' => '#4caf50'

			), array( 
				'name'  => _x( 'Teal', 'Theme color name', 'maxson' ), 
				'slug'  => 'teal', 
				'color' => '#009688'

			), array( 
				'name'  => _x( 'Cyan', 'Theme color name', 'maxson' ), 
				'slug'  => 'cyan', 
				'color' => '#00bcd4'

			), array( 
				'name'  => _x( 'Light Blue', 'Theme color name', 'maxson' ), 
				'slug'  => 'light-blue', 
				'color' => '#03a9f4'

			), array( 
				'name'  => _x( 'Blue', 'Theme color name', 'maxson' ), 
				'slug'  => 'blue', 
				'color' => '#039be5'

			), array( 
				'name'  => _x( 'Indigo', 'Theme color name', 'maxson' ), 
				'slug'  => 'indigo', 
				'color' => '#3f51b5'

			), array( 
				'name'  => _x( 'Purple', 'Theme color name', 'maxson' ), 
				'slug'  => 'purple', 
				'color' => '#8e24aa'

			), array( 
				'name'  => _x( 'Deep Purple', 'Theme color name', 'maxson' ), 
				'slug'  => 'deep-purple', 
				'color' => '#673ab7'

			), array( 
				'name'  => _x( 'Gray 100', 'Theme color name', 'maxson' ), 
				'slug'  => 'gray-100', 
				'color' => '#f5f5f5'

			), array( 
				'name'  => _x( 'Gray 200', 'Theme color name', 'maxson' ), 
				'slug'  => 'gray-200', 
				'color' => '#eee'

			), array( 
				'name'  => _x( 'Gray 300', 'Theme color name', 'maxson' ), 
				'slug'  => 'gray-300', 
				'color' => '#e0e0e0'

			), array( 
				'name'  => _x( 'Gray 400', 'Theme color name', 'maxson' ), 
				'slug'  => 'gray-400', 
				'color' => '#bdbdbd'

			), array( 
				'name'  => _x( 'Gray 500', 'Theme color name', 'maxson' ), 
				'slug'  => 'gray-500', 
				'color' => '#9e9e9e'

			), array( 
				'name'  => _x( 'Gray 600', 'Theme color name', 'maxson' ), 
				'slug'  => 'gray-600', 
				'color' => '#757575'

			), array( 
				'name'  => _x( 'Gray 700', 'Theme color name', 'maxson' ), 
				'slug'  => 'gray-700', 
				'color' => '#616161'

			), array( 
				'name'  => _x( 'Gray 800', 'Theme color name', 'maxson' ), 
				'slug'  => 'gray-800', 
				'color' => '#424242'

			), array( 
				'name'  => _x( 'Gray 900', 'Theme color name', 'maxson' ), 
				'slug'  => 'gray-900', 
				'color' => '#212121'

			)
		) );
	}
} // endif


if( ! function_exists( 'maxson_get_starter_content' ) )
{ 
	/**
	 * 
	 * 
	 * @return      array
	 */

	function maxson_get_starter_content()
	{ 
		return apply_filters( 'maxson_starter_content', array( 
			'posts' => array( 
				'home' => array( 
					'post_type'  => 'page', 
					'post_title' => __( 'Home', 'maxson' )
				), 
				'about' => array( 
					'post_type'  => 'page', 
					'post_title' => __( 'About', 'maxson' )
				), 
				'contact' => array( 
					'post_type'  => 'page', 
					'post_title' => __( 'Contact', 'maxson' )
				)
			), 

			// Default to a static front page and assign the front and posts pages.
			'options' => array( 
				'show_on_front' => 'page', 
				'page_on_front' => '{{home}}'
			), 

			// Set up nav menus for each of the two areas registered in the theme.
			'nav_menus' => array(
				// Assign a menu to the "top" location
				'primary' => array( 
					'name' => _x( 'Header Menu', 'Starter content menu name', 'maxson' ), 
					'items' => array( 
						'link_home', 
						'page_about', 
						'page_contact'
					)
				),

				// Assign a menu to the "social" location
				'social' => array( 
					'name' => _x( 'Social Media Menu', 'Starter content menu name', 'maxson' ), 
					'items' => array( 
						'link_facebook', 
						'link_github', 
					//	'link_google_plus', 
						'link_instagram', 
						'link_linkedin', 
						'link_twitter'
					)
				)
			)
		) );
	}
} // endif

?>