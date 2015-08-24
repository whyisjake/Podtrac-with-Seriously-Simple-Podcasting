<?php
/*
Plugin Name: Add Podtrac to Seriously Simple Podcasting
Version: 0.5
Description: Add filters to add Podtrac settings to Seriously Simple Podcasting.
Author: Jake Spurlock
Author URI: http://jakespurlock.com
Text Domain: podtrac-ss-podcasting
Domain Path: /languages
*/

add_filter( 'ssp_settings_fields', 'podtrac_add_new_settings' );

/**
 * Add new settings with a new tab to Seriously Simple Podcasting.
 *
 * @param  array    $settings    Array of fields to pass into the main array of settings options of Seriously Simple Podcasting
 * @return array                 The full array.
 */
function podtrac_add_new_settings( $settings ) {

	$settings['podtrac'] = array(
		'title'       => __( 'Podtrac', 'podtrac-ss-podcasting' ),
		'description' => __( 'If you are using Podtrac in conjunction with Seriously Simple Podcasting, add your feed settings here.', 'podtrac-ss-podcasting' ),
		'fields'      => array(
			array(
				'id'          => 'podtrac_episode_measurement_service',
				'label'       => __( 'Podtrac Episode Measurement Service', 'podtrac-podtrac-ss-podcasting' ),
				'description' => 'Podtrac\'s Measurement Service is free to most publishers. It provides third-party measurement data not available anywhere else. When using this, all enclosure URLs will be prefixed, and do not need to be updated by the user.',
				'type'        => 'checkbox',
				'default'     => '',
			),
			array(
				'id'          => 'redirect_feed',
				'label'       => __( 'Redirect podcast feed to Podtrac URL', 'podtrac-ss-podcasting' ),
				'description' => 'Redirect your feed to a new URL (specified below). This will inform all podcasting services that your podcast has moved and 48 hours after you have saved this option it will permanently redirect your feed to the new URL.  If you would like Podtrac to give you subscriber reports for your feeds (and automatically include the measurement service for your episode files), enable the Enhanced Feed Service below and then register the Podtrac feed URL with iTunes and other aggregators.',
				'type'        => 'checkbox',
				'default'     => '',
			),
			array(
				'id'          => 'new_feed_url',
				'label'       => __( 'Podtrac Feed URL', 'podtrac-ss-podcasting' ),
				'description' => __( 'Your Podtrac feed\'s new URL.', 'podtrac-ss-podcasting' ),
				'type'        => 'text',
				'default'     => '',
				'placeholder' => __( 'New feed URL', 'podtrac-ss-podcasting' ),
				'callback'    => 'esc_url_raw',
				'class'       => 'regular-text',
			),
		)
	);

	return $settings;
}

add_filter( 'ssp_episode_download_link', 'podtrac_download_url_filter' );

/**
 * If we have the option enabled for the measurement service, filter that onto the URL.
 *
 * @param  string     $link          The URL pointing to the file download.
 * @param  integer    $episode_id    The post ID of the podcast episode.
 * @param  string     $file          The full path to the episode audio file.
 * @return string                    The URL pointing to the file download.
 */
function podtrac_download_url_filter( $link, $episode_id, $file ) {
	$redirect = get_option( 'ss_podcasting_podtrac_episode_measurement_service', 'off' );

	if ( $redirect === 'on' ) {
		$parsed = parse_url( $link );
		$link = esc_url( 'http://www.podtrac.com/pts/redirect.mp3/' . $parsed['host'] . $parsed['path'] );
	}

	return $link;
}