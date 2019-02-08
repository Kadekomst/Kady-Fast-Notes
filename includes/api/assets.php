<?php
/**
 * assets.php
 * ---------------------------------------
 * API file. Contains functions-wrappers
 * for KFN_Assets_Loader class contents
 * ---------------------------------------
 * @author Kadekomst
 * @since 1.0.0
 */

function kfn_load_scripts( $dir )
{
	global $kfn_assets_loader;

	$kfn_assets_loader->load_scripts( $dir );

}