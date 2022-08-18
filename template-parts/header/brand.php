<?php
/**
 * Displays header site brand
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

$description = get_bloginfo( 'description', 'display' );

?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand" rel="home">
	<?php echo maxson_get_theme_brand_inverse_logo(); ?>
	<div class="navbar-brand-name">
		<?php if( ( is_front_page() || is_home() ) && ! is_page() )
		{ ?>
			<h1 class="navbar-brand-title"><?php bloginfo( 'name' ); ?></h1>

		<?php } else
		{ ?>
			<p class="navbar-brand-title"><?php bloginfo( 'name' ); ?></p>

		<?php } // endif


		if( $description || is_customize_preview() )
		{ ?>
			<p class="navbar-brand-description"><?php echo $description; ?></p>

		<?php } // endif ?>
	</div>
</a>