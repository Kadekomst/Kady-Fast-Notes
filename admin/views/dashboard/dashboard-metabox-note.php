<?php
/**
 * dashboard-metabox-note.php
 * ---------------------------------------------------
 * HTML/CSS view for KFN dashboard metabox note block
 * ---------------------------------------------------
 * @author Kadekomst
 * @since 1.0.0
 */
?>

<?php foreach ( get_option('kfn_dashboard_metabox_notes') as $note ) : ?>
    <div class="kfn-dashboard-note">
	    <h3 class="kfn-dashboard-note-title"><?php echo $note['title']; ?></h3>
        <p class="kfn-dashboard-note-date"><?php echo $note['date']; ?></p>
	    <p class="kfn-dashboard-note-content"><?php echo $note['content']; ?></p>
    </div>
<?php endforeach; ?>