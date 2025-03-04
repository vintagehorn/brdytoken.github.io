<?php

/**
 * Custom Feed class.
 */
class Feed {

	/**
	 * Constructor class.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'add_custom_feed' ) );
	}

	/**
	 * Add a custom feed.
	 */
	public function add_custom_feed() {

		// Set the slug of the custom feed.
		$feed_slug = 'brdy-feed';

		if ( ! empty( $feed_slug ) ) {
			add_feed( $feed_slug, array( $this, 'feed_callback' ) );
		}
	}

	/**
	 * Callback function for add_feed to locate the correct template.
	 */
	public function feed_callback() {
		add_filter( 'pre_option_rss_use_excerpt', '__return_zero' );

		$template = locate_template( 'feed-rss2-brdy.php' );

		if ( ! $template ) {
			$template = __DIR__ . '/feed-rss2-brdy.php';
		}

		load_template( $template );
	}
}

new Feed();