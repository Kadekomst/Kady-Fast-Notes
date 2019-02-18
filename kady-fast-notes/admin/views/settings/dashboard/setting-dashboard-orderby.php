<?php
/**
 * setting-dashboard-orderby.php
 * ----------------------------------
 * View file for "Order By" setting
 * in "Dashboard Metabox" section of
 * KFN settings page.
 * ----------------------------------
 * @author Kadekomst
 * @since 1.0.0
 */
$settings = get_option( 'kfn_settings' );
?>

<select name="kfn_settings[dashboard_metabox_orderby]" id="kfn_dashboard_orderby">
    <option value="none" <?php selected( $settings['dashboard_metabox_orderby'], 'none' ); ?>>
		<?php esc_html_e('No Sorting','kfn'); ?>
    </option>
    <option value="date"<?php selected( $settings['dashboard_metabox_orderby'], 'date' ); ?> >
		<?php esc_html_e('Date','kfn'); ?>
    </option>
    <option value="modified" <?php selected( $settings['dashboard_metabox_orderby'], 'modified' ); ?>>
		<?php esc_html_e('Last Modified','kfn'); ?>
    </option>
    <option value="rand" <?php selected( $settings['dashboard_metabox_orderby'], 'rand' ); ?>>
		<?php esc_html_e('Random','kfn'); ?>
    </option>
    <option value="author" <?php selected( $settings['dashboard_metabox_orderby'], 'author' ); ?>>
		<?php esc_html_e('Author','kfn'); ?>
    </option>
</select>

