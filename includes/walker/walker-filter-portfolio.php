<?php 

// https://github.com/axelerant/mediaburn-wordpress-theme-responsive/blob/master/functions/wpzoom/components/portfolio/portfolio.php

class Portfolio_Filter_Walker extends Walker_Category { 

	function start_el( &$output, $category, $depth = 0, $args = array(), $current_object_id = 0 )
	{ 
		extract( $args );

		// This filter is documented in wp-includes/category-template.php
        $cat_name = apply_filters( 'list_cats', esc_attr( $category->name ), $category );

        // Don't generate an element if the category name is empty
        if( ! $cat_name )
        { 
        	return;

        } // endif

		$cat_title = sprintf( __( "View all projects filed under '%s'", 'maxson' ), esc_attr( $category->name ) );
		$cat_slug = strtolower( preg_replace( '/\s+/', '-', $category->slug ) );

		$link = sprintf( '<a href="%1$s" title="%2$s" data-filter="%3$s">%4$s</a>', esc_url( get_term_link( $category ) ), esc_attr( $cat_title ), esc_attr( $cat_slug ), $cat_name );

		if( isset( $show_count ) && $show_count )
		{ 
			$link .= sprintf( ' (%1$s)', intval( $category->count ) );

		} // endif


		if( 'list' == $args['style'] )
		{ 
			$css_classes = array( 
				'cat-item', 
				"cat-item-{$category->term_id}"
			);
 
 
			/**
			* Filters the list of CSS classes to include with each category in the list
			* 
			* @param array  $css_classes An array of CSS classes to be applied to each list item
			* @param object $category    Category data object
			* @param int    $depth       Depth of page, used for padding
			* @param array  $args        An array of wp_list_categories() arguments
			*/ 

			$css_classes = join( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
 
 			$output .= "\t" . sprintf( '<li class="%1$s">%2$s</li>', $css_classes, $link ) . "\n";

		} elseif ( isset( $args['separator'] ) )
		{ 
			$output .= "\t" . $link . $args['separator'] . "\n";

		} else
		{ 
			$output .= "\t" . $link . '<br>' . "\n";

		} // endif
	}

} // endclass ?>