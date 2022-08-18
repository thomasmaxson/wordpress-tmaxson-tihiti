;( function( wp, $ )
{ 
	wp.customize.controlConstructor['maxson_checkbox_multiple'] = wp.customize.Control.extend( { 

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

			control.container.on( 'change', 'input', function()
			{ 
				var value = [],
					i = 0;

				$.each( control.params.choices, function( key )
				{ 
					if( control.container.find( 'input[value="' + key + '"]' ).is( ':checked' ) )
					{ 
						value[ i ] = key;
						i++;

					} // endif
				} );

				control.setting.set( value );
			} );
		}
	} );
} )( wp, jQuery );