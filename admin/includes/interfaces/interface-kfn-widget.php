<?php
/**
 * Interface KFN_Widget
 * -------------------------------------------
 * This interface is a boilerplate for all
 * KFN_*_Widget classes
 * -------------------------------------------
 * @since 1.0.0
 */

namespace KFN\admin\includes\interfaces;

interface KFN_Widget {
	/**
	 * widget()
	 * -------------------------------------------------
	 * Method must implement widget view functionality
	 * -------------------------------------------------
	 * @return mixed
	 */
	public function widget();
	/**
	 * init()
	 * -------------------------------------------------------------------------
	 * Method must implement initialization of the widget ( add_meta_box() call
	 * and defining arguments )
	 * -------------------------------------------------------------------------
	 * @return mixed
	 */
	public function init();
	/**
	 * run()
	 * ------------------------------------------------------------------
	 * Bootstrap method for the widget ( register init() method to the
	 * "wp_dashboard_setup" action )
	 * -------------------------------------------------------------------
	 * @return mixed
	 */
	public function run();
}