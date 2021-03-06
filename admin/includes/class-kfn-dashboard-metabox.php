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
use WP_Query;

// Classes
use KFN\includes\KFN_Hook;
use KFN\includes\KFN_Options;
use KFN\includes\KFN_Request;

require( KFN_DIR_PATH . 'admin/includes/interfaces/interface-kfn-metabox.php' );

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
	public $notes;

	/**
	 * KFN_Metabox constructor.
	 * ----------------------------------------
	 * Loads api helpers for easier plugin use
	 * ----------------------------------------
	 * @global KFN_Options
	 */
	public function __construct() {
		global $kfn;

		if ( method_exists( $kfn, 'load_api' ) && method_exists( $kfn, 'load_tests' ) ) {
			$kfn->load_api();
		}
	}

	/**
	 * KFN_Dashboard_Metabox->init()
	 * -------------------------------------
	 * Inherited from KFN_Metabox interface
	 * Initializes KFN dashboard metabox
	 * -------------------------------------
	 * @global KFN_Options;
	 *
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
		add_meta_box(
			$this->metabox_args['id'],
			$this->metabox_args['name'],
			$this->metabox_args['callback'],
			$this->metabox_args['screen'],
			$this->metabox_args['context'],
			$this->metabox_args['priority']
		);
	}

	/**
	 * KFN_Dashboard_Metabox->init_defaults()
	 * -----------------------------------------------------------------
	 * Initializes default parameters for KFN dashboard metabox block
	 * ( used for add_meta_box() call ) and KFN dashboard metabox form
	 * -----------------------------------------------------------------
	 * @global KFN_Options;
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function init_defaults() {
		global $kfn_options;

		// Dashboard metabox parameters ( used to build add_meta_box() call )
		$metabox_args = array(
			'id'       => 'kfn',
			'name'     => 'Kady Fast Notes',
			'callback' => array( $this, 'metabox' ),
			'screen'   => 'dashboard',
			'context'  => 'side',
			'priority' => 'high'
		);

		// Add new option and filter for it
		$kfn_options->add_option( 'dashboard_metabox_args', apply_filters( 'kfn_dashboard_metabox_args', $metabox_args ) );

		// Dashboard metabox form parameters ( used to generate view for metabox )
		$this->metabox_form_args = array(
			'action'           => '',
			'method'           => 'POST',
			'title_input'      => array(
				'label_text'  => 'Title',
				'type'        => 'text',
				'name'        => 'kfn_title',
				'placeholder' => 'Enter the title of the note!',
			),
			'content_textarea' => array(
				'label_text'  => 'Content',
				'name'        => 'kfn_content',
				'placeholder' => 'Enter the content of your note!',
				'class'       => 'kfn-dashboard-textarea'
			)
		);

		// Add new "kfn_dashboard_form_args" and "kfn_dashboard_metabox_form_args" filter for it.
		$kfn_options->update_option( 'dashboard_metabox_form_args', apply_filters( 'kfn_dashboard_metabox_form_args', $this->metabox_form_args ) );

		// Option contains all registered notes
		$kfn_options->add_option( 'dashboard_metabox_notes', $this->notes );
	}

	/**
	 * KFN_Dashboard_Metabox->run()
	 * ---------------------------------------------------------------------
	 * Bootstrap method for the metabox ( register init() method to the
	 * "wp_dashboard_setup" action )
	 * ---------------------------------------------------------------------
	 * @global KFN_Hook;
	 *
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
	 * @global KFN_Request|KFN_Options;
	 *
	 * @since 1.0.0
	 *
	 * @return \WP_Error|void
	 */
	public function save() {
		global $kfn_request;

		// Get data from current request object
		$request = $kfn_request->get_current_request();

		// Sanitize received data and put it into database
		if ( ! empty( $request ) ) {

			// Processing all form dashboard
			$title   = $kfn_request->is_set( $request[ $this->metabox_form_args['title_input']['name'] ] )
				? $request[ $this->metabox_form_args['title_input']['name'] ]
				: 'Please enter the title of the note!';
			$content = $kfn_request->is_set( $request[ $this->metabox_form_args['content_textarea']['name'] ] )
				? $request[ $this->metabox_form_args['content_textarea']['name'] ]
				: 'Please write the content of the note!';

			// Sanitizing all form dashboard
			$sanitized_title   = sanitize_text_field( $title );
			$sanitized_content = sanitize_textarea_field( $content );

			// New post args
			$new_post_args = array(
				'post_author' => get_current_user_id(),
				'post_content' => $sanitized_content,
				'post_title' => $sanitized_title,
				'post_status' => 'draft',
				'post_type' => 'kfn',
			);

			// Insert new post into database
			wp_insert_post(
				$new_post_args,
				true
			);
		}
	}

	/**
	 * KFN_Dashboard_Metabox->display_notes()
	 * -------------------------------------------
	 * Displays all registered notes
	 * -------------------------------------------
	 * @since 1.0.0
	 *
	 * @return \WP_Error|void
	 */
	public function display_notes() {
		// If there is new note requested, save it
		$this->save();

		// Print out our notes
		kfn_include( 'admin/views/dashboard/dashboard-metabox-note.php' );
	}

	/**
	 * KFN_Dashboard_Metabox->delete_all_notes()
	 * -------------------------------------------
	 * Deletes all registered notes
	 * -------------------------------------------
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function delete_all_notes() {
		$notes = new WP_Query( array(
			'numberposts'      => -1,
			'post_type'        => 'kfn',
		) );

		while ( $notes->have_posts() ) {
			$notes->the_post();
			wp_delete_post( $notes->post->ID, false );
		}
	}
}