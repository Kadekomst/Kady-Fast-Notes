<?php
/**
 * Created by PhpStorm.
 * User: Kadekomst
 * Date: 02.02.2019
 * Time: 22:23
 */

namespace KFN\includes;

use WP_Error;

class KFN_Settings {
	/**
	 * Array of plugin settings.
	 * Accepted from KFN class
	 * ---------------------------
	 * @since 1.0.0
	 * @var array
	 */
	private $settings;

	/**
	 * Sub-arrays of $this->settings
	 * -----------------------------
	 * @since 1.0.0
	 * @var array
	 */
	private $settings_arrays;

	/**
	 * Array of settings which values are reserved
	 * in the plugin.
	 * -------------------------------------------
	 * @since 1.0.0
	 * @var array
	 */
	private $reserved_settings = array( 'url', 'path', 'plugin_name', 'version', 'basename' );

	/**
	 * KFN_Settings constructor.
	 * --------------------------
	 * Sets up plugin settings
	 * --------------------------
	 *
	 * @param $settings
	 */
	public function __construct( $settings ) {
		$this->settings = $settings;
	}

	/**
	 * KFN_Settings->get_setting( $setting )
	 * --------------------------------------------
	 * Returns requested KFN setting if it was set.
	 * Otherwise, returns WP_Error instance.
	 * -------------------------------------------
	 * @since 1.0.0
	 *
	 * @param $setting
	 *
	 * @return WP_Error|mixed
	 */
	public function get_setting( $setting ) {
		if ( ! $this->has_setting( $setting ) ) {
			return new WP_Error( 'kfn_setting_not_found', 'Requested ' . $setting . ' setting is not registered in KFN plugin!' );
		}

		return $this->settings[ $setting ];
	}

	/**
	 * KFN_Settings->get_settings_array( $setting )
	 * --------------------------------------------
	 * Returns requested KFN setting if it was set.
	 * Otherwise, returns WP_Error instance.
	 * -------------------------------------------
	 * @since 1.0.0
	 *
	 * @param string $settings_array_name
	 *
	 * @return WP_Error|mixed
	 */
	public function get_settings_array( $settings_array_name ) {

		if ( !is_string( $settings_array_name ) ) {
			return new WP_Error( 'kfn_get_settings_array_wrong_type', 'Parameter $setting expected string, got ' . gettype( $setting ) );
		}

		if ( !$this->has_settings_array( $settings_array_name ) ) {
			return new WP_Error('kfn_get_settings_array_doesnt_exists', "Requested settings array doenst't exists!");
		}

		return $this->settings_arrays[ $settings_array_name ];
	}

	/**
	 * KFN_Settings->has_setting( $setting )
	 * -------------------------------------------------
	 * Checks for existence of requested plugin setting.
	 * Can be used as a condition.
	 * -------------------------------------------------
	 * @since 1.0.0
	 *
	 * @param $setting
	 *
	 * @return bool
	 */
	public function has_setting( $setting ) {
		if ( isset( $this->settings[ $setting ] )) {
			return true;
		}

		return false;
	}

	/**
	 * KFN_Settings->has_settings_array( $settings_object )
	 * ----------------------------------------------------------
	 * Checks for existence of requested plugin settings object.
	 * Can be used as a condition.
	 * ----------------------------------------------------------
	 * @since 1.0.0
	 *
	 * @param $settings_array string / Settings array to be checked.
	 *
	 * @return WP_Error|bool
	 */
	public function has_settings_array( $settings_array ) {
		if ( !is_string( $settings_array ) ) {
			return new WP_Error( 'kfn_has_settings_array_wrong_type', 'Parameter $setting expected string, got ' . gettype( $settings_array ) );
		}

		if ( isset( $this->settings_arrays[ $settings_array ] ) && is_array( $this->settings_arrays[ $settings_array ] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * KFN_Settings->update_setting( $setting )
	 * ----------------------------------------------------------------
	 * Updated specified plugin setting. It is not allowed
	 * to update a bunch of reserved settings. They are listed in
	 * $this->reserved_settings property of current class
	 * ----------------------------------------------------------------
	 * @since 1.0.0
	 *
	 * @param $setting
	 * @param $value
	 *
	 * @return WP_Error|bool
	 */
	public function update_setting( $setting, $value ) {
		if ( ! is_string( $setting ) ) {
			return new WP_Error( 'kfn_update_setting_wrong_type', 'Parameter $setting expected string, got ' . gettype( $setting ) );
		}

		foreach ( $this->reserved_settings as $reserved_setting ) {
			if ( $setting === $reserved_setting ) {
				return new WP_Error( 'kfn_update_setting_error', 'Attempt to update reserved setting "' . $setting . '"!' );
			}
		}

		$this->settings[ $setting ] = $value;

		return true;
	}
	/**
	 * KFN_Settings->add_setting( $setting )
	 * --------------------------------------------------------
	 * Adds new setting.
	 * Setting must be not already defined.
	 * Otherwise, method returns WP_Error instance
	 * -------------------------------------------------------
	 * @since 1.0.0
	 *
	 * @param $setting / New setting name
	 * @param $value / Setting value
	 *
	 * @return WP_Error|bool
	 */
	public function add_setting( $setting, $value ) {

		if ( ! $this->has_setting( $setting ) ) {
			$this->settings[ $setting ] = $value;
		} else {
			return new WP_Error( 'kfn_settings_add_setting_setting_has_already_defined', 'Setting "' . $setting . '" has already defined!' );
		}

		return true;
	}
	/**
	 * KFN_Settings->add_settings( $arr_name, $settings )
	 * --------------------------------------------------------
	 * Adds new setting.
	 * Setting must be not already defined.
	 * Otherwise, method returns WP_Error instance
	 * -------------------------------------------------------
	 * @since 1.0.0
	 *
	 * @param $arr_name / New settings array name
	 * @param $settings / Settings array
	 *
	 * @return void
	 */
	public function add_settings_array( $arr_name, $settings ) {
		if ( is_array( $settings ) ) {
			foreach ( $settings as $setting ) {
				if ( ! $this->has_settings_array( $arr_name ) && ! $this->has_setting( $setting ) ) {
					$this->settings[ $arr_name ][] = $setting;
					$this->settings_arrays[ $arr_name ] = $settings;
				}
			}
		}
	}
	/**
	 * KFN_Settings->remove_setting( $setting )
	 * ---------------------------------------------------------
	 * Removes specified setting.
	 * It is not allowed to remove reserved settings.
	 * Reserved settings are listed in $this->reserved_settings
	 * ---------------------------------------------------------
	 * @since 1.0.0
	 *
	 * @param string $setting / Setting to be removed
	 *
	 * @return WP_Error|bool
	 */
	public function remove_setting( $setting )
	{
		if ( ! is_string( $setting ) ) {
			return new WP_Error( 'kfn_remove_setting_wrong_type', 'Parameter $setting expected string, got ' . gettype( $setting ) );
		}

		foreach ( $this->reserved_settings as $reserved_setting ) {
			if ( $setting === $reserved_setting ) {
				return new WP_Error( 'kfn_remove_setting_error', 'Attempt to remove reserved setting "' . $setting . '"!' );
			}
		}

		unset($this->settings[ $setting ]);

		return true;
	}

}