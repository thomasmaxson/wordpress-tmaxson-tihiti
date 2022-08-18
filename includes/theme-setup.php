<?php
/**
 * Theme Setup
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! function_exists( 'maxson_content_width' ) )
{ 
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet
	 * Priority 0 to make it available to lower priority callbacks
	 * 
	 * @return      int $content_width
	 */

	function maxson_content_width()
	{ 
		$GLOBALS['content_width'] = apply_filters( 'bootstrap_content_width', 1170 );
	}
} // endif
add_action( 'after_setup_theme', 'maxson_content_width', 0 );


if( ! function_exists( 'maxson_language_attributes' ) )
{ 
	/** 
	 * Clean up language_attributes() used in <html> tag
	 * Change lang="en-US" to lang="en"
	 * Remove dir="ltr"
	 * 
	 * @return      string
	 */

	function maxson_language_attributes()
	{ 
		$attributes = array();
		$output = '';

		if( function_exists( 'is_rtl' ) )
		{ 
			if( is_rtl() == 'rtl' )
			{ 
				$attributes[] = 'dir="rtl"';

			} // endif
		} // endif

		$lang = get_bloginfo( 'language' );

		if( $lang && $lang !== 'en-US' )
		{ 
			$attributes[] = sprintf( 'lang="%1$s"', $lang );

		} else 
		{ 
			$attributes[] = 'lang="en"';

		} // endif

		if( is_single() )
		{ 
			$schema_type = 'Article';

		} else if( is_page() && ! is_front_page() )
		{ 
			if( maxson_is_core_page( 'contact' ) )
			{ 
				$schema_type = 'ContactPage';

			} elseif( maxson_is_core_page( 'about' ) )
			{ 
				$schema_type = 'AboutPage';

			} elseif( maxson_is_core_page( 'blog' ) )
			{ 
				$schema_type = 'Blog';

			} else 
			{ 
				$schema_type = 'WebPage';

			} // endif
		} elseif( is_search() )
		{ 
			$schema_type = 'SearchResultsPage';

		} elseif( is_author() )
		{ 
			$schema_type = 'ProfilePage';

		} else
		{ 
			$schema_type = 'WebPage';

		} // endif

		$attributes[] = 'itemscope';
		$attributes[] = sprintf( 'itemtype="%1$s"', esc_attr( "http://schema.org/{$schema_type}" ) );

		$output = apply_filters( 'maxson_language_attributes', $output );
		$output = join( ' ', $attributes );

		return $output;
	}
} // endif
add_filter( 'language_attributes', 'maxson_language_attributes' );


if( ! function_exists( 'maxson_add_header_scripts' ) )
{ 
	/**
	 * Add custom code in <head>
	 * 
	 * @return      void
	 */

	function maxson_add_header_scripts()
	{ 
		if( is_admin() || is_feed() || is_robots() || is_trackback() )
		{ 
			return;

		} // endif

		$option = get_option( 'maxson_scripts_header', false );

		if( ! empty( $option ) && trim( $option ) != '' )
		{ 
			echo stripslashes( $option ) . "\n\n";

		} // endif
	}
} // endif
add_action( 'wp_head', 'maxson_add_header_scripts' );


