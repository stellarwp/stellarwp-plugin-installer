<?php
/**
 * Our uninstall call.
 *
 * @package StellarWPInstaller
 */

// Declare our namespace.
namespace StellarWP\PluginInstaller\Uninstall;

// Set our aliases.
use StellarWP\PluginInstaller as Core;

/**
 * Run anything tied to our uninstall (deleting).
 *
 * @return void
 */
function uninstall() {

	// Include our action so that we may add to this later.
	do_action( Core\HOOK_PREFIX . 'before_uninstall_process' );

	// Include our action so that we may add to this later.
	do_action( Core\HOOK_PREFIX . 'after_uninstall_process' );

	// And flush our rewrite rules.
	flush_rewrite_rules();
}
register_uninstall_hook( Core\FILE, __NAMESPACE__ . '\uninstall' );