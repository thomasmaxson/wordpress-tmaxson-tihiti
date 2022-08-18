// https://github.com/wp-plugins/ajaxify-wordpress-site/blob/master/js/ajaxify.js
// http://www.deluxeblogtips.com/2010/05/how-to-ajaxify-wordpress-theme.html

// https://github.com/browserstate/ajaxify/blob/master/ajaxify-html5.js


;(function( $ ){ 
	"use strict";

	if( ! history.pushState )
		return false;

	if( document.location.protocol === 'file:' )
		return false;

	if( ! wp_ajaxify.container || ! wp_ajaxify.navigation )
		return false;

	var History        = window.History,
		$document      = jQuery( document ),
		$window        = jQuery( window ),
		$body          = jQuery( 'body' ),
		$windowWidth   = $window.width(),
		$windowHeight  = $window.height();

	var wpAdminBar = '#wpadminbar',
		wrapper    = wp_ajaxify.container, 
		navigation = wp_ajaxify.navigation;

	var animationSpeed = 500,
		historyCount   = 0,
		loading        = true;


	if( ! $body.hasClass( 'ajaxify-page-load' ) )
		return false;



	$.expr[':'].internal = function( obj, index, meta, stack ){ 
		var $this = $( obj ),
			url = $this.attr( 'href' ) || '',
			isInternalLink;

		// Check link
		isInternalLink = url.substring( 0, rootUrl.length ) === rootUrl || url.indexOf( ':' ) === -1;

		// Ignore or Keep
		return isInternalLink;
	};


	var documentHtml = function( html )
	{ 
		var result = String( html ).replace( /<\!DOCTYPE[^>]*>/i, '' )
			.replace( /<(html|head|body|title|script)([\s\>])/gi, '<div id="document-$1"$2' )
			.replace( /<\/(html|head|body|title|script)\>/gi, '</div>' );

		return result;
	};


	jQuery.fn.wp_ajaxify = function(){ 

	//	jQuery( 'a[href^="' + wp_ajaxify.site_url + '"]:not(.no-wp-ajaxify, [href^="#"], [href*="wp-login"], [href*="wp-admin"], [href*="feed"])' ).on( 'click', function( event ){ 

		jQuery( 'a:internal:not( .no-ajaxy )' ).on( 'click', function( event ){ 
			var $this = jQuery( this ),
				$parent = $this.parent(),
				href  = $this.attr( 'href' );

			if( $body.hasClass( 'loading' ) )
				return false;

			// Continue as normal for cmd clicks
			if( event.which == 2 || event.metaKey )
				return true;

			History.pushState( null, wp_ajaxify.loading_page_title, href );

			// remove click border
			$this.blur();

			event.preventDefault();
		});

	};


	$body.wp_ajaxify();


	$window.on( 'statechange', function( event ){ 

		var State = History.getState(),
			url   = State.url;

		console.log( url );
		// Start loading
		$body.addClass( 'loading' );

		jQuery.ajax({
			url	     : url,
			type     : 'GET',
			dataType : 'html',
			beforeSend: function( xhr ){ 

				$document.trigger({ 'type' : 'ajaxify.before' });

				jQuery( wrapper ).stop( true, true ).fadeTo( animationSpeed, 0 );

				jQuery( 'html, body' ).stop( true, true ).animate({
					scrollTop: wp_ajaxify.scroll_top_distance
				}, Math.floor( animationSpeed / 2 ) );

			}
		}).success(function( data ){ 

			setTimeout( function(){ 

			var $data = jQuery( documentHtml( data ) );

			if( $data.length )
			{ 
				var $data_body    = $data.find( '#document-body:first' ),
					$data_title   = $data.find( '#document-title' ),
					$data_scripts = $data.find( '#document-script' );

				// Set page title
				document.title = $data_title.html();

				// Remove extraneous scripts
				if( $data_scripts.length )
					$data_scripts.detach();

				// Update body classes
				jQuery( 'body' ).attr( 'class', $data_body.attr( 'class' ) );

				// Update page navigation
				jQuery( navigation ).html( $data.find( navigation ).html() );

				// Update WordPress Admin Bar
				if( wp_ajaxify.admin_bar_showing )
					jQuery( wpAdminBar ).html( $data.find( wpAdminBar ).html() );

				// Update page content
				jQuery( wrapper ).html( $data_body.find( wrapper ).html() ).stop( true, true ).fadeTo( animationSpeed, 1.0 );

				// Reinit AJAXify plugin
				$body.wp_ajaxify();

				$document.trigger({ 'type' : 'ajaxify.after' });

			} // endif

			}, wp_ajaxify.timeout_delay );

		}).done(function( data ){ 

			// Silence is Golden

			$document.trigger({ 'type' : 'ajaxify.done' });

		}).fail(function( jqXHR, textStatus, errorThrown ){ 

			console.log( jqXHR + ' - ' + textStatus + ' - ' + errorThrown );

			$document.trigger({ 'type' : 'ajaxify.fail' });

		});
	});
})( window.jQuery );