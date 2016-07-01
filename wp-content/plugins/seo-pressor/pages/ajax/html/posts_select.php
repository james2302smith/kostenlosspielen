<?php
/**
 * Return Html select with all Posts
 */

/*
 * Dont use $wp_posts = array_merge(get_posts(array('numberposts'=>-1)),get_pages(array('numberposts'=>-1)));
 * to avoid max memory exhausted problem
 */
global $wpdb;
$query = "SELECT ID,post_title FROM $wpdb->posts where post_status = 'publish'";
$post_data_arr = $wpdb->get_results( $query );
?>
<select multiselect="multiselect">
<?php
if (isset($_REQUEST['select_toolbar']) && $_REQUEST['select_toolbar']=='true') {
	?>
	<option value=""><?php echo __('All','seo-pressor');?></option>
	<?php
}

foreach ($post_data_arr as $post_data_item) {
	?>
	<option value="<?php echo $post_data_item->ID?>"><?php echo $post_data_item->post_title?></option>
	<?php
}
?>
</select>
<?php die(); ?>