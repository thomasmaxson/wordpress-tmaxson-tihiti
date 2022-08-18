<?php
/**
 * Theme Extras, Post Details
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! function_exists( 'maxson_post_details_inline_styles' ) )
{ 
	/**
	 * The function to include Post Details in a theme's stylesheet
	 * 
	 * @return     void
	 */

	function maxson_post_details_inline_styles()
	{ 
		// Make sure we can proceed
		list( $can_run, $options, $definied, $post_details ) = maxson_post_details_can_run();

		if( ! $can_run )
		{ 
			return;

		} // endif

		list( $opt_author, $opt_categories, $opt_comment, $opt_date, $opt_tags ) = $options;
		list( $def_author, $def_categories, $def_comment, $def_date, $def_tags ) = $definied;

		$elements = array();

		// If author option is unticked, add it to the list of classes
		if( true != $opt_author && ! empty( $def_author ) )
		{ 
			$elements[] = $def_author;

		} // endif

		// If categories option is unticked, add it to the list of classes
		if( true != $opt_categories && ! empty( $def_categories ) )
		{ 
			$elements[] = $def_categories;

		} // endif

		// If comment option is unticked, add it to the list of classes
		if( true != $opt_comment && ! empty( $def_comment ) )
		{ 
			$elements[] = $def_comment;

		} // endif

		// If date option is unticked, add it to the list of classes
		if( true != $opt_date && ! empty( $def_date ) )
		{ 
			$elements[] = $def_date;

		} // endif

		// If tags option is unticked, add it to the list of classes
		if( true != $opt_tags && ! empty( $def_tags ) )
		{ 
			$elements[] = $def_tags;

		} // endif

		// Get the list of classes
		$elements = join( ', ', $elements );

		if( ! empty( $elements ) )
		{ 
			// Hide the classes with CSS
			$css = $elements . ' { clip: rect( 1px, 1px, 1px, 1px ); position: absolute; width: 1px; height: 1px; overflow: hidden;}';

			// Add the CSS to the stylesheet
			wp_add_inline_style( $post_details['stylesheet'], $css );

		} // endif
	}
} // endif
//add_action( 'wp_enqueue_scripts', 'maxson_post_details_inline_styles', 999 );


if( ! function_exists( 'maxson_post_details_body_classes' ) )
{ 
	/**
	 * Adds custom classes to the array of body classes
	 * 
	 * @return     array
	 */

	function maxson_post_details_body_classes( $classes )
	{ 
		// Make sure we can proceed.
		list( $can_run, $options, $definied ) = maxson_post_details_can_run();

		if( ! $can_run )
		{ 
			return $classes;

		} // endif

		list( $opt_author, $opt_categories, $opt_comment, $opt_date, $opt_tags ) = $options;
		list( $def_author, $def_categories, $def_comment, $def_date, $def_tags ) = $definied;

		// If author option is unchecked, add a class to the body
		if( true != $opt_author && ! empty( $def_author ) )
		{ 
			$classes[] = 'hide-post-author';

		} // endif

		// If categories option is unchecked, add a class to the body
		if( true != $opt_categories && ! empty( $categories ) )
		{ 
			$classes[] = 'hide-post-categories';

		} // endif

		// If comment option is unchecked, add a class to the body
		if( true != $opt_comment && ! empty( $def_comment ) )
		{ 
			$classes[] = 'hide-post-comment-link';

		} // endif

		// If date option is unchecked, add a class to the body
		if( true != $opt_date && ! empty( $date ) )
		{ 
			$classes[] = 'hide-post-date';

		} // endif

		// If tags option is unchecked, add a class to the body
		if( true != $opt_tags && ! empty( $tags ) )
		{ 
			$classes[] = 'hide-post-tags';

		} // endif

		return $classes;
	}
} // endif
// add_filter( 'body_class', 'maxson_post_details_body_classes' );


