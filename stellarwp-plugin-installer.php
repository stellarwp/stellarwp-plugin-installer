<?php
/**
 * Plugin Name: StellarWP Plugin Installer
 * Plugin URI:  https://stellarwp.com/
 * Description: A user-friendly interface for installing plugins from StellarWP.
 * Version:     0.0.1-dev
 * Author:      Stellar WP
 * Author URI:  https://stellarwp.com/
 * Text Domain: stellarwp-plugin-installer
 * Domain Path: /languages
 * License:     MIT
 */


// To update plugins shown, modify the array in get_stellarwp_plugin_array();

// Call our namepsace.
namespace StellarWP\PluginInstaller;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; } // phpcs:ignore

// Pull in the individual admin pieces.
require_once __DIR__ . '/src/data.php';
require_once __DIR__ . '/src/tabs.php';
