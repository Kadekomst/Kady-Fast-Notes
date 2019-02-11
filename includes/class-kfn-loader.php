<?php
/**
 * Class KFN_Loader
 * -------------------------------------
 * Core class of Kady Fast Notes plugin
 *
 * This class is responsible for loading
 * assets files, retrieving filenames
 * for directories etc.
 * -------------------------------------
 * @since 1.0.0
 * @author Kadekomst
 */

namespace KFN\includes;

if ( ! class_exists( 'KFN_Loader' ) ) {

	class KFN_Loader {
		/**
		 * KFN_Assets_Loader constructor.
		 * ---------------------------------------------
		 * By default, like among other plugin classes,
		 * loads API functions to easier plugin use
		 * ---------------------------------------------
		 */
		public function __construct() {
			global $kfn;

			if ( method_exists( $kfn, 'load_api' ) ) {
				$kfn->load_api();
			}
		}

		/**
		 * KFN_Assets_Loader->load_stylesheets()
		 * -------------------------------------------------------------
		 * Loads all .css-files from specified directory to the page.
		 * Default directory - plugin directory assets/css/
		 * -------------------------------------------------------------
		 * @since 1.0.0
		 *
		 * @param $dir string / Plugin path to the directory contained .css-files
		 *
		 * @return \WP_Error|bool
		 */
		public function load_stylesheets( $dir = "assets/css/" ) {

			// All files from specified directories
			$files = $this->scan_dir( $dir );

			// $js_files array contains all .js-files matched in specified directories
			$css_files = array();

			// Generate $js_files array
			foreach ( $files as $path => $directory ) {
				foreach ( $directory as $file ) {
					if ( strpos( $file, '.css' ) ) {
						$css_files[] = array(
							'path' => $path,
							'filename' => $file
						);
					}
				}
			}

			// If there is no .css-files in any of specified directories, throw an exception
			if ( empty( $css_files ) ) {
				return new \WP_Error( 'kfn_assets_loader_load_stylesheets_error', 'No .css-files was founded in directory '.$dir );
			}

			// Finally, let's include our CSS to the webpage
			foreach ( $css_files as $path => $file_obj ) {
				wp_enqueue_style( str_replace( '.css', '', $file_obj['filename'] ), $file_obj['path'] . $file_obj['filename'] );
			}

			// If there were no exceptions, return true
			return true;
		}

		/**
		 * KFN_Assets_Loader->load_scripts()
		 * -------------------------------------------------------------------------------------------
		 * Loads all .js-files from specified directory to the page.
		 * Default directory - plugin directory assets/js/
		 * -------------------------------------------------------------------------------------------
		 * @since 1.0.0
		 *
		 * @param $dir string / Plugin path to the directory contained .js-files. Default: assets/js/
		 *
		 * @return \WP_Error|bool
		 */
		public function load_scripts( $dir = 'assets/js/' ) {

			// All files from specified directories
			$files = $this->scan_dir( $dir );

			// $js_files array contains all .js-files matched in specified directories
			$js_files = array();

			// Generate $js_files array
			foreach ( $files as $path => $directory ) {
				foreach ( $directory as $file ) {
					if ( strpos( $file, '.js' ) ) {
						$js_files[] = array(
							'path' => $path,
							'filename' => $file
						);
					}
				}
			}

			// If there is no .js-files in any of specified directories, throw an exception
			if ( empty( $js_files ) ) {
				return new \WP_Error( 'kfn_assets_loader_load_scripts_error', 'No .js-files was founded in directory ' . $dir );
			}

			// Finally, let's include our JavaScript to the webpage
			foreach ( $js_files as $path => $file_obj ) {
				wp_enqueue_style( str_replace( '.js', '', $file_obj['filename'] ), $file_obj['path'] . $file_obj['filename'] );
			}

			// If there were no exceptions, return true
			return true;
		}

		/**
		 * KFN_Assets_Loader->scan_dir()
		 * ----------------------------------------------------------------
		 * Grabs filenames and paths of the files in specified directories
		 * ----------------------------------------------------------------
		 * @since 1.0.0
		 *
		 * @param $dir string / Plugin path to the directories. Default: assets/js/
		 *
		 * @return \WP_Error|array
		 */
		public function scan_dir( $dir ) {

			// Array contains object of every specified directory ( $dir parameter )
			$directories = array();

			// Directory parsing process
			if ( is_string( $dir ) ) {
				$dir_arr = array( $dir );
				foreach ( $dir_arr as $directory ) {
					$directories[] = array(
						'name'         => $directory,
						'scan_path'    => kfn_get_default_option( 'path' ) . $directory,
						'include_path' => kfn_get_default_option( 'url' ) . $directory
					);
				}
			} else if ( is_array( $dir ) ) {
				foreach ( $dir as $directory ) {
					$directories[] = array(
						'name'         => $directory,
						'scan_path'    => kfn_get_default_option( 'path' ) . $directory,
						'include_path' => kfn_get_default_option( 'url' ) . $directory
					);
				}
			} else {
				return new \WP_Error( 'kfn_assets_loader_scan_dir_wrong_type', 'Parameter $dir expected string or array, got ' . gettype( $dir ) );
			}

			// $all_files array contains all files matched in specified directories
			$all_files = array();

			// Generating $all_files array
			foreach ( $directories as $directory ) {
				if ( is_dir( $directory['scan_path'] ) ) {
					$all_files[ $directory['include_path'] ] = array_diff( scandir( $directory['scan_path'] ), array('..', '.') );
				}
			}

			// Return all founded files to further processing
			return $all_files;
		}

		/**
		 * KFN_Assets_Loader->get_filenames_from_dir()
		 * ----------------------------------------------------------------
		 * Grabs filenames and paths of the files in specified directories
		 * ----------------------------------------------------------------
		 * @since 1.0.0
		 *
		 * @param $dir string|array / Plugin path to the directories. Default: assets/js/
		 * @param $extension string / Optional. Tells function to return filenames with specified extension.
		 *
		 * @return array
		 */
		public function get_filenames_from_dir( $dir = '', $extension = 'all' )
		{
			$directories = $this->scan_dir( $dir );
			return $directories;
		}
	}

}