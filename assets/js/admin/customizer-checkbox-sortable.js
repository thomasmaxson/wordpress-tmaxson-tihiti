;( function( wp, $ )
{ 
	// https://themes.trac.wordpress.org/browser/oceanwp/1.1.8.1.3/inc/customizer/controls/sortable/

	wp.customize.controlConstructor['maxson_checkbox_sortable'] = wp.customize.Control.extend( { 

		ready : function()
		{ 
			'use strict';

			var control = this;

			control.initMaxsonControl();
		},


		initMaxsonControl : function()
		{ 
			'use strict';

			var control = this;

			control.sortableContainer = control.container.find( 'ul.sortable' );
			control.sortableControls  = control.sortableContainer.find( '.sortable-controls' );
			control.reorderButton     = control.sortableContainer.siblings( '.reorder-toggle' );

			control.reorderButton.on( 'click', function( event )
			{ 
				event.preventDefault();

				control.sortableContainer.toggleClass( 'reordering' );
			} );


			control.sortableControls.on( 'click', '.move-control', function( event )
			{ 
				event.preventDefault();

				var move_button  = $( this ),
					this_element = move_button.closest( 'li' ),
					prev_sibling = this_element.prev( 'li' ),
					next_sibling = this_element.next( 'li' );

				move_button.focus();

				var isMoveUp   = move_button.is( '.move-up' ),
					isMoveDown = move_button.is( '.move-down' );

				if( isMoveUp && prev_sibling.length )
				{ 
					var elementToMove = this_element.detach();

					prev_sibling.before( elementToMove );

				} // endif
				
				if( isMoveDown && next_sibling.length )
				{ 
					var elementToMove = this_element.detach();

					next_sibling.after( elementToMove );

				} // endif

				control.updateValue();

				// Re-focus after the container was moved.
				moveBtn.focus();
			} );


			control.sortableContainer.disableSelection().find( 'li' ).each( function()
			{ 
				// Enable/disable options when we click on the eye of Thundera
				$( this ).find( 'input[type="checkbox"]' ).on( 'change', function()
				{ 
					$( this ).parents( 'li:eq(0)' ).toggleClass( 'active inactive' );
				} );
			} );
		},


		/**
		 * Updates the sorting list
		 */

		updateValue : function()
		{ 
			'use strict';

			var control  = this,
				newValue = [];

			control.sortablevalue = control.container.find( '.sortable-value' );

			this.sortableContainer.find( 'li' ).each( function()
			{ 
				if( ! $( this ).hasClass( 'inactive' ) )
				{ 
					newValue.push( $( this ).data( 'value' ) );

				} // endif
			});

			control.sortablevalue.val( newValue.join( ',' ) );

			control.setting.set( newValue );
		}
	} );
} )( wp, jQuery );