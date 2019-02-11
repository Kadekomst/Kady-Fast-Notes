<?php
/**
 * Interface KFN_Metabox
 * -------------------------------------------
 * This interface is a boilerplate for all
 * KFN_*_Metabox classes
 * -------------------------------------------
 * @since 1.0.0
 */

namespace KFN\admin\includes\interfaces;

interface KFN_Metabox {
	/**
	 * metabox()
	 * -------------------------------------------------
	 * Method must implement metabox view functionality
	 * -------------------------------------------------
	 * @return mixed
	 */
	public function metabox();
	/**
	 * init()
	 * -------------------------------------------------------------------------
	 * Method must implement initialization of the metabox ( add_meta_box() call
	 * and defining arguments )
	 * -------------------------------------------------------------------------
	 * @return mixed
	 */
	public function init();
	/**
	 * run()
	 * ------------------------------------------------------------------
	 * Bootstrap method for the metabox ( register init() method to the
	 * "wp_dashboard_setup" action )
	 * -------------------------------------------------------------------
	 * @return mixed
	 */
	public function run();
	/**
	 * save()
	 * ------------------------------------------------------------------
	 * Method must implement saving for new note entered by user.
	 * -------------------------------------------------------------------
	 * @return mixed
	 */
	public function save();
}