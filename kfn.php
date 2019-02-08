<?php
/**
 * The plugin bootstrap file
 * --------------------------------------------------------------------------------
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 * --------------------------------------------------------------------------------
 * @link https://kady-fast-notes.com
 * @package Kady Fast Notes
 * @since 1.0.0
 * --------------------------------------------------------------------------------
 * Plugin Name: Kady Fast Notes
 * Plugin URI: https://kady-fast-notes.com
 * Description: Flexible fast notes widget placed on WP console panel for easy access ( dep version )
 * Author: Nikita "Kadekomst" Zabashtin
 * Author URI: https://kady-fast-notes.com
 * Text Domain: kfn
 * Domain Path: /lang
 * Version: 1.0.0
 * Copyright: Nikita "Kadekomst" Zabashtin
 * License: ...
 * License URI: ...
 */

// Classes
use KFN\includes\KFN_Request;
use KFN\includes\KFN_Hook;
use KFN\includes\KFN_Settings;
use KFN\admin\includes\KFN_Dashboard_Widget;
use KFN\includes\KFN_View;
use KFN\includes\KFN_Loader;

// WordPress API
include( ABSPATH . 'wp-load.php' );

// If accessed directly, exit
if ( ! defined( 'WPINC' ) || ! defined( 'ABSPATH' ) ) {
	exit( 'Invalid request' );
}

