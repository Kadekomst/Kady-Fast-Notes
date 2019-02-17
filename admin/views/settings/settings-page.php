<?php
/*
 * settings-page.php
 * -------------------------------------
 * Part of Kady Fast Notes source code.
 *
 * This file contains HTML/CSS view
 * for KFN settings page.
 * -------------------------------------
 * @author Kadekomst
 * @since 1.0.0
 */
?>

<div class="wrap">
    <h1><?php _e('Kady Fast Notes', 'kfn'); ?></h1>
    <form method="post" action="options.php">
		<?php
		// This prints out all hidden setting dashboard
		settings_fields( 'kfn-settings-page' );
		do_settings_sections( 'kfn-settings-page' );

		// Submit button
		submit_button();
		?>
    </form>
</div>

