<?php
/**
 * Javascript Loader Class
 * Allow `async` and `defer` while enqueuing Javascript
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if ( ! class_exists( 'Maxson_Script_Loader' ) )
{ 
	/**
	 * A class that provides a way to add `async` or `defer` attributes to scripts
	 */

	class Maxson_Script_Loader { 

		/**
		 * Adds async/defer attributes to enqueued / registered scripts
		 * 
		 * @param       string $tag    The script tag
		 * @param       string $handle The script handle
		 * @return      string Script HTML string
		 */

		public function filter_script_loader_tag( $tag, $handle )
		{ 
			foreach( [ 'async', 'defer' ] as $attr )
			{ 
				if( ! wp_scripts()->get_data( $handle, $attr ) )
				{ 
					continue;

				} // endif

				// Prevent adding attribute when already added in #12009.
				if( ! preg_match( ":\s$attr(=|>|\s):", $tag ) )
				{ 
					$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );

				} // endif

				// Only allow async or defer, not both.
				break;
			}

			return $tag;
		}

	} // endclass
} // endif

?>