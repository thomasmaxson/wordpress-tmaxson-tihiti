/**
 * Instantly live-update customizer settings in the preview for improved user experience
 */

;( function( $ )
{ 
	// Update site title
	wp.customize( 'blogname', function( value )
	{ 
		value.bind( function( to )
		{ 
			$( '.navbar-brand-title' ).text( to );

		} );
	} );


	// Update site description
	wp.customize( 'blogdescription', function( value )
	{ 
		value.bind( function( to )
		{ 
			$( '.navbar-brand-description' ).text( to );

		} );
	} );


	// Update header position
	wp.customize( 'maxson_header_position', function( value )
	{ 
		value.bind( function( to )
		{ 
			var ajax_data = { 
				action : 'get_header_position',
				nonce  : maxson_customizer.nonce,
				value  : to
			};

			$.ajax( { 
				type    : 'json',
				url     : maxson_customizer.ajaxurl,
				data    : ajax_data,
				success : function( response )
				{ 
					if( response.success == true )
					{ 
						$( '.site-header' )
							.removeClass( 'navbar-fixed-top navbar-fixed-bottom' )
							.removeClass( 'navbar-static-top navbar-static-bottom' )
							.addClass( response.data.class );

					} else 
					{ 
						console.log( response.data.message );

					} // endif
				}, 
				error: function( request, status, error )
				{ 
					console.log( request.responseText );
					console.log( error );

				}
			} );

		} );
	} );


	// Update header style
	wp.customize( 'maxson_header_style', function( value )
	{ 
		value.bind( function( to )
		{ 
			var ajax_data = { 
				action : 'get_header_style',
				nonce  : maxson_customizer.nonce,
				value  : to
			};

			$.ajax( { 
				type    : 'json',
				url     : maxson_customizer.ajaxurl,
				data    : ajax_data,
				success : function( response )
				{ 
					if( response.success == true )
					{ 
						$( '.site-header' )
							.removeClass( 'navbar-default navbar-inverse' )
							.addClass( response.data.class );

					} else 
					{ 
						console.log( response.data.message );

					} // endif
				}, 
				error: function( request, status, error )
				{ 
					console.log( request.responseText );
					console.log( error );

				}
			} );

		} );
	} );


	// Update footer style
	wp.customize( 'maxson_footer_fixed', function( value )
	{ 
		value.bind( function( to )
		{ 
			$( 'body' ).toggleClass( 'footer-fixed' );

		} );
	} );


	// Update Call-to-Action visibility
	wp.customize( 'maxson_call_to_action[show]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( '.btn.btn-cta' );

			if( false === to )
			{ 
				$field.hide();

			} else
			{ 
				$field.show();

			} // endif

		} );
	} );


	// Update Call-to-Action text
	wp.customize( 'maxson_call_to_action[label]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( '.btn.btn-cta' );

			if( '' == to )
			{ 
				$field.text( '[Post or Page Title]' );

			} else
			{ 
				$field.text( to );

			} // endif

		} );
	} );

})( jQuery );