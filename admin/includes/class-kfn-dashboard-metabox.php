<?php
/**
 * Сlass KFN_Dashboard_Metabox
 * --------------------------------------------------------------
 * Core class of Kady Fast Notes plugin
 *
 * This is sub-class of KFN_Metabox interface. Responsible for
 * drawing of KFN notes dashboard metabox and its functionality.
 * --------------------------------------------------------------
 * @since 1.0.0
 * @author Kadekomst
 */

// Namespace
namespace KFN\admin\includes;

// KFN_Metabox interface
use KFN\admin\includes\interfaces\KFN_Metabox;

require(KFN_DIR_PATH . 'admin/includes/interfaces/interface-kfn-metabox.php');

class KFN_Dashboard_Metabox implements KFN_Metabox {
	/**
	 * KFN dashboard metabox options
	 * @var array
	 * @since 1.0.0
	 */
	public $metabox_args;
	/**
	 * KFN dashboard metabox options
	 * @var array
	 * @since 1.0.0
	 */
	public $metabox_form_args;
	/**
	 * Notes array
	 * @var array
	 * @since 1.0.0
	 */
	public $notes = array();

	/**
	 * KFN_Metabox constructor.
	 * ----------------------------------------
	 * Loads api helpers for easier plugin use
	 */
	public function __construct() {
		global $kfn;

		if ( method_exists( $kfn, 'load_api_helpers' ) && method_exists( $kfn, 'load_tests' ) ) {
			$kfn->load_api_helpers();
			$kfn->load_tests();
		}
	}
	/**
	 * KFN_Dashboard_Metabox->init()
	 * -------------------------------------
	 * Inherited from KFN_Metabox interface
	 * Initializes KFN dashboard metabox
	 * -------------------------------------
	 * @since 1.0.0
	 * @return void
	 */
	public function init() {
		// KFN_Options instance
		global $kfn_options;

		// Init default options for KFN dashboard metabox
		$this->init_defaults();

		// Default options for KFN dashboard metabox
		$this->metabox_args = $kfn_options->get_option( 'dashboard_metabox_args' );

		// Register new metabox
		add_meta_box( $this->metabox_args['id'], $this->metabox_args['name'], $this->metabox_args['callback'], $this->metabox_args['screen'], $this->metabox_args['context'], $this->metabox_args['priority'] );
	}

	/**
	 * KFN_Dashboard_Metabox->init_defaults()
	 * -----------------------------------------------------------------
	 * Initializes default parameters for KFN dashboard metabox block
	 * ( used for add_meta_box() call ) and KFN dashboard metabox form
	 * -----------------------------------------------------------------
	 * @since 1.0.0
	 * @return void
	 */
	public function init_defaults() {
		global $kfn_options;

		// Dashboard metabox parameters ( used to build add_meta_box() call )
		$this->metabox_args = array(
			'id'       => 'kfn',
			'name'     => 'Kady Fast Notes',
			'callback' => array( $this, 'metabox' ),
			'screen'   => 'dashboard',
			'context'  => 'side',
			'priority' => 'high'
		);

		// Add new option and filter for it
		$kfn_options->add_option( 'dashboard_metabox_args', apply_filters( 'kfn_dashboard_metabox_args', $this->metabox_args ) );

		// Dashboard metabox form parameters ( used to generate view for metabox )
		$this->metabox_form_args = array(
			'form_class'    => 'kfn',
			'title_input'   => array(
				'label_text'  => 'Title',
				'type'        => 'text',
				'name'        => 'kfn_title',
				'placeholder' => 'Enter the title of the note!'
			),
			'content_input' => array(
				'type'        => 'text',
				'label_text'  => 'Content',
				'name'        => 'kfn_content',
				'placeholder' => 'Enter the content of your note!'
			),
			'save_button'   => array(
				'type'  => 'submit',
				'text'  => 'Save',
				'class' => 'button button-primary'
			)
		);

		// Add new "kfn_dashboard_form_args" and "kfn_dashboard_metabox_form_args" filter for it.
		$kfn_options->add_option( 'dashboard_metabox_form_args', apply_filters( 'kfn_dashboard_metabox_form_args', $this->metabox_form_args ) );

		// Option contains all registered notes
		$kfn_options->add_option('dashboard_metabox_notes', $this->notes);
	}

	/**
	 * KFN_Dashboard_Metabox->run()
	 * ---------------------------------------------------------------------
	 * Bootstrap method for the metabox ( register init() method to the
	 * "wp_dashboard_setup" action )
	 * ---------------------------------------------------------------------
	 * @since 1.0.0
	 * @return void
	 */
	public function run() {
		global $kfn_hook;

		if ( method_exists( $kfn_hook, 'add_action' ) ) {
			$kfn_hook->add_action( 'wp_dashboard_setup', array( $this, 'init' ) );
		}
	}

	/**
	 * KFN_Dashboard_Metabox->metabox()
	 * ---------------------------------
	 * Draws metabox markup
	 * ---------------------------------
	 * @global KFN_View
	 *
	 * @since 1.0.0
	 *
	 * @return \WP_Error|void
	 */
	public function metabox() {
		$view = kfn_include( 'admin/views/dashboard/dashboard-metabox.php' );
		echo apply_filters( 'kfn_dashboard_metabox_html', $view );
	}

	/**
	 * KFN_Dashboard_Metabox->save()
	 * -------------------------------------------
	 * Saves new note if it is requested by user
	 * -------------------------------------------
	 * @global KFN_View
	 *
	 * @since 1.0.0
	 *
	 * @return \WP_Error|void
	 */
	public function save()
	{
		global $kfn_request, $kfn_options;

		// Get data from current request object
		$request = $kfn_request->get_current_request();

		// Sanitize received data and put it into database
		if ( ! empty( $request ) ) {
			$title   = $kfn_request->is_set( $request[ $this->metabox_form_args['title_input']['name'] ] ) ? $request[ $this->metabox_form_args['title_input']['name'] ] : '';
			$content = $kfn_request->is_set( $request[ $this->metabox_form_args['content_input']['name'] ] ) ? $request[ $this->metabox_form_args['content_input']['name'] ] : '';

			$sanitized_title   = sanitize_text_field( $title );
			$sanitized_content = sanitize_text_field( $content );

			$notes_array = $kfn_options->get_option('dashboard_metabox_notes');

			$notes_array[ $title ] = array(
				'date'    => current_time( get_option( 'time_format' ) ),
				'title'   => $sanitized_title,
				'content' => $sanitized_content
			);

			print_r($notes_array);
		}
	}

	/**
	 * KFN_Dashboard_Metabox->display_notes()
	 * -------------------------------------------
	 * Displays all registered notes
	 * -------------------------------------------
	 * @global KFN_View
	 *
	 * @since 1.0.0
	 *
	 * @return \WP_Error|void
	 */
	public function display_notes()
	{
		// If there is new note requested, save it
		$this->save();

		// Print out our notes
		kfn_include('admin/views/dashboard/dashboard-metabox-note.php');
	}
}