<?php
/**
 * settings.php
 * -------------------------------------------
 * File contains API functions-wrappers for
 * KFN_Settings class functionality.
 * Part of KFN plugin source code.
 * -------------------------------------------
 * @since 1.0.0
 *
 * @param $setting
 *
 * @return WP_Error
 */

/**
 * kfn_get_setting( $setting )
 * ----------------------------------------------------------
 * API function.
 * Returns request KFN setting like url, path, version etc.
 * Wrapper for KFN_Settings->get_setting( $setting )
 * -----------------------------------------------------------
 * @since 1.0.0
 *
 * @param $setting
 *
 * @return \KFN\includes\KFN_Settings|WP_Error|bool;
 */
function kfn_get_setting( $setting ) {
	global $kfn_settings;

	if ( isset( $kfn_settings ) && method_exists( $kfn_settings, 'get_setting') ) {
		return $kfn_settings->get_setting( $setting );
	} else {
		return new WP_Error('kfn_update_setting_func_undefined_global', 'Global $kfn_settings or its method update_setting() was not defined!');
	}
}

/**
 * kfn_has_setting( $setting )
 * ----------------------------------------------------------
 * API function.
 * Check for existence of requested plugin setting
 * Wrapper for KFN_Settings->has_setting( $setting )
 * -----------------------------------------------------------
 *
 * @param $setting
 *
 * @return \KFN\includes\KFN_Settings;
 */
function kfn_has_setting( $setting ) {
	global $kfn_settings;

	if ( isset( $kfn_settings ) && method_exists( $kfn_settings, 'get_setting') ) {
		return $kfn_settings->get_setting( $setting );
	} else {
		return new WP_Error('kfn_update_setting_func_undefined_global', 'Global $kfn_settings or its method update_setting() was not defined!');
	}
}
/**
 * kfn_update_setting( $setting )
 * ----------------------------------------------------------
 * API function.
 * Updates specified setting of the plugin.
 * More info in includes/class-kfn-settings.php:84
 * Wrapper for KFN_Settings->has_setting( $setting )
 * -----------------------------------------------------------
 * @since 1.0.0
 *
 * @param string $setting / Plugin setting
 * @param $value / New value for the specified plugin setting
 *
 * @return WP_Error|bool
 */
function kfn_update_setting( $setting, $value )
{
	global $kfn_settings;

	if ( isset( $kfn_settings ) && method_exists( $kfn_settings, 'update_setting') ) {
		$kfn_settings->update_setting( $setting, $value );
	} else {
		return new WP_Error('kfn_update_setting_func_undefined_global', 'Global $kfn_settings or its method update_setting() was not defined!');
	}

	return true;
}

