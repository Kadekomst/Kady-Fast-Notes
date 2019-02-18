<?php
/**
 * uninstall.php
 * -------------------------------------------
 * Uninstalling of Kady Fast Notes.
 *
 * This file is managed by WordPress to
 * correctly uninstall Kady Fast Notes plugin
 * -------------------------------------------
 * @since 1.0.0
 * @author Kadekomst
 */

global $kfn;
$kfn->load_api();

// If accessed directly, bail
if ( !defined('WP_UNINSTALL_PLUGIN') ) {
	exit('Direct access is not allowed!');
}

// Plugin deleting functionality
function kfn_delete_plugin()
{
	$defaults = kfn_get_option('defaults');
}


