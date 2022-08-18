<?php 
/**
 * Theme Functions
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! function_exists( 'maxson_get_section_title' ) )
{ 
	/**
	 * Get section title
	 * 
	 * @param       array $args An array of arguments
	 * @return      bool|string
	 */

	function maxson_get_section_title( $args = array() )
	{ 
		$defaults = array( 
			'href'   => '#', 
			'text'   => null, 
			'hidden' => false
		);

		$args = wp_parse_args( $args, $defaults );

		extract( $args );

		// Bail out if no text present
		if( empty( $text ) || is_null( $text ) )
		{ 
			return false;

		} // endif


		$classes = array( 'h2', 'section-title' );

		if( true == filter_var( $hidden, FILTER_VALIDATE_BOOLEAN ) )
		{
			$classes[] = 'sr-only';

		} // endif


		$link = maxson_build_html_output( 'a', $text, array( 
			'href'       => $href, 
			'class'      => 'jump-link', 
			'title'      => __( "Link to section '{$text}'", 'maxson' ), 
			'aria-label' => $text
		) );

		return sprintf( '<h2 class="%1$s">%2$s</h2>', join( ' ', $classes ), $link );
	}
} // endif


if( ! function_exists( 'maxson_the_section_title' ) )
{ 
	function maxson_the_section_title( $args = array() )
	{ 
		echo maxson_get_section_title( $args );
	}
} // endif


if( ! function_exists( 'maxson_get_intro_section' ) )
{ 
	/** 
	 * Get intro section
	 * 
	 * @return      bool|string
	 */

	function maxson_get_intro_section()
	{ 
		$item_id = get_the_ID();

		if( is_post_type_archive() )
		{ 
			if( is_post_type_archive( 'portfolio_project' ) )
			{ 
				$item_id = ''; // maxson_portfolio_get_archive_page_id();
				$title   = ''; // post_type_archive_title( '', false );
				$tagline = ''; // get_field( '_tagline', $item_id );

			} else
			{ 
				$title   = post_type_archive_title( '', false );
				$tagline = get_field( '_tagline', $item_id );

			} // endif
		} elseif( is_tax() || is_category() || is_tag() )
		{ 
			$title   = single_term_title( '', false );
			$tagline = get_field( '_tagline', $item_id );

		} elseif( is_singular() || is_page() )
		{ 
			$title   = get_the_title();
			$tagline = get_field( '_tagline', $item_id );

		} elseif( is_404() )
		{ 
			$title   = __( 'Error 404', 'maxson' );
			$tagline = __( "Oops! You've landed on a URL that doesn't seem to exist.", 'maxson' );

		} else
		{ 
			$title   = __( 'Archives', 'maxson' );
			$tagline = false;

		} // endif

		$output = '<section class="intro" id="intro">';
			$output .= '<div class="container">';
				$output .= maxson_build_html_output( 'h1', $title, array( 
					'class' => 'sr-only h1'
				) );

				$output .= '<div class="page-header">';
					$output .= '<header class="page-header-content">';
						$output .= maxson_build_html_output( 'p', $title, array( 
							'class' => 'page-title'
						) );

						if( ! empty( $tagline ) )
						{ 
							$formatted_tagline = apply_filters( 'the_content', $tagline );

							$output .= maxson_build_html_output( 'div', $formatted_tagline, array( 
								'class' => 'page-subtitle'
							) );

						} // endif
					$output .= '</header>';
				$output .= '</div>';
		
			//	if( is_home() || is_front_page() )
				if( is_post_type_archive( 'portfolio_project' ) )
				{ 
					$output .= maxson_build_html_output( 'a', false, array( 
						'href'        => '#teasers', 
						'class'       => 'scroll-wheel scroll-wheel-inverse', 
						'tabindex'    => '-1', 
						'aria-hidden' => 'true'
					) );

				} // endif

			$output .= '</div>';
		$output .= '</section>';

		return $output;
	}
} // endif


if( ! function_exists( 'maxson_the_intro_section' ) )
{ 
	/** 
	 * Output intro section
	 * 
	 * @return      string
	 */

	function maxson_the_intro_section()
	{ 
		echo maxson_get_intro_section();
	}
}





if( ! function_exists( 'maxson_get_cta_button' ) )
{ 
	/** 
	 * Output call to action button
	 * 
	 * @return      bool|string
	 */

	function maxson_get_cta_button()
	{ 
		global $post;

		if( is_404() )
		{ 
			return false;

		} // endif

			
		$options = get_theme_mod( 'maxson_call_to_action', array() );
			$show = ( isset( $options['show'] ) && ! empty( $options['show'] ) ) ? $options['show'] : false;

		if( ! empty( $show ) )
		{ 
			$post_id = ( $post ) ? $post->ID : 0;

			$attrs = ( isset( $options['attr'] ) && ! empty( $options['attr'] ) ) ? $options['attr'] : false;

			if( empty( $attrs['id'] ) )
			{ 
				return false;

			} // endif

			// Do not show on same page as link
			if( $post_id == $attrs['id'] && apply_filters( 'maxson_cta_button_hide_on_same_page', true ) )
			{ 
				return false;

			} // endif

			$label = ( isset( $options['label'] ) && ! empty( $options['label'] ) ) ? $options['label'] : get_the_title( $attrs['id'] );

			$link_attrs = apply_filters( 'maxson_cta_button_attributes', array( 
				'href'   => get_permalink( $attrs['id'] ), 
				'class'  => 'btn btn-lg btn-block btn-primary btn-cta', 
				'id'     => "link-call-to-action-{$attrs['id']}", 
				'title'  => $label
			//	'target' => '', // Added afterwards with WordPress links_add_target() function
			//	'rel'    => '', // Added afterwards with WordPress wp_rel_nofollow() function
			) );

			$link = maxson_build_html_output( 'a', $label, $link_attrs );

			// Add target attribute
		//	if( isset( $attrs['target'] ) && ! empty( $attrs['target'] ) )
			if( true == filter_var( $attrs['target'], FILTER_VALIDATE_BOOLEAN ) )
			{ 
				$link = links_add_target( $link );

			} // endif

			// Add rel attribute
		//	if( isset( $attrs['rel'] ) && ! empty( $attrs['rel'] ) )
			if( true == filter_var( $attrs['rel'], FILTER_VALIDATE_BOOLEAN ) )
			{ 
			//	$link = stripslashes( wp_rel_nofollow( $link ) );
				$link = preg_replace( '/(<a )/', '<a rel="nofollow noopener" ', $link );

			} // endif

			return $link;

		} else
		{ 
			return false;

		} // endif
	}
} // endif

if( ! function_exists( 'maxson_the_cta_button' ) )
{ 
	function maxson_the_cta_button()
	{ 
		echo maxson_get_cta_button();
	}
} // endif

?>