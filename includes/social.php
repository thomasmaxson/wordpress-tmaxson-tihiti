<?php 
/**
 * Theme Social Details
 * 
 * @package    WordPress
 * @subpackage Thomas Maxson v3 - A Thomas Maxson Theme
 * @since      1.0
 */

if( ! defined( 'ABSPATH' ) ) 
{ 
	die;

} // endif


if( ! function_exists( 'maxson_query_social_icon_details' ) )
{ 
	/**
	 * Find social details
	 * 
	 * @return      array
	 */

	function maxson_query_social_icon_details( $link, $key = 'key' )
	{ 
		$details = maxson_get_social_icon_details();

		foreach( $details as $detailsKey => $detailsVal )
		{ 
			if( strpos( $link, $detailsVal[ $key ] ) !== false )
			{ 
				return $detailsVal;

			} // endif
		} // endforeach

		return array();
	}
} // endif


if( ! function_exists( 'maxson_query_social_icon_details_via_key' ) )
{ 
	/**
	 * Find social details by supplied key
	 * 
	 * @return      array
	 */

	function maxson_query_social_icon_details_via_key( $link )
	{ 
		return maxson_query_social_icon_details( $link, 'key' );
	}
} // endif


if( ! function_exists( 'maxson_query_social_icon_details_via_url' ) )
{ 
	/**
	 * Find social details by supplied URL
	 * 
	 * @return      array
	 */

	function maxson_query_social_icon_details_via_url( $link )
	{ 
		return maxson_query_social_icon_details( $link, 'url' );
	}
} // endif


