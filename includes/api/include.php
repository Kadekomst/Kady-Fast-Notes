<?php
/*
 * include.php
 * --------------------------------------------------------------
 * Part of Kady Fast Notes plugin source code.
 * File contains API function for various types of file loading
 * -------------------------------------------------------------
 * @since 1.0.0
 * @author Kadekomst
 * @link https://kfn.com/widget
 */

/**
 * kfn_file_exists( $file )
 * ------------------------------------------------
 * Checks an existence of file in plugin structure
 * ------------------------------------------------
 *
 * @param $path / Path to the file
 *
 * @return bool
 * @since 1.0.0
 */
function kfn_file_exists( $path ) {
	if ( defined( 'KFN_DIR_PATH' ) ) {
		return file_exists( KFN_DIR_PATH . $path );
	}

	return file_exists( plugin_dir_path( dirname( dirname( $path ) ) ) );
}

/**
 * kfn_get_path( $path )
 * -----------------------------------------
 * Receives a path to the file if it exists
 * in plugin structure
 * -----------------------------------------
 *
 * @param $path / Path to the file
 *
 * @return WP_Error|string
 * @since 1.0.0
 */
function kfn_get_plugin_path( $path ) {
	return kfn_file_exists( $path )
		? KFN_DIR_PATH . $path
		: new WP_Error( 'kfn_file_not_found', 'File was not found in KFN plugin structure', $path );
}

/**
 * kfn_get_absolete_path( $path )
 * -----------------------------------------
 * Receives a path to the file if it exists
 * in whole WordPress project
 * -----------------------------------------
 *
 * @param $path / Path to the file
 *
 * @return string
 * @since 1.0.0
 * @return WP_Error|string
 */
function kfn_get_absolete_path( $path ) {
	return file_exists( $path )
		? $path
		: new WP_Error( 'kfn_file_not_found_in_absolete', 'File was not found in whole project!', $path );
}

/**
 * kfn_include( $file, $absolete, $include_once = true )
 * ---------------------------------------------------------------------
 * Includes the file by $file path
 * If $include_once is equals "true", function will use include_once().
 * Otherwise, file will be included via include()
 * ----------------------------------------------------------------------
 *
 * @param $file
 * @param bool $absolete / false - search through plugin structure, true - search through whole project
 * @param bool $include_once / true - will be used include_once(), false - will be used include()
 *
 * @since 1.0.0
 * @return void
 */
function kfn_include( $file, $absolete = false, $include_once = true ) {
	if ( ! $absolete ) {
		$path = kfn_get_plugin_path( $file );
	} else {
		$path = kfn_get_absolete_path( $file );
	}

	if ( ! is_wp_error( $path ) ) {
		if ( $include_once ) {
			include_once( $path );
		} else {
			include( $path );
		}
	} else {
		print_r( $path );
	}
}

/**
 * kfn_require( $file, $absolete, $include_once = true )
 * ---------------------------------------------------------------------
 * Includes the file by $file path
 * If $include_once is equals "true", function will use include_once().
 * Otherwise, file will be included via include()
 * ----------------------------------------------------------------------
 *
 * @param $file
 * @param bool $absolete / false - search through plugin structure, true - search through whole project
 * @param bool $require_once / true - will be used require_once(), false - will be used require()
 *
 * @since 1.0.0
 * @return void
 */
function kfn_require( $file, $absolete = false, $require_once = true ) {
	if ( ! $absolete ) {
		$path = kfn_get_plugin_path( $file );
	} else {
		$path = kfn_get_absolete_path( $file );
	}

	if ( ! is_wp_error( $path ) ) {
		if ( $require_once ) {
			require_once( $path );
		} else {
			require( $path );
		}
	} else {
		print_r( $path );
	}
}