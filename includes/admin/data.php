<?php
/**
 * Our data fetching and construction functions to use across the plugin.
 *
 * @package StellarWPInstaller
 */

// Declare our namespace.
namespace StellarWP\PluginInstaller\Admin\Data;

// Set our aliases.
use StellarWP\PluginInstaller as Core;

/**
 * Get all the info for the plugins we wanna show.
 *
 * @param  boolean $return_keys  Whether to return just the keys.
 *
 * @return array
 */
function get_stellarwp_plugin_array( $return_keys = true ) {

	// Set our array of slugs and labels.
	$set_plugin_slugs	= array(
		'give'                 => __( 'GiveWP', 'stellarwp-plugin-installer' ),
		'the-events-calendar'  => __( 'The Events Calendar', 'stellarwp-plugin-installer' ),
		'event-tickets'        => __( 'Event Tickets', 'stellarwp-plugin-installer' ),
		'kadence-blocks'       => __( 'Kadence Blocks', 'stellarwp-plugin-installer' ),
	);

	// Return them all, or just the keys.
	return false !== $return_keys ? array_keys( $set_plugin_slugs) : $set_plugin_slugs;
}

/**
 * Attempt to get all the data we need.
 *
 * @return array
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

	// If we have none, do the things.
	if ( false === $cached_dataset ) {

		// Get my slugs.
		$get_slugs  = get_stellarwp_plugin_array();

		// Set an empty for the return.
		$set_return = array();

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
		set_transient( $ky, $set_return, HOUR_IN_SECONDS );

		// And change the variable to do the things.
		$cached_dataset = $set_return;
	}

	// Return the dataset.
	return $cached_dataset;
}

/**
 * Get all the info for the plugins we wanna show.
 *
 * @param  boolean $return_keys  Whether to return just the keys.
 *
 * @return array
 */
function get_plugin_dot_org_data( $plugin_slug = '' ) {

	// Bail if our slug is missing.
	if ( empty( $plugin_slug ) ) {
		return false;
	}

	// Set the args for looking up a plugin.
	$set_info_args  = array(
		'slug'   => $plugin_slug,
		'fields' => array(
			'sections'          => false,
			'short_description' => true,
			'icons'             => true,
			'contributors'      => false,
			'screenshots'       => false,
			'versions'          => false,
		),
	);

	// Try to retrieve the information.
	return plugins_api( 'plugin_information', $set_info_args );
}
