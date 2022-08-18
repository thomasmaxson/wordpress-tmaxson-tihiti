<?php
/**
 * Custom nav walker
 *
 * Custom nav walker to assign icons to menu items.
 */

class WP_Nav_Walker_Social_Media extends Walker_Nav_Menu
{ 
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
	{ 
		$href = ( ! empty( $item->url ) ) ? trailingslashit( $item->url ) : false;

		$details = maxson_query_social_icon_details_via_url( $href );

		$item_output = '';

		if( ! empty( $details ) )
		{ 
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

		//	$title = strtolower( apply_filters( 'the_title', $item->title, $item->ID ) );

			$atts = array( 
				'href'       => $href, 
				'target'     => ( ! empty( $item->target ) ) ? $item->target : '', 
				'rel'        => ( ! empty( $item->xfn ) )    ? $item->xfn    : '', 
				'title'      => ( ! empty( $item->title ) )  ? $item->title  : $details['title'], 
				'class'      => "btn btn-sq btn-rounded btn-outline btn-{$details['key']}", 
				'itemprop'   => 'url', 
			//	'tabindex'   => '-1', 
				'aria-label' => $details['title']
			);

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach( $atts as $attr => $value )
			{ 
				if( ! empty( $value ) )
				{ 
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';

				} // endif
			} // endforeach

			$item_output .= $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= '<i class="' . $details['icon'] . '" aria-hidden="true"></i>';
			$item_output .= '</a>';
			$item_output .= $args->after;

		} // endif

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}