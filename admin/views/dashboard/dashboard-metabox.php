<?php
/**
 * dashboard-metabox.php
 * ----------------------------------------
 * View component file.
 * Contains view for KFN dashboard metabox
 * ----------------------------------------
 * @since 1.0.0
 */

global $kfn, $kfn_dashboard_metabox;
$kfn->load_api_helpers();

$params = kfn_get_option('dashboard_metabox_form_args');
?>

<form action="" method="POST" class="<?php echo $params['form_class'] ?>">

	<label for="<?php echo $params['title_input']['name'] ?>">
		<?php echo $params['title_input']['label_text'] ?>
	</label>

	<input type="<?php echo $params['title_input']['type'] ?>"
	       name="<?php echo $params['title_input']['name'] ?>"
	       placeholder="<?php echo $params['title_input']['placeholder'] ?>">

	<label for="<?php echo $params['content_input']['name'] ?>">
		<?php echo $params['content_input']['label_text'] ?>
	</label>

	<input type="<?php echo $params['content_input']['type'] ?>"
	       name="<?php echo $params['content_input']['name'] ?>"
	       placeholder="<?php echo $params['content_input']['placeholder'] ?>">

	<input type="<?php echo $params['save_button']['type'] ?>"
	       value="<?php echo $params['save_button']['text'] ?>"
	       class="<?php  echo $params['save_button']['class'] ?>">

    <?php $kfn_dashboard_metabox->display_notes(); ?>

</form>
