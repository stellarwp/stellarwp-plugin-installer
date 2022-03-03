<?php
/**
 * Load our various installer screen tabs for the admin.
 */

namespace StellarWP\PluginInstaller\Tabs;

use StellarWP\PluginInstaller as Core;
use StellarWP\PluginInstaller\Data;

/**
 * Start our engines.
 */
add_action( 'admin_head', __NAMESPACE__ . '\display_installer_tab_css' );
add_filter( 'install_plugins_tabs', __NAMESPACE__ . '\add_installer_tab' );
add_filter( 'install_plugins_table_api_args_stellarwp', __NAMESPACE__ . '\load_installer_tab_args' );
add_filter( 'plugins_api_result', __NAMESPACE__ . '\load_installer_tab_results', 10, 3 );
add_action( 'install_plugins_stellarwp', __NAMESPACE__ . '\display_installer_tab_table' );
add_action( 'install_plugins_table_header', __NAMESPACE__ . '\display_installer_tab_content' );

/**
 * Add a bit of CSS for our installer tab.
 *
 * @return void
 */
function display_installer_tab_css() {
	?>
	<style>
		p.stellarwp-kadence-banner-wrap {
			text-align: center;
		}

		a.stellarwp-kadence-banner-link {
			display: block;
			margin: 0 auto;
		}

		span.stellarwp-content-intro {
			display: inline-block;
			margin: 5px 0;
		}
	</style>
	<?php
}

/**
 * Add our custom tab for StellarWP plugins.
 *
 * @param array $tabs The existing array of tabs.
 *
 * @return array Our modified array.
 */
function add_installer_tab( $tabs ) {
	return array_merge( [ Core\TAB_SLUG => __( 'StellarWP', 'stellarwp-plugin-installer' ) ], $tabs );
}

/**
 * Set the query args that core will use to look up plugins.
 *
 * @return array Our arguments to pass on, which we already know will return nothing.
 */
function load_installer_tab_args() {

	// We set a query using an author that will never exist.
	return [
		'author'   => 'stellarwp-plugin-installer',
		'page'     => 1,
		'per_page' => 99,
	];
}

/**
 * Load up the plugins we wanna use, bypassing a lot of API stuff.
 *
 * @param object|WP_Error $response Response object or WP_Error.
 * @param string          $action   The type of information being requested from the Plugin Installation API.
 * @param object          $args     Plugin API arguments.
 *
 * @return object Our modified response object.
 */
function load_installer_tab_results( $response, $action, $args ) {

	// Bail if we aren't on our specific query.
	if ( is_wp_error( $response ) || 'query_plugins' !== $action || empty( $args->author ) || 'stellarwp-plugin-installer' !== $args->author ) {
		return $response;
	}

	// Get our requested plugins.
	$get_plugin_details = (array) Data\get_stellarwp_plugin_api_data();

	// Set our info portion of the array.
	$return_args['info'] = [
		'page'    => 1,
		'pages'   => 1,
		'results' => count( $get_plugin_details ),
	];

	// Now add in all the stuff we got.
	$return_args['plugins'] = $get_plugin_details;

	// Return them, cast as an object, because that's what this version of wp-list-table wants and who are we to question that?
	return (object) $return_args;
}

/**
 * Show our table of plugins.
 *
 * @return string HTML markup.
 */
function display_installer_tab_table() {

	// Include the list table global.
	global $wp_list_table;

	// Get our Kadence info.
	$kadence_data = Data\get_kadence_theme_info();

	// Wrap the Kadence banner in a div.
	echo '<p class="stellarwp-kadence-banner-wrap">';
		echo '<a title="' . esc_attr( $kadence_data['text'] ) . '" class="stellarwp-kadence-banner-link" href="' . esc_url( $kadence_data['link'] ) . '"><img src="' . esc_url( $kadence_data['banner'] ) . '"></a>';
	echo '</p>';

	// Now render the table display, wrapped in a form post so it works.
	echo '<form id="plugin-filter" method="post">';
		$wp_list_table->display();
	echo '</form>';
}

/**
 * Include a bit of content for guiding users.
 *
 * @return string HTML markup.
 */
function display_installer_tab_content() {

	// Only show this on our tab.
	if ( empty( $GLOBALS['tab'] ) || Core\TAB_SLUG !== sanitize_text_field( $GLOBALS['tab'] ) ) {
		return;
	}

	// Display a small bit of content.
	echo '<span class="stellarwp-content-intro">' . esc_html__( 'Scroll down to install any of the plugins from the StellarWP brand of companies.', 'stellarwp-plugin-installer' ) . '</span>';
}