if( ! function_exists( 'maxson_header_meta' ) )
{ 
	/**
	 * Add <head> specific meta information
	 * 
	 * @return      void
	 */

	function maxson_header_meta()
	{ 
		global $pagenow;

		if( is_feed() || is_robots() || is_trackback() )
		{ 
			return;

		} // endif

		$output = array();

		$brand_color   = maxson_get_theme_brand_default_color();
		$version       = apply_filters( 'meta_query_version', '1' );
		$path          = apply_filters( 'meta_asset_path', get_template_directory_uri() . '/assets/images/favicon' );

		$favicon_sizes = apply_filters( 'favicon_icon_sizes', array( '196', '194', '160', '96', '32', '16' ) );
		$ios_sizes     = apply_filters( 'ios_icon_sizes', array( '57', '114', '72', '144', '60', '120', '76', '152', '180' ) );

		$webapp_capable    = get_theme_mod( 'maxson_web_app_capable', true );
		$webapp_icon_title = get_theme_mod( 'maxson_web_app_icon_title', get_bloginfo( 'name', 'display' ) );
		$webapp_bar_style  = get_theme_mod( 'maxson_web_app_status_bar', '' );


		if( ! is_admin() && $pagenow !== 'wp-login.php' )
		{ 
			if( is_singular() && pings_open() )
			{ 
				$output[] = sprintf( '<link rel="pingback" href="%s">', get_bloginfo( 'pingback_url' ) );

			} // endif

			$output[] = sprintf( '<meta http-equiv="cleartype" content="%1$s">', apply_filters( 'meta_clear_type', 'on' ) );
			$output[] = sprintf( '<meta http-equiv="imagetoolbar" content="%1$s">', apply_filters( 'meta_image_toolbar', 'no' ) );
			$output[] = sprintf( '<meta name="MobileOptimized" content="%1$s">', apply_filters( 'meta_mobile_optimized', '320' ) );
			$output[] = sprintf( '<meta name="HandheldFriendly" content="%1$s">', apply_filters( 'meta_handheld_friendly', 'True' ) );
			$output[] = sprintf( '<meta name="viewport" content="%1$s">', apply_filters( 'meta_responsive_viewport', 'width=device-width, initial-scale=1.0, user-scalable=no, shrink-to-fit=no' ) );
			$output[] = sprintf( '<meta name="theme-color" content="%1$s">', apply_filters( 'meta_theme_color', $brand_color ) );

		} // endif

		if( ! has_site_icon() )
		{ 
			$output[] = sprintf( '<link rel="manifest" href="%1$s">', add_query_arg( array( 'v' => $version ), $path . '/manifest.json' ) );

			if( ! empty( $favicon_sizes ) && is_array( $favicon_sizes ) )
			{ 
				foreach( $favicon_sizes as $size )
				{ 
					$img_size = "{$size}x{$size}";
					$img_path = sprintf( '%1$s/favicon-%2$s.png', $path, $img_size );
					$img_src  = add_query_arg( array( 'v' => $version ), $img_path );

					$output[] = sprintf( '<link rel="icon" type="image/png" sizes="%1$s" href="%2$s">', $img_size, $img_src );

				} // endforeach
			} // endif

			$output[] = sprintf( '<!--[if IE]><link rel="shortcut icon" href="%1$s"><![endif]-->', add_query_arg( array( 'v' => $version ), "{$path}/favicon.ico" ) );

			if( ! empty( $ios_sizes ) && is_array( $ios_sizes ) )
			{ 
				foreach( $ios_sizes as $size )
				{ 
					$img_size = "{$size}x{$size}";
					$img_path = sprintf( '%1$s/apple-touch-icon-%2$s.png', $path, $img_size );
					$img_src  = add_query_arg( array( 'v' => $version ), $img_path );

					$output[] = sprintf( '<link rel="apple-touch-icon" sizes="%1$s" href="%2$s">', $img_size, $img_src );

				} // endforeach
			} // endif

			//	$output[] = sprintf( '<link rel="mask-icon" href="%1$s">', add_query_arg( array( 'v' => $version ), $path . '/safari-pinned-tab.svgsafari-pinned-tab.svg' ), apply_filters( 'meta_safari_pinned_tab_color', $brand_color ) );

			$output[] = sprintf( '<meta name="msapplication-TileColor" content="%1$s">', apply_filters( 'meta_tile_color', $brand_color ) );
			$output[] = sprintf( '<meta name="msapplication-TileImage" content="%1$s">', add_query_arg( array( 'v' => $version ), $path . '/mstile-144x144.png' ) );
			$output[] = sprintf( '<meta name="msapplication-config" content="%1$s">', add_query_arg( array( 'v' => $version ), $path . '/browserconfig.xml' ) );

		} // enidf


		if( ! empty( $webapp_capable ) )
		{ 
			$output[] = '<meta name="apple-mobile-web-app-capable" content="yes">';
			$output[] = sprintf( '<meta name="apple-mobile-web-app-status-bar-style" content="%1$s">', $webapp_bar_style );
			$output[] = sprintf( '<meta name="apple-mobile-web-app-title" content="%1$s">', $webapp_icon_title );
			$output[] = sprintf( '<meta name="application-name" content="%1$s">', $webapp_icon_title );

		} // endif

		echo join( "\r\n", $output ) . "\r\n";
	}
} // endif
add_action( 'wp_head', 'maxson_header_meta', 9999 );
add_action( 'login_head', 'maxson_header_meta', 9999 );
add_action( 'admin_head', 'maxson_header_meta', 9999 );


