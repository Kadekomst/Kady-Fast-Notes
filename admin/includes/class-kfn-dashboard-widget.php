<?php
/**
 * Created by PhpStorm.
 * User: Kadekomst
 * Date: 02.02.2019
 * Time: 21:44
 */

// Namespace
namespace KFN\admin\includes;

use KFN\includes\KFN_View;
use KFN\admin\includes\interfaces\KFN_Widget;

require(KFN_DIR_PATH . 'admin/includes/interfaces/interface-kfn-widget.php');

class KFN_Dashboard_Widget implements KFN_Widget {
	/**
	 * KFN dashboard metabox settings
	 * @var array
	 */
	public $widget_args;
	/**
	 * KFN dashboard metabox settings
	 * @var array
	 */
	public $widget_form_args;
	/**
	 * KFN_Widget constructor.
	 * ----------------------------------------
	 * Loads api helpers for easier plugin use
	 */
	public function __construct() {
		global $kfn;

		if ( method_exists( $kfn, 'load_api_helpers') && method_exists( $kfn, 'load_tests') )
		{
			$kfn->load_api_helpers();
			$kfn->load_tests();
		}
	}
	/**
	 * init()
	 */
	public function init()
	{
		global $kfn_settings;

		$kfn_settings->add_settings_array('dashboard_widget_args', array(
			'id' => 'kfn',
			'name' => 'Kady Fast Notes',
			'callback' => array($this, 'widget'),
			'screen' => 'dashboard',
			'context' => 'side',
			'priority' => 'high'
		));

		$settings = $this->widget_args;
		add_meta_box($settings['id'], $settings['name'], $settings['callback'], $settings['screen'], $settings['context'], $settings['priority']);
	}
	/**
	 * run()
	 */
	public function run()
	{
		global $kfn_hook;

		if ( method_exists($kfn_hook, 'add_action')) {
			$kfn_hook->add_action( 'wp_dashboard_setup', array($this, 'init') );
		}
	}
	/**
	 * widget()
	 * -------------------------
	 * Creates widget markup
	 * -------------------------
	 * @global KFN_View
	 *
	 * @since 1.0.0
	 *
	 * @return \WP_Error|void
	 */
	public function widget()
	{
		global $kfn_view;

		$this->widget_form_args = array(

		);

		$view = method_exists( $kfn_view, 'load_admin_view')
			? $kfn_view->load_admin_view('dashboard-widget')
		    : 'Unable to load dashboard KFN widget content!';
		echo $view;
	}
}