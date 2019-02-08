<?php
/**
 * Created by PhpStorm.
 * User: Kadekomst
 * Date: 02.02.2019
 * Time: 20:27
 */

namespace KFN\includes;

class KFN_Hook {
	/**
	 * Array of actions to be registered via WordPress
	 * @var array
	 * @since 1.0.0
	 */
	public $actions = array();
	/**
	 * Array of filters to be registered via WordPress
	 * @var array
	 * @since 1.0.0
	 */
	public $filters = array();

	/**
	 * KFN_Hook constructor.
	 */
	public function __construct() {
		// Nothing is here
	}

	/**
	 * add_action()
	 * -----------------------------------
	 * Registers new action via WordPress
	 * ----------------------------------
	 * @since 1.0.0
	 *
	 * @param $hook / WordPress action name
	 * @param $callback / Callable callback-function in string ( 'callback' ) or static class method ( array('$class', '$static_method'))
	 * @param $priority / Action priority
	 * @param $accepted_args / Integer represented the number of accepted tags in callback function
	 *
	 * @return bool|\WP_Error;
	 */
	public function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		if ( ! is_string( $hook )  ) {
			return new \WP_Error('kfn_add_action_wrong_type', '$hook parameter of '.__METHOD__.' was specified with wrong type!');
		}

		if ( ! is_string( $callback ) && ! is_array( $callback ) ) {
			return new \WP_Error('kfn_add_action_wrong_type', '$hook parameter of '.__METHOD__.' was specified with wrong type!');
		}

		$this->actions[] = array(
			'hook'          => $hook,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_tags' => $accepted_args
		);

		return true;
	}

	/**
	 * add_action()
	 * -----------------------------------
	 * Registers new action via WordPress
	 * ----------------------------------
	 * @since 1.0.0
	 *
	 * @param $hook / WordPress action name
	 * @param $callback / Callable callback-function in string ( 'callback' ) or static class method ( array('$class', '$static_method'))
	 * @param $priority / Action priority
	 * @param $accepted_args / Integer represented the number of accepted tags in callback function
	 *
	 * @return bool|\WP_Error
	 */
	public function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
		if ( ! is_string( $hook )  ) {
			return new \WP_Error('kfn_add_filter_wrong_type', '$hook parameter of '.__METHOD__.' was specified with wrong type!');
		}

		if ( ! is_string( $callback ) && ! is_array( $callback ) ) {
			return new \WP_Error('kfn_add_filter_wrong_type', '$hook parameter of '.__METHOD__.' was specified with wrong type!');
		}

		$this->filters[] = array(
			'hook'          => $hook,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_tags' => $accepted_args
		);

		return true;
	}

	/**
	 * KFN_Hook->action_has_done( $action )
	 * -----------------------------------------
	 * Check has a requested action done
	 * -----------------------------------------
	 *
	 * @param $action / Action to be checked
	 *
	 * @return bool|WP_Error
	 */
	public function action_has_done( $action ) {
		if ( ! is_string( $action ) ) {
			return new WP_Error( 'kfn_filter_has_done_wrong_type', 'Wrong data type is given in the function ' . __FUNCTION__ );
		}

		if ( ! isset( $this->actions[ $action ] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * KFN_Hook->filter_has_done( $filter )
	 * -----------------------------------------
	 * Check has a requested filter done
	 * -----------------------------------------
	 *
	 * @param $filter / Filter to be checked
	 *
	 * @return bool|WP_Error
	 */
	public function filter_has_done( $filter ) {
		if ( ! is_string( $filter ) ) {
			return new WP_Error( 'kfn_filter_has_done_wrong_type', 'Wrong data type is given in the function ' . __FUNCTION__ );
		}

		if ( ! isset( $this->filters[ $filter ] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * run()
	 * -------------------------------------------------
	 * Implements the registration of all added filters
	 * and actions via WordPress API.
	 * -------------------------------------------------
	 * @since 1.0.0
	 */
	public function run() {
		foreach ( $this->actions as $action ) {
			add_action( $action['hook'], $action['callback'], $action['priority'], $action['accepted_tags'] );
		}

		foreach ( $this->filters as $filter ) {
			add_filter( $filter['hook'], $filter['callback'], $filter['priority'], $filter['accepted_tags'] );
		}
	}
}