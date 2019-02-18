<?php
/*
 * hook.php
 * --------------------------------------------------------------
 * Part of Kady Fast Notes plugin source code.
 * File contains API functions-wrappers for KFN_Hook class
 * functionality.
 * -------------------------------------------------------------
 * @since 1.0.0
 * @author Kadekomst
 * @link https://kfn.com/widget
 */

/**
 * kfn_add_action( $hook, $callback, $priority, $accepted_tags )
 * ------------------------------------------------------------------------------------------------
 * Register new action via WordPress API.
 * API function-wrapper for KFN_Hook->add_action( $hook, $callback, $priority, $accepted_tags )
 * ------------------------------------------------------------------------------------------------
 * @since 1.0.0
 *
 * @global \KFN\includes\KFN_Hook;
 *
 * @param string $hook / WordPress action name
 * @param callable|array $callback / Callable callback-function in string ( 'callback' ) or static class method ( array('$class', '$static_method'))
 * @param int $priority / Action priority. Default 10.
 * @param int $accepted_args / Integer represented the number of accepted tags in callback function
 *
 * @return bool|WP_Error
 */
function kfn_add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
	global $kfn_hook;

	if ( isset( $kfn_hook ) && method_exists( $kfn_hook, 'add_action' ) ) {
		$kfn_hook->add_action( $hook, $callback, $priority, $accepted_args );

		return true;
	}

	return new WP_Error( 'kfn_add_action_error', 'KFN_Hook global instance or "add_action" method were not defined!' );
}

/**
 * kfn_add_filter( $hook, $callback, $priority, $accepted_tags )
 * ------------------------------------------------------------------------------------------------
 * Register new filter via WordPress API.
 * API function-wrapper for KFN_Hook->add_filter( $hook, $callback, $priority, $accepted_tags )
 * ------------------------------------------------------------------------------------------------
 * @since 1.0.0
 *
 * @param string $hook / WordPress filter name
 * @param callable|array $callback / Callable callback-function in string ( 'callback' ) or static class method ( array('$class', '$static_method'))
 * @param int $priority / Action priority
 * @param int $accepted_args / Integer represented the number of accepted tags in callback function
 *
 * @return bool|WP_Error
 */
function kfn_add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
	global $kfn_hook;

	if ( isset( $kfn_hook ) && method_exists( $kfn_hook, 'add_filter' ) ) {
		$kfn_hook->add_filter( $hook, $callback, $priority, $accepted_args );

		return true;
	}

	return new WP_Error( 'kfn_add_filter_error', 'KFN_Hook global instance is not defined!' );
}

/**
 * kfn_action_has_done( $hook )
 * ------------------------------------------------------------
 * Check has requested action done in KFN plugin.
 * API function-wrapper for KFN_Hook->action_has_done( $hook )
 * -------------------------------------------------------------
 *
 * @param string $action / WordPress hook
 *
 * @return bool|WP_Error;
 */
function kfn_action_has_done( $action ) {
	global $kfn_hook;

	if ( isset( $kfn_hook ) && method_exists( $kfn_hook, 'action_has_done' ) ) {
		return $kfn_hook->action_has_done( $action );
	}

	return new WP_Error( 'kfn_action_has_done_error', 'KFN_Hook global instance or "action_has_done" were not defined!' );
}

/**
 * kfn_filter_has_done( $hook )
 * ------------------------------------------------------------
 * Check has requested filter done in KFN plugin.
 * API function-wrapper for KFN_Hook->filter_has_done( $hook )
 * -------------------------------------------------------------
 *
 * @param string $filter / WordPress filter
 *
 * @return bool|WP_Error;
 */
function kfn_filter_has_done( $filter ) {
	global $kfn_hook;

	if ( isset( $kfn_hook ) && method_exists( $kfn_hook, 'filter_has_done' ) ) {
		return $kfn_hook->filter_has_done( $filter );
	}

	return new WP_Error( 'kfn_filter_has_done_error', 'KFN_Hook global instance or "filter_has_done" method were not defined!' );
}
