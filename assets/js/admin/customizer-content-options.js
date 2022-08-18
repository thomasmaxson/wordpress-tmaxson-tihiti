;( function( $ ){ 

	var contentOptionsCssHide = { 
		'clip'     : 'rect( 1px, 1px, 1px, 1px )',
		'position' : 'absolute',
		'height'   : '1px',
		'width'    : '1px',
		'overflow' : 'hidden'
	};

	var contentOptionsCssShow = { 
		'clip'     : 'auto',
		'position' : 'relative',
		'height'   : 'auto',
		'width'    : 'auto',
		'overflow' : 'auto'
	};

	// Post Details: Author
	wp.customize( 'maxson_layout_project_details[author]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsPost.author );

			if( false === to )
			{ 
				$field.css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-post-author' );

			} else
			{ 
				$field.css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-post-author' );

			} // endif
		} );
	} );


	// Post Details: Categories
	wp.customize( 'maxson_layout_project_details[categories]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsPost.categories );

			if( false === to )
			{ 
				$( maxsonDetailsPost.categories ).css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-post-categories' );

			} else
			{ 
				$( maxsonDetailsPost.categories ).css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-post-categories' );

			} // endif
		} );
	} );


	// Post Details: Comment link
	wp.customize( 'maxson_layout_project_details[comment]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsPost.comment );

			if( false === to )
			{ 
				$field.css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-post-comment' );

			} else
			{ 
				$field.css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-post-comment' );

			} // endif
		} );
	} );


	// Post Details: Date
	wp.customize( 'maxson_layout_project_details[date]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsPost.date );

			if( false === to )
			{ 
				$field.css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-post-date' );

			} else
			{ 
				$field.css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-post-date' );

			} // endif
		} );
	} );


	// Post Details: Tags
	wp.customize( 'maxson_layout_project_details[tags]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsPost.tags );

			if( false === to )
			{ 
				$field.css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-post-tags' );

			} else
			{ 
				$field.css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-post-tags' );

			} // endif
		} );
	} );







	// Project Details: Author
	wp.customize( 'maxson_layout_project_details[author]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsProject.author );

			if( false === to )
			{ 
				$field.css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-project-author' );

			} else
			{ 
				$field.css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-project-author' );

			} // endif
		} );
	} );


	// Project Details: Categories
	wp.customize( 'maxson_layout_project_details[categories]', function( value )
	{ 
		// Project Details: Categories
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsProject.categories );

			if( false === to )
			{ 
				$field.css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-project-categories' );

			} else
			{ 
				$field.css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-project-categories' );

			} // endif
		} );
	} );


	// Project Details: Client
	wp.customize( 'maxson_layout_project_details[client]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsProject.client );

			if( false === to )
			{ 
				$field.css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-project-client' );

			} else
			{ 
				$field.css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-project-client' );

			} // endif
		} );
	} );


	// Project Details: Date
	wp.customize( 'maxson_layout_project_details[date]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsProject.date );

			if( false === to )
			{ 
				$field.css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-project-date' );

			} else
			{ 
				$field.css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-project-date' );

			} // endif
		} );
	} );


	// Project Details: Date
	wp.customize( 'maxson_layout_project_details[dates]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsProject.dates );

			if( false === to )
			{ 
				$field.css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-project-dates' );

			} else
			{ 
				$field.css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-project-dates' );

			} // endif
		} );
	} );


	// Project Details: Tags
	wp.customize( 'maxson_layout_project_details[tags]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsProject.tags );

			if( false === to )
			{ 
				$field.css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-project-tags' );

			} else
			{ 
				$field.css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-project-tags' );

			} // endif
		} );
	} );


	// Project Details: URL Link
	wp.customize( 'maxson_layout_project_details[link]', function( value )
	{ 
		value.bind( function( to )
		{ 
			var $field = $( maxsonDetailsProject.link );

			if( false === to )
			{ 
				$field.css( contentOptionsCssHide );
				$( 'body' ).addClass( 'hide-project-link' );

			} else
			{ 
				$field.css( contentOptionsCssShow );
				$( 'body' ).removeClass( 'hide-project-link' );

			} // endif
		} );
	} );

} )( jQuery );