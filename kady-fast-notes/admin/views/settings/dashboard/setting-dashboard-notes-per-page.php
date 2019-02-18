<?php
/**
 * setting-dashboard-notes-per-page.php
 * -------------------------------------------
 * View file for "Notes per page" setting
 * in "Dashboard Metabox" section of
 * KFN settings page.
 * -------------------------------------------
 * @author Kadekomst
 * @since 1.0.0
 */

$settings = get_option('kfn_settings');

printf(
	'<input type="text" name="kfn_settings[dashboard_metabox_notes_per_page]" placeholder="Enter the number" value="%s">',
	isset( $settings['dashboard_metabox_notes_per_page'] ) ? esc_attr( $settings['dashboard_metabox_notes_per_page'] ) : 5
);