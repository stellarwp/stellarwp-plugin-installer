<?php
/**
 * Our activation call.
 *
 * @package StellarWPInstaller
 */

// Declare our namespace.
namespace StellarWP\PluginInstaller\Activate;

// Set our aliases.
use StellarWP\PluginInstaller as Core;

/**
 * Run anything tied to our initial activation.
 *
 * @return void
 */
function activate() {

	// Include our action so that we may add to this later.
	do_action( Core\HOOK_PREFIX . 'before_activate_process' );

	// Include our action so that we may add to this later.
	do_action( Core\HOOK_PREFIX . 'after_activate_process' );

	// And flush our rewrite rules.
	flush_rewrite_rules();
}
register_activation_hook( Core\FILE, __NAMESPACE__ . '\activate' );
