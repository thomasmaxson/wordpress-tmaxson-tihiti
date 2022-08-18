<?php 
/**
 * Theme Shortcodes
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! function_exists( 'maxson_shortcode_year' ) )
{ 
	/**
	 * Year shortcode
	 * 
	 * @return      string
	 */

	function maxson_shortcode_year( $atts )
	{ 
		$defaults = array( 
			'format' => 'Y'
		);

		$args = shortcode_atts( $defaults, $atts );

		return date( $args['format'] );
	}
} // endif
add_shortcode( 'year', 'maxson_shortcode_year' );
add_shortcode( 'date', 'maxson_shortcode_year' );


if( ! function_exists( 'maxson_privacy_link_shortcode' ) )
{ 
	/**
	 * Display privacy policy link
	 * 
	 * @param       array  $atts    Standard WordPress shortcode attributes
	 * @param       array  $content The enclosed content
	 * @param       array  $tag     The shortcode being called
	 * @return      string
	 */

	function maxson_privacy_link_shortcode( $atts, $content = null, $tag )
	{ 
		if( ! function_exists( 'get_the_privacy_policy_link' ) )
		{ 
			return false;

		} // endif

		$defaults = array( 
			'before' => '', 
			'after'  => ''
		);

		$args = shortcode_atts( $defaults, $atts, $tag );

		return get_the_privacy_policy_link( $args['before'], $args['after'] );
	}
} // endif
add_shortcode( 'privacy', 'maxson_privacy_link_shortcode', 10, 3 );
add_shortcode( 'privacy_url', 'maxson_privacy_link_shortcode', 10, 3 );
add_shortcode( 'privacy_link', 'maxson_privacy_link_shortcode', 10, 3 );
add_shortcode( 'privacy_policy', 'maxson_privacy_link_shortcode', 10, 3 );


if( ! function_exists( 'maxson_bloginfo_shortcode' ) )
{ 
	/**
	 * Display bloginfo data
	 * 
	 * @param       array  $atts    Standard WordPress shortcode attributes
	 * @param       array  $content The enclosed content
	 * @param       array  $tag     The shortcode being called
	 * @return      string
	 */

	function maxson_bloginfo_shortcode( $atts, $content = null, $tag )
	{ 
		$defaults = array( 
			'info'   => '', 
			'filter' => 'raw'
		);

		$args = shortcode_atts( $defaults, $atts, $tag );

		if( empty( $args['info'] ) )
		{ 
			return false;

		} // endif

		$default_bloginfo = array( 'name', 'desc', 'description', 'wpurl', 'url', 'admin_email', 'charset', 'version', 'html_type', 'text_direction', 'language', 'stylesheet_url', 'stylesheet_directory', 'template_url', 'template_directory', 'pingback_url', 'atom_url', 'rdf_url', 'rss_url', 'rss2_url', 'comments_atom_url', 'comments_rss2_url', 'siteurl', 'home' );

		if( ! in_array( $args['info'], $default_bloginfo ) )
		{ 
			return false;

		} // endif

		if( 'desc' == $args['info'] )
		{ 
			$args['info'] = 'description';

		} // endif

		return get_bloginfo( $args['info'], $args['filter'] );
	}
} // endif
add_shortcode( 'blog', 'maxson_bloginfo_shortcode', 10, 3 );
add_shortcode( 'bloginfo', 'maxson_bloginfo_shortcode', 10, 3 );


