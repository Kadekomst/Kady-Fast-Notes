<?php
/**
 * class-kfn-settings.php
 * ----------------------------------------
 * Core class of Kady Fast Notes plugin
 *
 * This class is responsible for drawing
 * and displaying plugin settings page.
 * ----------------------------------------
 * @author Kadekomst
 * @since 1.0.0
 */

namespace KFN\includes;

class KFN_Settings {
	/**
	 * KFN_Settings constructor.
	 */
	public function __construct() {

		// Global KFN class object
		global $kfn;

		// API loading
		$kfn->load_api();

		// Hook to admin_menu action to setup plugin settings page
		kfn_add_action('admin_menu', array( $this, 'settings_page') );

	}
	/**
	 * KFN_Settings->settings_page()
	 * --------------------------------------
	 * Register new options page for plugin
	 * --------------------------------------
	 * @since 1.0.0
	 * @return void
	 */
	public function settings_page()
	{
		add_options_page(
			'Kady Fast Notes',
			'Kady Fast Notes settings',
			'manage_options',
			'kfn-settings-page',
			array( $this, 'settings_page_view' )
		);
	}
	/**
	 * KFN_Settings->settings_page()
	 * --------------------------------------
	 * Register new options page for plugin
	 * --------------------------------------
	 * @since 1.0.0
	 * @return void
	 */
	public function settings_page_view()
	{
		$view = kfn_include('admin/views/settings/settings-page.php');
		echo $view;
	}
}