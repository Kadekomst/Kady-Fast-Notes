<?php
/**
 * Class KFN_Options
 * ---------------------------------------
 * Core class of Kady Fast Notes plugin
 *
 * This class is responsible for managing
 * various plugin options. It implements
 * functionality for adding, removing,
 * updating, organising various types
 * of options.
 * ---------------------------------------
 * @since 1.0.0
 * @author Kadekomst
 */

namespace KFN\includes;

use WP_Error;

class KFN_Options {
	/**
	 * Array of plugin options.
	 * Accepted from KFN class
	 * ---------------------------
	 * @since 1.0.0
	 * @var array
	 */
	protected $options = array();

	/**
	 * Array of options which values are protected
	 * in the plugin.
	 * -------------------------------------------
	 * @since 1.0.0
	 * @var array
	 */
	protected $protected_options = array( 'url', 'path', 'plugin_name', 'version', 'basename' );

	/**
	 * KFN_Settings constructor.
	 * -------------------------------------------------------------------
	 * Sets up default plugin options
	 * -------------------------------------------------------------------
	 * @param $defaults / Default parameter. Accepted from main KFN class
	 */
	public function __construct( $defaults ) {
		$this->add_option('defaults', $defaults);
	}

	/**
	 * KFN_Options->get_options_object()
	 * -------------------------------------------
	 * Retrieves $this->settings object contained
	 * all registered options
	 * -------------------------------------------
	 * @since 1.0.0
	 * @return array
	 */
	public function get_options_object()
	{
		$options = $this->options;
		return $options;
	}

	/**
	 * KFN_Settings->get_option( $option )
	 * --------------------------------------------
	 * Returns requested KFN option if it was set.
	 * Otherwise, returns WP_Error instance.
	 * -------------------------------------------
	 * @since 1.0.0
	 *
	 * @param string $option
	 *
	 * @return WP_Error|mixed
	 */
	public function get_option( $option ) {
		if ( ! $this->has_option( $option ) ) {
			return new WP_Error( 'kfn_option_not_found', "Requested \"$option\" option is not registered in KFN plugin!" );
		}

		return get_option( 'kfn_'.$option );
	}

	/**
	 * KFN_Settings->has_option( $option )
	 * -------------------------------------------------
	 * Checks for existence of requested plugin option.
	 * Can be used as a condition.
	 * -------------------------------------------------
	 * @since 1.0.0
	 *
	 * @param string $option
	 *
	 * @return WP_Error|bool
	 */
	public function has_option( $option ) {
		if ( ! is_string( $option ) ) {
			return new WP_Error( 'kfn_has_option_wrong_type', 'Parameter $option expected string, got' . gettype( $option ) );
		}

		if ( isset( $this->options[ $option ] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * KFN_Settings->update_option( $option )
	 * ----------------------------------------------------------------
	 * Updated specified plugin option. It is not allowed
	 * to update a bunch of protected options. They are listed in
	 * $this->protected_options property of current class
	 * ----------------------------------------------------------------
	 * @since 1.0.0
	 *
	 * @param $option
	 * @param $value
	 *
	 * @return WP_Error|bool
	 */
	public function update_option( $option, $value ) {
		if ( ! is_string( $option ) ) {
			return new WP_Error( 'kfn_update_option_wrong_type', 'Parameter $option expected string, got ' . gettype( $option ) );
		}

		foreach ( $this->protected_options as $protected_option ) {
			if ( $option === $protected_option ) {
				return new WP_Error( 'kfn_update_option_error', 'Attempt to update protected option "' . $option . '"!' );
			}
		}

		$this->options[ $option ] = $value;
		update_option( 'kfn_' . $option, $value );

		return true;
	}

	/**
	 * KFN_Settings->add_option( $option )
	 * --------------------------------------------------------
	 * Adds new option.
	 * Setting must be not already defined.
	 * Otherwise, method returns WP_Error instance
	 * -------------------------------------------------------
	 * @since 1.0.0
	 *
	 * @param $option / New option name
	 * @param $value / Setting value
	 *
	 * @return WP_Error|bool
	 */
	public function add_option( $option, $value ) {

		if ( ! $this->has_option( $option ) ) {
			$this->options[ $option ] = $value;
			add_option( 'kfn_' . $option, $value );
		} else {
			return new WP_Error( 'kfn_options_add_option_option_has_already_defined', 'Setting "' . $option . '" has already defined!' );
		}

		return true;
	}

	/**
	 * KFN_Settings->remove_option( $option )
	 * ---------------------------------------------------------
	 * Removes specified option.
	 * It is not allowed to remove protected options.
	 * Reserved options are listed in $this->protected_options
	 * ---------------------------------------------------------
	 * @since 1.0.0
	 *
	 * @param string $option / Setting to be removed
	 *
	 * @return WP_Error|bool
	 */
	public function delete_option( $option ) {
		if ( ! is_string( $option ) ) {
			return new WP_Error( 'kfn_remove_option_wrong_type', 'Parameter $option expected string, got ' . gettype( $option ) );
		}

		foreach ( $this->protected_options as $protected_option ) {
			if ( $option === $protected_option ) {
				return new WP_Error( 'kfn_remove_option_error', 'Attempt to remove protected option "' . $option . '"!' );
			}
		}

		unset( $this->options[ $option ] );
		delete_option( $option );

		return true;
	}

	/**
	 * KFN_Settings->remove_all_options( $option )
	 * ---------------------------------------------------------
	 * Removes specified option.
	 * It is not allowed to remove protected options.
	 * Reserved options are listed in $this->protected_options
	 * ---------------------------------------------------------
	 * @since 1.0.0
	 * @return WP_Error|bool
	 */
	public function delete_non_protected_options() {

		// Array of options to be deleted from plugin and database
		$options = array();

		foreach ( $this->options as $option => $value ) {

			// Our goal is to remove only non-protected options
			foreach ( $this->protected_options as $protected_option ) {
				if ( $option === $protected_option ) {
					continue;
				}
			}

			// Delete options from plugin
			unset( $this->options[ $option ] );

			// Add non-protected plugin options to special array to do further removing from DB
			$options[ $option ] = get_option( $option, 'nothing' );

		}

		// We should check for existence of each particular plugin option in DB
		foreach ( $options as $option_name => $value ) {
			if ( $value !== 'nothing' ) {
				delete_option( $option_name );
			}
		}

		// Success
		return true;

	}

}