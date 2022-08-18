<?php
/**
 * Bootstrap 3.0 Shortcodes
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

// Base Code: 
// https://raw.githubusercontent.com/filipstefansson/bootstrap-3-shortcodes/master/bootstrap-shortcodes.php
// https://wordpress.org/plugins/bootstrap-3-shortcodes/


if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! class_exists( 'WP_Boostrap_Shortcodes' ) )
{ 
	class WP_Boostrap_Shortcodes { 

		public function __construct()
		{ 
			add_action( 'init', array( $this, 'add_shortcodes' ) );

		}


		public function add_shortcodes()
		{ 
			$shortcodes = array( 
				'container', 
				'row', 
				'column', 
				
				'alert', 
				'badge', 
				'panel', 
				'well', 

				'button', 
				'button_group', 
				'button_toolbar', 

				'dropdown', 
				'dropdown_item', 
				'dropdown_divider', 
				'dropdown_header', 

				'list_group', 
				'list_group_item', 
				'list_group_item_heading', 
				'list_group_item_text', 

				'media', 
				'media_body', 
				'media_object', 
				'media_left', 
				'media_right'
			);

			foreach( $shortcodes as $shortcode )
			{ 
				add_shortcode( $shortcode, array( $this, $shortcode ), 10, 3 );

				if( in_array( $shortcode, apply_filters( 'bootstrap3_shortcode_nesting_array', array( 'container', 'row', 'column' ) ) ) )
				{ 
					foreach( range( 'a', 'z' ) as $letter )
					{ 
						add_shortcode( "{$shortcode}_{$letter}", array( $this, $shortcode ), 10, 3 );

					} // endforeach
				} // endif
			} // endforeach
		}


		/**
		 * Parse data-attributes for Bootstrap shortcodes
		 * 
		 * @param       array  $data Standard WordPress shortcode attributes
		 * @return      string
		 */

		public function parse_classes( $class = '' )
		{ 
		//	$class = preg_replace( '/[^A-Za-z0-9:._-]/', '', $class );

			return join( ' ', array_filter( $class, 'esc_attr' ) );
		}


		/**
		 * Parse attributes for Bootstrap shortcodes
		 * 
		 * @param       array  $attributes Standard WordPress shortcode attributes
		 * @return      string
		 */

		public function parse_attributes( $attributes = '' )
		{ 
			$attrs = '';

			if( is_array( $attributes ) && ! empty( $attributes ) )
			{ 
				foreach( $attributes as $attr_key => $attr_value )
				{ 
					if( empty( $attr_key ) || empty( $attr_value ) )
						continue;

					$attrs .= sprintf( ' %1$s="%2$s"', $attr_key, $attr_value );

				} // endforeach
			} // endif

			return $attrs;
		}


		/**
		 * Parse data-attributes for Bootstrap shortcodes
		 * 
		 * @param       array  $data Standard WordPress shortcode attributes
		 * @return      string
		 */

		public function parse_data_attributes( $data = '' )
		{ 
			$data_props = false;

			if( $data )
			{ 
				$data = explode( '|', $data );

				foreach( $data as $d )
				{ 
					$d = explode( ',', $d );
					$data_props .= sprintf( ' data-%1$s="%2$s"', esc_html( $d[0] ), esc_attr( trim( $d[1] ) ) );

				} // endforeach
			} // endif

			return $data_props;
		}


		/**
		 * Container
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function container( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class' => false, 
				'data'  => false, 
				'fluid' => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( $atts['class'] );

			$class[] = ( $atts['fluid'] == 'true' ) ? 'container-fluid' : 'container';

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<div class="%1$s"%2$s>%3$s</div>', $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * Row
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function row( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class' => false, 
				'data'  => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'row', $atts['class'] );

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<div class="%1$s"%2$s>%3$s</div>', $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * Column
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function column( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class'     => false, 
				'data'      => false, 

				'xs'        => false, 
				'offset-xs' => false, 
				'pull-xs'   => false, 
				'push-xs'   => false, 

				'sm'        => false, 
				'offset-sm' => false, 
				'pull-sm'   => false, 
				'push-sm'   => false, 

				'md'        => false, 
				'offset-md' => false, 
				'pull-md'   => false, 
				'push-md'   => false, 

				'lg'        => false, 
				'offset-lg' => false, 
				'pull-lg'   => false, 
				'push-lg'   => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( $atts['class'] );

			$class[] = ( $atts['xs'] )                                      ? "col-xs-{$atts['xs']}" : '';
			$class[] = ( $atts['offset-xs'] || $atts['offset-xs'] === '0' ) ? "col-xs-offset-{$atts['offset-xs']}" : '';
			$class[] = ( $atts['push-xs'] || $atts['push-xs'] === '0' )     ? "col-xs-push-{$atts['push-xs']}" : '';
			$class[] = ( $atts['pull-xs'] || $atts['pull-xs'] === '0' )     ? "col-xs-pull-{$atts['pull-xs']}" : '';

			$class[] = ( $atts['sm'] )                                      ? "col-sm-{$atts['sm']}" : '';
			$class[] = ( $atts['offset-sm'] || $atts['offset-sm'] === '0' ) ? "col-sm-offset-{$atts['offset-sm']}" : '';
			$class[] = ( $atts['push-sm'] || $atts['push-sm'] === '0' )     ? "col-sm-push-{$atts['push-sm']}" : '';
			$class[] = ( $atts['pull-sm'] || $atts['pull-sm'] === '0' )     ? "col-sm-pull-{$atts['pull-xs']}" : '';

			$class[] = ( $atts['md'] )                                      ? "col-md-{$atts['md']}" : '';
			$class[] = ( $atts['offset-md'] || $atts['offset-md'] === '0' ) ? "col-md-offset-{$atts['offset-md']}" : '';
			$class[] = ( $atts['push-md'] || $atts['push-md'] === '0' )     ? "col-md-push-{$atts['push-md']}" : '';
			$class[] = ( $atts['pull-md'] || $atts['pull-md'] === '0' )     ? "col-md-pull-{$atts['pull-md']}" : '';

			$class[] = ( $atts['lg'] )                                      ? "col-lg-{$atts['lg']}" : '';
			$class[] = ( $atts['offset-lg'] || $atts['offset-lg'] === '0' ) ? "col-lg-offset-{$atts['offset-lg']}" : '';
			$class[] = ( $atts['push-lg'] || $atts['push-lg'] === '0' )     ? "col-lg-push-{$atts['push-lg']}" : '';
			$class[] = ( $atts['pull-lg'] || $atts['pull-lg'] === '0' )     ? "col-lg-pull-{$atts['pull-lg']}" : '';

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );
				
			return sprintf( '<div class="%1$s"%2$s>%3$s</div>', $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * Alert
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function alert( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'type'        => 'success', 
				'class'       => false, 
				'data'        => false, 
				'dismissable' => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'alert', "alert-{$atts['type']}", $atts['class'] );

			if( $atts['dismissable'] == 'true' )
			{ 
				$class[] = 'alert-dismissable';

				$content .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';

			} // endif

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<div class="%1$s" role="alert"%2$s>%2$s</div>', $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * Badge
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		function badge( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class' => false, 
				'data'  => false, 
				'right' => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'badge', $atts['class'] );

			if( $atts['right'] == 'true' )
				$class[] = 'pull-right';

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<span class="%1$s"%2$s>%3$s</span>', $classes, $data_props, do_shortcode( $content ) );
		}


  		/**
		 * Button
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function button( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class'    => false, 
				'data'     => false, 

				'link'     => '#', 
				'title'    => '', 
				'target'   => '_self', 

				'type'     => 'default', 
				'active'   => false, 
				'block'    => false, 
				'disabled' => false, 
				'dropdown' => false, 
				'size'     => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'btn', "btn-{$atts['type']}", $atts['class'] );

			if( filter_var( $atts['active'], FILTER_VALIDATE_BOOLEAN ) )
				$class[] = 'active';

			if( filter_var( $atts['block'], FILTER_VALIDATE_BOOLEAN ) )
				$class[] = 'btn-block';

			if( filter_var( $atts['disabled'], FILTER_VALIDATE_BOOLEAN ) )
				$class[] = 'disabled';

			if( filter_var( $atts['dropdown'], FILTER_VALIDATE_BOOLEAN ) )
				$class[] = 'dropdown-toggle';

			if( $atts['size'] )
				$class[] = "btn-{$atts['size']}";

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			$title = ( $atts['title'] ) ? sprintf( ' title="%1$s"', esc_attr( $atts['title'] ) ) : false;

			return sprintf( '<a href="%1$s" target="%2$s" class="%3$s"%4$s%5$s>%6$s</a>', esc_url( $atts['link'] ), esc_attr( $atts['target'] ), $classes, $title, $data_props, do_shortcode( $content ) );
		}


		/**
		 * Button group
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function button_group( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class'     => false, 
				'data'      => false, 

				'size'      => false, 
				'dropup'    => false, 
				'vertical'  => false, 
				'justified' => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'btn-group', $atts['class'] );

			$args['size'] = filter_var( $args['size'], FILTER_VALIDATE_BOOLEAN );

			if( $atts['size'] )
				$class[] = "btn-group-{$atts['size']}";

			$args['vertical'] = filter_var( $args['vertical'], FILTER_VALIDATE_BOOLEAN );

			if( $atts['vertical'] )
				$class[] = 'btn-group-vertical';

			$args['justified'] = filter_var( $args['justified'], FILTER_VALIDATE_BOOLEAN );

			if( $atts['justified'] )
				$class[] = 'btn-group-justified';

			$args['dropup'] = filter_var( $args['dropup'], FILTER_VALIDATE_BOOLEAN );

			if( $atts['dropup'] )
				$class[] = 'dropup';

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<div class="%1$s" role="group"%2$s>%2$s</div>', $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * Button toolbar
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function button_toolbar( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class' => false, 
				'data'  => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'btn-toolbar', $atts['class'] );

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<div class="%1$s" role="toolbar"%2$s>%3$s</div>', $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * Dropdown
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function dropdown( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class' => false, 
				'data'  => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'dropdown-menu', $atts['class'] );

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<ul role="menu" class="%1$s"%2$s>%3$s</ul>', $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * Dropdown item
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function dropdown_item( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'link'     => '', 
				'disabled' => false, 
				'class'    => false, 
				'data'     => false, 
				'li_class' => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class    = array( $atts['class'] );
			$li_class = array( $atts['li_class'] );

			if( $atts['disabled'] == 'true' )
				$li_class[] = 'disabled';

			$classes    = $this->parse_classes( $class );
			$li_classes = $this->parse_classes( $li_class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			$output  = sprintf( '<li role="presentation" class="%1$s">', $li_classes );
			$output .= sprintf( '<a role="menuitem" href="%1$s" class="%2$s"%3$s>%4$s</a>', esc_url( $atts['link'] ), $classes, $data_props, do_shortcode( $content ) );
			$output .= '</li>';

			return $output;
		}


		/**
		 * Dropdown divider
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function dropdown_divider( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class'  => false, 
				'data'   => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'divider', $atts['class'] );

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<li class="%1$s"%2$s>%3$s</li>', $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * Dropdown header
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function dropdown_header( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class'  => false, 
				'data'   => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'dropdown-header', $atts['class'] );

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<li class="%1$s"%2$s>%3$s</li>', $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * List group
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function list_group( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class'  => false, 
				'data'   => false, 
				'linked' => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$tag = ( $atts['linked'] == 'true' ) ? 'div' : 'ul';

			$class = array( 'list-group', $atts['class'] );

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<%1$s class="%2$s"%3$s>%4$s</%1$s>', $tag, $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * List group item
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function list_group_item( $atts, $content = null )
		{ 
			$defaults = array( 
				'class'    => false, 
				'data'     => false, 
				'type'     => false, 
				'link'     => false, 
				'target'   => '_self', 
				'active'   => false, 
				'disabled' => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$tag = ( ! empty( $atts['link'] ) ) ? 'a' : 'li';

			$class = array( 'list-group-item', $atts['class'] );

			if( $atts['type'] )
				$class[] = "list-group-item-{$atts['type']}";

			if( $atts['active'] == 'true' )
				$class[] = 'active';

			if( $atts['disabled'] == 'true' )
				$class[] = 'disabled';

			$attributes = array();

			$attributes['class'] = $this->parse_classes( $class );

			if( $atts['link'] )
			{ 
				$attributes['href'] = esc_url( $atts['link'] );
				$attributes['target'] = esc_attr( $atts['target'] );

			} // endif

			$attr_props = $this->parse_attributes( $attributes );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<%1$s %2$s %3$s>%4$s</%1$s>', $tag, $attr_props, $data_props, do_shortcode( $content ) );
		}


		/**
		 * List group item heading
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function list_group_item_heading( $atts, $content = null )
		{ 
			$defaults = array( 
				'class'  => false, 
				'data'   => false, 
				'tag'    => 'h4'
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'list-group-item-heading', $atts['class'] );

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<%1$s class="%2$s"%3$s>%4$s</%1$s>', $atts['tag'], $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * List group item text
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function list_group_item_text( $atts, $content = null )
		{ 
			$defaults = array( 
				'class'  => false, 
				'data'   => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'list-group-item-text', $atts['class'] );

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<p class="%1$s"%2$s>%3$s</p>', $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * Media
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function media( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class' => false, 
				'data'  => false
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'media', $atts['class'] );

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<div class="%1$s"%2$s>%3$s</div>', $classes, $data_props, do_shortcode( $content ) );
		}


		/**
		 * Media body
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function media_body( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class' => false, 
				'data'  => false, 
				'title' => ''
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( 'media-body', $atts['class'] );

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<div class="%1$s"%2$s>%3$s</div>', $classes, $data_props, do_shortcode( wpautop( $content ) ) );
		}


		/**
		 * Media object
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function media_object( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class' => false, 
				'data'  => false, 
				'align' => 'left', 
				'tag'   => 'div'
			);

			$atts = shortcode_atts( $defaults, $atts );

			$class = array( "media-{$atts['align']}", $atts['class'] );

			if( ! in_array( $atts['tag'], apply_filters( 'bootstrap3_shortcode_valid_media_object_tags', array( 'div', 'span', 'figure' ) ) ) )
				$atts['tag'] = $defaults['tag'];

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<%1$s class="%2$s"%3$s>%4$s</%1$s>', $atts['tag'], $classes, $data_props, do_shortcode( wpautop( $content ) ) );
		}


		/**
		 * Media object, left
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function media_left( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class' => false, 
				'data'  => false, 
				'tag'   => 'div'
			);

			$atts = shortcode_atts( $defaults, $atts );

			$atts['align'] = 'left';

			return $this->media_object( $atts, $content, $tag );
		}


		/**
		 * Media object, right
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function media_right( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class' => false, 
				'data'  => false, 
				'tag'   => 'div'
			);

			$atts = shortcode_atts( $defaults, $atts );

			$atts['align'] = 'right';

			return $this->media_object( $atts, $content, $tag );
		}


		/**
		 * Panel
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function panel( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class'   => false, 
				'data'    => false, 
				'type'    => 'default', 
				'title'   => false, 
				'heading' => false, 
				'footer'  => false
			);

			$atts = shortcode_atts( $defaults, $atts );
 
			$class = array( 'panel', "panel-{$atts['type']}", $atts['class'] );

		//	if( $atts['heading'] )
		//		$atts['heading'] = sprintf( '<div class="panel-heading">%1$s</div>', $atts['heading'] );

			if( ! $atts['heading'] && $atts['title'] )
			{ 
				$atts['heading'] = $atts['title'];
				$atts['title'] = true;

			} // endif


			$heading = '';

			if( $atts['heading'] )
			{ 
				$heading_output = ( $atts['title'] ) ? sprintf( '<h3 class="panel-title">%1$s</h3>', $atts['heading'] ) : $atts['heading'];

				$heading = sprintf( '<div class="panel-heading">%s%s%s</div>', esc_html( $heading_output ) );

			} // endif

			if( $atts['footer'] )
				$atts['footer'] = sprintf( '<div class="panel-footer">%1$s</div>', $atts['footer'] );

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<div class="%1$s"%2$s>%3$s<div class="panel-body">%4$s</div>%5$s</div>', $classes, $data_props, $heading, do_shortcode( wpautop( $content ) ), $atts['footer'] );
		}


		/**
		 * Well
		 * 
		 * @param       array  $atts    Standard WordPress shortcode attributes
		 * @param       array  $content The enclosed content
		 * @param       array  $tag     The shortcode being called
		 * @return      string
		 */

		public function well( $atts, $content = null, $tag )
		{ 
			$defaults = array( 
				'class'   => false, 
				'data'    => false, 
				'size'    => false
			);

			$atts = shortcode_atts( $defaults, $atts );
 
			$class = array( 'well', $atts['class'] );

			if( $atts['size'] )
				$class[] = "well-{$atts['size']}";

			$classes    = $this->parse_classes( $class );
			$data_props = $this->parse_data_attributes( $atts['data'] );

			return sprintf( '<div class="%1$s"%2$s>%3$s</div>', $classes, $data_props, do_shortcode( $content ) );
		}

	} // endclass
} // endif

return new WP_Boostrap_Shortcodes();

?>