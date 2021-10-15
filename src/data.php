<?php
/**
 * Our data fetching and construction functions to use across the plugin.
 */

namespace StellarWP\PluginInstaller\Data;

use StellarWP\PluginInstaller as Core;

/**
 * Get all the info for the plugins we wanna show.
 *
 * @return array The array of plugin data.
 */
function get_stellarwp_plugin_array() {

	// Set our array: Key is the plugin slug on WP.org, value is the name of the plugin.
	return array_keys( apply_filters( Core\HOOK_PREFIX . 'suggested_plugins', [
		'give'                => __( 'GiveWP', 'stellarwp-plugin-installer' ),
		'the-events-calendar' => __( 'The Events Calendar', 'stellarwp-plugin-installer' ),
		'event-tickets'       => __( 'Event Tickets', 'stellarwp-plugin-installer' ),
		'kadence-blocks'      => __( 'Kadence Blocks', 'stellarwp-plugin-installer' ),
	] ) );
}

/**
 * Fetch the data for a single plugin from dot org.
 *
 * @param string $plugin_slug Which slug to look up on dot org.
 *
 * @return mixed Usually an object but that API can be finicky.
 */
function get_plugin_dot_org_data( $plugin_slug = '' ) {

	// Bail if our slug is missing.
	if ( empty( $plugin_slug ) ) {
		return false;
	}

	// Set the args for looking up a plugin.
	$set_info_args = [
		'slug'   => sanitize_text_field( $plugin_slug ),
		'fields' => [
			'sections'          => false,
			'short_description' => true,
			'icons'             => true,
			'contributors'      => false,
			'screenshots'       => false,
			'versions'          => false,
		],
	];

	// Try to retrieve the information.
	return plugins_api( 'plugin_information', $set_info_args );
}

/**
 * Attempt to get all the data we need.
 *
 * @return array The array of plugin data.
 */
function get_stellarwp_plugin_api_data() {

	// Set the key to use in our transient.
	$ky = Core\CACHE_PREFIX . 'plugin_api_data';

	// If we don't want the cache'd version, delete the transient first.
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		delete_transient( $ky );
	}

	// Attempt to get the reviews from the cache.
	$cached_dataset = get_transient( $ky );

	// Return the cached version if we have it.
	if ( false !== $cached_dataset ) {
		return $cached_dataset;
	}

	// No cache'd version, so begin with the slugs.
	$get_slugs = get_stellarwp_plugin_array();

	// Bail if there are no slugs in the array.
	if ( empty( $get_slugs ) ) {
		return false;
	}

	// Set an empty array for the return.
	$set_return = [];

	// Loop and test.
	foreach ( $get_slugs as $single_slug ) {

		// Attempt to get the single data.
		$fetch_data = get_plugin_dot_org_data( $single_slug );

		// Skip if we don't have it.
		if ( empty( $fetch_data ) || is_wp_error( $fetch_data ) ) {
			continue;
		}

		// Now add the results into the larger array.
		$set_return[] = (array) $fetch_data;
	}

	// Bail if there are no items in the array.
	if ( empty( $set_return ) ) {
		return false;
	}

	// Set our transient with our data.
	set_transient( $ky, $set_return, 5 * MINUTE_IN_SECONDS );

	// Return the dataset.
	return $set_return;
}
