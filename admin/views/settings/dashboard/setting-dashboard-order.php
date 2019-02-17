<?php
/**
 * setting-dashboard-order.php
 * ----------------------------------
 * View file for "Order" setting
 * in "Dashboard Metabox" section of
 * KFN settings page.
 * ----------------------------------
 * @author Kadekomst
 * @since 1.0.0
 */
$settings = get_option('kfn_settings');
?>

<select name="kfn_settings[dashboard_metabox_order]" id="kfn_dashboard_order">
	<option value="ASC"<?php selected( $settings['dashboard_metabox_order'], 'ASC' ); ?> >
		<?php esc_html_e('Direct','kfn'); ?>
	</option>
	<option value="DESC" <?php selected( $settings['dashboard_metabox_order'], 'DESC' ); ?>>
		<?php esc_html_e('Reversed','kfn'); ?>
	</option>
</select>

