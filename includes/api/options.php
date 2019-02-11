<?php
/**
 * options.php
 * --------------------------------------------------------------------------
 * File contains API functions-wrappers for KFN_Options class functionality.
 *
 * For more information about Options API, see includes/class-kfn-options.php,
 * wp-includes/option.php and documentation page placed in @link tag
 *
 * Part of KFN plugin source code.
 * --------------------------------------------------------------------------
 * @since 1.0.0
 * @link https://developer.wordpress.org/plugins/settings/options-api/
 */

/**
 * kfn_get_option( $option )
 * ----------------------------------------------------------
 * API function.
 * Returns request KFN option like url, path, version etc.
 * Wrapper for KFN_Options->get_option( $option )
 * -----------------------------------------------------------
 * @since 1.0.0
 *
 * @param $option
 *
 * @return \KFN\includes\KFN_Options|WP_Error|bool;
 */
function kfn_get_option( $option ) {
	global $kfn_options;

	if ( isset( $kfn_options ) && method_exists( $kfn_options, 'get_option') ) {
		return $kfn_options->get_option( $option );
	} else {
		return new WP_Error('kfn_update_option_func_undefined_global', 'Global $kfn_options or its method update_option() was not defined!');
	}
}

/**
 * kfn_get_default_option( $option )
 * ----------------------------------------------------------
 * API function.
 * Returns request default KFN option like url, path,
 * plugin_name etc.
 * -----------------------------------------------------------
 * @since 1.0.0
 *
 * @param $option
 *
 * @return \KFN\includes\KFN_Options|WP_Error|bool;
 */
function kfn_get_default_option( $option ) {
	global $kfn_options;

	if ( isset( $kfn_options ) && method_exists( $kfn_options, 'get_option') ) {
		return $kfn_options->get_option( 'defaults' )[ $option ];
	} else {
		return new WP_Error('kfn_update_option_func_undefined_global', 'Global $kfn_options or its method update_option() was not defined!');
	}
}

/**
 * kfn_has_option( $option )
 * ----------------------------------------------------------
 * API function.
 * Check for existence of requested plugin option
 * Wrapper for KFN_Options->has_option( $option )
 * -----------------------------------------------------------
 *
 * @param $option
 *
 * @return WP_Error|\KFN\includes\KFN_Options;
 */
function kfn_has_option( $option ) {
	global $kfn_options;

	if ( isset( $kfn_options ) && method_exists( $kfn_options, 'get_option') ) {
		return $kfn_options->get_option( $option );
	} else {
		return new WP_Error('kfn_update_option_func_undefined_global', 'Global $kfn_options or its method update_option() was not defined!');
	}
}
/**
 * kfn_update_option( $option )
 * ----------------------------------------------------------
 * API function.
 * Updates specified option of the plugin.
 * More info in includes/class-kfn-options.php:84
 * Wrapper for KFN_Options->has_option( $option )
 * -----------------------------------------------------------
 * @since 1.0.0
 *
 * @param string $option / Plugin option
 * @param $value / New value for the specified plugin option
 *
 * @return WP_Error|bool
 */
function kfn_update_option( $option, $value )
{
	global $kfn_options;

	if ( isset( $kfn_options ) && method_exists( $kfn_options, 'update_option') ) {
		$kfn_options->update_option( $option, $value );
	} else {
		return new WP_Error('kfn_update_option_func_undefined_global', 'Global $kfn_options or its method update_option() was not defined!');
	}

	return true;
}
/**
 * kfn_add_option( $option, $value )
 * -------------------------------------------------------------------------
 * API function.
 * Adds new plugin option.
 * Wrapper for KFN_Options->add_option( $option, $value )
 * -------------------------------------------------------------------------
 * @since 1.0.0
 *
 * @param string $option / Plugin option
 * @param $value / Option value. Any scalar values and arrays are possible
 *
 * @return WP_Error|bool
 */
function kfn_add_option( $option, $value )
{
	global $kfn_options;

	if ( isset( $kfn_options ) && method_exists( $kfn_options, 'add_option') ) {
		$kfn_options->add_option( $option, $value );
	} else {
		return new WP_Error('kfn_add_option_func_undefined_global', 'Global $kfn_options or its method update_option() was not defined!');
	}

	return true;
}
/**
 * kfn_delete_option( $option )
 * -------------------------------------------------------------------------
 * API function.
 * Deletes specified option from $kfn_options global object and database
 * Wrapper for KFN_Options->delete_option( $option )
 * -------------------------------------------------------------------------
 * @since 1.0.0
 *
 * @param string $option / Plugin option
 *
 * @return WP_Error|bool
 */
function kfn_delete_option( $option )
{
	global $kfn_options;

	if ( isset( $kfn_options ) && method_exists( $kfn_options, 'delete_option') ) {
		$kfn_options->delete_option( $option );
	} else {
		return new WP_Error('kfn_delete_option_func_undefined_global', 'Global $kfn_options or its method update_option() was not defined!');
	}

	return true;
}