<?php
/**
 * Template for displaying the main header
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

$navbar_class    = maxson_get_header_style_class();
$navbar_position = maxson_get_header_position_class();

?><!DOCTYPE html>
<!--[if lt IE 9 ]><html class="ie ie8 no-js" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9 ]>   <html class="ie ie9 no-js" <?php language_attributes(); ?>><![endif]-->
<!--[if (gte IE 9)|!(IEMobile)|!(IE)]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">

<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P6XXG5H');</script>

<?php wp_head(); // Always have wp_head() just before the closing </head> tag of your theme. ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); // Always have wp_body_open() just after the opening <body> tag of your theme ?>
<a href="#content" class="sr-only sr-only-focusable skip-to-content" title="<?php echo esc_attr_x( 'Skip to content', 'A link that gives users the ability to skip to the primary content of the page.', 'maxson' ); ?>"><?php _ex( 'Skip to content', 'A link that gives users the ability to skip to the primary content of the page.', 'maxson' ); ?></a>

<header class="site-header navbar <?php echo sanitize_html_class( $navbar_class ); ?> <?php echo sanitize_html_class( $navbar_position ); ?>" id="top" itemscope itemtype="http://schema.org/WPHeader">
	<div class="container">
		<div class="navbar-header">
			<?php if( has_nav_menu( 'primary' ) )
			{ ?>
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#primary-menu" aria-controls="top-menu" aria-expanded="false"><?php _e( 'Menu', 'maxson' ); ?></button>

			<?php } // endif ?>
			<?php get_template_part( 'template-parts/header/brand' ); ?>
		</div><!-- .navbar-header -->
		<?php get_template_part( 'template-parts/navigation/primary' ); ?>
	</div><!-- .container -->
</header>

<main id="content" class="site-body" itemscope itemtype="http://schema.org/WebPageElement">
	<div itemprop="mainContentOfPage">