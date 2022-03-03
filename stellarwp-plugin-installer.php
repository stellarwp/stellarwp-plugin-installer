<?php
/**
 * Plugin Name: StellarWP Plugin Installer
 * Plugin URI:  https://stellarwp.com/
 * Description: Show the free plugins from StellarWP brands as recommended plugins on the Add New Plugin screen.
 * Version:     1.0.1-dev
 * Author:      Stellar WP
 * Author URI:  https://stellarwp.com/
 * Text Domain: stellarwp-plugin-installer
 * Domain Path: /languages
 * License:     MIT
 */

// Call our namepsace.
namespace StellarWP\PluginInstaller;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; } // phpcs:ignore

define( __NAMESPACE__ . '\URL', plugin_dir_url( __FILE__ ) );
define( __NAMESPACE__ . '\ASSETS_URL', URL . 'assets' );

define( __NAMESPACE__ . '\CACHE_PREFIX', 'swp_pi_cache_' );
define( __NAMESPACE__ . '\HOOK_PREFIX', 'swp_installer_' );

define( __NAMESPACE__ . '\TAB_SLUG', 'stellarwp' );

// Pull in the individual admin pieces.
require_once __DIR__ . '/src/data.php';
require_once __DIR__ . '/src/tabs.php';