if( ! function_exists( 'maxson_add_footer_scripts' ) )
{ 
	/**
	 * Add custom code before </body>
	 * 
	 * @return      void
	 */

	function maxson_add_footer_scripts()
	{ 
		if( is_admin() || is_feed() || is_robots() || is_trackback() )
		{ 
			return;

		} // endif

		if( apply_filters( 'maxson_add_jquery_fallback', true ) )
		{ 
			$jquery_version = maxson_get_version_jquery();
			$jquery_src     = get_theme_file_uri( "assets/js/vendor/jquery-{$jquery_version}.min.js" );

		//	echo '<!-- jQuery Fallback -->' . "\n";
		//	echo '<script>window.jQuery || document.write( \'<script src="' . $jquery_src . '"><\/script>\' );</script>' . "\n\n";

		} // endif

		$option = get_option( 'maxson_scripts_footer', false );

		if( ! empty( $option ) && trim( $option ) != '' )
		{ 
			echo stripslashes( $option ) . "\n\n";

		} // endif
	}
} // endif
add_action( 'wp_footer', 'maxson_add_footer_scripts' );


if( ! function_exists( 'maxson_add_footer_meta' ) )
{ 
	/**
	 * Add information before </body>
	 * 
	 * @return      void
	 */

	function maxson_add_footer_meta()
	{ 
		if( is_user_logged_in() && ! is_preview() && ! is_customize_preview() )
		{ 
			$theme = ( function_exists( 'wp_get_theme' ) ) ? wp_get_theme() : get_current_theme();
				$name    = $theme->get( 'Name' );
				$version = $theme->get( 'Version' );

			$queries  = get_num_queries();
			$duration = timer_stop( 0, 3 );
			$memory   = ( memory_get_peak_usage() / 1024 / 1024 );

			echo '<!-- ';
			printf( __( '%1$s (v%2$s) loaded %3$s queries in %4$s seconds, using %5$sMB memory.', 'maxson' ), $name, $version, $queries, $duration, $memory );
			echo ' -->';

		} // endif
	}
} // endif
add_action( 'wp_footer', 'maxson_add_footer_meta', 9999 );


if( ! function_exists( 'maxson_remove_admin_menus' ) )
{ 
	/**
	 * Remove admin menu items
	 * 
	 * @return      void
	 */

	function maxson_remove_admin_menus()
	{ 
		remove_menu_page( 'link-manager.php' );
	}
} // endif
add_action( 'admin_menu', 'maxson_remove_admin_menus' );


if( ! function_exists( 'maxson_body_class' ) )
{ 
	/**
	 * Add classes to the array of body classes.
	 * 
	 * @return      array
	 */

	function maxson_body_class( $wp_classes )
	{ 
		global $post;
		$post_type = isset( $post ) ? $post->post_type : false;

		$classes = array();

		// Add class to sites with more than 1 published author
		if( is_multi_author() )
		{ 
			$classes[] = 'is-group-blog';

		} // endif


		// Check whether we're singular
		if( is_singular() )
		{ 
			$classes[] = 'singular';

		} // endif


		// Check whether we're in the customizer preview
		if( is_customize_preview() )
		{ 
			$classes[] = 'customize-preview';

		} // endif


		// Check for post thumbnail
		if( is_singular() && has_post_thumbnail() )
		{ 
			$classes[] = 'has-post-thumbnail';

		} elseif( is_singular() )
		{ 
			$classes[] = 'missing-post-thumbnail';

		} // endif


		// Check if posts have single pagination
		if( is_single() && ( get_next_post() || get_previous_post() ) )
		{ 
			$classes[] = 'has-single-pagination';

		} else
		{ 
			$classes[] = 'has-no-pagination';

		} // endif


		// Check if we're showing comments
		if( $post && ( ( 'post' === $post_type || comments_open() || get_comments_number() ) && ! post_password_required() ) )
		{ 
			$classes[] = 'showing-comments';

		} else
		{ 
			$classes[] = 'not-showing-comments';

		} // endif


		// Check if avatars are visible
		if( get_option( 'show_avatars' ) )
		{ 
			$classes[] = 'show-avatars';

		} else
		{ 
			$classes[] = 'hide-avatars';

		} // endif


		// Check if footer should be trapdoor style
		if( maxson_is_footer_fixed() )
		{ 
			$classes[] = 'footer-fixed';

		} // endif


		// Check for sidebar position
		$sidebar_position = get_theme_mod( 'maxson_layout', 'none' );

		$classes[] = "sidebar-{$sidebar_position}";


		$output = array_merge( $wp_classes, $classes );

		return array_unique( $output );
	}
} // endif
add_filter( 'body_class', 'maxson_body_class' );


