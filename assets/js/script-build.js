// @codekit-prepend 'vendor/modernizr.js';
// @codekit-prepend 'vendor/bootstrap/bootstrap.js';
// @codekit-prepend 'vendor/jquery.appear.js';
// @codekit-prepend 'vendor/jquery.countTo.js';
// @codekit-prepend 'vendor/jquery.doubletaptogo.js';
// @codekit-prepend 'vendor/jquery.flexslider.js';
// @codekit-prepend 'vendor/slick.js';
// @codekit-prepend 'vendor/imagesloaded.pkgd.js';
// @codekit-prepend 'vendor/isotope.pkgd.js';
// @codekit-prepend 'vendor/jquery.simple-lightbox.js';

;( function( $ )
{ 
	"use strict";

	var bootstrapGridGutterWidth = 30;
	var bootstrapGridXs = 480;
	var bootstrapGridSm = 768;
	var bootstrapGridMd = 992;
	var bootstrapGridLg = 1200;
	var gridFloatBreakPoint = bootstrapGridSm;

	var animationSpeed = 350;  // DO NOT CHANGE THIS VALUE
	var slideshowSpeed = 7000; // DO NOT CHANGE THIS VALUE

	var $document    = $( document );
	var $window      = $( window );
	var $siteHeader  = $( '.site-header' );
	var $siteBody    = $( '.site-body' );
	var $siteFooter  = $( '.site-footer' );
	var $portFilters = $( '#portfolio-filters' );
	var $portTeasers = $( '#portfolio-teasers' );
	var isMobile     = ( $window.width() < bootstrapGridMd ) ? true : false;

	$document.ready( function( $ )
	{ 
		if( $.isFunction( $.fn.appear ) )
		{ 
			$( '.process' ).each( function( index, value )
			{ 
				var $this = $( this );

				$this.appear( function( event, $affected )
				{ 
					$this.addClass( 'active' );

				} );
			} );

		} // endif


		if( $.isFunction( $.fn.appear ) && $.isFunction( $.fn.countTo ) )
		{ 
			$( '.skills' ).appear( function( event, $affected )
			{ 
				$( this ).find( '.skill' ).each( function( index, value )
				{ 
					var $percentage = $( this ).find( '.skill-percentage' );

					$percentage.countTo( { 
						'from'  : 0,
						'to'    : parseInt( $percentage.text() ),
						'speed' : ( animationSpeed * 2 )
					} );
				} );
			} );

		} // endif


		// On click, smooth scroll to hash
		$( 'a[href^="#"]:not([data-toggle])' ).on( 'click',function( event )
		{ 
			event.preventDefault();

			// Only fire for non site-subnav links
			if( $( this ).parents( '.site-subnav' ).length === 0 )
			{
				triggerSmoothScroll( this.hash );

			} // endif
		} );



		if( $.isFunction( $.fn.simpleLightbox ) )
		{ 
			$( '#gallery-images a[id^="#"], .lightbox, .zoom' ).simpleLightbox( { 
				animationSpeed    : ( animationSpeed / 2 ), 
				disableScroll     : true, 
				disableRightClick : true, 
			//	history           : false,
				navText           : [ 
					maxsonParams.lightbox_nav_previous_label, 
					maxsonParams.lightbox_nav_next_label
				], 
				closeText         : maxsonParams.lightbox_nav_close_button, 
				alertErrorMessage : maxsonParams.lightbox_missing_image

			} );

		} // endif


		if( $.isFunction( $.fn.slick ) )
		{ 
			$( '.project-gallery' ).slick( { 
				arrows         : false,
				dots           : true,
				centerPadding  : '0px',
				draggable      : true, 
				mobileFirst    : true,
				centerMode     : true,
				adaptiveHeight : true,
			//	variableWidth  : true,
				infinite       : false,
				slidesToShow   : 1,
				speed          : animationSpeed,
				autoplaySpeed  : slideshowSpeed,

			//	cssEase        : 'ease-in-out',
				prevArrow      : '<button type="button" class="slick-prev">' + maxsonParams.gallery_nav_previous_label + '</button>',
				nextArrow      : '<button type="button" class="slick-next">' + maxsonParams.gallery_nav_next_label + '</button>',

				responsive     : [{ 
					breakpoint : gridFloatBreakPoint,
					settings   : { 
						centerPadding  : bootstrapGridGutterWidth + 'px',
						arrows         : true,
						infinite       : true
					}
				}],

			} );

		} // endif


		if( $.isFunction( $.fn.affix ) && $portFilters.length )
		{ 
			var filtersTopOffset    = getPortfolioFilterTopOffset();
			var teasersBottomOffset = getPortfolioTeaserBottomOffset();

			$portFilters.on( 'affix.bs.affix', function()
			{ 
				$portFilters.parent().css( { 
					'padding-top' : $portFilters.outerHeight( true )

				} );
			} ).on( 'affix-top.bs.affix', function()
			{ 
				$portFilters.parent().css( { 
					'padding-top' : 0

				} );
			} ).affix( { 
				offset : { 
					top    : filtersTopOffset,
					bottom : teasersBottomOffset

				}

			} );

			$window.on( 'resize', function( event )
			{ 
				var $filterOptions = $portFilters.data( 'bs.affix' ).options;

				filtersTopOffset    = getPortfolioFilterTopOffset();
				teasersBottomOffset = getPortfolioTeaserBottomOffset();

				$filterOptions.offset.top    = filtersTopOffset;
				$filterOptions.offset.bottom = teasersBottomOffset;

			} );

		} // endif
	} );


	$window.on( 'resize', function( event )
	{ 
		isMobile = ( $window.width() < gridFloatBreakPoint ) ? true : false;


	}).on( 'load', function()
	{ 
		var hash = window.location.hash;

		triggerSmoothScroll( hash );

		if( $.isFunction( $.fn.isotope ) )
		{ 
			var isotopeOptions = { 
					filter             : '*',
					itemSelector       : '.project-teaser',
					layoutMode         : 'masonry', 
					resizable          : false, 
					transitionDuration : animationSpeed
				};

			if( $portTeasers.length )
			{ 
				$portTeasers.isotope( isotopeOptions );

				$portFilters.on( 'click', 'a', function( event )
				{ 
					if( $( 'body' ).hasClass( 'customize-preview') )
					{ 
						return false;

					} // endif

					event.preventDefault();

					var $this    = $( this );
					var filter   = $this.data( 'filter' );
					var taxonomy = $portFilters.data( 'taxonomy' );
					var value    = ( '*' == filter ) ? filter : '.' + taxonomy + '-' + filter;

					$portFilters.find( '.active' ).removeClass( 'active' );
					$this.parent().addClass( 'active' );

					$portTeasers.isotope( { 
						'filter' : value

					} );
				});

			} // endif
		} // endif

	});


	function triggerSmoothScroll( hash )
	{ 
		if( typeof hash !== undefined && hash !== '' )
		{ 
			var $target = $( hash );

			if( ! $target.length )
			{ 
				return false;

			} // endif

			var menuOffset = getHeaderHeight();

			$( 'html, body' ).stop().animate( { 
				'scrollTop' : ( ( $target.offset().top - menuOffset ) + 1 )

			}, ( animationSpeed * 1.5 ), 'swing' );

		} // endif
	}


	function getAdminBarHeight()
	{ 
		return ( $( 'body' ).hasClass( 'admin-bar' ) && $( '#wpadminbar' ).length ) ? $( '#wpadminbar' ).height() : 0;
	}


	function getNavbarHeight()
	{ 
		return ( $siteHeader.hasClass( 'navbar-fixed-top' ) ) ? $siteHeader.height() : 0;
	}


	function getHeaderHeight()
	{ 
		var navbarHeight   = getNavbarHeight();
		var adminbarHeight = getAdminBarHeight();

		return ( navbarHeight + adminbarHeight );
	}


	function getPortfolioFilterTopOffset()
	{ 
		var headerHeight = getHeaderHeight();
		var topOffset    = $( '#portfolio-filters' ).offset().top;

		return ( ( topOffset - headerHeight ) );
	}


	function getPortfolioTeaserBottomOffset()
	{ 
		var windowHeight        = $( document ).outerHeight();
		var portTeaserTopOffset = $( '#teasers' ).offset().top;
		var portTeaserHeight    = $( '#teasers' ).outerHeight();

		return ( windowHeight - ( portTeaserTopOffset + portTeaserHeight ) );
	}

} )( window.jQuery );