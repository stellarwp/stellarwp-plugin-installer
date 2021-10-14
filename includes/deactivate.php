<?php
/**
 * Our deactivation call.
 *
 * @package StellarWPInstaller
 */

// Declare our namespace.
namespace StellarWP\PluginInstaller\Deactivate;

// Set our aliases.
use StellarWP\PluginInstaller as Core;

/**
 * Run anything tied to our deactivation.
 *
 * @return void
 */
function deactivate() {

	// Include our action so that we may add to this later.
	do_action( Core\HOOK_PREFIX . 'before_deactivate_process' );

	// Include our action so that we may add to this later.
	do_action( Core\HOOK_PREFIX . 'after_deactivate_process' );

	// And flush our rewrite rules.
	flush_rewrite_rules();
}
register_deactivation_hook( Core\FILE, __NAMESPACE__ . '\deactivate' );