if( ! function_exists( 'maxson_allow_schema_markup' ) )
{ 
	/**
	 * Allows Schema.org attributes to be added to HTML tags in the editor (but not for comments).
	 * 
	 * @return      array
	 */

	function maxson_allow_schema_markup()
	{ 
		global $allowedposttags;

		foreach( $allowedposttags as $tag => $attr )
		{ 
			$attr['itemscope'] = array();
			$attr['itemtype'] = array();
			$attr['itemprop'] = array();

			$allowedposttags[$tag] = $attr;
		}

		return $allowedposttags;
	}
} // endif
add_action( 'init', 'maxson_allow_schema_markup' );


if( ! function_exists( 'maxson_register_sidebars' ) )
{ 
	/**
	 * Register and load the widgets, with support for overriding the widget via a child theme
	 * Remove injected widget CSS
	 * Load Theme Sidebars for Widgets
	 * 
	 * @return      void
	 */

	function maxson_register_sidebars()
	{ 
		global $wp_widget_factory;

		// Remove injected CSS from recent comments widget
		if( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) )
		{ 
			remove_action( 'wp_head', array( 
				$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'
			) );

		} // endif

		add_filter( 'show_recent_comments_widget_style', '__return_false' );

//		unregister_widget( 'WP_Nav_Menu_Widget' );
//		unregister_widget( 'WP_Widget_Archives' );
//		unregister_widget( 'WP_Widget_Calendar' );
//		unregister_widget( 'WP_Widget_Categories' );
//		unregister_widget( 'WP_Widget_Links' );
//		unregister_widget( 'WP_Widget_Meta' );
//		unregister_widget( 'WP_Widget_Pages' );
//		unregister_widget( 'WP_Widget_Recent_Comments' );
//		unregister_widget( 'WP_Widget_Recent_Posts' );
//		unregister_widget( 'WP_Widget_RSS' );
//		unregister_widget( 'WP_Widget_Search' );
//		unregister_widget( 'WP_Widget_Tag_Cloud' );
		unregister_widget( 'WP_Widget_Text' );
//		unregister_widget( 'Twenty_Eleven_Ephemera_Widget' );

//		unregister_widget( 'WP_Widget_Media' ); // WordPress 4.8
//		unregister_widget( 'WP_Widget_Media_Audio' ); // WordPress 4.8
//		unregister_widget( 'WP_Widget_Media_Image' ); // WordPress 4.8
//		unregister_widget( 'WP_Widget_Media_Video' ); // WordPress 4.8

		unregister_widget( 'WP_Widget_Custom_HTML' ); // WordPress 4.8.1


		register_sidebar( array( 
			'name'          => __( 'Primary Sidebar', 'maxson' ), 
			'id'            => 'primary_sidebar', 
			'before_widget' => '<div class="widget %2$s">', 
			'after_widget'  => '</div>', 
			'before_title'  => '<h3 class="h3 widget-title">', 
			'after_title'   => '</h3>'
		) );

		register_sidebar( array( 
			'name'          => __( 'Footer, Copyright Information', 'maxson' ), 
			'description'   => __( 'Add widgets here to appear in the left side of your footer.', 'maxson' ), 
			'id'            => 'footer_left_sidebar', 
			'before_widget' => '<div id="%1$s" class="col-xs-12 col-md-6 widget %2$s">', 
			'after_widget'  => '</div>', 
			'before_title'  => '<h3 class="h3 widget-title">', 
			'after_title'   => '</h3>'
		) );

		register_sidebar( array( 
			'name'          => __( 'Footer, Social Media', 'maxson' ), 
			'description'   => __( 'Add widgets here to appear in the right side of your footer.', 'maxson' ), 
			'id'            => 'footer_right_sidebar', 
			'before_widget' => '<div id="%1$s" class="pull-right col-xs-12 col-md-6 widget %2$s">', 
			'after_widget'  => '</div>', 
			'before_title'  => '<h3 class="h3 widget-title">', 
			'after_title'   => '</h3>'
		) );
	}
} // endif
add_action( 'widgets_init', 'maxson_register_sidebars' );


