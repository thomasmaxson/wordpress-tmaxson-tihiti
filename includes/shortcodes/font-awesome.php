<?php
/**
 * Font Awesome Shortcodes
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! class_exists( 'WP_Font_Awesome_Shortcodes' ) )
{ 
	class WP_Font_Awesome_Shortcodes { 

		public function __construct()
		{ 
			add_action( 'init', array( $this, 'add_shortcodes' ) );
		}


		public function add_shortcodes()
		{ 
		//	add_shortcode( 'fa', array( $this, 'font_awesome_shortcode_icon' ) );
		//	add_shortcode( 'icon', array( $this, 'font_awesome_shortcode_icon' ) );
			add_shortcode( 'fas', array( $this, 'font_awesome_shortcode_icon' ) );
			add_shortcode( 'far', array( $this, 'font_awesome_shortcode_icon' ) );
			add_shortcode( 'fal', array( $this, 'font_awesome_shortcode_icon' ) );
			add_shortcode( 'fab', array( $this, 'font_awesome_shortcode_icon' ) );
		}


		/**
		 * Parse data-attributes for Bootstrap shortcodes
		 * 
		 * @param       array  $data Standard WordPress shortcode attributes
		 * @return      string
		 */

		public function parse_classes( $class = '' )
		{ 
			return join( ' ', array_filter( $class, 'esc_attr' ) );
		}


		/**
		 * Container
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function font_awesome_shortcode_icon( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'type'        => '', 
				'size'        => false, 
				'pull'        => false, 
				'border'      => false, 
				'spin'        => false, 
				'list_item'   => false, 
				'fixed_width' => false, 
				'rotate'      => false, 
				'flip'        => false, 
				'stack_size'  => false, 
				'inverse'     => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$classes = array( $tag );

			$classes[] = ( $atts['type'] )        ? "fa-{$atts['type']}"   : '';
			$classes[] = ( $atts['size'] )        ? "fa-{$atts['size']}"   : '';
			$classes[] = ( $atts['pull'] )        ? "pull-{$atts['pull']}" : '';

			$classes[] = ( $atts['border'] )      ? 'fa-border' : '';
			$classes[] = ( $atts['spin'] )        ? 'fa-spin'   : '';
			$classes[] = ( $atts['list_item'] )   ? 'fa-li'     : '';
			$classes[] = ( $atts['fixed_width'] ) ? 'fa-fw'     : '';

			$classes[] = ( $atts['rotate'] )      ? "fa-rotate-{$atts['rotate']}"    : '';
			$classes[] = ( $atts['flip'] )        ? "fa-flip-{$atts['flip']}"        : '';
			$classes[] = ( $atts['stack_size'] )  ? "fa-stack-{$atts['stack_size']}" : '';

			$classes[] = ( $atts['inverse'] )     ? 'fa-inverse' : '';

			return sprintf( '<i class="%1$s" aria-hidden="true"></i>', $this->parse_classes( $classes ) );
		}

	} // endclass
} // endif

return new WP_Font_Awesome_Shortcodes();

?>