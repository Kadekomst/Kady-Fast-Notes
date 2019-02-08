<?php
/**
 * Created by PhpStorm.
 * User: Kadekomst
 * Date: 02.02.2019
 * Time: 19:19
 */

namespace KFN\includes;

class KFN_Request {

	public function __construct() {
		// code...
	}
	/**
	 * get_current_request()
	 * -------------------------------------------------------
	 * Returns non-empty request object ( $_GET or $_POST )
	 * -------------------------------------------------------
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_current_request()
	{
		$get = $_GET;
		$post = $_POST;

		if ( !empty($_GET) ) {
			return $get;
		}

		if ( !empty($_POST) ) {
			return $post;
		}

		return array('There is not requested data');
	}

	/**
	 * is_set( $data )
	 * --------------------------------------------
	 * Checks is set entry data set and not empty
	 * ---------------------------------------------
	 * @since 1.0.0
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function is_set( $data )
	{
		return isset( $data ) && !empty( $data );
	}



}