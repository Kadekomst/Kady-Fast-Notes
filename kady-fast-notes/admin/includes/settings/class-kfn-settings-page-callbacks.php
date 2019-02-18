<?php
/**
 * Class KFN_Settings_Page_Callbacks
 * ------------------------------------------------------------------------
 * Core class of Kady Fast Notes plugin
 *
 * This class is a part of KFN settings page implementation.
 * Collects callback-functions responsible for processing settings dashboard
 * on Kady Fast Notes's settings page
 * ------------------------------------------------------------------------
 * @since 1.0.0
 * @author Kadekomst
 */

namespace KFN\admin\includes\settings;

class KFN_Settings_Page_Callbacks {
	/**
	 * Array of registered settings
	 * ------------------------------------------
	 * @since 1.0.0
	 * @var array
	 */
	public $settings;
	/**
	 * KFN_Settings_Page_Callbacks constructor.
	 * ------------------------------------------
	 * Sets up $this->settings array
	 * -------------------------------------------
	 */
	public function __construct() {
	    global $kfn;
	    $kfn->load_api();

		$this->settings = get_option('kfn_settings');
	}
	/**
	 * KFN_Settings_Page_Callbacks->dashboard_metabox_section()
	 * ------------------------------------------------------
	 * Description for "Dashboard Metabox" settings section
	 * ------------------------------------------------------
	 * @since 1.0.0
	 * @return void
	 */
	public function dashboard_metabox_section()
	{
		_e('Settings for dashboard KFN notes metabox', 'kfn');
	}
	/**
	 * KFN_Settings_Page_Callbacks->dashboard_metabox_notes_per_page()
	 * -----------------------------------------------------------------------------
	 * View for "Notes per page" field of "Dashboard Metabox"
	 * settings section
	 * ------------------------------------------------------------------------------
	 * @since 1.0.0
     * @see setting-dashboard-notes-per-page.php ( admin/views/settings/dashboard )
	 * @return void
	 */
	public function dashboard_metabox_notes_per_page()
	{
		kfn_include('admin/views/settings/dashboard/setting-dashboard-notes-per-page.php');
	}
	/**
	 * KFN_Settings_Page_Callbacks->dashboard_metabox_bg_color()
	 * ---------------------------------------------------------------
	 * View for "Background Color" field of "Dashboard Metabox"
	 * settings section
	 * ---------------------------------------------------------------
	 * @since 1.0.0
     * @see setting-dashboard-bg-color.php ( admin/views/settings/dashboard )
	 * @return void
	 */
	public function dashboard_metabox_bg_color()
	{
		kfn_include('admin/views/settings/dashboard/setting-dashboard-bg-color.php');
	}
	/**
	 * KFN_Settings_Page_Callbacks->dashboard_metabox_orderby()
	 * ---------------------------------------------------------------
	 * View for "Order By" field of "Dashboard Metabox"
	 * settings section
	 * ---------------------------------------------------------------
	 * @since 1.0.0
     * @see setting-dashboard-orderby.php ( admin/views/settings/dashboard )
	 * @return void
	 */
	public function dashboard_metabox_orderby()
	{
		kfn_include('admin/views/settings/dashboard/setting-dashboard-orderby.php');
	}
	/**
	 * KFN_Settings_Page_Callbacks->dashboard_metabox_order()
	 * -------------------------------------------------------------------
	 * View for "Order" field of "Dashboard Metabox"
	 * settings section
	 * -------------------------------------------------------------------
	 * @since 1.0.0
     * @see setting-dashboard-order.php ( admin/views/settings/dashboard )
	 * @return void
	 */
	public function dashboard_metabox_order()
	{
		kfn_include('admin/views/settings/dashboard/setting-dashboard-order.php');
	}
}