if( ! function_exists( 'maxson_wordpress_cleanup' ) )
{ 
	/**
	 * Remove inline CSS used by posts with galleries
	 * Remove unnecessary <link> tag's
	 * 
	 * @return      void
	 */

	function maxson_wordpress_cleanup()
	{ 
		// This theme uses its own Gallery styles, remove WordPress default styles
		add_filter( 'use_default_gallery_style', '__return_false' );

		// Script replaces htmlenities with actual characters they represent
		remove_action( 'wp_head', 'l10n' );

		// Remove link to the RSD service endpoint, EditURI link
		remove_action( 'wp_head', 'rsd_link' );

		// Remove meta tag with WordPress version
		remove_action( 'wp_head', 'wp_generator' );

		// Displays tag within the head pointing to the single blog url
	//	remove_action( 'wp_head', 'rel_canonical' );

		// Might be necessary if you or other people on this site use Windows Live Writer.
		remove_action( 'wp_head', 'wlwmanifest_link' );

		// Displays the links to the general feeds: Post and Comment Feed
	//	remove_action( 'wp_head', 'feed_links', 2 );

		// Displays the links to the extra feeds such as category feeds
	//	remove_action( 'wp_head', 'feed_links_extra', 3 );

		// Displays the shortened SEO version of URL
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );

		// Displays relations link for site index
	//	remove_action( 'wp_head', 'index_rel_link' );

		// Start link
	//	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

		// Previous link
	//	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

		// Displays relational links for the posts adjacent to the current post.
	//	remove_action( 'wp_head', 'adjacent_posts_rel_link' );

		// Remove Emoji styles and scripts
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}
} // endif
add_action( 'init', 'maxson_wordpress_cleanup' );


if( ! function_exists( 'maxson_theme_generator_type' ) )
{ 
	/**
	 * Filter the generator tag type
	 * 
	 * @param       string $generator_type The XHTML generator
	 * @return      string
	 */

	function maxson_theme_generator_type( $generator_type )
	{ 
		if( current_theme_supports( 'html5' ) )
		{ 
			$generator_type = 'html';

		} // endif

		return $generator_type;
	}
} // endif
add_filter( 'wp_generator_type', 'maxson_theme_generator_type' );


if( ! function_exists( 'maxson_set_excerpt_length' ) )
{ 
	/**
	 * Change excerpt length for default posts
	 * 
	 * @param       int $length Length of excerpt in number of words
	 * @return      int
	 */

	function maxson_set_excerpt_length( $length )
	{ 
		$default = 30;
		$option  = get_theme_mod( 'maxson_excerpt_length', $default );

		if( $option >= 0 )
		{ 
			$length = absint( $option );

		} else
		{ 
			$length = $default;

		} // endif

		return apply_filters( 'maxson_excerpt_length', $length );
	}
} // endif
add_filter( 'excerpt_length', 'maxson_set_excerpt_length' );


if( ! function_exists( 'maxson_set_excerpt_more' ) )
{ 
	/**
	 * Change excerpt more text for posts
	 * 
	 * @param       string $more_text Excerpt more text
	 * @return      string
	 */

	function maxson_set_excerpt_more( $more_text )
	{ 
		$option = get_theme_mod( 'maxson_excerpt_more', '[...]' );

		return apply_filters( 'maxson_excerpt_more', $option );
	}
} // endif
add_filter( 'excerpt_more', 'maxson_set_excerpt_more' );


if( ! function_exists( 'maxson_set_content_more' ) )
{ 
	/**
	 * Replace "[...]" with Read More
	 * 
	 * @return      string
	 */

	function maxson_set_content_more()
	{ 
		$option = get_theme_mod( 'maxson_excerpt_more', '[...]' );

		return sprintf( '<a href="%1$s" class="more-link">%2$s</a>', esc_url( get_permalink() ), $option );
	}
} // endif
add_filter( 'the_content_more_link', 'maxson_set_content_more' );


if( ! function_exists( 'maxson_remove_more_link_scroll' ) )
{ 
	/**
	 * Prevents scroll on Read More links
	 * 
	 * @return      string
	 */

	function maxson_remove_more_link_scroll( $link )
	{ 
		$link = preg_replace( '|#more-[0-9]+|', '', $link );

		return $link;
	}
} // endif
add_filter( 'the_content_more_link', 'maxson_remove_more_link_scroll' );