if( ! function_exists( 'maxson_get_social_icon_details' ) )
{ 
	/**
	 * Get social icon details
	 * 
	 * @return      array Multidimensional array containing social media data
	 */

	function maxson_get_social_icon_details()
	{ 
		$social_icons = array(
			array( 
				'key'   => 'behance', 
				'url'   => 'behance.net', 
				'icon'  => 'fab fa-behance', 
				'title' => esc_html__( 'Follow me on Behance', 'maxson' )

			), 
			array( 
				'key'   => 'bitbucket', 
				'url'   => 'bitbucket.org', 
				'icon'  => 'fab fa-bitbucket', 
				'title' => esc_html__( 'Fork me on Bitbucket', 'maxson' )

			), 
			array( 
				'key'   => 'codepen', 
				'url'   => 'codepen.io', 
				'icon'  => 'fab fa-codepen', 
				'title' => esc_html__( 'Follow me on CodePen', 'maxson' )

			), 
			array( 
				'key'   => 'deviantart', 
				'url'   => 'deviantart.com', 
				'icon'  => 'fab fa-deviantart', 
				'title' => esc_html__( 'Watch me on DeviantArt', 'maxson' )

			), 
			array( 
				'key'   => 'discord', 
				'url'   => 'discord.gg', 
				'icon'  => 'fab fa-discord', 
				'title' => esc_html__( 'Join me on Discord', 'maxson' )

			), 
			array( 
				'key'   => 'dribbble', 
				'url'   => 'dribbble.com', 
				'icon'  => 'fab fa-dribbble', 
				'title' => esc_html__( 'Follow me on Dribbble', 'maxson' )

			), 
			array( 
				'key'   => 'etsy', 
				'url'   => 'etsy.com', 
				'icon'  => 'fab fa-etsy', 
				'title' => esc_html__( 'favorite me on Etsy', 'maxson' )

			), 
			array( 
				'key'   => 'facebook', 
				'url'   => 'facebook.com', 
				'icon'  => 'fab fa-facebook-f', 
				'title' => esc_html__( 'Like me on Facebook', 'maxson' )

			), 
			array( 
				'key'   => 'flickr', 
				'url'   => 'flickr.com', 
				'icon'  => 'fab fa-flickr', 
				'title' => esc_html__( 'Connect with me on Flickr', 'maxson' )

			), 
			array( 
				'key'   => 'foursquare', 
				'url'   => 'foursquare.com', 
				'icon'  => 'fab fa-foursquare', 
				'title' => esc_html__( 'Follow me on Foursquare', 'maxson' )

			), 
			array( 
				'key'   => 'github', 
				'url'   => 'github.com', 
				'icon'  => 'fab fa-github', 
				'title' => esc_html__( 'Fork me on GitHub', 'maxson' )

			), 
			array( 
				'key'   => 'instagram', 
				'url'   => 'instagram.com', 
				'icon'  => 'fab fa-instagram', 
				'title' => esc_html__( 'Follow me on Instagram', 'maxson' )

			), 
			array( 
				'key'   => 'kickstarter', 
				'url'   => 'kickstarter.com', 
				'icon'  => 'fab fa-kickstarter-k', 
				'title' => esc_html__( 'Back me on Kickstarter', 'maxson' )

			), 
			array( 
				'key'   => 'linkedin', 
				'url'   => 'linkedin.com', 
				'icon'  => 'fab fa-linkedin-in', 
				'title' => esc_html__( 'Connect with me on LinkedIn', 'maxson' )

			), 
			array( 
				'key'   => 'medium', 
				'url'   => 'medium.com', 
				'icon'  => 'fab fa-medium-m', 
				'title' => esc_html__( 'Follow me on Medium', 'maxson' )

			), 
			array( 
				'key'   => 'patreon', 
				'url'   => 'patreon.com', 
				'icon'  => 'fab fa-patreon', 
				'title' => esc_html__( 'Support me on Patreon', 'maxson' )

			), 
			array( 
				'key'   => 'pinterest', 
				'url'   => 'pinterest.com', 
				'icon'  => 'fab fa-pinterest-p', 
				'title' => esc_html__( 'Follow me on Pinterest', 'maxson' )

			), 
			array( 
				'key'   => 'reddit', 
				'url'   => 'reddit.com', 
				'icon'  => 'fab fa-reddit-alien', 
				'title' => esc_html__( 'Join me on Reddit', 'maxson' )

			), 
			array( 
				'key'   => 'slack', 
				'url'   => 'slack.com', 
				'icon'  => 'fab fa-slack-hash', 
				'title' => esc_html__( 'Join me on Slack', 'maxson' )

			), 
			array( 
				'key'   => 'snapchat', 
				'url'   => 'snapchat.com', 
				'icon'  => 'fab fa-snapchat-ghost', 
				'title' => esc_html__( 'Add me on Snapchat', 'maxson' )

			), 
			array( 
				'key'   => 'soundcloud', 
				'url'   => 'soundcloud.com', 
				'icon'  => 'fab fa-soundcloud', 
				'title' => esc_html__( 'Follow me on SoundCloud', 'maxson' )

			), 
			array( 
				'key'   => 'spotify', 
				'url'   => 'spotify.com', 
				'icon'  => 'fab fa-spotify', 
				'title' => esc_html__( 'Follow me on Spotify', 'maxson' )

			), 
			array( 
				'key'   => 'stackoverflow', 
				'url'   => 'stackoverflow.com', 
				'icon'  => 'fab fa-stack-overflow', 
				'title' => esc_html__( 'Join me on Stack Overflow', 'maxson' )

			), 
			array( 
				'key'   => 'tumblr', 
				'url'   => 'tumblr.com', 
				'icon'  => 'fab fa-tumblr', 
				'title' => esc_html__( 'Follow me on Tumblr', 'maxson' )

			), 
			array( 
				'key'   => 'twitch', 
				'url'   => 'twitch.tv', 
				'icon'  => 'fab fa-twitch', 
				'title' => esc_html__( 'Follow me on Twitch', 'maxson' )

			), 
			array( 
				'key'   => 'twitter', 
				'url'   => 'twitter.com', 
				'icon'  => 'fab fa-twitter', 
				'title' => esc_html__( 'Follow me on Twitter', 'maxson' )

			), 
			array( 
				'key'   => 'vimeo', 
				'url'   => 'vimeo.com', 
				'icon'  => 'fab fa-vimeo-v', 
				'title' => esc_html__( 'Follow me on Vimeo', 'maxson' )

			), 
			array( 
				'key'   => 'youtube', 
				'url'   => 'youtube.com', 
				'icon'  => 'fab fa-youtube', 
				'title' => esc_html__( 'Subscribe to me on YouTube', 'maxson' )
			),
		);

		return apply_filters( 'maxson_social_icon_details', $social_icons );
	}
}

?>