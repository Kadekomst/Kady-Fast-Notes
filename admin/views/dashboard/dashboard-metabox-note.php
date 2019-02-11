<?php
/**
 * dashboard-metabox-note.php
 * -----------------------------------------
 * HTML/CSS view for KFN dashboard metabox
 * -----------------------------------------
 * @since 1.0.0
 */
global $kfn, $kfn_options;
$kfn->load_api_helpers();

?>
<!---->
<?php foreach( kfn_get_option('dashboard_metabox_notes') as $note ) : ?>
<div class="kfn-note">
	<h3 class="kfn-note-title"><?php echo $note['title']; ?></h3>
	<p class="kfn-note-content"><?php echo $note['content']; ?></p>
</div>
<?php endforeach; ?>