if( ! function_exists( 'maxson_post_details_can_run' ) )
{ 
	/**
	 * Determines if Post Details should run
	 * 
	 * @return     array
	 */

	function maxson_post_details_can_run()
	{ 
		// Empty value representing a false return value
		$void = array( false, false, false, false );

		// If the theme doesn't support content options, don't continue
		if( ! current_theme_supports( 'maxson-content-options' )  || ! is_singular() )
		{ 
			return $void;

		} // endif

		$options      = get_theme_support( 'maxson-content-options' );
		$_details = ( ! empty( $options[0]['post_details'] ) ) ? $options[0]['post_details'] : array();

		// If the theme doesn't support 'maxson-content-options[ 'post-details' ]', don't continue
		if( empty( $_details ) )
		{ 
			return $void;

		} // endif

		$_layout = get_option( 'maxson_layout_post_details', array() );

		$opt_author     = ( isset( $_layout['author'] ) )     ? $_layout['author']     : false;
		$opt_categories = ( isset( $_layout['categories'] ) ) ? $_layout['categories'] : false;
		$opt_client     = ( isset( $_layout['comment'] ) )    ? $_layout['comment']    : false;
		$opt_date       = ( isset( $_layout['date'] ) )       ? $_layout['date']       : false;
		$opt_tags       = ( isset( $_layout['tags'] ) )       ? $_layout['tags']       : false;

		$_options  = array( $opt_author, $opt_categories, $opt_comment, $opt_date, $opt_tags );

		$def_author     = ( ! empty( $_details['author'] ) )     ? $_details['author']     : false;
		$def_categories = ( ! empty( $_details['categories'] ) ) ? $_details['categories'] : false;
		$def_comment    = ( ! empty( $_details['comment'] ) )    ? $_details['comment']    : false;
		$def_date       = ( ! empty( $_details['date'] ) )       ? $_details['date']       : false;
		$def_tags       = ( ! empty( $_details['tags'] ) )       ? $_details['tags']       : false;

		
		$_definied = array( $def_author, $def_categories, $def_comment, $def_date, $def_tags );

		// If all the options are ticked, don't continue
		if( array( 1, 1, 1, 1, 1 ) == $_options )
		{ 
			return $void;

		} // endif

		return array( true, $_options, $_definied, $_details );
	}
} // endif


if( ! function_exists( 'maxson_project_details_inline_styles' ) )
{ 
	/**
	 * The function to include Post Details in a theme's stylesheet
	 * 
	 * @return     void
	 */

	function maxson_project_details_inline_styles()
	{ 
		// Make sure we can proceed
		list( $can_run, $options, $definied, $project_details ) = maxson_project_details_can_run();

		if( ! $can_run )
		{ 
			return;

		} // endif

		list( $opt_author, $opt_categories, $opt_client, $opt_date, $opt_dates, $opt_tags, $opt_link ) = $options;
		list( $def_author, $def_categories, $def_client, $def_date, $def_dates, $def_tags, $def_link ) = $definied;

		$elements = array();

		// If author option is unticked, add it to the list of classes
		if( true != $opt_author && ! empty( $def_author ) )
		{ 
			$elements[] = $def_author;

		} // endif

		// If categories option is unticked, add it to the list of classes
		if( true != $opt_categories && ! empty( $def_categories ) )
		{ 
			$elements[] = $def_categories;

		} // endif

		// If client option is unticked, add it to the list of classes
		if( true != $opt_client && ! empty( $def_client ) )
		{ 
			$elements[] = $def_client;

		} // endif

		// If date option is unticked, add it to the list of classes
		if( true != $opt_date && ! empty( $def_date ) )
		{ 
			$elements[] = $def_date;

		} // endif

		// If dates option is unticked, add it to the list of classes
		if( true != $opt_dates && ! empty( $def_dates ) )
		{ 
			$elements[] = $def_dates;

		} // endif

		// If tags option is unticked, add it to the list of classes
		if( true != $opt_tags && ! empty( $def_tags ) )
		{ 
			$elements[] = $def_tags;

		} // endif

		// If comment option is unticked, add it to the list of classes
		if( true != $opt_link && ! empty( $def_link ) )
		{ 
			$elements[] = $def_link;

		} // endif

		// Get the list of classes
		$elements = join( ', ', $elements );

		if( ! empty( $elements ) )
		{ 
			// Hide the classes with CSS
			$css = $elements . ' { clip: rect( 1px, 1px, 1px, 1px ); position: absolute; width: 1px; height: 1px; overflow: hidden;}';

			// Add the CSS to the stylesheet
			wp_add_inline_style( $project_details['stylesheet'], $css );

		} // endif
	}
} // endif
add_action( 'wp_enqueue_scripts', 'maxson_project_details_inline_styles', 999 );


