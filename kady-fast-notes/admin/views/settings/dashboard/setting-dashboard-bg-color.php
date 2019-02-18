<?php
/**
 * setting-dashboard-bg-color.php
 * ---------------------------------------------
 * View file for "Background Color" setting
 * in "Dashboard Metabox" section of
 * KFN settings page.
 * ---------------------------------------------
 * @author Kadekomst
 * @since 1.0.0
 */

$settings = get_option('kfn_settings');

printf(
	'<input type="color" name="kfn_settings[dashboard_metabox_bg_color]" value="%s">',
	isset( $settings['dashboard_metabox_bg_color'] ) ? esc_attr( $settings['dashboard_metabox_bg_color'] ) : ''
);