/**
 * Move wpautop() filter to AFTER shortcode is processed
 * 
 * @return      string
 */

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99 );
add_filter( 'the_content', 'shortcode_unautop', 100 );


if( ! function_exists( 'maxson_shortcode_empty_paragraph_fix' ) )
{ 
	/**
	 * Fix filtering for shortcodes
	 * 
	 * @return      string
	 */

	function maxson_shortcode_empty_paragraph_fix( $content )
	{ 
		$array = array( 
			'<p>['    => '[', 
			']</p>'   => ']', 
			']<br />' => ']'
		);

		$content = strtr( $content, $array );

		return $content;
	}
} // endif
add_filter( 'the_content', 'maxson_shortcode_empty_paragraph_fix' );


if( ! function_exists( 'maxson_html5_remove_self_closing_tags' ) )
{ 
	/**
	 * Remove unnecessary self-closing tags
	 * 
	 * @return      string
	 */

	function maxson_html5_remove_self_closing_tags( $input )
	{ 
		return str_replace( array( ' />', '/>' ), '>', $input );
	}
} // endif
add_filter( 'get_avatar', 'maxson_html5_remove_self_closing_tags' ); // <img />
add_filter( 'comment_id_fields', 'maxson_html5_remove_self_closing_tags' ); // <input />
add_filter( 'post_thumbnail_html', 'maxson_html5_remove_self_closing_tags' ); // <img />
add_filter( 'image_send_to_editor', 'maxson_html5_remove_self_closing_tags', 10, 8 ); // <img />


/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */


if( ! function_exists( 'maxson_modify_nav_menu_class' ) )
{ 
	/**
	 * Modify menu to include first/last class
	 * 
	 * @return      array
	 */

	function maxson_modify_nav_menu_class( $items, $args )
	{ 
		if( $args->theme_location !== 'primary' )
		{ 
			return $items;

		} // endif

	//	global $post;

	//	$post_id = ( $post ) ? $post->ID : 0;
		$core_id = maxson_get_core_page_id( 'contact' );

		foreach( $items as $item )
		{ 
			$page_id = get_post_meta( $item->ID, '_menu_item_object_id', true );

			$item->classes[] = ( $page_id == $core_id ) ? 'menu-item-button' : 'menu-item-link';

		} // endforeach

		$items[1]->classes[] = 'menu-item-first';
		$items[ count( $items ) ]->classes[] = 'menu-item-last';

		return $items;
	}
} // endif
add_filter( 'wp_nav_menu_objects', 'maxson_modify_nav_menu_class', 10, 2 );


/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */

if( ! function_exists( 'maxson_thumbnail_sizes_attr' ) )
{ 
	/**
	 * Add custom image sizes attribute to enhance responsive image functionality for post thumbnails
	 * 
	 * @param       string       $sizes         A source size value for use in a 'sizes' attribute
     * @param       array|string $size          Requested size. Image size or array of width and height values in pixels (in that order)
     * @param       string|null  $image_src     The URL to the image file or null
     * @param       array|null   $image_meta    The image meta data as returned by wp_get_attachment_metadata() or null
     * @param       int          $attachment_id Image attachment ID of the original image or 0
     * @return      string A source size value for use in a post thumbnail 'sizes' attribute
	 */

	function maxson_thumbnail_sizes_attr( $sizes, $size, $image_src, $image_meta, $attachment_id )
	{ 
	//	if( ! in_array( $size, array( 'project_thumbnail', 'project_medium', 'project_large' ) ) )
	//	{ 
	//		return $sizes;

	//	} // endif

		if( ( is_portfolio_archive() || is_project() ) && $size[0] <= 360 )
		{ 
			$teaser_count = get_option( 'maxson_project_teaser_column_count', '3' );
			$bootstrap_lg = maxson_get_bootstrap_breakpoint( 'lg' );
			$bootstrap_md = maxson_get_bootstrap_breakpoint( 'md' );
			$bootstrap_sm = maxson_get_bootstrap_breakpoint( 'sm' );

			switch( $teaser_count )
			{ 
				case 1: 
					$size_lg = '1140px';
					$size_md = '940px';
					$size_sm = '370px';
					break;

				case 2: 
					$size_lg = '555px';
					$size_md = '454px';
					$size_sm = '370px';
					break;

				case 4: 
					$size_lg = '263px';
					$size_md = '212px';
					$size_sm = '370px';
					break;

				case 6: 
					$size_lg = '165px';
					$size_md = '131px';
					$size_sm = '370px';
					break;

				case 3: 
				default: 
					$size_lg = '360px';
					$size_md = '293px';
					$size_sm = '370px';
					break;

			} // endswitch

			$sizes = sprintf( '(min-width: %1$s) %2$s, (min-width: %3$s) %4$s, (min-width: %5$s) %6$s, calc(100vw - 30px)', $bootstrap_lg, $size_lg, $bootstrap_md, $size_md, $bootstrap_sm, $size_sm );

		} // endif

		return $sizes;
	}
} // endif
add_filter( 'wp_calculate_image_sizes', 'maxson_thumbnail_sizes_attr', 10, 5 );


