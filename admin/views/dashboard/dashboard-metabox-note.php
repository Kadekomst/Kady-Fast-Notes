<?php
/**
 * dashboard-metabox-note.php
 * ---------------------------------------------------
 * HTML/CSS view for KFN dashboard metabox note block
 * ---------------------------------------------------
 * @author Kadekomst
 * @since 1.0.0
 */

// Notes array
$notes = new WP_Query( array(
	'numberposts'      => -1,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_type'        => 'kfn',
	'suppress_filters' => true
) );

while ( $notes->have_posts() ) {
	// Required post call
	$notes->the_post();

	// Post contents
	$post_title     = $notes->post->post_title;
	$post_content   = $notes->post->post_content;
	$post_date      = $notes->post->post_date;
	$post_permalink = admin_url('post.php?post='.$notes->post->ID.'&action=edit');

	?>

    <!-- Metabox note template  -->
    <div class="kfn-dashboard-note">
        <a href="<?php echo $post_permalink; ?>" class="kfn-dashboard-note-title"><?php echo $post_title; ?></a>
        <p class="kfn-dashboard-note-date"><?php echo $post_date; ?></p>
        <p class="kfn-dashboard-note-content"><?php echo $post_content; ?></p>
    </div>

<?php

}
wp_reset_postdata();