// Class existing check
if ( ! class_exists( 'KFN' ) ) :

	class KFN {
		/**
		 * Plugin version
		 * @var string
		 * @since 1.0.0
		 */
		public $plugin_name = 'Kady Fast Notes';
		/**
		 * Plugin version
		 * @var string
		 * @since 1.0.0
		 */
		public $version = '1.0.0';
		/**
		 * Plugin settings
		 * @var string
		 * @since 1.0.0
		 */
		public $settings = array();
		/**
		 * Include paths for core classes
		 * @var array
		 */
		private $class_include_paths = array();

		/**
		 * KFN constructor.
		 */
		public function __construct() {
			// Nothing is here
		}

		/**
		 * KFN->initialize()
		 * ---------------------------------------
		 * Initializes the plugin settings, loads
		 * core files etc.
		 * ---------------------------------------
		 * @since 1.0.0
		 */
		public function initialize() {

			// Initialize settings
			$this->init_settings();
			$this->define_default_constants();

			// Plugin core file loading
			$this->load_api_helpers();
			$this->load_classes();
			$this->load_tests();

			// After full plugin files loading, init the globals
			$this->globals_init();

			// Initialize KFN_Hook instance which registers WordPress actions/filters.
			// Initialize KFN_Widget instance which displays the widget in admin-panel.
			global $kfn_hook, $kfn_widget, $kfn_loader, $kfn_settings;

			// Actions
			$kfn_hook->add_action('init', array($this, 'register_post_types'));

			// Load CSS and JS files
			$stylesheets = array("assets/css/", "admin/css/");
			$scripts = array("assets/js/", "admin/js/");
			$kfn_loader->load_stylesheets( $stylesheets );
			$kfn_loader->load_scripts( $scripts );

			// Display widget
			$kfn_widget->run();

			// Register all actions/filters
			$kfn_hook->run();
		}

		/**
		 * KFN->define($name, $value)
		 * ------------------------------------------------------
		 * Defines new constant if it is hasn't already defined.
		 * ------------------------------------------------------
		 *
		 * @param $name | Constant name
		 * @param $value | Constant value
		 *
		 * @since 1.0.0
		 * @access private
		 */
		private function define( $name, $value ) {
			if ( defined( $name ) ) {
				return;
			}
			define( $name, $value );
		}

		/**
		 * KFN->init_settings()
		 * -----------------------------------
		 * Initializes main plugin settings
		 * like various paths, version etc.
		 * -----------------------------------
		 * @access private
		 * @since 1.0.0
		 */
		private function init_settings() {
			$plugin_name = $this->plugin_name;
			$version     = $this->version;
			$path        = plugin_dir_path( __FILE__ );
			$basename    = plugin_basename( __FILE__ );
			$url         = plugin_dir_url( __FILE__ );

			$this->settings = array(
				'plugin_name' => $plugin_name,
				'version'     => $version,
				'path'        => $path,
				'basename'    => $basename,
				'url'         => $url
			);
		}

		/**
		 * KFN->define_default_constants()
		 * ----------------------------------
		 * Defines main path constants
		 * ---------------------------------
		 * @since 1.0.0
		 * @access private
		 */
		private function define_default_constants() {
			/*
            * Default constants
            * ----------------------------------------------------------
            * KFN_DIR_PATH - path to Kady Fast Notes's plugin directory
            * KFN_DIR_INC_PATH - path to KFN's /includes sub-directory
            * KFN_DIR_LANG_PATH - path to KFN's /lang sub-directory
            * KFN_DIR_ADMIN_PATH - path to KFN's /admin sub-directory
            * KFN_DIR_ASSETS_PATH - path to KFN's /assets sub-directory
            * ----------------------------------------------------------
            */
			define( 'KFN_DIR_PATH', $this->settings['path'] );
			define( 'KFN_DIR_INC_PATH', KFN_DIR_PATH . 'includes' );
			define( 'KFN_DIR_ADMIN_PATH', KFN_DIR_PATH . 'admin' );
			define( 'KFN_DIR_LANG_PATH', KFN_DIR_PATH . 'lang' );
			define( 'KFN_DIR_ASSETS_PATH', KFN_DIR_PATH . 'assets' );
		}

		/**
		 * KFN->load_api_helpers()
		 * ----------------------------------
		 * Loads all API functions
		 * ---------------------------------
		 * @since 1.0.0
		 * @access private
		 */
		public function load_api_helpers() {
			require_once( KFN_DIR_INC_PATH . '/api/include.php' );

			foreach ( glob( KFN_DIR_INC_PATH . '\api\*.php' ) as $file ) {
				kfn_include( $file, true );
			}
		}

		/**
		 * KFN->load_classes()
		 * ----------------------------------
		 * Loads all core classes
		 * ---------------------------------
		 * @since 1.0.0
		 * @access private
		 */
		public function load_classes() {
			$this->class_include_paths = array(
				'admin' => KFN_DIR_ADMIN_PATH . '/includes/class-kfn-*.php',
				'core'  => KFN_DIR_INC_PATH . '/class-kfn-*.php'
			);

			foreach ( $this->class_include_paths as $path ) {
				foreach ( glob( $path ) as $file ) {
					kfn_include( $file, true );
				}
			}
		}

		/**
		 * KFN->load_api_helpers()
		 * -------------------------------------------
		 * Loads different plugin functionality tests
		 * -------------------------------------------
		 * @since 1.0.0
		 * @access private
		 */
		public function load_tests() {
			require_once( KFN_DIR_INC_PATH . '/api/include.php' );

			foreach ( glob( KFN_DIR_INC_PATH . '/tests/*.php' ) as $file ) {
				kfn_include( $file, true );
			}
		}

		/**
		 * KFN->globals_init()
		 * -----------------------------------------
		 * Initializes globals for main KFN classes
		 * -----------------------------------------
		 * @since 1.0.0
		 * @access private
		 */
		private function globals_init() {
			if ( ! isset( $GLOBALS['kfn_request'] ) ) {
				$GLOBALS['kfn_request'] = new KFN_Request();
			}

			if ( ! isset( $GLOBALS['kfn_hook'] ) ) {
				$GLOBALS['kfn_hook'] = new KFN_Hook();
			}

			if ( ! isset( $GLOBALS['kfn_settings'] ) ) {
				$GLOBALS['kfn_settings'] = new KFN_Settings( $this->settings );
			}

			if ( ! isset( $GLOBALS['kfn_widget'] ) ) {
				$GLOBALS['kfn_widget'] = new KFN_Dashboard_Widget();
			}

			if ( ! isset( $GLOBALS[ 'kfn_view' ]) ) {
				$GLOBALS['kfn_view'] = new KFN_View();
			}

			if ( ! isset( $GLOBALS[ 'kfn_loader' ]) ) {
				$GLOBALS['kfn_loader'] = new KFN_Loader();
			}
		}

		/**
		 * KFN->register_post_types()
		 * -----------------------------------------
		 * Register post types for the plugin
		 * -----------------------------------------
		 * @since 1.0.0
		 * @access private
		 */
		public function register_post_types() {
			register_post_type( 'kfn', array(
				'label'               => null,
				'labels'              => array(
					'name'               => __( 'Kady Fast Notes', 'kfn' ),
					// основное название для типа записи
					'singular_name'      => __( 'Kady Fast Notes', 'kfn' ),
					// название для одной записи этого типа
					'add_new'            => __( 'Add note', 'kfn' ),
					// для добавления новой записи
					'add_new_item'       => __( 'Add new note', 'kfn' ),
					// заголовка у вновь создаваемой записи в админ-панели.
					'edit_item'          => __( 'Edit note', 'kfn' ),
					// для редактирования типа записи
					'new_item'           => __( 'Note Content', 'kfn' ),
					// текст новой записи
					'view_item'          => __( 'View note', 'kfn' ),
					// для просмотра записи этого типа.
					'search_items'       => __( 'Search for note', 'kfn' ),
					// для поиска по этим типам записи
					'not_found'          => __( 'Not found', 'kfn' ),
					// если в результате поиска ничего не было найдено
					'not_found_in_trash' => __( 'Not found in trash', 'kfn' ),
					// если не было найдено в корзине
					'parent_item_colon'  => '',
					// для родителей (у древовидных типов)
					'menu_name'          => 'Kady Fast Notes',
					// название меню
				),
				'description'         => '',
				'public'              => true,
				'publicly_queryable'  => null,
				// зависит от public
				'exclude_from_search' => null,
				// зависит от public
				'show_ui'             => null,
				// зависит от public
				'show_in_menu'        => null,
				// показывать ли в меню адмнки
				'show_in_admin_bar'   => null,
				// по умолчанию значение show_in_menu
				'show_in_nav_menus'   => null,
				// зависит от public
				'show_in_rest'        => null,
				// добавить в REST API. C WP 4.7
				'rest_base'           => null,
				// $post_type. C WP 4.7
				'menu_position'       => null,
				'menu_icon'           => null,
				//'capability_type'   => 'post',
				//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
				//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
				'hierarchical'        => false,
				'supports'            => array( 'title', 'editor' ),
				// 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
				'taxonomies'          => array(),
				'has_archive'         => false,
				'rewrite'             => true,
				'query_var'           => true,
			) );
		}
	}

	/**
	 * kfn()
	 * ------------------------------------------------------------
	 * Main function which creates the instance
	 * of KFN class, sets global for it and runs the init method
	 * ------------------------------------------------------------
	 * @since 1.0.0
	 */
	function kfn() {
		if ( ! isset( $GLOBALS['kfn'] ) ) {
			$kfn = $GLOBALS['kfn'] = new KFN();
			$kfn->initialize();
		}
	}

	// Run the plugin
	kfn();

endif; // Class existing check