if( ! function_exists( 'maxson_shortcode_email_antispambot' ) )
{ 
	/**
	 * Anti-spambot shortcode
	 * 
	 * @param       array  $atts    Standard WordPress shortcode attributes
	 * @param       array  $content The enclosed content
	 * @param       array  $tag     The shortcode being called
	 * @return      string
	 */

	function maxson_shortcode_email_antispambot( $atts, $content = null, $tag )
	{ 
		$attrs = '';

		$defaults = array( 
			'email' => get_option( 'admin_email' ), 
			'link'  => true, 
			'rel'   => 'no-follow', 
            'title' => false, 
			'class' => 'email-address'
		);

		$atts = shortcode_atts( $defaults, $atts );

		if( empty( $atts['email'] ) )
		{ 
			return false;

		} // endif

		$email = antispambot( $atts['email'] );

		$attrs .= ( true == filter_var( $atts['class'], FILTER_VALIDATE_BOOLEAN ) ) ? sprintf( ' class="%1$s"', $atts['class'] ) : '';

		$text = ( ! empty( $content ) ) ? do_shortcode( $content ) : $email;

		if( true == filter_var( $atts['link'], FILTER_VALIDATE_BOOLEAN ) )
		{ 
			return sprintf( '<span%1$s>%2$s</span>', $attrs, $text );

		} else
		{ 
			$attrs .= ( true == filter_var( $atts['title'], FILTER_VALIDATE_BOOLEAN ) ) ? sprintf( ' title="%1$s"', $atts['title'] ) : '';
			$attrs .= ( true == filter_var( $atts['rel'], FILTER_VALIDATE_BOOLEAN ) )   ? sprintf( ' rel="%1$s"', $atts['rel'] )     : '';

			return sprintf( '<a href="%1$s"%2$s>%3$s</a>', "mailto:{$email}", $attrs, $text );

		} // endif
	}
} // endif
add_shortcode( 'email', 'maxson_shortcode_email_antispambot');
add_shortcode( 'email_address', 'maxson_shortcode_email_antispambot');


if( ! function_exists( 'maxson_shortcode_skill' ) )
{ 
	/**
	 * Display CV block
	 * 
	 * @param       array  $atts    WordPress shortcode attributes
	 * @param       array  $content The enclosed content
	 * @param       array  $tag     The shortcode being called
	 * @return      string
	 */

	function maxson_shortcode_skill( $atts = array(), $content = null, $tag )
	{ 
		$skills_array   = maxson_get_skills();
		$skills_options = get_theme_mod( 'maxson_skills', array() );

		$defaults = array( 
			'type' => false, 
			'icon' => false
		);

		$atts = shortcode_atts( $defaults, $atts );

		$key = $atts['type'];

		$output  = '<p class="skill-details">';

			if( ! empty( $atts['icon'] ) )
			{ 
				$output .= sprintf( '<i class="%1$s" aria-hidden="true"></i>', $atts['icon'] );

			} // endif

			$output .= sprintf( '<span class="skill-percentage">%1$s</span>', $skills_options[ $key ] );
		$output .= '</p>';
		$output .= sprintf( '<h4 class="h3 skill-title">%1$s</h4>', $skills_array[ $key ] );

		return sprintf( '<div class="skill" id="skill-%1$s">%2$s</div>', $key, $output );
	}
} // endif
add_shortcode( 'skill', 'maxson_shortcode_skill', 10, 3 );


if( ! function_exists( 'maxson_shortcode_cv_block' ) )
{ 
	/**
	 * Display CV block
	 * 
	 * @param       array  $atts    WordPress shortcode attributes
	 * @param       array  $content The enclosed content
	 * @param       array  $tag     The shortcode being called
	 * @return      string
	 */

	function maxson_shortcode_cv_block( $atts = array(), $content = null, $tag )
	{ 
		if( is_null( $content ) )
		{
			return false;

		} // endif

		$output = '';

		$defaults = array( 
			'class'   => false, 
			'title'   => false, 
			'company' => false, 
			'date'    => false
		);

		$atts = shortcode_atts( $defaults, $atts );

		$class = ( ! empty( $atts['class'] ) ) ? join( ' ', array( 'cv-block', $atts['class'] ) ) : 'cv-block';

		$content = apply_filters( 'the_content', $content );

		$date = sprintf( '<span class="badge badge-default cv-block-duration">%1$s</span>', $atts['date'] );

		if( ! empty( $atts['title'] ) )
		{ 
			$output .= sprintf( '<h4 class="h3 cv-block-heading"><strong>%1$s</strong></h4>', $atts['title'] );

		} // endif

		if( ! empty( $atts['company'] ) )
		{ 
			$output .= sprintf( '<p class="cv-block-company">%1$s %2$s</p>', $atts['company'], $date );

		} // endif

		$output .= sprintf( '<div class="cv-block-body">%1$s</div>', $content );

		return sprintf( '<div class="%1$s">%2$s</div>', $class, $output );
	}
} // endif
add_shortcode( 'cv_block', 'maxson_shortcode_cv_block', 10, 3 );

?>