if( ! function_exists( 'maxson_project_details_body_classes' ) )
{ 
	/**
	 * Adds custom classes to the array of body classes
	 * 
	 * @return     array
	 */

	function maxson_project_details_body_classes( $classes )
	{ 
		// Make sure we can proceed.
		list( $can_run, $options, $definied ) = maxson_project_details_can_run();

		if( ! $can_run )
		{ 
			return $classes;

		} // endif

		list( $opt_author, $opt_categories, $opt_client, $opt_date, $opt_dates, $opt_tags, $opt_link ) = $options;
		list( $def_author, $def_categories, $def_client, $def_date, $def_dates, $def_tags, $def_link ) = $definied;

		// If author option is unchecked, add a class to the body
		if( true != $opt_author && ! empty( $def_author ) )
		{ 
			$classes[] = 'hide-project-author';

		} // endif

		// If categories option is unchecked, add a class to the body
		if( true != $opt_categories && ! empty( $def_categories ) )
		{ 
			$classes[] = 'hide-project-categories';

		} // endif

		// If client option is unchecked, add a class to the body
		if( true != $opt_client && ! empty( $def_client ) )
		{ 
			$classes[] = 'hide-project-client';

		} // endif

		// If date option is unchecked, add a class to the body
		if( true != $opt_date && ! empty( $def_date ) )
		{ 
			$classes[] = 'hide-project-date';

		} // endif

		// If dates option is unchecked, add a class to the body
		if( true != $opt_dates && ! empty( $def_dates ) )
		{ 
			$classes[] = 'hide-project-dates';

		} // endif

		// If tags option is unchecked, add a class to the body
		if( true != $opt_tags && ! empty( $def_tags ) )
		{ 
			$classes[] = 'hide-project-tags';

		} // endif

		// If comment option is unchecked, add a class to the body
		if( true != $opt_link && ! empty( $def_link ) )
		{ 
			$classes[] = 'hide-project-link';

		} // endif

		return $classes;
	}
} // endif
add_filter( 'body_class', 'maxson_project_details_body_classes' );


if( ! function_exists( 'maxson_project_details_can_run' ) )
{ 
	/**
	 * Determines if Project Details should run
	 * 
	 * @return     array
	 */

	function maxson_project_details_can_run()
	{ 
		// Empty value representing a false return value
		$void = array( false, false, false, false );

		// If the theme doesn't support content options, don't continue
		if( ! current_theme_supports( 'maxson-content-options' ) || ! is_singular( 'portfolio_project' ) )
		{ 
			return $void;

		} // endif

		$project_options = get_theme_support( 'maxson-content-options' );
		$_details = ( ! empty( $project_options[0]['project_details'] ) ) ? $project_options[0]['project_details'] : array();

		// If the theme doesn't support 'maxson-content-options[ 'project-details' ]', don't continue
		if( empty( $_details ) )
		{ 
			return $void;

		} // endif

		$_layout = get_option( 'maxson_layout_project_details', array() );

		$opt_author     = ( isset( $_layout['author'] ) )     ? $_layout['author']     : false;
		$opt_categories = ( isset( $_layout['categories'] ) ) ? $_layout['categories'] : false;
		$opt_client     = ( isset( $_layout['client'] ) )     ? $_layout['client']     : false;
		$opt_date       = ( isset( $_layout['date'] ) )       ? $_layout['date']       : false;
		$opt_dates      = ( isset( $_layout['dates'] ) )      ? $_layout['dates']      : false;
		$opt_tags       = ( isset( $_layout['tags'] ) )       ? $_layout['tags']       : false;
		$opt_link       = ( isset( $_layout['link'] ) )       ? $_layout['link']       : false;

		$_options  = array( $opt_author, $opt_categories, $opt_client, $opt_date, $opt_dates, $opt_tags, $opt_link );


		$def_author     = ( ! empty( $_details['author'] ) )     ? $_details['author']     : false;
		$def_categories = ( ! empty( $_details['categories'] ) ) ? $_details['categories'] : false;
		$def_client     = ( ! empty( $_details['client'] ) )     ? $_details['client']     : false;
		$def_date       = ( ! empty( $_details['date'] ) )       ? $_details['date']       : false;
		$def_dates      = ( ! empty( $_details['dates'] ) )      ? $_details['dates']      : false;
		$def_tags       = ( ! empty( $_details['tags'] ) )       ? $_details['tags']       : false;
		$def_link       = ( ! empty( $_details['link'] ) )       ? $_details['link']       : false;

		$_definied = array( $def_author, $def_categories, $def_client, $def_date, $def_dates, $def_tags, $def_link );


		// If all the options are ticked, don't continue
		if( array( 1, 1, 1, 1, 1, 1, 1 ) == $_options )
		{ 
			return $void;

		} // endif

		return array( true, $_options, $_definied, $_details );
	}
} // endif

?>
