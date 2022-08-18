<?php
/**
 * The template for displaying Google Analytics code
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

$network_site  = network_site_url( '/' );
$tracking_code = maxson_get_tracking_code();

if( empty( $tracking_code ) )
{ 
	printf( '<!-- %1$s -->', __( 'Analytics is missing the tracking code', 'maxson' ) );
	return;

} elseif( is_user_logged_in() || is_admin() || is_feed() )
{ 
	printf( '<!-- %1$s -->', __( 'Analytics is set to ignore this area of your site', 'maxson' ) );
	return;

} elseif( stristr( $network_site, 'dev'       ) !== false || 
	stristr( $network_site, 'stg'       ) !== false || 
	stristr( $network_site, '127.0.0.1' ) !== false || 
	stristr( $network_site, 'localhost' ) !== false || 
	stristr( $network_site, ':8888'     ) !== false )
{ 
	printf( '<!-- %1$s -->', __( 'Analytics is not available for development environments', 'maxson' ) );
	return;

} else
{ 
	$custom_vars = array( 
		"ga( 'create', '{$tracking_code}', 'auto' );", 
		"ga( 'send', 'pageview' );"
	);

	if( is_404() )
	{ 
		// This is a 404 and we are supposed to track them
		$custom_vars[] = "ga( 'send', 'event', 'error', '404', 'page: ' + document.location.pathname + document.location.search + ' ref: ' + document.referrer, {'nonInteraction': true} );";
	} // endif

	?>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	<?php echo join( "\r\n\t", $custom_vars ) . "\r\n"; ?> 
</script>

<?php } // endif ?>