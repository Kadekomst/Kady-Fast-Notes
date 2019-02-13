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
$kfn->load_api();
$params = kfn_get_option('dashboard_metabox_form_args');

?>

<form action=""
      method="<?php echo $params['method'] ?>"
      class="kfn-dashboard-metabox">

	<label for="<?php echo $params['title_input']['name'] ?>"
           class="kfn-dashboard-label">
		<?php echo $params['title_input']['label_text'] ?>
	</label>

	<input type="<?php echo $params['title_input']['type'] ?>"
	       name="<?php echo $params['title_input']['name'] ?>"
	       placeholder="<?php echo $params['title_input']['placeholder'] ?>"
           class="kfn-dashboard-input">

	<label for="<?php echo $params['content_textarea']['name'] ?>"
           class="kfn-dashboard-label">
		<?php echo $params['content_textarea']['label_text'] ?>
	</label>

    <textarea name="<?php echo $params['content_textarea']['name'] ?>"
              cols="30"
              rows="10"
              class="kfn-dashboard-textarea"
              placeholder="<?php echo $params['content_textarea']['placeholder'] ?>">
    </textarea>

	 <?php
     // Submit button provided by WordPress API.
     submit_button( __('Save') );
     ?>

    <?php
     // Display all registered notes
     $kfn_dashboard_metabox->display_notes();
    ?>

</form>
