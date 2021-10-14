<?php
/**
 * Load our various installer screen tabs for the admin.
 *
 * @package StellarWPInstaller
 */

// Declare our namespace.
namespace StellarWP\PluginInstaller\Admin\Tabs;

// Set our aliases.
use StellarWP\PluginInstaller as Core;
use StellarWP\PluginInstaller\Admin\Data as AdminData;

/**
 * Start our engines.
 */
add_filter( 'install_plugins_tabs', __NAMESPACE__ . '\add_installer_tab' );
add_filter( 'install_plugins_table_api_args_stellarwp', __NAMESPACE__ . '\load_installer_tab_args' );
add_filter( 'plugins_api_result', __NAMESPACE__ . '\load_installer_tab_results', 10, 3 );
add_action( 'install_plugins_stellarwp', __NAMESPACE__ . '\display_installer_tab_table' );

/**
 * Add our custom tab for StellarWP plugins.
 *
 * @param  array $tabs  The existing array of tabs.
 *
 * @return array        Our modified array.
 */
function add_installer_tab( $tabs ) {

	// Add ours assuming it isn't already there.
	if ( ! isset( $tabs['stellarwp'] ) ) {

		// Add the slug and label.
		$tabs['stellarwp'] = __( 'StellarWP', 'stellarwp-plugin-installer' );
	}

	// And send them back.
	return $tabs;
}

/**
 * Side-load our plugins into the API setup.
 *
 * @param  array $args  The existing array of args.
 *
 * @return array        Our modified array.
 */
function load_installer_tab_args( $args ) {

	// We set a query using an author that will never exist.
	$set_query_args = array(
		'author'   => 'stellarwp-installer',
		'page'     => 1,
		'per_page' => 99
	);

	// Return the setup cast as an object.
	return $set_query_args;
}

/**
 * Load up the plugins we wanna use, bypassing a lot of API stuff.
 *
 * @param  object|WP_Error $response  Response object or WP_Error.
 * @param  string          $action   The type of information being requested from the Plugin Installation API.
 * @param  object          $args     Plugin API arguments.
 *
 * @return object
 */
function load_installer_tab_results( $response, $action, $args ) {

	// Bail if we aren't on our specific query.
	if ( is_wp_error( $response ) || 'query_plugins' !== $action || empty( $args->author ) || 'stellarwp-installer' !== $args->author ) {
		return $response;
	}

	// Get our requested plugins.
	$get_plugin_details = AdminData\get_stellarwp_plugin_api_data();

	// Set our info portion of the array.
	$return_args['info'] = array(
		'page'    => 1,
		'pages'   => 1,
		'results' => count( $get_plugin_details ),
	);

	// Now add in all the stuff we got.
	$return_args['plugins'] = $get_plugin_details;

	// Return them, cast as an object.
	return (object) $return_args;
}

/**
 * Show our table of plugins.
 *
 * @return HTML
 */
function display_installer_tab_table() {

	// Include the list table global.
	global $wp_list_table;

	// This is gonna probably be a banner or something.
	echo '<p>' . __( 'Below are plugins from the StellarWP family of brands' ) . '</p>';

	// Now render the table display, wrapped in a form post.
	echo '<form id="plugin-filter" method="post">';
		$wp_list_table->display();
	echo '</form>';
}
