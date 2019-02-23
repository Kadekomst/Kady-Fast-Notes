<?php
/**
 * uninstall.php
 * -------------------------------------------
 * Uninstalling of Kady Fast Notes.
 *
 * This file is managed by WordPress to
 * correctly uninstall Kady Fast Notes plugin
 * -------------------------------------------
 * @since 1.0.0
 * @author Kadekomst
 */

// If accessed directly, bail
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit( 'Direct access is not allowed!' );
}

/**
 * Plugin deleting functionality
 * -----------------------------------------------------------------------------------------------
 * Deleting KFN plugin process contains two main parts:
 *
 * 1. Delete all plugin data from database ( "kfn" and "kfn_settings" rows in "wp_options" table )
 * 2. Delete all posts with type "kfn"
 */

delete_option( 'kfn' );
delete_option( 'kfn_settings' );

$kfn_posts = get_posts( array(
	'numberposts' => - 1,
	'post_status' => 'any',
	'post_type'   => 'kfn'
) );

foreach ( $kfn_posts as $post ) {
	wp_delete_post( $post->ID, true );
}



