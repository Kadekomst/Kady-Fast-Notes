<?php
/**
 * dashboard-widget.php
 * ----------------------------------------
 * View component file.
 * Contains view for KFN dashboard widget
 * ----------------------------------------
 * @since 1.0.0
 */
global $kfn_widget;

?>

<form action="" method="POST" class="kfn">
	<label for="kfn_title">Title</label>
	<input type="text" name="kfn_title">
	<label for="kfn_content">Content</label>
	<input type="text" name="kfn_content">
	<input type="submit" value="Save">
</form>
