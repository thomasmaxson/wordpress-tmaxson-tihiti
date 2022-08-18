<?php
/**
 * Add custom customizer controls
 * 
 * @package	WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since	  1.0
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) )
{ 
	die;

} // endif


if( class_exists( 'WP_Customize_Control' ) )
{ 
	if( ! class_exists( 'Maxson_Customize_Control' ) )
	{ 
		/**
		 * Class to create a custom control
		 */

		class Maxson_Customize_Control extends WP_Customize_Control
		{ 
			public function __construct( $manager, $id, $args = array(), $options = array() )
			{ 
				parent::__construct( $manager, $id, $args );
			}


			/**
			 * Render the field label
			 */

			public function _get_label()
			{ 
				if( ! empty( $this->label ) )
				{ 
					printf( '<span class="customize-control-title">%1$s</span>', wp_kses_post( $this->label ) );

				} // endif
			}


			/**
			 * Render the field description
			 */

			public function _get_description()
			{ 
				if( ! empty( $this->description ) )
				{ 
					$allowed_html = array( 
						'a'      => array( 
							'href'   => array(), 
							'title'  => array(), 
							'class'  => array(), 
							'target' => array()
						), 
						'br'     => array(), 
						'em'     => array(), 
						'strong' => array(),
						'i'      => array( 
							'class' => array()
						), 
						'span'   => array( 
							'class' => array()
						), 
						'code'   => array()
					);

					printf( '<span class="description customize-control-description">%1$s</span>', wp_kses( $this->description, $allowed_html ) );

				} // endif
			} 


			/**
			 * Render the select option
			 */

			public function _get_option( $id = null, $label = null, $args = array() )
			{ 
				$attributes = false;

				$defaults = array( 
					'value' => $id
				);

				$attrs = wp_parse_args( $args, $defaults );

				foreach( $attrs as $key => $value )
				{ 
					if( is_int( $key ) )
					{ 
						$attributes .= " {$key}";

					} else
					{ 
						$attributes .= sprintf( ' %s="%s"', $key, esc_attr( $value ) );

					} // endif
				} // endforeach

				$attributes .= selected( $this->value(), $id, false );

				printf( '<option%1$s>%2$s</option>', $attributes, $label );
			}


			/**
			 * Retrieve option none label
			 */

			public function _get_option_none_label()
			{ 
				return _x( '&ndash; Select One &ndash;', 'Default dropdown label', 'maxson' );
			}

		} // endclass
	} // endif


	if( ! class_exists( 'Maxson_Customize_Arbitrary_Control' ) )
	{ 
		/**
		 * Class to create a custom control
		 */

		class Maxson_Customize_Arbitrary_Control extends Maxson_Customize_Control { 

			/**
			 * Declare the control type
			 */

			public $type = 'maxson_arbitrary';


			/**
			 * Render the control's content
			 * Allows the content to be overridden without having to rewrite the wrapper
			 */

			public function render_content()
			{ 
				switch( $this->type )
				{ 
					case 'headline': 
					//	echo '<label>';
							$this->_get_label();
							$this->_get_description();
					//	echo '</label>';
						break;

					case 'description': 
						$this->_get_description();
						break;

					case 'divider': 
						echo '<p><hr /></p>';
						break;

				} // endswitch
			}

		} // endclass
	} // endif


	if( ! class_exists( 'Maxson_Customize_More_Control' ) )
	{ 
		/**
		 * Class to create a custom control
		 */

		class Maxson_Customize_More_Control extends Maxson_Customize_Control { 

			/**
			 * Declare the control type
			 */

			public $type = 'maxson_more';


			/**
			 * Render the control's content
			 * Allows the content to be overridden without having to rewrite the wrapper
			 */

			public function render_content()
			{ 
				return false;
			}
		} // endclass
	} // endif


	if( ! class_exists( 'Maxson_Customize_Code_Control' ) )
	{ 
		/**
		 * Class to create a custom control
		 */

		class Maxson_Customize_Code_Control extends Maxson_Customize_Control
		{ 
			/**
			 * Declare the control type
			 */

			public $type = 'maxson_code';


			/**
			 * Render the control's content
			 * Allows the content to be overridden without having to rewrite the wrapper
			 */

			public function render_content()
			{ 
				$this->_get_label();
				$this->_get_description();
				
				?><textarea name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id ); ?>" class="code"<?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
				</div>

			<?php }
		} // endclass
	} // endif


	if( ! class_exists( 'Maxson_Customize_Checkbox_Toggle_Control' ) )
	{ 
		/**
		 * Class to create a custom control
		 */

		class Maxson_Customize_Checkbox_Toggle_Control extends Maxson_Customize_Control
		{ 
			/**
			 * Declare the control type
			 */

			public $type = 'maxson_checkbox_toggle';


			/**
			 * Render the control's content
			 * Allows the content to be overridden without having to rewrite the wrapper
			 */

			public function render_content()
			{ 
				?><label><div class="toggle-switch">
					<input type="checkbox" name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id ); ?>" class="screen-reader-text toggle-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?>>
					<label class="toggle-knob" for="<?php echo esc_attr( $this->id ); ?>"></label>
				</div>

				<?php $this->_get_label(); ?>
				<?php $this->_get_description(); ?>
				</label>

			<?php }
		} // endclass
	} // endif


	// if( ! class_exists( 'Maxson_Customize_Checkbox_Multiple_Control' ) )
	// { 
	// 	/**
	// 	 * Class to create a custom control
	// 	 */

	// 	class Maxson_Customize_Checkbox_Multiple_Control extends Maxson_Customize_Control
	// 	{ 
	// 		/**
	// 		 * Declare the control type
	// 		 */

	// 		public $type = 'maxson_checkbox_multiple';


 //    		/**
	// 		* Enqueue styles and scripts on the theme customizer page
	// 		*/

	// 		public function enqueue()
	// 		{ 
	// 			wp_register_script( 'maxson-customizer-checkbox-multiple-control', get_theme_file_uri( '/assets/js/admin/customizer-checkbox-multiple.js' ), array( 'jquery', 'customize-base' ), false, true );

	// 			wp_enqueue_script( 'maxson-customizer-checkbox-multiple-control' );
	// 		}


	// 		/**
	// 		 * Refresh the parameters passed to the JavaScript via JSON
	// 		 */

	// 		public function to_json()
	// 		{ 
	// 			parent::to_json();

	// 			$this->json['default'] = $this->setting->default;

	// 			if( isset( $this->default ) )
	// 			{ 
	// 				$this->json['default'] = $this->default;

	// 			} // endif

	// 			$this->json['output']  = $this->output;
	// 			$this->json['value']   = maybe_unserialize( $this->value() );
	// 			$this->json['choices'] = $this->choices;
	// 			$this->json['link']    = $this->get_link();
	// 			$this->json['id']      = $this->id;

	// 			$this->json['inputAttrs'] = '';

	// 			foreach( $this->input_attrs as $attr => $value )
	// 			{ 
	// 				$this->json['inputAttrs'] .= ' ' . $attr . '="' . esc_attr( $value ) . '"';

	// 			} // endforeach
	// 		}


	// 		/**
	// 		 * Render the control's content
	// 		 * Allows the content to be overridden without having to rewrite the wrapper
	// 		 */

	// 		public function render_content()
	// 		{ 
	// 			if( empty( $this->choices ) )
	// 			{ 
	// 				return;

	// 			} // endif

	// 			$this->_get_label();
	// 			$this->_get_description();

	// 			$multi_values = ( ! is_array( $this->value() ) ) ? explode( ',', $this->value() ) : $this->value();

	// 			echo '<ul>';
	// 			foreach( $this->choices as $value => $label )
	// 			{ 
	// 				$is_checked = checked( in_array( $value, $multi_values ), true, false );

	// 				printf( '<li><label><input type="checkbox" value="%1$s"%2$s>%3$s</label></li>', esc_attr( $value ), $is_checked, esc_html( $label ) );

	// 			} // endforeach
	// 			echo '</ul>';
	// 		}
	// 	} // endclass
	// } // endif


	if( ! class_exists( 'Maxson_Customize_Checkbox_Sortable_Control' ) )
	{ 
		/**
		 * Class to create a custom control
		 */

		class Maxson_Customize_Checkbox_Sortable_Control extends Maxson_Customize_Control
		{ 
			/**
			 * Declare the control type
			 */

			public $type = 'maxson_checkbox_sortable';


			/**
			* Enqueue styles and scripts on the theme customizer page
			*/

			public function enqueue()
			{ 
				wp_register_script( 'maxson-customizer-checkbox-sortable-control', get_theme_file_uri( '/assets/js/admin/customizer-checkbox-sortable.js' ), array( 'jquery', 'customize-base' ), false, true );

				wp_enqueue_script( 'maxson-customizer-checkbox-sortable-control' );
			}


			/**
			 * Render the sortable list item
			 */

			private function _get_sortable_item( $key, $title )
			{ 
				$in_array = in_array( $key, $this->value() );
				$class    = ( $in_array ) ? 'active' : 'inactive';

				?><li class="sortable-item <?php echo $class; ?>" data-value="<?php echo esc_attr( $key ); ?>" title="<?php echo esc_attr( $title ); ?>">
					<div class="sortable-controls">
						<label class="sortable-control visibility">
							<input type="checkbox" class="screen-reader-text sortable-checkbox" value="<?php echo esc_attr( $key ); ?>"<?php checked( $in_array, 1 ); ?>> <span class="screen-reader-text"><?php _e( 'Toggle item visibility', 'maxson' ); ?></span>
						</label>

						<span class="sortable-control move-control move-up" tabindex="-1" aria-hidden="true"><span class="screen-reader-text"><?php _e( 'Move Up', 'maxson' ); ?></span></span>
						<span class="sortable-control move-control move-down" tabindex="-1" aria-hidden="true"><span class="screen-reader-text"><?php _e( 'Move Down', 'maxson' ); ?></span></span>
					</div>

					<span class="sortable-title">
						<?php echo $title; ?>
					</span>
				</li>

			<?php }


			/**
			 * Render the control's content
			 * Allows the content to be overridden without having to rewrite the wrapper
			 */

			public function render_content()
			{ 
				if( empty( $this->choices ) )
				{ 
					return;

				} // endif

				$values = ( is_array( $this->value() ) ) ? join( ',', array_map( 'esc_attr', $this->value() ) ) : $this->value();

				$this->_get_label();
				$this->_get_description();

				echo '<ul class="sortable">';
					foreach( $this->value() as $key )
					{ 
						$title = $this->choices[ $key ];

						$this->_get_sortable_item( $key, $title );

					} // endforeach


					foreach( $this->choices as $key => $title )
					{ 
						if( in_array( $key, $this->value() ) )
						{ 
							continue;

						} // endif

						$this->_get_sortable_item( $key, $title );

					} // endif
				echo '</ul>';


				printf( '<button type="button" class="button-link reorder-toggle" aria-label="%1$s">', __( 'Reorder items', 'maxson' ) );
					printf( '<span class="reorder">%1$s</span>', __( 'Reorder', 'maxson' ) );
					printf( '<span class="reorder-done">%1$s</span>', __( 'Done', 'maxson' ) );
				echo '</button>';


				printf( '<input type="hidden" name="%1$s" class="sortable-value" value="%2$s">', esc_attr( $this->id ), $values );
			}
		}
	} // endif


	if( ! class_exists( 'Maxson_Customize_Radio_Image_Control' ) )
	{ 
		/**
		 * Class to create a custom control
		 */

		class Maxson_Customize_Radio_Image_Control extends Maxson_Customize_Control
		{ 
			/**
			 * Declare the control type
			 */

			public $type = 'maxson_radio_image';


			/**
			 * Render the control's content
			 * Allows the content to be overridden without having to rewrite the wrapper
			 */

			public function render_content()
			{ 
				if( empty( $this->choices ) )
				{ 
					return;

				} // endif

				$this->_get_label();
				$this->_get_description();

				$name = "_customize-radio-{$this->id}";

				?><div id="input_<?php echo esc_attr( $this->id ); ?>" class="radio-images">
				<?php foreach( $this->choices as $value => $data )
				{ 
					if( is_array( $data ) )
					{ 
						$label   = ( isset( $data['label'] ) ) ? $data['label'] : $value;
						$img_src = sprintf( $data['image'], get_template_directory_uri() );

					} else
					{ 
						$label   = $value;
						$img_src = sprintf( $data, get_template_directory_uri() );

					} // endif

					$for = "{$this->id}_{$value}";

					?><label for="<?php echo esc_attr( $for ); ?>">
						<span class="screen-reader-text"><?php echo esc_html( $label ); ?></span>
						<input type="radio" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $for ); ?>" class="radio-image screen-reader-text" value="<?php echo esc_attr( $value ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $label ); ?>" title="<?php echo esc_attr( $label ); ?>">
					</label>

				<?php } // endforeach ?>
				</div><!-- .radio-images -->

				<?php
			}

		} // endclass
	} // endif


	if( ! class_exists( 'Maxson_Customize_Range_Control' ) )
	{ 
		/**
		 * Class to create a custom control
		 */

		class Maxson_Customize_Range_Control extends Maxson_Customize_Control
		{ 
			/**
			 * Declare the control type
			 */

			public $type = 'maxson_range';


			/**
			* Enqueue styles and scripts on the theme customizer page
			*/

			public function enqueue()
			{ 
				wp_register_script( 'maxson-customizer-range-control', get_theme_file_uri( '/assets/js/admin/customizer-range.js' ), array( 'jquery', 'customize-base' ), false, true );

				wp_enqueue_script( 'maxson-customizer-range-control' );
			}


			/**
			 * Render the control's content
			 * Allows the content to be overridden without having to rewrite the wrapper
			 */

			public function render_content()
			{ 
				$min  = ( isset( $this->input_attrs['min'] ) ) ? $this->input_attrs['min'] : 1;
				$max  = ( isset( $this->input_attrs['max'] ) ) ? $this->input_attrs['max'] : 100;
				$step = ( isset( $this->input_attrs['step'] ) ) ? $this->input_attrs['step'] : 1;

				$value = maxson_sanitize_in_range( $this->value(), $min, $max );

				?><label>
					<div class="range-field">
						
						<div class="range-details">
							<?php $this->_get_label(); ?>

							<div class="range-value">
								<input type="number" class="small-text" value="<?php echo esc_attr( $value ); ?>" <?php $this->input_attrs(); $this->link(); ?>>
							</div><!-- .range-value -->
						</div>

						
						<div class="range-slider-inputs">
							<div class="range-slider">
								<input type="range" value="<?php echo esc_attr( $value ); ?>" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $step ); ?>">
							</div><!-- .range-slider -->

							<div class="range-reset" title="<?php esc_attr_e( 'Reset value', 'maxson' ); ?>" data-reset-value="<?php echo esc_attr( $this->value() ); ?>">
								<span class="dashicons dashicons-image-rotate" aria-hidden="true"></span>
							</div><!-- .range-reset -->
						</div><!-- .range-slider-inputs -->

						<?php $this->_get_description(); ?>

					</div><!-- .range-slider -->
            	</label>

			<?php }
		} // endclass
	} // endif


	if( ! class_exists( 'Maxson_Customize_Dropdown_Posts_Control' ) )
	{ 
		/**
		 * Class to create a custom control
		 */

		class Maxson_Customize_Dropdown_Posts_Control extends Maxson_Customize_Control
		{ 
			/**
			 * Declare the control type
			 */

			public $type = 'maxson_dropdown_posts';


			/**
			 * Declare control post types
			 */

			private $post_types;


			/**
			 * Declare control options
			 */

			private $options;


			public function __construct( $manager, $id, $args = array(), $options = array() )
			{ 
				$this->options = $options;

				parent::__construct( $manager, $id, $args );
			}


			/**
			* Render the post types
			*/

			private function _get_post_types()
			{ 
				if( isset( $this->options['include'] ) )
				{ 
					$post_types = $this->options['include'];

				} else
				{ 
					$args = array( 
						'public' => true
					);

					$post_types = get_post_types( $args );

					$default_exclude = array( 'attachment' );

					$exclude = ( isset( $this->options['exclude'] ) ) ? array_merge( $this->options['exclude'], $default_exclude ) : $default_exclude;

					$post_types = array_diff_key( $post_types, $exclude );

				} // endif

				sort( $post_types );

				$this->post_types = $post_types;
			}


			/**
			* Render the posts optgroup
			*/

			private function _get_posts( $post_type = null, $multiple = true )
			{ 
				$posts = get_posts( array( 
					'post_type'      => $post_type, 
					'post_status'    => array( 'publish' ), 
					'posts_per_page' => -1, 
					'order'          => 'ASC', 
					'orderby'        => 'title'
				) );

				if( ! $posts )
				{ 
					return false;

				} // endif

				$post_type_obj = get_post_type_object( $post_type );

				if( count( $this->post_types ) > 1 )
				{ 
					printf( '<optgroup label="%1$s">', $post_type_obj->labels->name );

				} // endif

				foreach( $posts as $the_post )
				{ 
					$post_id = $the_post->ID;
					$title   = get_the_title( $post_id );

					if( empty( $title ) )
					{ 
						$title = sprintf( _x( 'Untitled %1$s', 'Unknown post title', 'maxson' ), '(ID # ' . $post_id . ')' );

					} // endif

					$this->_get_option( $post_id, $title );

				} // endforeach

				if( count( $this->post_types ) > 1 )
				{ 
					echo '</optgroup>';

				} // endif
			}


			/**
			 * Render the control's content
			 * Allows the content to be overridden without having to rewrite the wrapper
			 */

			public function render_content()
			{ 
				$default_label = $this->_get_option_none_label();

				echo '<label>';
					$this->_get_label();
					$this->_get_description();

					$this->_get_post_types();

					printf( '<select name="%1$s" id="%1$s"%2$s>', $this->id, $this->get_link() );

						$this->_get_option( '', $default_label );

						if( $this->post_types )
						{ 
							foreach( $this->post_types as $post_type )
							{ 
								$this->_get_posts( $post_type );

							} // endforeach
						} // endif

					echo '</select>';
				echo '</label>';
			}
		} // endclass
	} // endif


	if( ! class_exists( 'Maxson_Customize_Dropdown_Terms_Control' ) )
	{ 
		/**
		 * Class to create a custom control
		 */

		class Maxson_Customize_Dropdown_Terms_Control extends Maxson_Customize_Control
		{ 
			/**
			 * Declare the control type
			 */

			public $type = 'maxson_dropdown_terms';


			/**
			 * Declare control options
			 */

			private $options;


			public function __construct( $manager, $id, $args = array(), $options = array() )
			{ 
				$this->options = $options;

				parent::__construct( $manager, $id, $args );
			}


			/**
			 * Render the control's content.
			 * Allows the content to be overriden without having to rewrite the wrapper.
			 */

			public function render_content()
			{ 
				// call wp_dropdown_cats to get data and add to select field
				add_action( 'wp_dropdown_cats', array( &$this, 'wp_dropdown_cats' ) );

				$defaults = array( 
					'orderby'    => 'name', 
					'hide_empty' => false, 
					'option_none_value' => '', 
					'show_option_none'  => $this->_get_option_none_label()
				);

				$args = wp_parse_args( $this->options, $defaults );

				$args['id']       = $this->id;
				$args['name']     = $this->id;
				$args['selected'] = $this->value();
				$args['echo']     = true;

				echo '<label>';
					$this->_get_label();
					$this->_get_description();

					wp_dropdown_categories( $args );
				echo '</label>';
			}


			/**
			* Replace WP default dropdown
			*/

			public function wp_dropdown_cats( $output )
			{ 
				return str_replace( '<select', '<select ' . $this->get_link(), $output );
			}

		} // endclass
	} // endif


	if( ! class_exists( 'Maxson_Customize_Dropdown_Users_Control' ) )
	{ 
		/**
		 * Class to create a custom control
		 */

		class Maxson_Customize_Dropdown_Users_Control extends Maxson_Customize_Control
		{ 
			/**
			 * Declare the control type
			 */

			public $type = 'maxson_dropdown_users';


			/**
			 * Declare control options
			 */

			private $options;


			public function __construct( $manager, $id, $args = array(), $options = array() )
			{ 
				$this->options = $options;

				parent::__construct( $manager, $id, $args );
			}


			/**
			 * Render the control's content
			 * Allows the content to be overridden without having to rewrite the wrapper
			 */

			public function render_content()
			{ 
				$default_label = $this->_get_option_none_label();

				$defaults = array( 
					'orderby' => 'name'
				);

				$args = wp_parse_args( $this->options, $defaults );

				$users = get_users( $args );

				echo '<label>';
					$this->_get_label();
					$this->_get_description();

					printf( '<select name="%1$s" id="%1$s"%2$s>', $this->id, $this->get_link() );
						$this->_get_option( '', $default_label );

						foreach( $users as $user )
						{ 
							$this->_get_option( $user->data->ID, $user->data->display_name );

						} // endforeach

					echo '</select>';
				echo '</label>';

			}

		} // endclass
	} // endif

} // endif

?>