;( function( wp, $ )
{ 
	wp.customize.controlConstructor['maxson_range'] = wp.customize.Control.extend( { 

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

			var value, defaultValue, changeAction, 
				$rangeSlider = $( '.range-slider input[type="range"]', this.container ), 
				$rangeValue  = $( '.range-value input[type="number"]', this.container ), 
				$rangeReset  = $( '.range-reset', this.container );

			$rangeSlider.on( 'input', function( event )
			{ 
				var slideValue = $( this ).attr( 'value' );

				$rangeValue.val( slideValue ).trigger( 'change' );
			} );


			$rangeValue.on( 'input keyup', function( event )
			{ 
				value = $( this ).val();

				$rangeSlider.val( value );
			} );


			$rangeReset.on( 'click', function( event )
			{ 
				defaultValue = $( this ).data( 'reset-value' );

				$rangeSlider.val( defaultValue );

				$rangeValue.val( defaultValue );
			} );
		}
	} );
} )( wp, jQuery );