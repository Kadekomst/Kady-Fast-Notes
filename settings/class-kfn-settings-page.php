<?php
/**
 * class-kfn-settings-page.php
 * ----------------------------------------
 * Core class of Kady Fast Notes plugin
 *
 * This class is responsible for drawing
 * and displaying plugin settings page.
 * ----------------------------------------
 * @author Kadekomst
 * @since 1.0.0
 */

namespace KFN\admin\includes\settings;

class KFN_Settings_Page {
	/**
	 * Settings sections
	 *
	 * @var array
	 * @since 1.0.0
	 */
	public $settings_section;
	/**
	 * Settings array
	 *
	 * @var array
	 * @since 1.0.0
	 */
	public $settings;
	/**
	 * Instance of KFN_Settings_Page_Callbacks class.
	 *
	 * @var KFN_Settings_Page_Callbacks;
	 * @see admin/includes/settings/class-kfn-settings-page-callbacks.php
	 * @since 1.0.0
	 */
	public $callbacks;
	/**
	 * KFN_Settings_Page constructor.
	 * ---------------------------------------------------------
	 * Registers required admin hooks.
	 * Retrieves callbacks used for processing settings dashboard
	 * ---------------------------------------------------------
	 * @param KFN_Settings_Page_Callbacks;
	 */
	public function __construct( $callbacks ) {
		global $kfn;

		// API loading
		$kfn->load_api();

		/*
		 * Retrieve KFN_Settings_Page_Callbacks instance.
		 * @see class-kfn-settings-page.php:31
		 */
		$this->callbacks = $callbacks;

		// Hook to admin_menu action to setup plugin settings page
		if ( is_admin() ) {
			kfn_add_action( 'admin_menu', array( $this, 'init_settings_page') );
			kfn_add_action( 'admin_init', array( $this, 'register_setting' ) );
			kfn_add_action( 'admin_init', array( $this, 'register_field_sections' ) );
			kfn_add_action( 'admin_init', array( $this, 'register_fields' ) );
		}
	}
	/**
	 * KFN_Settings_Page->init_settings_page()
	 * --------------------------------------
	 * Register new options page for plugin
	 * --------------------------------------
	 * @since 1.0.0
	 * @return void
	 */
	public function init_settings_page()
	{
		add_options_page(
			'Kady Fast Notes',
			'Kady Fast Notes',
			'manage_options',
			'kfn-settings-page',
			array( $this, 'settings_page_view' )
		);
	}
	/**
	 * KFN_Settings_Page->settings_page_view()
	 * ----------------------------------------
	 * Display HTML/CSS view for settings page
	 * -----------------------------------------
	 * @since 1.0.0
	 * @return void
	 */
	public function settings_page_view() {
		$this->settings = get_option('kfn_settings');
		echo kfn_include( 'admin/views/settings/settings-page.php' );
	}
	/**
	 * KFN_Settings_Page->register_setting()
	 * ----------------------------------------
	 * Registers main setting
	 * -----------------------------------------
	 * @since 1.0.0
	 * @return void
	 */
	public function register_setting()
    {
        register_setting(
	        'kfn-settings-page', // Option group
	        'kfn_settings', // Option name
	        array( $this->callbacks, 'sanitize' ) // Sanitize
        );
    }
	/**
	 * KFN_Settings_Page->register_field_sections()
	 * --------------------------------------------
	 * Registers all dashboard section
	 * ---------------------------------------------
	 * @since 1.0.0
	 * @return void
	 */
	public function register_field_sections()
    {
	    // Dashboard metabox
	    add_settings_section(
		    'kfn/settings/section/dashboard-metabox',
		    'Dashboard Metabox',
		    array( $this->callbacks, 'dashboard_metabox_section' ),
		    'kfn-settings-page'
	    );
    }
	/**
	 * KFN_Settings_Page->register_fields()
	 * --------------------------------------------
	 * Registers all dashboard section
	 * ---------------------------------------------
	 * @since 1.0.0
	 * @return void
	 */
	public function register_fields()
	{
	    /*
	     * Dashboard metabox section dashboard
	     */

	    // Notes per page
		add_settings_field(
			'kfn/settings/field/dashboard_metabox/notes-per-page',
			'Notes per page',
			array( $this->callbacks, 'dashboard_metabox_notes_per_page' ),
			'kfn-settings-page',
			'kfn/settings/section/dashboard-metabox'
		);

		// Background Color
		add_settings_field(
			'kfn/settings/field/dashboard_metabox/background-color',
			'Background Color',
			array( $this->callbacks, 'dashboard_metabox_bg_color' ),
			'kfn-settings-page',
			'kfn/settings/section/dashboard-metabox'
		);

		// Order By
		add_settings_field(
			'kfn/settings/field/dashboard_metabox/orderby',
			'Order By',
			array( $this->callbacks, 'dashboard_metabox_orderby' ),
			'kfn-settings-page',
			'kfn/settings/section/dashboard-metabox'
		);

		// Order
		add_settings_field(
			'kfn/settings/field/dashboard_metabox/order',
			'Order',
			array( $this->callbacks, 'dashboard_metabox_order' ),
			'kfn-settings-page',
			'kfn/settings/section/dashboard-metabox'
		);
	}
	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings dashboard as array keys
	 * @return mixed
	 */
	public function sanitize( $input )
	{
		$new_input = array();
		if ( isset( $input['dashboard_notes_per_page'] ) )
			$new_input['dashboard_notes_per_page'] = sanitize_text_field( $input['dashboard_notes_per_page'] );

		return $new_input;
	}
}