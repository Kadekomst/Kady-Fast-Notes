<?php
/**
 * globals.php
 * ----------------------------------------
 * API functions-wrapper for global object
 * like $kfn, $kfn_hook, $kfn_widget etc.
 *
 * Note:
 * Function-wrapper for $kfn global object
 * kfn() is defined in kfn.php, it is
 * necessary to run the plugin
 * ----------------------------------------
 * @since 1.0.0
 * @author Kadekomst
 */

/**
 * kfn_settings()
 * -----------------------------------------------------------
 * Returns $kfn_settings global object if it is already set
 * @return WP_Error
 */
function kfn_settings()
{
	global $kfn_settings;

	if ( kfn_is_global_valid( $kfn_settings ) ) {
		return $kfn_settings;
	}

	return new WP_Error('kfn_settings_global_validation_error', '$kfn_settings global object was not set or is empty!');
}

function kfn_is_global_valid( $obj )
{
	if ( isset( $obj ) && !empty( $obj ) ) {
		return true;
	}

	return false;
}



