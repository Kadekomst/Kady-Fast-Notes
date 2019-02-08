<?php
/**
 * Created by PhpStorm.
 * User: Kadekomst
 * Date: 05.02.2019
 * Time: 21:52
 */

namespace KFN\includes;

class KFN_View {
	/**
	 * KFN_View constructor.
	 */
	public function __construct() {
		global $kfn;

		if ( method_exists($kfn, 'load_api_helpers') )
		{
			$kfn->load_api_helpers();
		}
	}

	/**
	 * load_admin_view( $view )
	 * ---------------------------------
	 * Loads view file for admin panel
	 * ---------------------------------
	 * @param $view
	 *
	 * @return \WP_Error
	 */
	public function load_admin_view( $view )
	{
		if ( !is_string( $view ) ) {
			return new \WP_Error('kfn_view_load_admin_view_error_wrong_type', 'Wrong type given to $view parameter of '.__METHOD__);
		}

		return kfn_include("admin/views/$view.php");
	}





}