// Portfolio Projects by Maxson
// Edit image by clicking on gallery thumbnail
add_filter( 'maxson_portfolio_gallery_meta_box_thumbnail_can_edit', '__return_true' );


// Force NOT a test environment
// add_filter( 'maxson_portfolio_site_is_test_environment', '__return_false' );


if( ! function_exists( 'maxson_theme_project_gallery_image_picture' ) )
{ 
	/**
	 * 
	 * 
	 * @return      array
	 */

	function maxson_theme_project_gallery_image_picture( $image, $attachment_id, $img_args )
	{ 
		$sizes = array( 
			array( 
				'breakpoint' => maxson_get_media_breakpoint( 0 ), 
				'size'       => 'project_gallery_th'

			), 
			array( 
				'breakpoint' => maxson_get_media_breakpoint( '320px' ), 
				'size'       => 'project_gallery_sm'

			), 
			array( 
				'breakpoint' => maxson_get_media_breakpoint( '760px' ), 
				'size'       => 'project_gallery_md'

			), 
			array( 
				'breakpoint' => maxson_get_media_breakpoint( '990px' ), 
				'size'       => 'project_gallery_lg'

			)
		);

		$pic_args = array( 
			'class' => 'picture-responsive project-thumbnail wp-post-picture img-centered'
		);

		$image = maxson_get_the_attachment_picture( 'project_gallery_lg', $sizes, $attachment_id, $pic_args, $img_args );

		return $image;
	}
} // endif
add_filter( 'maxson_portfolio_media_gallery_image', 'maxson_theme_project_gallery_image_picture', 10, 3 );


/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */

add_filter( 'wpcf7_autop_or_not', '__return_false' );


add_filter( 'wpcf7_form_elements', 'do_shortcode' );


if( ! function_exists( 'maxson_wpcf7_form_elements' ) )
{ 
	/**
	 * Filter the form response output
	 * 
	 * @param       $output 
	 * @return      $output
	 */

	function maxson_wpcf7_form_elements( $output )
	{ 
		$output = do_shortcode( $output );

		// Add Bootstrap "form-control" class
		$html_tags   = array( 'input',  'select', 'textarea' );
		$input_types = array( 'date', 'datetime', 'datetime-local', 'email', 'hidden', 'month', 'number', 'password', 'tel', 'text', 'time', 'url', 'week' );
		$input_class = 'form-control';

		foreach( $html_tags as $html_tag )
		{ 
			if( 'input' == $html_tag )
			{ 
				foreach( $input_types as $input_type )
				{ 
					$output = preg_replace( '/(<' . $html_tag . '.*? type="' . $input_type . '".*? class=".*?)(".*?\/>)/', "$1 {$input_class} $2", $output );

				} // endforeach
			} else
			{ 
				$output = preg_replace( '/(<' . $html_tag . '.*? class=".*?)(".*?>)/', "$1 {$input_class} $2", $output );

			} // endif
		} // endforeach

		return $output;
	}
} // endif
add_filter( 'wpcf7_form_elements', 'maxson_wpcf7_form_elements', 10 );


/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */


// Yoast SEO
// Hide version number (premium only)
add_filter( 'wpseo_hide_version', '__return_true' );


/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */
/** --------------------------------------------------------------------------------- */


// W3 Total Cache
// Hide source code message
add_filter( 'w3tc_process_content', '__return_false' );


?>