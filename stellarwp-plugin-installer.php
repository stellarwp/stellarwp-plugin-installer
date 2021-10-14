<?php
/**
 * Plugin Name: StellarWP Plugin Installer
 * Plugin URI:  https://stellarwp.com/
 * Description: A user-friendly interface for installing plugins from StellarWP
 * Version:     0.0.1-dev
 * Author:      Andrew Norcross
 * Author URI:  https://github.com/norcross/
 * Text Domain: stellarwp-plugin-installer
 * Domain Path: /languages
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 *
 * @package StellarWPInstaller
 */

// Call our namepsace.
namespace StellarWP\PluginInstaller;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Define our version.
define( __NAMESPACE__ . '\VERS', '0.0.1-dev' );

// Plugin Folder URL.
define( __NAMESPACE__ . '\URL', plugin_dir_url( __FILE__ ) );

// Plugin root file.
define( __NAMESPACE__ . '\FILE', __FILE__ );

// Plugin root file.
define( __NAMESPACE__ . '\PLUGIN', plugin_basename( __FILE__ ) );

// Define the various prefixes we use.
define( __NAMESPACE__ . '\OPTION_PREFIX', 'swp_installer_data_' );
define( __NAMESPACE__ . '\CACHE_PREFIX', 'swp_pi_cache_' );
define( __NAMESPACE__ . '\HOOK_PREFIX', 'swp_installer_' );
define( __NAMESPACE__ . '\NONCE_PREFIX', 'swp_pi_nonce_' );

// And load our files.
stellarwp_plugin_installer_file_load();

/**
 * The function that loads the files.
 *
 * @return void
 */
function stellarwp_plugin_installer_file_load() {

	// Pull in the individual admin pieces.
	require_once __DIR__ . '/includes/admin/data.php';
	require_once __DIR__ . '/includes/admin/tabs.php';

	// And last, load the activations and whatnot.
	require_once __DIR__ . '/includes/activate.php';
	require_once __DIR__ . '/includes/deactivate.php';
	require_once __DIR__ . '/includes/uninstall.php';
}
